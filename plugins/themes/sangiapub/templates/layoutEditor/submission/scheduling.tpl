{**
 * templates/layoutEditor/submission/scheduling.tpl
 *
 * Copyright (c) 2013-2015 Sangia Publishing House Library
 * Copyright (c) 2003-2015 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Subtemplate defining the scheduling view.
 *
 *}
<div id="scheduling" class="block">
<h3>{translate key="submission.scheduling"}</h3>
<p>
{if $issue}
	{assign var=issueName value=$issue->getIssueIdentification()}
{else}
	{translate|assign:"issueName" key="submission.scheduledIn.tba"}
{/if}

{translate key="submission.scheduledIn" issueName=$issueName}

{if $issue}
	{if $issue->getPublished()}
		<a href="{url page="issue" op="view" path=$issue->getBestIssueId()}" class="action">{translate key="issue.toc"}</a>
	{else}
		<a href="{url op="issueToc" path=$issue->getId()}" class="action">{translate key="issue.toc"}</a>
	{/if}
{/if}
</p>
</div>
