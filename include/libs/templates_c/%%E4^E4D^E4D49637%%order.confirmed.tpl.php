<?php /* Smarty version 2.6.16, created on 2013-10-23 16:05:22
         compiled from ru/modules/orders/index/mail/order.confirmed.tpl */ ?>
﻿<html><body><p>Здравствуйте!</p><p>&nbsp</p><p>Ваш заказ № <?php echo $this->_tpl_vars['orderid']; ?>
 успешно принят в обработку. Благодарим, что выбрали нашу компанию.</p><p>Состав вашего заказа:<br/><br/><table>	<tr>		<th align="left">Наименование товара</th>		<th align="left">Цена</th>		<th align="center">Количество</th>		<th align="center">Итого</th>															</tr>			<?php $_from = $this->_tpl_vars['order_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>			<?php if (is_int ( $this->_tpl_vars['key'] )): ?>				<tr>					<td align="left"><?php echo $this->_tpl_vars['item']['name']; ?>
</td>					<td align="center"><?php echo $this->_tpl_vars['item']['price']; ?>
 руб.</td>					<td align="center"><?php echo $this->_tpl_vars['item']['quantity']; ?>
</td>					<td align="center"><?php echo $this->_tpl_vars['item']['total']; ?>
 руб.</td>				</tr>			<?php endif; ?>		<?php endforeach; endif; unset($_from); ?>							</table></p><p>Доставка<br/>Вид доставки: <?php echo $this->_tpl_vars['shipmentName']; ?>
				<?php if ($this->_tpl_vars['datadata']['addr']): ?>		<br> Адрес: <?php echo $this->_tpl_vars['datadata']['addr']; ?>
 		<?php endif; ?>				<?php if ($this->_tpl_vars['datadata']['ddate']): ?>		<br> Дата: <?php echo $this->_tpl_vars['datadata']['ddate']; ?>
 		<?php endif; ?>				<?php if ($this->_tpl_vars['datadata']['town2']): ?>		<br>		Адрес: <?php echo $this->_tpl_vars['datadata']['town2']; ?>
 		<?php endif; ?>				<?php if ($this->_tpl_vars['datadata']['ddate2']): ?>		<br> Дата: <?php echo $this->_tpl_vars['datadata']['ddate2']; ?>
 		<?php endif; ?>		<br>Стоимость доставки: <?php echo $this->_tpl_vars['shipmentPrice']; ?>
 руб.<br/><?php if ($this->_tpl_vars['shipmentPeriod']): ?>Срок доставки: <?php echo $this->_tpl_vars['shipmentPeriod'];  endif; ?></p><p>Итого к оплате:<?php if ($this->_tpl_vars['shipmentPrice'] != '0.00'): ?>	<?php echo $this->_tpl_vars['cost']; ?>
 руб.<?php else: ?>	<?php echo $this->_tpl_vars['total']; ?>
 руб.<?php endif; ?></p><p>Тип оплаты: <?php echo $this->_tpl_vars['paymentName']; ?>
</p><p> --------------------- </p><p>&nbsp</p>	<p>	<?php echo $this->_tpl_vars['appName']; ?>
<br/><a href="http://<?php echo $this->_tpl_vars['sitename']; ?>
"><?php echo $this->_tpl_vars['sitename']; ?>
</a><br/><?php echo $this->_tpl_vars['adminEmail']; ?>
<br/><?php echo $this->_tpl_vars['adminPhone']; ?>
</p></body><html>