<?php
declare(strict_types=1);

/**
 * @defgroup pages_install
 */

/**
 * @file pages/install/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup pages_install
 * @brief Handle installation requests.
 *
 */

switch ($op) {
	case 'index':
	case 'install':
	case 'upgrade':
	case 'installUpgrade':
		define('HANDLER_CLASS', 'CoreInstallHandler');
		import('app.Pages.install.CoreInstallHandler');
		break;
}

?>