<?php
declare(strict_types=1);

/**
 * @defgroup pages_announcement
 */
 
/**
 * @file pages/announcement/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup pages_announcement
 * @brief Handle requests for public announcement functions. 
 *
 */

switch ($op) {
	case 'index':
	case 'view':
		define('HANDLER_CLASS', 'AnnouncementHandler');
		import('app.Pages.announcement.AnnouncementHandler');
		break;
}

?>