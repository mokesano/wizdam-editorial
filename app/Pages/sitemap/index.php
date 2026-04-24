<?php
declare(strict_types=1);

/**
 * @defgroup pages_sitemap
 */
 
/**
 * @file pages/sitemap/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup pages_sitemap
 * @brief Produce a sitemap in XML format for submitting to search engines. 
 *
 */

switch ($op) {
	case 'index':
		define('HANDLER_CLASS', 'SitemapHandler');
		import('app.Pages.sitemap.SitemapHandler');
		break;
}

?>