{**
 * templates/form/subLabel.tpl
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * form label
 *}

<label class="sub_label{if $FBV_error} error{/if}" {if !$FBV_suppressId} for="{$FBV_id|escape}"{/if}>
	{if $FBV_subLabelTranslate}{translate key=$FBV_label|escape}{else}{$FBV_label|escape}{/if} {if $FBV_required}<span class="req">*</span>{/if}
</label>
