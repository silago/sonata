{if $tree}
<ul style=""  class="main-menu">
{foreach from=$tree key=key item=item}
	<li id="top_menu_{$item.id}">	
	<a href="{$item.data.url}" title="{$item.data.title}">{$item.data.title}</a><input type="hidden" name="id" value="{$item.id}">
		{include file="$dir/templates/ru/plugins/showMenu/index.tpl" tree=$item.children}		
	</li>	
{/foreach}
</ul>
{/if}
