<?php
declare(strict_types=1);

/**
 * @defgroup pages_notification
 */

/**
 * @file pages/notification/index.php
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup pages_notification
 * @brief Handle requests for viewing notifications.
 *
 */

switch ($op) {
	case 'index':
	case 'delete':
	case 'settings':
	case 'saveSettings':
	case 'getNotificationFeedUrl':
	case 'notificationFeed':
	case 'subscribeMailList':
	case 'saveSubscribeMailList':
	case 'mailListSubscribed':
	case 'confirmMailListSubscription':
	case 'unsubscribeMailList':
	case 'fetchNotification':
		define('HANDLER_CLASS', 'NotificationHandler');
		import('core.Modules.pages.notification.NotificationHandler');
		break;
}

?>