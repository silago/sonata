<script>
	$("a[href $= 'listItems.php']").parent().parent().append('<li><a href="/admin/tags/">Бренды</a></li>');
</script>

<div class="subnav">
<ul class="nav nav-pills">
{foreach from=$navigation item=item key=key}

    {if $item.type=="config"}
        <li class="pull-right"><a href="{$item.url}"><i class="{$item.icon}"></i> {$item.actionName}</a></li>
    {else}
        <li><a href="{$item.url}">{$item.actionName}</a></li>
    {/if}
{/foreach}
</ul>
</div>