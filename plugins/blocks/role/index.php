<?php
declare(strict_types=1);

/**
 * @defgroup plugins_blocks_role
 */
 
/**
 * @file plugins/blocks/role/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_blocks_role
 * @brief Wrapper for role block plugin.
 *
 */

require_once('RoleBlockPlugin.inc.php');

return new RoleBlockPlugin();