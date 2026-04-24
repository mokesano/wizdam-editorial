<?php
declare(strict_types=1);

/**
 * @defgroup plugins
 */

/**
 * @file plugins/importexport/mets/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins
 * @brief Wrapper for METS export plugin.
 */

require_once('MetsExportPlugin.inc.php');

return new METSExportPlugin();