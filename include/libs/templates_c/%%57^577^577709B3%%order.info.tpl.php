<?php /* Smarty version 2.6.16, created on 2014-03-05 15:48:11
         compiled from ru/modules/orders/admin/order.info.tpl */ ?>
<div id="order-info"></div>
<table class="table table-condensed table-striped table-bordered">
    <thead>
    <tr>
        <th style="text-align:center">Наименование товара</th>
        <th style="text-align:center">Цена</th>
		<th style="text-align:center">Количество</th>
		<th style="text-align:center">Сумма</th>			
		<?php if ($this->_tpl_vars['edit']): ?><th style="text-align:center">Удалить</th>		<?php endif; ?>	
    </tr>
    </thead>
    <tbody>
    
    
	<?php if ($this->_tpl_vars['orderData']['total'] != '0.00'): ?>
		<?php $_from = $this->_tpl_vars['orderData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<?php if (is_int ( $this->_tpl_vars['key'] )): ?>
				<tr>
					<td style="text-align:left"><?php echo $this->_tpl_vars['item']['name']; ?>
</td>
					<td style="text-align:center"><?php echo $this->_tpl_vars['item']['price']; ?>
 руб.</td>
					<td style="text-align:center">
						<?php if ($this->_tpl_vars['edit']): ?>
						<input id='q<?php echo $this->_tpl_vars['key']; ?>
' value="<?php echo $this->_tpl_vars['item']['quantity']; ?>
" type="text">
							<a onclick="$(this).attr('href','/admin/orders/viewOrder.php?id=<?php echo $this->_tpl_vars['id']; ?>
&orderitemid=<?php echo $this->_tpl_vars['key']; ?>
&orderitemcount='+$('#q<?php echo $this->_tpl_vars['key']; ?>
').val()); ";  href='#'> Применить </a>
						<?php else: ?>
							<?php echo $this->_tpl_vars['item']['quantity']; ?>
						
						<?php endif; ?>
						</td>
					<td style="text-align:center;"><?php echo $this->_tpl_vars['item']['total']; ?>
  руб.</td>						
					<?php if ($this->_tpl_vars['edit']): ?><td style="text-align:center;width:90px;">
						
						<div class="btn-group" style="padding-left:25px;">        
							<a class="btn btn-danger" onclick='return deleteItem("<?php echo $this->_tpl_vars['id']; ?>
","<?php echo $this->_tpl_vars['key']; ?>
");' href="#"><i class="icon-trash icon-white"></i></a>
						</div>
						
					</td><?php endif; ?>
				</tr>
			<?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
			<tr>
			<td colspan=4>
			<?php if ($this->_tpl_vars['datadata']['discountType']): ?>
			Скидка: <?php echo $this->_tpl_vars['datadata']['discountType']; ?>
. Код: <?php echo $this->_tpl_vars['datadata']['discountValue']; ?>

			<?php endif; ?> </td>
			</tr>
			<tr>
			<td colspan=4>
			<?php if ($this->_tpl_vars['datadata']['comment']): ?>
			Комментарий к заказу: <?php echo $this->_tpl_vars['datadata']['comment']; ?>
.
			<?php endif; ?>
			</tr>
            <tr><td>Имя:</td>           <td colspan=4>           <?php echo $this->_tpl_vars['datadata']['order_name']; ?>
</td></tr>
            <tr><td>Телефон:</td>       <td colspan=4>       <?php echo $this->_tpl_vars['datadata']['order_phone']; ?>
</td></tr>
            <tr><td>Email:</td>         <td colspan=4>         <?php echo $this->_tpl_vars['datadata']['order_email']; ?>
</td></tr>
            <tr><td>Улица:</td>         <td colspan=4>         <?php echo $this->_tpl_vars['datadata']['order_street']; ?>
</td></tr>
            <tr><td>Дом:</td>           <td colspan=4>           <?php echo $this->_tpl_vars['datadata']['order_house']; ?>
</td></tr>
            <tr><td>Корпус:</td>        <td colspan=4>        <?php echo $this->_tpl_vars['datadata']['order_corp']; ?>
</td></tr>
            <tr><td>Офис:</td>          <td colspan=4>          <?php echo $this->_tpl_vars['datadata']['order_office']; ?>
</td></tr>
            <tr><td>Дата доставки:</td> <td colspan=4> <?php echo $this->_tpl_vars['datadata']['order_date']; ?>
</td></tr>
            <tr><td>Время доставки:</td><td colspan=4><?php echo $this->_tpl_vars['datadata']['order_time1']; ?>
</td></tr>
            <tr><td>Время доставки:</td><td colspan=4><?php echo $this->_tpl_vars['datadata']['order_time2']; ?>
</td></tr>
            <tr><td>Тип оплаты:</td>    <td colspan=4>    <?php echo $this->_tpl_vars['datadata']['pname']; ?>
</td></tr>
    
			<?php if ($this->_tpl_vars['orderData']['sprice'] != '0.00'): ?>
			<tr>
				<td style="text-align:left">Доставка</td>
				<td style="text-align:center"><?php echo $this->_tpl_vars['orderData']['sprice']; ?>
  руб.</td>
				<td style="text-align:center">1</td>
				<td style="text-align:center"><?php echo $this->_tpl_vars['orderData']['sprice']; ?>
  руб.</td>
				<td style="text-align:center"></td>
			</tr>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['orderData']['sprice'] != '0.00'): ?>
				<tr>
					<td colspan="3" style="text-align:right"><strong>Итого:</strong></td>				
					<td colspan="2"  style="text-align:center"><?php echo $this->_tpl_vars['orderData']['cost']; ?>
  руб.</td>				
				</tr>
			<?php else: ?>
				<tr>
					<td colspan="3" style="text-align:right"><strong>Итого:</strong></td>				
					<td colspan="2"  style="text-align:center"><?php echo $this->_tpl_vars['orderData']['total']; ?>
  руб.</td>				
				</tr>
			<?php endif; ?>
			
	<?php else: ?>
		<tr>
			<td style="text-align:center" colspan="5"><strong>В данном заказе нет позиций</strong></td>
		</tr>
	<?php endif; ?>
    </tbody>
</table>