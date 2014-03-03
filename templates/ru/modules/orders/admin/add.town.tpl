<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление магазином</a><span class="divider">/</span></li>
        <li><a href="/admin/orders/showList.php">Заказы</a><span class="divider">/</span></li>
        <li><a href="/admin/orders/townsList.php">Список адресов</a><span class="divider">/</span></li>
		<li class="active">Добавление адреса</li>
    </ul>
</div>
{if $error}
	<div class="alert alert-error">
		{foreach from=$error item=item key=key}
				{$item}<br/>
		{/foreach}
	</div>
{/if}
<form method="post" action="/admin/orders/addTown.php">
  <fieldset>
    <div class="control-group">
		<label class="control-label" for="tname"><strong>Адрес:</strong></label>
			<div class="controls">
				<input type="text" class="span6" id="tname" name="tname" value="{$tname}">
				<input type="hidden" name="go" value="go">
			</div>
	</div>	
	
	<div class="control-group">		
			<label class="control-label" for=""><strong>Виды доставки:</strong></label>
			<div class="controls">
				{foreach from=$shipments item=item key=key}
					<label class="checkbox">
						<input type="checkbox" name="shipment[]" value="{$item.id}" {foreach from=$shipment item=item1 key=key1}{if $item.id == $item1}checked{/if}{/foreach}> {$item.sname}
					</label>
				{/foreach}				
			</div>
	</div>
	
    <button type="submit" class="btn btn-primary">Добавить</button>
  </fieldset>
</form>
