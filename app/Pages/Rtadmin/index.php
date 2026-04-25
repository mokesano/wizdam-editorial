<?php
declare(strict_types=1);

/**
 * @defgroup pages_rtadmin
 */

/**
 * @file pages/rtadmin/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup pages_rtadmin
 * @brief Handle requests for RT admin functions.
 *
 */

switch ($op) {
	//
	// General
	//
	case 'index':
	case 'validateUrls':
		define('HANDLER_CLASS', 'RTAdminHandler');
		import('app.Pages.rtadmin.RTAdminHandler');
		break;
	case 'settings':
	case 'saveSettings':
		define('HANDLER_CLASS', 'RTSetupHandler');
		import('app.Pages.rtadmin.RTSetupHandler');
		break;
	//
	// Versions
	//
	case 'createVersion':
	case 'exportVersion':
	case 'importVersion':
	case 'restoreVersions':
	case 'versions':
	case 'editVersion':
	case 'deleteVersion':
	case 'saveVersion':
		define('HANDLER_CLASS', 'RTVersionHandler');
		import('app.Pages.rtadmin.RTVersionHandler');
		break;
	//
	// Contexts
	//
	case 'createContext':
	case 'contexts':
	case 'editContext':
	case 'saveContext':
	case 'deleteContext':
	case 'moveContext':
		define('HANDLER_CLASS', 'RTContextHandler');
		import('app.Pages.rtadmin.RTContextHandler');
		break;
	//
	// Searches
	//
	case 'createSearch':
	case 'searches':
	case 'editSearch':
	case 'saveSearch':
	case 'deleteSearch':
	case 'moveSearch':
		define('HANDLER_CLASS', 'RTSearchHandler');
		import('app.Pages.rtadmin.RTSearchHandler');
		break;
}

?>