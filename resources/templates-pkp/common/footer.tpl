{**
 * templates/common/footer.tpl
 *
 * Copyright (c) 2013-2019 Sangia Publishing House
 * Copyright (c) 2000-2019 Rochmady and Wizdam Team
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Common site footer.
 *
 *}
</div><!-- content -->
</div><!-- main -->
</div><!-- body -->
</div><!-- entah -->

</main><!-- container -->

<footer id="footer">
{if $displayCreativeCommons}
	{translate key="common.ccLicense"}
{/if}
{call_hook name="Templates::Common::Footer::PageFooter"}
{if $pageFooter}
	<br /><br />
	<div id="pageFooter">{$pageFooter}</div>
{/if}
</footer>

{get_debug_info}
{if $enableDebugStats}{include file=$pqpTemplate}{/if}

</body>
</html>
