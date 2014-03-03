<div class="breadcrumbs">
    <div class="warp">
        <a href="/catalog"> Каталог </a>
        {foreach from=$array item=item key=key}
		<img src="/templates/ru/images/img/marker_breadcrumb.png"   alt="" border=0 />
        <a href="/{$item.data.url}">{$item.data.title}</a>{if $key != $count} {/if}
        {/foreach}
    </div>
</div>
