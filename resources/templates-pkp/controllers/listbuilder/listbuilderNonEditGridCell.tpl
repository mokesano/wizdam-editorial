{**
 * templates/controllers/grid/listbuilderNonEditGridCell.tpl
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * a regular listbuilder grid cell (with or without actions), but uneditable.
 *}
{if $id}
	{assign var=cellId value="cell-"|concat:$id}
{else}
	{assign var=cellId value=""}
{/if}
<span {if $cellId}id="{$cellId|escape}" {/if}class="core_linkActions gridCellContainer">
	<div class="gridCellDisplay">
		{* Display the current value *}
		{include file="controllers/grid/gridCellContents.tpl"}
	</div>

	<div class="gridCellEdit">
		{* To hide the cell contents *}
	</div>
</span>

