{**
 * templates/common/urlInDiv.tpl
 *
 * [WIZDAM EDITION] AJAX Loader
 * Memuat konten URL ke dalam DIV secara asinkron (Lazy Load).
 *}

<script type="text/javascript">
    $(function() {ldelim}
        // Panggil handler JS UrlInDivHandler
        $('#{$inDivDivId|escape:"javascript"}').coreHandler(
            '$.core.controllers.UrlInDivHandler',
            {ldelim}
                sourceUrl: '{$inDivUrl|escape:"javascript"}'
            {rdelim}
        );
    {rdelim});
</script>

<div id="{$inDivDivId|escape}" class="core_url_in_div {if $inDivClass}{$inDivClass|escape}{/if}">
    {$inDivLoadMessage}
</div>