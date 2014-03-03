<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление магазином</a><span class="divider">/</span></li>
        <li><a href="/admin/orders/showList.php">Заказы</a><span class="divider">/</span></li>
        <li><a href="/admin/orders/paymentsList.php">Список видов доставки</a><span class="divider">/</span></li>
		<li class="active">Добавление вида доставки</li>
    </ul>
</div>
{if $error}
	<div class="alert alert-error">
		{foreach from=$error item=item key=key}
				{$item}<br/>
		{/foreach}
	</div>
{/if}
<form method="post" action="/admin/orders/addShipment.php">
  <fieldset>
    <div class="control-group">
		<label class="control-label" for="sname"><strong>Наименование вида доставки:</strong></label>
			<div class="controls">
				<input type="text" class="span6" id="sname" name="sname" value="{$sname}">
				<input type="hidden" name="go" value="go">
			</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="sprice"><strong>Стоимость доставки:</strong></label>
			<div class="controls">
				<input type="text" class="span6" id="sprice" name="sprice" value="{$sprice}">				
			</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="seriod"><strong>Срок доставки:</strong></label>
			<div class="controls">
				<input type="text" class="span6" id="speriod" name="speriod" value="{$speriod}">				
			</div>
	</div>
	
	<div class="control-group">		
			<label class="control-label" for=""><strong>Вида оплат:</strong></label>
			<div class="controls">
				{foreach from=$payments item=item key=key}
					<label class="checkbox">
						<input type="checkbox" name="payment[]" value="{$item.title}" {foreach from=$payment item=item1 key=key1}{if $item.title == $item1}checked{/if}{/foreach}> {$item.name}
					</label>
				{/foreach}				
			</div>
	</div>
	
    <button type="submit" class="btn btn-primary">Добавить</button>
  </fieldset>
</form>