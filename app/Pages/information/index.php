<?php
declare(strict_types=1);

/**
 * @defgroup pages_information
 */
 
/**
 * @file pages/information/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup pages_information
 * @brief Handle information requests. 
 *
 */

switch ($op) {
	case 'index':
	case 'readers':
	case 'authors':
	case 'librarians':
	case 'competingInterestGuidelines':
	case 'sampleCopyrightWording':
		define('HANDLER_CLASS', 'InformationHandler');
		import('app.Pages.information.InformationHandler');
		break;
}

?>