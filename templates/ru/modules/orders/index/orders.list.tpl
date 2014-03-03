{literal}
<style>
.prods_content td, .prods_content th {padding:10px;}
</style>
{/literal}

  
            <table  border="0" cellspacing="0" cellpadding="0" class="prods_content cart" style="width:90%; margin-left:10px; color: #888;">
					<tbody>
						<tr>
							<th    colspan="5">Список заказов</th>
						</tr>
						<tr>
							<th   >№ заказа</th>
							<th   >Статус заказа</th>
							<th   >Дата оформления заказа</th>
							<th   >Сумма заказа</th>														
							<th   >Оплата</th>
						</tr>
						{if $orders}
						{foreach from=$orders item=item key=key}
						<tr class="sectiontableentry2">
							<td    style="border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5;"><a style="color: #817A7A; text-decoration: none;" href="/order?order_id={$item.id}">{$item.id}</a></td>
							<td    style="border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5;"><a style="color: #817A7A; text-decoration: none;" href="/order?order_id={$item.id}">
								{if $item.state == 0}
									В обработке
								{elseif $item.state == 1}
									Ожидает оплаты
								{elseif $item.state == 2}
										Оплачен
								{elseif $item.state == 3}
										Доставка
								{elseif $item.state == 4}
										Выполнен
								{elseif $item.state == 5}
										Отменен
								{/if}
								</a>
							</td>
							<td align="" style="border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5;"><a style="color: #817A7A; text-decoration: none;" href="/order?order_id={$item.id}">{$item.date|date_format:"%d.%m.%Y"}</a></td>
							<td align="" style="border-right: 1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;"><a style="color: #817A7A; text-decoration: none;" href="/order?order_id={$item.id}">{$item.order_data.cost} руб.</a></td>
							<td    style="border-bottom:1px solid #E5E5E5;">
								
									<div class="itemCart" style="float:center;padding-left:8px;">
										<form method="post" action="/bill/" target="_blank" id="bill">
											<input type="hidden" name="order_id" value="{$item.id}">
												<input class="button_4" type="submit" value="{$item.button}">
											</form>										
									</div>									
								
							</td>														
						</tr>
						{/foreach}						
						{else}
							<tr class="sectiontableentry2">
								<td    colspan="5"><strong>Ваш список заказов пуст<strong></td>
							</tr>
						{/if}
					</tbody>	
			</table>

