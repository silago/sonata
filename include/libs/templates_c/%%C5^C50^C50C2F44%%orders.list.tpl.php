<?php /* Smarty version 2.6.16, created on 2013-10-21 17:01:39
         compiled from ru/modules/orders/index/orders.list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'ru/modules/orders/index/orders.list.tpl', 40, false),)), $this); ?>
<?php echo '
<style>
.prods_content td, .prods_content th {padding:10px;}
</style>
'; ?>


  
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
						<?php if ($this->_tpl_vars['orders']): ?>
						<?php $_from = $this->_tpl_vars['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
						<tr class="sectiontableentry2">
							<td    style="border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5;"><a style="color: #817A7A; text-decoration: none;" href="/order?order_id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['id']; ?>
</a></td>
							<td    style="border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5;"><a style="color: #817A7A; text-decoration: none;" href="/order?order_id=<?php echo $this->_tpl_vars['item']['id']; ?>
">
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
								</a>
							</td>
							<td align="" style="border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5;"><a style="color: #817A7A; text-decoration: none;" href="/order?order_id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</a></td>
							<td align="" style="border-right: 1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;"><a style="color: #817A7A; text-decoration: none;" href="/order?order_id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['order_data']['cost']; ?>
 руб.</a></td>
							<td    style="border-bottom:1px solid #E5E5E5;">
								
									<div class="itemCart" style="float:center;padding-left:8px;">
										<form method="post" action="/bill/" target="_blank" id="bill">
											<input type="hidden" name="order_id" value="<?php echo $this->_tpl_vars['item']['id']; ?>
">
												<input class="button_4" type="submit" value="<?php echo $this->_tpl_vars['item']['button']; ?>
">
											</form>										
									</div>									
								
							</td>														
						</tr>
						<?php endforeach; endif; unset($_from); ?>						
						<?php else: ?>
							<tr class="sectiontableentry2">
								<td    colspan="5"><strong>Ваш список заказов пуст<strong></td>
							</tr>
						<?php endif; ?>
					</tbody>	
			</table>
