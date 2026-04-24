{**
 * templates/install/installComplete.tpl
 *
 * Copyright (c) 2013-2015 Sangia Publishing House Library
 * Copyright (c) 2003-2015 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Display confirmation of successful installation.
 * If necessary, will also display new config file contents if config file could not be written.
 *
 *}
{strip}
{assign var="pageTitle" value="installer.wizdamInstallation"}
{include file="core:install/installComplete.tpl"}
{/strip}
