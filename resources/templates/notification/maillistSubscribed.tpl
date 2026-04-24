{**
 * templates/notification/maillistSubscribed.tpl
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Displays the notification settings page and unchecks
 *
 *}
{strip}
{assign var="pageTitle" value="notification.mailList"}
{include file="common/header.tpl"}
{/strip}

<ul>
	<li>
		<span{if $error} class="core_form_error"{/if}>
			{translate key="notification.$status"}
		</span>
	</li>
<ul>

{include file="common/footer.tpl"}
