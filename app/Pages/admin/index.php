<?php
declare(strict_types=1);

/**
 * @defgroup pages_admin
 */
 
/**
 * @file pages.admin.index.php
 *
 * Copyright (c) 2013-2025 Wizdam Editorial Project
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup pages_admin
 * @brief Handle requests for publisher administration functions. 
 *
 */

switch ($op) {
	//
	// Publisher Settings
	//
	case 'settings':
	case 'saveSettings':
		define('HANDLER_CLASS', 'AdminPublisherSettingsHandler');
		import('pages.admin.AdminPublisherSettingsHandler');
		break;
	//
	// Press Management
	//
	case 'presses':
	case 'createPress':
	case 'editPress':
	case 'updatePress':
	case 'deletePress':
	case 'movePress':
		define('HANDLER_CLASS', 'AdminPressHandler');
		import('pages.admin.AdminPressHandler');
		break;
	//
	// Languages
	//
	case 'languages':
	case 'saveLanguageSettings':
	case 'installLocale':
	case 'uninstallLocale':
	case 'reloadLocale':
	case 'reloadDefaultEmailTemplates':
	case 'downloadLocale':
		define('HANDLER_CLASS', 'AdminLanguagesHandler');
		import('pages.admin.AdminLanguagesHandler');
		break;
	//
	// Authentication sources
	//
	case 'auth':
	case 'updateAuthSources':
	case 'createAuthSource':
	case 'editAuthSource':
	case 'updateAuthSource':
	case 'deleteAuthSource':
		define('HANDLER_CLASS', 'AuthSourcesHandler');
		import('pages.admin.AuthSourcesHandler');
		break;
	//
	// Merge users
	//
	case 'mergeUsers':
		define('HANDLER_CLASS', 'AdminPeopleHandler');
		import('pages.admin.AdminPeopleHandler');
		break;
	//
    // AREA ADMIN WIZDAM PAYMENT ---
    //
    case 'payment-settings':
    case 'save-payment-settings':
        define('HANDLER_CLASS', 'AdminPaymentHandler'); 
        import('pages.admin.AdminPaymentHandler');
        break;
	//
	// Administrative functions
	//
	case 'systemInfo':
	case 'phpinfo':
	case 'expireSessions':
	case 'clearTemplateCache':
	case 'clearDataCache':
	case 'downloadScheduledTaskLogFile':
	case 'clearScheduledTaskLogFiles':
		define('HANDLER_CLASS', 'AdminFunctionsHandler');
		import('pages.admin.AdminFunctionsHandler');
		break;
		
	// 
	// Main administration page
	// 
	// Categories
	//
	case 'categories':
	case 'createCategory':
	case 'editCategory':
	case 'updateCategory':
	case 'deleteCategory':
	case 'moveCategory':
	case 'setCategoriesEnabled':
		define('HANDLER_CLASS', 'AdminCategoriesHandler');
		import('pages.admin.AdminCategoriesHandler');
		break;
		
	case 'index':
	case 'aboutPublisher':
    case 'saveAboutPublisher':
		define('HANDLER_CLASS', 'AdminHandler');
		import('pages.admin.AdminHandler');
		break;
}
?>