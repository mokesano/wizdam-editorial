{**
 * templates/controllers/listbuilder/listbuilder.tpl
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Displays a Listbuilder object
 *}

{assign var=staticId value="component-"|concat:$grid->getId()}
{assign var=gridId value=$staticId|concat:'-'|uniqid}
{assign var=gridTableId value=$gridId|concat:"-table"}
{assign var=gridActOnId value=$gridTableId|concat:">tbody:first"}

<script type="text/javascript">
	$(function() {ldelim}
		$('#{$gridId|escape}').coreHandler(
			'$.core.controllers.listbuilder.ListbuilderHandler',
			{ldelim}
				{include file="controllers/listbuilder/listbuilderOptions.tpl"}
			{rdelim}
		);
	});
</script>


<div id="{$gridId|escape}" class="core_controllers_grid core_controllers_listbuilder formWidget">

	{* Use this disabled input to store LB deletions. See ListbuilderHandler.js *}
	<input disabled="disabled" type="hidden" class="deletions" />

	<div class="wrapper">
		{include file="controllers/grid/gridHeader.tpl"}
		{include file="controllers/listbuilder/listbuilderTable.tpl}
		{if $hasOrderLink}
			{include file="controllers/grid/gridOrderFinishControls.tpl" gridId=$staticId}
		{/if}
	</div>
</div>

