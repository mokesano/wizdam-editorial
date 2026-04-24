<?php
declare(strict_types=1);

/**
 * @file pages/checkout/CheckoutHandler.inc.php
 *
 * Copyright (c) 2017-2026 Sangia Publishing House
 * Copyright (c) 2017-2026 Rochmady
 *
 * [WIZDAM EDITION] Refactored for PHP 8.4 Strict Compliance
 * @class CheckoutHandler
 * @brief Controller antarmuka untuk 3-Tahap Checkout (Cart -> Billing -> Payment/Finalize).
 */

import('core.Modules.handler.Handler');
import('core.Modules.services.CheckoutService');

class CheckoutHandler extends Handler {
    
    /** @var CheckoutService */
    private CheckoutService $checkoutService;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        
        // Mutlak: Hanya user yang login yang bisa checkout
        $this->addCheck(new HandlerValidatorCustom($this, true, null, null, function() {
            return Validation::isLoggedIn();
        }));
        
        $this->checkoutService = new CheckoutService();
    }

    /**
     * Override untuk memuat komponen bahasa yang diperlukan di semua halaman checkout
     * @param Request|null $request
     */
    public function setupTemplate($request = null): void {
        parent::setupTemplate($request);
        AppLocale::requireComponents(
            array(
                LOCALE_COMPONENT_CORE_COMMON,
                LOCALE_COMPONENT_CORE_USER,
                LOCALE_COMPONENT_APPLICATION_COMMON,
                LOCALE_COMPONENT_APP_PAYMENT
            )
        );
    }

    // 
    // TAHAP 1: CART & OPTIONS (Rute: /checkout/cart/[articleId]?feeType=...)
    // 
    
    /**
     * Menampilkan halaman keranjang belanja (Tahap 1: Cart & Options).
     * @param array $args
     * @param Request|null $request
     */
    public function cart(array $args = [], $request = null): void {
        $this->validate();
        $this->setupTemplate($request);
        if (!$request) $request = Application::get()->getRequest();
        
        import('core.Modules.validation.ValidatorCSRF');
        // Token untuk form utama
        $submitToken = ValidatorCSRF::generateSignedToken('checkoutSubmit', []);
        // Token khusus untuk AJAX
        $ajaxToken = ValidatorCSRF::generateSignedToken('updateCartAjax', []);

        $articleId = isset($args[0]) ? (int) $args[0] : 0;
        $feeType = $request->getUserVar('feeType') ?: 'PUBLICATION'; 
        $baseAmount = (float) ($request->getUserVar('amount') ?: 0); 
        
        $user = $request->getUser();
        if (!$user) {
            $request->redirect(null, 'login');
            return; 
        }

        $context = $request->getContext(); 
        $contextId = $context ? (int) $context->getId() : 0; 
        
        // Menarik pengaturan currency langsung dari context/jurnal
        $defaultCurrency = Config::getVar('general', 'default_currency', 'USD');
        $currency = $context ? ($context->getSetting('currency') ?: $defaultCurrency) : $defaultCurrency;

        // Peta konfigurasi fee dinamis. Tidak ada teks bahasa (hardcode) di sini.
        // Teks dilokalkan menggunakan locale key.
        $optionalFeeConfigs = [
            'FAST_TRACK' => [
                'setting_key' => 'fastTrackFee',
                'locale_name' => 'manager.payment.options.fastTrackFee',
                'locale_desc' => 'manager.payment.options.fastTrackFeeDescription'
            ],
            'COLOR_FIGURE' => [
                'setting_key' => 'colorFigureFee',
                'locale_name' => 'manager.payment.options.colorFigureFee',
                'locale_desc' => 'manager.payment.options.colorFigureFeeDescription'
            ],
            'PAGE_CHARGE' => [
                'setting_key' => 'pageChargeFee',
                'locale_name' => 'manager.payment.options.pageChargeFee',
                'locale_desc' => 'manager.payment.options.pageChargeFeeDescription'
            ]
        ];

        $optionalFees = [];
        if ($context) {
            foreach ($optionalFeeConfigs as $type => $config) {
                // Konsep DAO Wizdam 2.x: nilai setting ditarik via getSetting
                $feeAmount = (float) $context->getSetting($config['setting_key']);
                if ($feeAmount > 0) {
                    $optionalFees[$type] = [
                        'amount' => $feeAmount,
                        'label'  => __($config['locale_name']), // Translate dinamis
                        'desc'   => __($config['locale_desc'])
                    ];
                }
            }
        }

        $queuedPaymentId = $this->checkoutService->initCart(
            $contextId, (int) $user->getId(), $articleId, $feeType, $baseAmount, $currency
        );

        $checkoutAuthToken = ValidatorCSRF::generateSignedToken('checkoutAuth', []);
        $summary = $this->checkoutService->calculateCartSummary($queuedPaymentId);
        $fastTrackPrice = $optionalFees['FAST_TRACK']['amount'] ?? 0;

        $templateMgr = TemplateManager::getManager($request);
        $templateMgr->assign([
            'csrfToken'       => $submitToken,
            'ajaxCsrfToken'   => $ajaxToken,
            'checkoutAuthToken' => $checkoutAuthToken,
            'queuedPaymentId' => $queuedPaymentId,
            'articleId'       => $articleId,
            'summary'         => $summary,
            'optionalFees'    => $optionalFees,
            'fastTrackPrice'  => $fastTrackPrice,
            'pageTitle'       => 'checkout.cart.title',
            'currentStep'     => 1
        ]);

        $templateMgr->display('checkout/cart.tpl');
    }

    // =========================================================================
    // PEMICU CHECKOUT: VALIDASI LOGIN & SIMPAN KE DATABASE
    // =========================================================================
    /**
     * Memproses form dari cart.tpl dan redirect ke billing
     */
    public function checkoutSubmit(array $args = [], $request = null): void {
        if (!$request) $request = Application::get()->getRequest();
        
        // [TAMBAHAN KEAMANAN KRUSIAL]: Wajibkan metode POST!
        // Jika ada yang mencoba mengakses via URL (GET), langsung tolak dan kembalikan ke Cart
        if (!$request->isPost()) {
            $articleId = isset($args[0]) ? (int) $args[0] : 0;
            if ($articleId) {
                $request->redirect(null, 'checkout', 'cart', [$articleId]);
            } else {
                $request->redirect(null, 'index');
            }
            return;
        }

        // 1. Validasi CSRF yang mewajibkan argumen
        $this->validate(null, $request);
        import('core.Modules.validation.ValidatorCSRF');
        $authToken = $request->getUserVar('checkoutAuthToken');
        if (!ValidatorCSRF::checkToken($authToken, 'checkoutAuth', [], true)) {
            $request->redirect(null, 'checkout', 'cart', [$articleId]);
            return;
        }

        if (!Validation::isLoggedIn()) {
            Validation::redirectLogin();
            return;
        }

        $user = $request->getUser();
        
        // 2. [PERBAIKAN] Tangkap kembali articleId dari argumen URL ($args[0])
        $articleId = isset($args[0]) ? (int) $args[0] : 0;
        
        if (!$articleId) {
            $request->redirect(null, 'index');
            return;
        }
        
        $journal = $request->getJournal(); 
        $journalId = $journal ? (int) $journal->getId() : 0;
        
        $currency = $journal ? $journal->getSetting('currency') : null;
        if (!$currency) {
            $currency = Config::getVar('general', 'default_currency', 'IDR'); 
        }

        $feeType = $request->getUserVar('feeType') ?: 'PUBLICATION';
        $amount = (float) $request->getUserVar('amount');
        $promoCode = trim((string) $request->getUserVar('promoCode'));
        
        $queuedPaymentId = $this->checkoutService->initCart(
            $journalId, (int) $user->getId(), $articleId, $feeType, $amount, $currency
        );

        $isFastTrack = (int) $request->getUserVar('fastTrack');
        $validatedItems = [];
        
        if ($isFastTrack === 1 && $journal) {
            $fastTrackFee = (float) $journal->getSetting('fastTrackFee');
            if ($fastTrackFee > 0) {
                $validatedItems[] = ['type' => 'FAST_TRACK', 'amount' => $fastTrackFee];
            }
        }

        $this->checkoutService->updateCartItems($queuedPaymentId, $validatedItems, $promoCode, 0.0);

        // Arahkan ke halaman Billing
        $request->redirect(null, 'checkout', 'billing', [$queuedPaymentId]);
    }
    
    /**
     * Endpoint AJAX untuk mengupdate keranjang (Centang Fast-Track, Kupon, dll)
     * Rute: POST /checkout/updateCartAjax
     * @param array $args
     * @param Request|null $request
     */
    public function updateCartAjax(array $args = [], $request = null): void {
        $this->validate();
        if (!$request) $request = Application::get()->getRequest();

        $queuedPaymentId = (int) $request->getUserVar('queuedPaymentId');
        $additionalItemsRaw = $request->getUserVar('additionalItems'); 
        $promoCode = trim((string) $request->getUserVar('promoCode'));
        
        $additionalItems = is_array($additionalItemsRaw) ? $additionalItemsRaw : json_decode($additionalItemsRaw ?: '[]', true);

        // [CRITICAL FIX] Jangan pernah percaya discountAmount dari parameter frontend!
        $discountAmount = 0.0;
        if (!empty($promoCode)) {
            // TODO: Integrasi validasi DB riil (Sama seperti logika di checkout() atas)
            if (strtoupper($promoCode) === 'SANGIA50') {
                $discountAmount = 50000.0;
            } else {
                $promoCode = null; // Batalkan promo jika tidak valid di DB
            }
        }

        $success = $this->checkoutService->updateCartItems($queuedPaymentId, $additionalItems, $promoCode, $discountAmount);
        
        header('Content-Type: application/json');
        if ($success) {
            $newSummary = $this->checkoutService->calculateCartSummary($queuedPaymentId);
            echo json_encode(['status' => 'success', 'summary' => $newSummary]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Cart not found']);
        }
        exit;
    }

    // 
    // TAHAP 2: BILLING ADDRESS (Rute: /checkout/billing/[queuedPaymentId])
    // 
    
    /**
     * Menampilkan halaman alamat penagihan
     * @param array $args
     * @param Request|null $request
     */
    public function billing(array $args = [], $request = null): void {
        $this->validate();
        $this->setupTemplate($request);
        if (!$request) $request = Application::get()->getRequest();
        
        import('core.Modules.validation.ValidatorCSRF');
        $billingToken = ValidatorCSRF::generateSignedToken('billing', []);

        $queuedPaymentId = isset($args[0]) ? (int) $args[0] : 0;
        // Tampilkan notice jika diarahkan dari logika "alreadyExists"
        $alreadyExists = (bool) $request->getUserVar('alreadyExists');
        
        if ($queuedPaymentId === 0) {
            $request->redirect(null, 'index');
            return;
        }

        // Jika form alamat disubmit
        if ($request->isPost()) {
            $billingData = [
                'name'        => $request->getUserVar('billingName'),
                'institution' => $request->getUserVar('billingInstitution'),
                'address'     => $request->getUserVar('billingAddress'),
                'city'        => $request->getUserVar('billingCity'),
                'country'     => $request->getUserVar('billingCountry'),
                'postal_code' => $request->getUserVar('billingPostalCode'),
            ];
            
            $this->checkoutService->updateBillingAddress($queuedPaymentId, $billingData);
            $request->redirect(null, 'checkout', 'payment', [$queuedPaymentId]);
            return;
        }

        $summary = $this->checkoutService->calculateCartSummary($queuedPaymentId);
        $user = $request->getUser();

        $templateMgr = TemplateManager::getManager($request);
        if ($alreadyExists) {
            $templateMgr->assign('notification', 'Anda memiliki transaksi tertunda yang belum diselesaikan.');
        }
        $templateMgr->assign([
            'csrfToken'       => $billingToken,
            'queuedPaymentId' => $queuedPaymentId,
            'summary'         => $summary,
            'user'            => $user, // Untuk auto-fill form alamat
            'pageTitle'       => 'checkout.billing.title',
            'currentStep'     => 2
        ]);

        $templateMgr->display('checkout/billing.tpl');
    }

    // 
    // TAHAP 3: PAYMENT REVIEW & FINALIZE (Rute: /checkout/payment/[queuedPaymentId])
    // 
    
    /**
     * Menampilkan halaman ulasan pembayaran
     * @param array $args
     * @param Request|null $request
     */
    public function payment(array $args = [], $request = null): void {
        $this->validate();
        $this->setupTemplate($request);
        if (!$request) $request = Application::get()->getRequest();

        $queuedPaymentId = isset($args[0]) ? (int) $args[0] : 0;
        if ($queuedPaymentId === 0) {
            $request->redirect(null, 'index');
            return;
        }

        $summary = $this->checkoutService->calculateCartSummary($queuedPaymentId);
        
        // payment() — TAMBAHKAN sebelum assign
        import('core.Modules.validation.ValidatorCSRF');
        $finalizeToken = ValidatorCSRF::generateSignedToken('finalize', []);

        $templateMgr = TemplateManager::getManager($request);
        $templateMgr->assign([
            'csrfToken'       => $finalizeToken,
            'queuedPaymentId' => $queuedPaymentId,
            'summary'         => $summary,
            'pageTitle'       => 'checkout.payment.title',
            'currentStep'     => 3
        ]);

        $templateMgr->display('checkout/payment.tpl');
    }

    /**
     * EKSEKUSI MUTLAK: Mengubah Keranjang menjadi Invoice.
     * Rute: POST /checkout/finalize/[queuedPaymentId]
     * @param array $args
     * @param Request|null $request
     */
    public function finalize(array $args = [], $request = null): void {
        $this->validate();
        if (!$request) $request = Application::get()->getRequest();

        $queuedPaymentId = isset($args[0]) ? (int) $args[0] : 0;
        
        try {
            // Memanggil Garda Akhir di Service
            $invoice = $this->checkoutService->finalizeCheckout($queuedPaymentId);
            
            // JIKA SUKSES: 
            // Kita sudah punya Invoice ID dan Hash Keamanan. 
            // Lempar pengguna ke halaman BillingHandler untuk melihat Kuitansi Resmi dan Membayar!
            import('core.Modules.security.SecurityHashService');
            $hashService = new SecurityHashService();
            
            $invoiceId = $invoice->getInvoiceId();
            $authHash = $hashService->generateHash('invoice', $invoiceId);
            
            $request->redirect(null, 'billing', 'invoice', ["{$authHash}-{$invoiceId}"]);

        } catch (\Throwable $e) {
            // Jika gagal (keranjang tidak ditemukan, dll)
            $request->redirect(null, 'checkout', 'cart');
        }
    }
}
?>