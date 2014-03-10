<div style="margin-top:-20px; clear:left;" class="container-content">
		<div class="aside-setting">
					<div class="nav-aside">
						<ul>
							<li><a href="/cabinet">Личный кабинет</a></li>
							<li class="active"><a href="/orderslist">Мои заказы</a></li>
							<li><a href="/basket">Моя корзина</a></li>
						</ul>	
					</div>

					<div class="help">
						<span>Помощь</span>

						<div class="block">
                             {show_menu menuid=7}
						<!--	<p><a class="orders" href="#">Как заказать</a></p>	
							<p><a class="delivery" href="#">Условия доставки</a></p>
							<p><a class="pay" href="#">Условия оплаты</a></p>	
						-->
                            </div>	
					</div>
				</div>


            
				<div class="content">

					<div class="product">
           		<h2>Мои заказы</h2>	

						<div class="cont-block">
							<div class="my-order">
                    <table >
					<tbody>			<tr class="title">
										<td class="num">Номер</td>
										<td class="status">Статус</td>
										<td class="date">Дата</td>
										<td class="pay">Оплата</td>
										<td class="summ">Сумма</td>
										<td></td>
									</tr>
											{if $orders}
						{foreach from=$orders item=item key=key}
                        <tr class="proces-bg">
                            <td> {$item.id}</td>
							<td>
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
                                </td>
							<td>{$item.date|date_format:"%d.%m.%Y"}</td>
							<td>{$item.order_data.cost} руб.</td>
															
								
							<td><a style="color: #817A7A; text-decoration: none;" href="/order?order_id={$item.id}">{$item.id}</a></td>
							</td>														
						</tr>
						{/foreach}						
						{else}
							<tr class="sectiontableentry2">
								<td    style="padding:20px;" colspan="5"><strong>Ваш список заказов пуст<strong></td>
							</tr>
						{/if}
					</tbody>	
			</table>

            </div>
</div>
</div>
</div>
</div>
</div>
