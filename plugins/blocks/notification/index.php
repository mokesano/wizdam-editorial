<?php
declare(strict_types=1);

/**
 * @defgroup plugins_blocks_notification
 */
 
/**
 * @file plugins/blocks/notification/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_blocks_notification
 * @brief Wrapper for "notification" block plugin.
 *
 */

require_once('NotificationBlockPlugin.inc.php');

return new NotificationBlockPlugin();