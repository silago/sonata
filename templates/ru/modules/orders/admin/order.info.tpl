<div id="order-info"></div>
<table class="table table-condensed table-striped table-bordered">
    <thead>
    <tr>
        <th style="text-align:center">Наименование товара</th>
        <th style="text-align:center">Цена</th>
		<th style="text-align:center">Количество</th>
		<th style="text-align:center">Сумма</th>			
		{if $edit}<th style="text-align:center">Удалить</th>		{/if}	
    </tr>
    </thead>
    <tbody>
    
    
	{if $orderData.total !='0.00'}
		{foreach from=$orderData item=item key=key}
			{if is_int($key)}
				<tr>
					<td style="text-align:left">{$item.name}</td>
					<td style="text-align:center">{$item.price} руб.</td>
					<td style="text-align:center">
						{if $edit}
						<input id='q{$key}' value="{$item.quantity}" type="text">
							<a onclick="$(this).attr('href','/admin/orders/viewOrder.php?id={$id}&orderitemid={$key}&orderitemcount='+$('#q{$key}').val()); ";  href='#'> Применить </a>
						{else}
							{$item.quantity}						
						{/if}
						</td>
					<td style="text-align:center;">{$item.total}  руб.</td>						
					{if $edit}<td style="text-align:center;width:90px;">
						
						<div class="btn-group" style="padding-left:25px;">        
							<a class="btn btn-danger" onclick='return deleteItem("{$id}","{$key}");' href="#"><i class="icon-trash icon-white"></i></a>
						</div>
						
					</td>{/if}
				</tr>
			{/if}
    {/foreach}
			<tr>
			<td colspan=4>
			{ if $datadata.discountType }
			Скидка: {$datadata.discountType}. Код: {$datadata.discountValue}
			{/if} </td>
			</tr>
			<tr>
			<td colspan=4>
			{ if $datadata.comment }
			Комментарий к заказу: {$datadata.comment}.
			{/if}
			</tr>
    
    
			{if $orderData.sprice!='0.00'}
			<tr>
				<td style="text-align:left">Доставка</td>
				<td style="text-align:center">{$orderData.sprice}  руб.</td>
				<td style="text-align:center">1</td>
				<td style="text-align:center">{$orderData.sprice}  руб.</td>
				<td style="text-align:center"></td>
			</tr>
			{/if}
			{if $orderData.sprice!='0.00'}
				<tr>
					<td colspan="3" style="text-align:right"><strong>Итого:</strong></td>				
					<td colspan="2"  style="text-align:center">{$orderData.cost}  руб.</td>				
				</tr>
			{else}
				<tr>
					<td colspan="3" style="text-align:right"><strong>Итого:</strong></td>				
					<td colspan="2"  style="text-align:center">{$orderData.total}  руб.</td>				
				</tr>
			{/if}
			
	{else}
		<tr>
			<td style="text-align:center" colspan="5"><strong>В данном заказе нет позиций</strong></td>
		</tr>
	{/if}
    </tbody>
</table>
