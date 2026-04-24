{**
 * templates/help/searchResults.tpl
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2003-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Show help search results.
 *
 *}
{strip}
{translate|assign:applicationHelpTranslated key="help.wizdamHelp"}
{include file="core:help/searchResults.tpl"}
{/strip}
