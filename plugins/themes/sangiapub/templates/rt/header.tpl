<!DOCTYPE html>
<html lang="{$currentLocale|replace:"_":"-"}" xml:lang="{$currentLocale|replace:"_":"-"}">
{**
 * templates/rt/header.tpl
 *
 * Copyright (c) 2013-2017 Sangia Publishing House
 * Copyright (c) 2003-2016 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Common header for RT pages.
 *}
<head>
	<title>{translate key="rt.readingTools"}</title>
	<meta http-equiv="Content-Type" content="text/html; charset={$defaultCharset|escape}" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />

	{if $displayFavicon}<link rel="icon" href="{$faviconDir}/{$displayFavicon.uploadName|escape:"url"}" type="{$displayFavicon.mimeType|escape}" />{/if}

	<link rel="stylesheet" href="{$baseUrl}/core/Library/styles/common.css" type="text/css" />
	<link rel="stylesheet" href="{$baseUrl}/styles/common.css" type="text/css" />
	<link rel="stylesheet" href="{$baseUrl}/styles/compiled.css" type="text/css" />
	<link rel="stylesheet" href="{$baseUrl}/core/Library/styles/rt.css" type="text/css" />

	{foreach from=$stylesheets item=cssUrl}
		<link rel="stylesheet" href="{$cssUrl}" type="text/css" />
	{/foreach}

	{include file="common/jqueryScripts.tpl"}
	
	<!-- Base Jquery -->
	{if $allowCDN}<script type="text/javascript" src="//www.google.com/jsapi"></script>
	<script type="text/javascript">{literal}
		// Provide a local fallback if the CDN cannot be reached
		if (typeof google == 'undefined') {
			document.write(unescape("%3Cscript src='{/literal}{$baseUrl}{literal}/core/Library/js/lib/jquery/jquery.min.js' type='text/javascript'%3E%3C/script%3E"));
			document.write(unescape("%3Cscript src='{/literal}{$baseUrl}{literal}/core/Library/js/lib/jquery/plugins/jqueryUi.min.js' type='text/javascript'%3E%3C/script%3E"));
		} else {
			google.load("jquery", "{/literal}{$smarty.const.CDN_JQUERY_VERSION}{literal}");
			google.load("jqueryui", "{/literal}{$smarty.const.CDN_JQUERY_UI_VERSION}{literal}");
		}
	{/literal}</script>
	{else}
	<script type="text/javascript" src="{$baseUrl}/core/Library/js/lib/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="{$baseUrl}/core/Library/js/lib/jquery/plugins/jqueryUi.min.js"></script>
	{/if}

	<!-- Compiled scripts -->
	{if $useMinifiedJavaScript}
		<script type="text/javascript" src="{$baseUrl}/js/core.min.js"></script>
	{else}
		{include file="common/minifiedScripts.tpl"}
	{/if}
	
	{include file="common/commonCSS.tpl"}
	
	{$additionalHeadData}
	
</head>

<body id="sangia.org" class="cms cms-sangia">
    <a id="skip-to-content" href="#main">Skip to Main Content</a>
    
    <!-- Back to top button -->
    <a class="buttontop" href="#sangia.org"></a>
    
    {include file="common/navbar.tpl"}

    {literal}
    <script type="text/javascript">
    <!--
    	if (self.blur) { self.focus(); }
    // -->
    </script>
    {/literal}

    {if !$pageTitleTranslated}{translate|assign:"pageTitleTranslated" key=$pageTitle}{/if}
    
    <div id="container" class="journal-content sangia u-mt-48">
        
        <div id="main">
        
            {literal}
            <script type="text/javascript">
            <!--
            	if (self.blur) { self.focus(); }
            // -->
            </script>
            {/literal}
        
        <h2 class="main-heading">{$pageTitleTranslated}</h2>
        
        <div id="content">
