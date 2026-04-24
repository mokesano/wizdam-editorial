<?php
declare(strict_types=1);

/**
 * @defgroup plugins_generic_driver
 */
 
/**
 * @file plugins/generic/driver/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_generic_driver
 * @brief Wrapper for driver plugin.
 *
 */

require_once('DRIVERPlugin.inc.php');

return new DRIVERPlugin();