{**
 * templates/controllers/grid/feature/gridOrderFinishControls.tpl
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Controls (button and link) to finish the ordering action in grids.
 *}
<div class="grid_controls order_finish_controls">
{fbvElement type="link" class="cancelFormButton core_helpers_align_left" id=$gridId|concat:"-cancel" label="grid.action.cancelOrdering"}
{fbvElement type="link" class="saveButton core_helpers_align_right" id=$gridId|concat:"-saveButton" label="common.done"}
</div>
