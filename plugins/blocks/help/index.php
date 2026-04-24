<?php
declare(strict_types=1);

/**
 * @defgroup plugins_blocks_help
 */
 
/**
 * @file plugins/blocks/help/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_blocks_help
 * @brief Wrapper for help block plugin.
 *
 */

require_once('HelpBlockPlugin.inc.php');

return new HelpBlockPlugin();