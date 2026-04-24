{**
 * templates/about/aboutThisPublishingSystem.tpl
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * About the Journal / About This Publishing System.
 *
 * TODO: Display the image describing the system.
 *
 *}
{strip}
{assign var="pageTitle" value="about.journalInsight"}
{include file="common/header.tpl"}


<p id="aboutThisPublishingSystem">
{if $currentJournal}
	{translate key="about.aboutAppPress" appVersion=$appVersion}
{else}
	{translate key="about.aboutAppSite" appVersion=$appVersion}
{/if}
</p>

<p align="center">
	<img src="{$baseUrl}/{$edProcessFile}" style="border: 0;" alt="{translate key="about.aboutThisPublishingSystem.altText"}" />
</p>
{/strip}

{include file="common/footer.tpl"}

