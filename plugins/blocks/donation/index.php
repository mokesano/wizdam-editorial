<?php
declare(strict_types=1);

/**
 * @defgroup plugins_blocks_user
 */
 
/**
 * @file plugins/blocks/donation/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_blocks_user
 * @brief Wrapper for donation block plugin.
 *
 */

require_once('DonationBlockPlugin.inc.php');

return new DonationBlockPlugin();