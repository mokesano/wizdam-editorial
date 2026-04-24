<?php
declare(strict_types=1);

/**
 * @defgroup plugins_blocks_subscription
 */
 
/**
 * @file plugins/blocks/subscription/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_blocks_subscription
 * @brief Wrapper for subscription block plugin.
 *
 *
 */

require_once('SubscriptionBlockPlugin.inc.php');

return new SubscriptionBlockPlugin();