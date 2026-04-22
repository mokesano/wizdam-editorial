{**
 * templates/checkout/cart.tpl
 *
 * [WIZDAM EDITION]
 * Tahap 1: Keranjang Belanja & Opsi Tambahan (Fast-Track, Promo)
 *}
{include file="common/header.tpl" pageTitle="checkout.cart.title"}

{literal}
<style>
    /* WIZDAM Checkout UI - Elsevier Inspired */
    .wizdam-checkout-container { display: flex; flex-wrap: wrap; gap: 30px; margin-top: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .wizdam-checkout-main { flex: 1; min-width: 60%; }
    .wizdam-checkout-sidebar { width: 350px; background: #f8f9fa; padding: 25px; border-radius: 8px; border: 1px solid #e0e0e0; height: fit-content; }
    
    /* Stepper */
    .wizdam-stepper { display: flex; justify-content: center; margin-bottom: 40px; border-bottom: 1px solid #eee; padding-bottom: 20px; }
    .step { font-size: 14px; font-weight: bold; color: #adb5bd; margin: 0 20px; display: flex; align-items: center; }
    .step.active { color: #0056b3; }
    .step-circle { width: 24px; height: 24px; border-radius: 50%; background: #adb5bd; color: white; display: flex; justify-content: center; align-items: center; margin-right: 8px; font-size: 12px; }
    .step.active .step-circle { background: #0056b3; }

    /* Product Item */
    .product-box { border: 1px solid #e0e0e0; padding: 20px; border-radius: 8px; margin-bottom: 20px; display: flex; justify-content: space-between; }
    .product-title { font-size: 18px; font-weight: 600; margin-bottom: 5px; color: #333; }
    .product-meta { font-size: 13px; color: #666; margin-bottom: 15px; }
    
    /* Options & Promo */
    .option-box { background: #f0f4f8; padding: 15px; border-radius: 6px; margin-bottom: 15px; border-left: 4px solid #0056b3; }
    .promo-box { display: flex; gap: 10px; margin-top: 20px; }
    .wizdam-input { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
    
    /* Summary */
    .summary-title { font-size: 20px; font-weight: bold; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: #444; }
    .summary-total { display: flex; justify-content: space-between; margin-top: 20px; padding-top: 15px; border-top: 1px solid #ccc; font-size: 18px; font-weight: bold; color: #000; }
    
    .wizdam-btn-primary { background: #0056b3; color: white; border: none; padding: 12px 20px; width: 100%; border-radius: 4px; font-size: 16px; font-weight: bold; cursor: pointer; text-align: center; text-decoration: none; display: inline-block; margin-top: 20px; transition: background 0.3s;}
    .wizdam-btn-primary:hover { background: #004494; text-decoration: none; color: white;}
    .wizdam-btn-secondary { background: #e0e0e0; color: #333; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-weight: bold; }
</style>
{/literal}

<div class="wizdam-stepper">
    <div class="step active"><div class="step-circle">1</div> Cart Options</div>
    <div class="step"><div class="step-circle">2</div> Billing Details</div>
    <div class="step"><div class="step-circle">3</div> Payment</div>
</div>

<div class="wizdam-checkout-container">
    <div class="wizdam-checkout-main">
        
        <div class="product-box">
            <div>
                <div class="product-title">Article Publication Charge (APC)</div>
                <div class="product-meta">Manuscript ID: #{$articleId}</div>
                <div style="font-size: 14px;">Standar publikasi jurnal setelah naskah dinyatakan diterima (Accepted).</div>
            </div>
            <div style="font-weight: bold; font-size: 16px;">
                {$summary.currency} {$summary.base_amount|number_format:2}
            </div>
        </div>

        <div class="option-box">
            <label style="display: flex; align-items: flex-start; cursor: pointer;">
                <input type="checkbox" id="fastTrackCheck" style="margin-top: 4px; margin-right: 15px; width: 18px; height: 18px;" onchange="updateCart()">
                <div>
                    <strong style="font-size: 15px; display: block; color: #0056b3;">Apply Fast-Track Review (+ {$summary.currency} 700,000.00)</strong>
                    <span style="font-size: 13px; color: #555;">Percepatan proses review dan prioritas publikasi naskah.</span>
                </div>
            </label>
        </div>

    </div>

    <div class="wizdam-checkout-sidebar">
        <div class="summary-title">Order summary</div>
        
        <div class="summary-row">
            <span>Subtotal</span>
            <span id="ui-subtotal">{$summary.currency} {$summary.subtotal|number_format:2}</span>
        </div>
        
        <div class="summary-row" id="row-discount" style="{if $summary.discount <= 0}display: none;{/if} color: #28a745;">
            <span>Discount <span id="ui-promo-label"></span></span>
            <span id="ui-discount">- {$summary.currency} {$summary.discount|number_format:2}</span>
        </div>
        
        <div class="summary-row">
            <span>Tax ({$summary.tax_rate}%) {if $summary.is_tax_inclusive}<small>(Inclusive)</small>{/if}</span>
            <span id="ui-tax">{$summary.currency} {$summary.tax_amount|number_format:2}</span>
        </div>

        <div class="summary-total">
            <span>Today's payment</span>
            <span id="ui-grand-total">{$summary.currency} {$summary.grand_total|number_format:2}</span>
        </div>

        <div class="promo-box">
            <input type="text" id="promoCodeInput" class="wizdam-input" placeholder="Enter promo code">
            <button class="wizdam-btn-secondary" type="button" onclick="applyPromo()">Apply</button>
        </div>
        <input type="hidden" name="csrfToken" value="{$csrfToken|escape}">

        <a href="{url page="checkout" op="billing" path=$queuedPaymentId}" class="wizdam-btn-primary">
            Continue to Billing Details &raquo;
        </a>
    </div>
</div>

<script>
{literal}
    const queuedPaymentId = {$queuedPaymentId};
    const updateUrl = '{url page="checkout" op="updateCartAjax"}';

    // Konfigurasi Harga Fix (Bisa ditarik dari setting jurnal ke depannya)
    const fastTrackPrice = 700000;

    function updateCart(promoCode = null, discountAmount = 0) {
        let additionalItems = [];
        
        // Cek apakah Fast-Track dicentang
        if (document.getElementById('fastTrackCheck').checked) {
             additionalItems.push({
                type: 'FAST_TRACK',
                amount: fastTrackPrice,
                description: 'Fast-Track Review Service'
            });
        }

        // Siapkan Payload AJAX
        let formData = new URLSearchParams();
        formData.append('queuedPaymentId', queuedPaymentId);
        formData.append('additionalItems', JSON.stringify(additionalItems));
        formData.append('promoCode', promoCode || '');
        formData.append('discountAmount', discountAmount);

        // Tembak ke Backend (CheckoutHandler::updateCartAjax)
        fetch(updateUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                let s = data.summary;

                // Update UI Angka secara Real-time
                document.getElementById('ui-subtotal').innerText = s.currency + ' ' + formatMoney(s.subtotal);
                document.getElementById('ui-tax').innerText = s.currency + ' ' + formatMoney(s.tax_amount);
                document.getElementById('ui-grand-total').innerText = s.currency + ' ' + formatMoney(s.grand_total);

                let discRow = document.getElementById('row-discount');
                if (s.discount > 0) {
                    discRow.style.display = 'flex';
                    document.getElementById('ui-discount').innerText = '- ' + s.currency + ' ' + formatMoney(s.discount);
                    if(s.promo_code) document.getElementById('ui-promo-label').innerText = '(' + s.promo_code + ')';
                } else {
                    discRow.style.display = 'none';
                }
            } else {
                alert("Gagal memperbarui keranjang: " + data.message);
            }
        });
    }

    // Simulasi Apply Promo Sederhana
    function applyPromo() {
        let code = document.getElementById('promoCodeInput').value.trim().toUpperCase();
        let discount = 0;

        // Logika bisnis promo bisa ditaruh di backend, ini contoh diskon jika kode SANGIA50
        if (code === 'SANGIA50') {
            discount = 50000;
            alert("Kupon berhasil diterapkan! Potongan Rp 50.000");
        } else if (code !== '') {
            alert("Kupon tidak valid atau kadaluarsa.");
            code = '';
        }

        updateCart(code, discount);
    }

    // Helper Format Uang
    function formatMoney(amount) {
        return parseFloat(amount).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
{/literal}
</script>

{include file="common/footer.tpl"}