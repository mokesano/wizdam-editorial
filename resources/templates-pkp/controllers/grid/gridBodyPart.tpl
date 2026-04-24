{**
 * templates/controllers/grid/gridBodyPart.tpl
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * a set of grid rows within a tbody
 *}
<tbody>
	{foreach from=$rows item=row}
		{$row}
	{/foreach}
	<tr></tr>
</tbody>

