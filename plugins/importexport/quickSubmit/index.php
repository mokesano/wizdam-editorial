<?php
declare(strict_types=1);

/**
 * @defgroup plugins_importexport_quickSubmit
 */
 
/**
 * @file plugins/importExport/quickSubmit/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @brief Wrapper for QuickSubmit plugin.
 *
 * @ingroup plugins_importexport_quickSubmit
 */

require_once('QuickSubmitPlugin.inc.php');

return new QuickSubmitPlugin();