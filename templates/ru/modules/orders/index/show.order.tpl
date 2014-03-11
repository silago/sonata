
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


                
                
                <div class="content">

					<div class="product">
						<a class="back" href="/orderlist/"><p>Назад к списку</p></a>
						<h2>Заказ № {$id}</h2>	

						<div class="cont-block">
							<div class="my-order-list">
								<table>
									<tr class="title">
										<td class="num">Номер</td>
										<td class="status">Статус</td>
										<td class="date">Дата</td>
										<td class="delive">Доставка</td>
										<td class="pay">Оплата</td>
										<td class="summ">Сумма</td>
									</tr>

									<tr>
										<td class="num">{$id}</td>
										<td class="status"><span>
                                        
                            	{if $state == 0}
									В обработке
								{elseif $state == 1}
									Ожидает оплаты
								{elseif $state == 2}
										Оплачен
								{elseif $state == 3}
										Доставка
								{elseif $state == 4}
										Выполнен
								{elseif $state == 5}
										Отменен
								{/if}
    
                                        
                                        </span></td>
							<td class="date">{$date|date_format:"%d.%m.%Y"}</td>
										<td class="delive">
                                        
                                {if $data.sname == 1} Курьером {else} Самовывоз {/if}
                                        </td>
										<td class="pay">
                                        
                            {if $data.pname == 'cashpayment'} Наличными {else} Банкрвской картой {/if}
                                        </td>
										<td class="summ">{$order_data.total} руб.</td>
									</tr>
								</table>	
							</div>
						</div>

						<div class="info-list">
							<div class="box">
								<p><strong>Имя</strong> <span>{$data.order_name}</span></p>

								<p><strong>Телефон</strong> <span> {$data.order_phone}</span></p>

								<p><strong>e-mail</strong> <span>{$data.email}</span></p>	
							</div>

							<div class="box">
								<p><strong class="a1">Адрес:</strong> <span>
{$data.order_street} {$data.order_house} {$data.order_office}
                                </span></p>

								<p><strong class="a1">Дата дотавки:</strong> <span>{$data.order_date}</span></p>

								<p><strong class="a1">Время дотавки:</strong> <span>в {$data.order_time1}:{$data.order_time2}</span></p>	
							</div>	
						</div>

						<div class="structure">
							<h3>Состав заказа</h3>	

							<div class="structure-box">
								<div class="basket-cont">
						<table>
							<tr class="title">
								<!-- <td class="imgs"></td> -->
								<td class="imgs" style="width:0px; padding-right:0px;"></td>
								<td class="name">Название</td>
								<td class="ed">Цена за ед.</td>
								<td class="kv">Кол-во</td>
								<td class="summ">Сумма</td>
							</tr>

						        {foreach from=$order_data item=item}
							    {if isset($item.name)}
                                
                                <tr>
                                <td class="imgs" style="width:0px; padding-right:0px;"> </td>
								<!--
                                 <td class="imgs"><a href="#"><img src="images/img-table.jpg" height="67" width="67" alt="" /></a></td>
								-->
                                 <td class="name">
									<a href="#">{$item.name}</a>
								</td>
								<td class="ed">{$item.price} руб.</td>
								<td class="kv">{$item.quantity}</td>
								<td class="summ"><span>{$item.total} руб.</span></td>
							</tr>
{/if}
                            {/foreach}
						</table>
					</div>	
							</div>
						</div>
					</div>
				</div>	
                
                
                
                </div>
</div>
</div>
