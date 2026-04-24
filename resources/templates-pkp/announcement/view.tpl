{**
 * view.tpl
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * View full announcement text.
 *
 *}
{strip}
{assign var="pageTitleTranslated" value=$announcementTitle}
{assign var="pageId" value="announcement.view"}
{include file="common/header.tpl"}
{/strip}

<table id="announcementDescription" width="100%">
	<tr>
		<td>{$announcement->getLocalizedDescription()|nl2br}</td>
	</tr>
</table>

{include file="common/footer.tpl"}

