{**
 * templates/common/jsLocaleKeys.tpl
 *
 * Copyright (c) 2013-2017 Sangia Publishing House
 * Copyright (c) 2003-2016 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Default Locale keys used by JavaScript.  May be overridden by the calling template
 *}

{* List constants for JavaScript in $.core.locale namespace *}
<script type="text/javascript">
	jQuery.pkp = jQuery.pkp || {ldelim} {rdelim};
	jQuery.core.locale = {ldelim} {rdelim};
	{foreach from=$jsLocaleKeys item=keyName}
		{translate|assign:"keyValue" key=$keyName}
		{* replace periods in the key name with underscores to prevent JS complaints about undefined variables *}
		jQuery.core.locale.{$keyName|replace:'.':'_'|escape:"javascript"} = {if is_numeric($keyValue)}{$keyValue}{else}'{$keyValue|escape:"javascript"}'{/if};
	{/foreach}
</script>
