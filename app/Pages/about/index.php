<?php
declare(strict_types=1);

/**
 * @defgroup pages_about
 */
 
/**
 * @file pages/about/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup pages_about
 * @brief Handle requests for about the journal functions. 
 *
 */

switch($op) {
	case 'index':
	case 'contact':
	case 'editorial-team':
	case 'leadership':
	case 'displayMembership':
	case 'display-membership':
	case 'editorialTeamBio':
	case 'editorial-team-bio':
	case 'editorial-policies':
	case 'subscriptions':
	case 'memberships':
	case 'submissions':
	case 'sponsorship':
	case 'sitemap': // Tidak penting, redundant di SitemapHandler indexer
	case 'history':
	case 'aboutThisPublishingSystem': // Hanya diaktifkan sementara
	case 'insights':
	case 'statistics':
		define('HANDLER_CLASS', 'AboutHandler');
		import('app.Pages.about.AboutHandler');
		break;
}

?>