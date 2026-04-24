<?php
declare(strict_types=1);

/**
 * @defgroup pages_rt
 */
 
/**
 * @file pages/rt/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup pages_rt
 * @brief Handle Reading Tools requests. 
 *
 */

switch ($op) {
	case 'bio':
	case 'metadata':
	case 'context':
	case 'captureCite':
	case 'printerFriendly':
	case 'emailColleague':
	case 'emailAuthor':
	case 'suppFiles':
	case 'suppFileMetadata':
	case 'findingReferences':
		define('HANDLER_CLASS', 'RTHandler');
		import('app.Pages.rt.RTHandler');
		break;
}

?>