<div class="boxPadding">    
    {if $pages}
    <ul>        
        {foreach from=$pages key=key item=item}          
			{if $key == 1000}
				<li><span>...</span></li>
				<li><a href="?{$s}&{$additfstring}page={$item}">{$item}</a></li>				
			{elseif $key == 999}
				<li><a href="?{$s}&{$additfstring}page={$item}">{$item}</a></li>
			{elseif $key == -1}				
				<li><a href="?{$s}&{$additfstring}page={$item}">{$item}</a></li>				
				<li><span>...</span></li>
			{elseif $key == -2}				
				<li><a href="?{$s}&{$additfstring}page={$item}">{$item}</a></li>
			{else}
				{if $item==$currpage}
					<li class="active"><a href="">{$item}</a></li>
				{else}
					<li><a href="?{$s}&{$additfstring}page={$item}">{$item}</a></li>
				{/if}
			{/if}
				
        {/foreach}
    </ul>
    {/if}
</div>
