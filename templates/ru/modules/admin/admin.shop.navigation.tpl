{foreach from=$array item=item key=key}
    {if $item.area == 'shop'}
        <li><a href="{$item.navigation.1.url}">{$item.moduleName}</a></li>
    {/if}
{/foreach}