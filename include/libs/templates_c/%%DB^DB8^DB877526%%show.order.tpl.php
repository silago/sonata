<?php /* Smarty version 2.6.16, created on 2014-03-11 15:38:07
         compiled from ru/modules/orders/index/show.order.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'show_menu', 'ru/modules/orders/index/show.order.tpl', 16, false),array('modifier', 'date_format', 'ru/modules/orders/index/show.order.tpl', 70, false),)), $this); ?>

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
                             <?php echo smarty_function_show_menu(array('menuid' => 7), $this);?>

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
						<h2>Заказ № <?php echo $this->_tpl_vars['id']; ?>
</h2>	

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
										<td class="num"><?php echo $this->_tpl_vars['id']; ?>
</td>
										<td class="status"><span>
                                        
                            	<?php if ($this->_tpl_vars['state'] == 0): ?>
									В обработке
								<?php elseif ($this->_tpl_vars['state'] == 1): ?>
									Ожидает оплаты
								<?php elseif ($this->_tpl_vars['state'] == 2): ?>
										Оплачен
								<?php elseif ($this->_tpl_vars['state'] == 3): ?>
										Доставка
								<?php elseif ($this->_tpl_vars['state'] == 4): ?>
										Выполнен
								<?php elseif ($this->_tpl_vars['state'] == 5): ?>
										Отменен
								<?php endif; ?>
    
                                        
                                        </span></td>
							<td class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</td>
										<td class="delive">
                                        
                                <?php if ($this->_tpl_vars['data']['sname'] == 1): ?> Курьером <?php else: ?> Самовывоз <?php endif; ?>
                                        </td>
										<td class="pay">
                                        
                            <?php if ($this->_tpl_vars['data']['pname'] == 'cashpayment'): ?> Наличными <?php else: ?> Банкрвской картой <?php endif; ?>
                                        </td>
										<td class="summ"><?php echo $this->_tpl_vars['order_data']['total']; ?>
 руб.</td>
									</tr>
								</table>	
							</div>
						</div>

						<div class="info-list">
							<div class="box">
								<p><strong>Имя</strong> <span><?php echo $this->_tpl_vars['data']['order_name']; ?>
</span></p>

								<p><strong>Телефон</strong> <span> <?php echo $this->_tpl_vars['data']['order_phone']; ?>
</span></p>

								<p><strong>e-mail</strong> <span><?php echo $this->_tpl_vars['data']['email']; ?>
</span></p>	
							</div>

							<div class="box">
								<p><strong class="a1">Адрес:</strong> <span>
<?php echo $this->_tpl_vars['data']['order_street']; ?>
 <?php echo $this->_tpl_vars['data']['order_house']; ?>
 <?php echo $this->_tpl_vars['data']['order_office']; ?>

                                </span></p>

								<p><strong class="a1">Дата дотавки:</strong> <span><?php echo $this->_tpl_vars['data']['order_date']; ?>
</span></p>

								<p><strong class="a1">Время дотавки:</strong> <span>в <?php echo $this->_tpl_vars['data']['order_time1']; ?>
:<?php echo $this->_tpl_vars['data']['order_time2']; ?>
</span></p>	
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

						        <?php $_from = $this->_tpl_vars['order_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
							    <?php if (isset ( $this->_tpl_vars['item']['name'] )): ?>
                                
                                <tr>
                                <td class="imgs" style="width:0px; padding-right:0px;"> </td>
								<!--
                                 <td class="imgs"><a href="#"><img src="images/img-table.jpg" height="67" width="67" alt="" /></a></td>
								-->
                                 <td class="name">
									<a href="#"><?php echo $this->_tpl_vars['item']['name']; ?>
</a>
								</td>
								<td class="ed"><?php echo $this->_tpl_vars['item']['price']; ?>
 руб.</td>
								<td class="kv"><?php echo $this->_tpl_vars['item']['quantity']; ?>
</td>
								<td class="summ"><span><?php echo $this->_tpl_vars['item']['total']; ?>
 руб.</span></td>
							</tr>
<?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?>
						</table>
					</div>	
							</div>
						</div>
					</div>
				</div>	
                
                
                
                </div>
</div>
</div>