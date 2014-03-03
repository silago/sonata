<div class="breadcrumbs">
    <div class="warp">
        <a href="/"> Главная </a> »
    {foreach from=$array item=item key=key}
        <a href="/{$item.data.url}">{$item.data.title}</a>{if $key != $count} »{/if}
    {/foreach}
    </div><!-- warp -->
</div>