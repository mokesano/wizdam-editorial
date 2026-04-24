{**
 * controllers/notification/inPlaceNotification.tpl
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Display in place notifications.
 *}

<script type="text/javascript">
	$(function() {ldelim}
		// Attach the form handler.
		$('#{$notificationId|escape:javascript}').coreHandler('$.core.controllers.NotificationHandler',
		{ldelim}
			{include file="core:controllers/notification/notificationOptions.tpl"}
		{rdelim});
	{rdelim});
</script>
<div id="{$notificationId|escape}" class="core_notification"></div>
