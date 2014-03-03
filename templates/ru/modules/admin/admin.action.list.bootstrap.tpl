<div class="subnav">
<ul class="nav nav-pills">
{foreach from=$array item=item}
	{if !empty($item.subActions)}
		
		<li class="dropdown"><a href="{$item.uri}" class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="{$item.icon}"></i> {$item.actionName} <b class="caret"></b></a>
			<ul class="dropdown-menu">
			{foreach from=$item.subActions item=item key=key}
				<li><a href="{$item.uri}"><i class="{$item.icon}"></i>  {$item.subActionName}</a></li>
			{/foreach}
			</ul>
		</li>
	{else}
		{if $item.actionName == 'Настройки модуля'}<li class="pull-right"><a href="{$item.uri}"><i class="{$item.icon}"></i>  {$item.actionName}</a></li>{else}<li><a href="{$item.uri}"><i class="{$item.icon}"></i>  {$item.actionName}</a></li>{/if}		
	{/if}	
{/foreach}
</ul>
</div>