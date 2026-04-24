<?php
declare(strict_types=1);

/**
 * @defgroup plugins_generic_dataverse
 */
 
/**
 * @file plugins/generic/dataverse/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_generic_dataverse
 * @brief Wrapper for Dataverse plugin.
 *
 */

require_once('DataversePlugin.inc.php');

return new DataversePlugin();