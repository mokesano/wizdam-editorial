<?php
declare(strict_types=1);

/**
 * @defgroup plugins_blocks_fontSize
 */
 
/**
 * @file plugins/blocks/fontSize/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_blocks_fontSize
 * @brief Wrapper for font size block plugin.
 *
 */

require_once('FontSizeBlockPlugin.inc.php');

return new FontSizeBlockPlugin();