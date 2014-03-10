<?php /* Smarty version 2.6.16, created on 2014-03-10 23:16:57
         compiled from ru/modules/orders/index/orders.list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'show_menu', 'ru/modules/orders/index/orders.list.tpl', 15, false),array('modifier', 'date_format', 'ru/modules/orders/index/orders.list.tpl', 61, false),)), $this); ?>
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
											<?php if ($this->_tpl_vars['orders']): ?>
						<?php $_from = $this->_tpl_vars['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                        <tr class="proces-bg">
                            <td> <?php echo $this->_tpl_vars['item']['id']; ?>
</td>
							<td>
								<?php if ($this->_tpl_vars['item']['state'] == 0): ?>
									В обработке
								<?php elseif ($this->_tpl_vars['item']['state'] == 1): ?>
									Ожидает оплаты
								<?php elseif ($this->_tpl_vars['item']['state'] == 2): ?>
										Оплачен
								<?php elseif ($this->_tpl_vars['item']['state'] == 3): ?>
										Доставка
								<?php elseif ($this->_tpl_vars['item']['state'] == 4): ?>
										Выполнен
								<?php elseif ($this->_tpl_vars['item']['state'] == 5): ?>
										Отменен
								<?php endif; ?>
                                </td>
							<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</td>
							<td><?php echo $this->_tpl_vars['item']['order_data']['cost']; ?>
 руб.</td>
															
								
							<td><a style="color: #817A7A; text-decoration: none;" href="/order?order_id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['id']; ?>
</a></td>
							</td>														
						</tr>
						<?php endforeach; endif; unset($_from); ?>						
						<?php else: ?>
							<tr class="sectiontableentry2">
								<td    style="padding:20px;" colspan="5"><strong>Ваш список заказов пуст<strong></td>
							</tr>
						<?php endif; ?>
					</tbody>	
			</table>

            </div>
</div>
</div>
</div>
</div>
</div>