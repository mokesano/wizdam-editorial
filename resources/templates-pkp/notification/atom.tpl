{**
 * templates/notification/atom.tpl
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Atom feed template
 *
 *}
<?xml version="1.0" encoding="{$defaultCharset|escape}"?>
<feed xmlns="http://www.w3.org/2005/Atom">
	<id>{$selfUrl|escape}</id>
	<title>{$siteTitle} {translate key="notification.notifications"}</title>

	<link rel="self" type="application/atom+xml" href="{$selfUrl}" />

	<generator uri="https://wizdam.editorial/" version="{$version|escape}">{translate key=$appName}</generator>

	{$formattedNotifications}
</feed>
