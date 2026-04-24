<?php
declare(strict_types=1);

/**
 * @defgroup pages_user
 */

/**
 * @file pages/user/index.php
 * 
 * Copyright (c) 2017-2026 Sangia Publishing House
 * Copyright (c) 2017-2026 Rochmady
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 * 
 * @ingroup pages_user
 * @brief Handle requests for user functions.
 *
 */

switch ($op) {
    //
	// Index
	//
    case 'index':
        define('HANDLER_CLASS', 'UserIndexHandler');
        import('app.Pages.user.UserIndexHandler');
        break;
	//
	// Profiles & Account
	//
	case 'my-profile':         // [WIZDAM] Lihat profil sendiri
	case 'update-profile':     // [WIZDAM] Form ubah profil
	case 'public-profile':     // [WIZDAM] Lihat profil orang lain
	case 'saveProfile':        // (POST Internal)
	case 'changePassword':
	case 'savePassword':       // (POST Internal)
    case 'linked-accounts':    // [WIZDAM ROUTING] KEBAB-CASE URL ---
		define('HANDLER_CLASS', 'ProfileHandler');
		import('app.Pages.user.ProfileHandler');
		break;
	//
	// Registration
	//
	case 'register':
	case 'registerUser':
	case 'activateUser':
		define('HANDLER_CLASS', 'RegistrationHandler');
		import('app.Pages.user.RegistrationHandler');
		break;
	//
	// Email
	//
	case 'email':
		define('HANDLER_CLASS', 'EmailHandler');
		import('app.Pages.user.EmailHandler');
		break;
	//
    // Subscriptions & Payments
    //
    case 'subscriptions':
    case 'purchaseSubscription':
    case 'payPurchaseSubscription':
    case 'completePurchaseSubscription':
    case 'payRenewSubscription':
    case 'payMembership':
        define('HANDLER_CLASS', 'UserSubscriptionHandler');
        import('app.Pages.user.UserSubscriptionHandler');
        break;

    //
    // Gifts
    //
    case 'gifts':
    case 'redeemGift':
        define('HANDLER_CLASS', 'UserGiftHandler');
        import('app.Pages.user.UserGiftHandler');
        break;
	//
	// Core Utilities / Misc.
	//
	case 'setLocale':
	case 'become':
	case 'authorizationDenied':
	case 'viewCaptcha':
		define('HANDLER_CLASS', 'UserHandler');
		import('app.Pages.user.UserHandler');
		break;
	//
	// Interest
	//
	case 'getInterests':
		define('HANDLER_CLASS', 'CoreUserHandler');
		import('app.Pages.user.CoreUserHandler');
		break;
}

?>