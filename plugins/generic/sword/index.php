<?php
declare(strict_types=1);

/**
 * @defgroup plugins_generic_sword
 */

/**
 * @file plugins/generic/sword/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_generic_sword
 * @brief Wrapper for sword deposit plugin.
 *
 */


require_once('SwordPlugin.inc.php');

return new SwordPlugin();