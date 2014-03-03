<?php /* Smarty version 2.6.16, created on 2014-03-03 13:34:39
         compiled from ru/modules/orders/admin/show.order.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'ru/modules/orders/admin/show.order.tpl', 49, false),)), $this); ?>
<?php echo '
	<script>
	function sort(){
		var status = jQuery(\'select#status option:selected\').val();		
		if(status.length > 0){
			document.location = \'/admin/orders/showList.php?status=\'+status;			
		}else{
			document.location = \'/admin/orders/showList.php\';			
		}		
		return false;
	}
	
	function deleteItem(orderid, itemid){
		if(confirm(\'Удалить позицию?\')){
			jQuery.ajax({
                type: \'POST\',
                url: \'/admin/orders/deleteItem.php\',
				dataType: "json",                 
                data: {orderid:orderid, itemid:itemid},				
                success: function(data){					
					jQuery(\'div#order-data\').html(data.content);
					jQuery(\'div#order-info\').html(data.info);
					jQuery(\'div#order-info\').addClass(\'alert\').addClass(\'alert-success\');					
                }
            });		
		}		
		return false;
	}
	
	</script>
'; ?>


<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление магазином</a><span class="divider">/</span></li>
        <li><a href="/admin/orders/showList.php">Заказы</a><span class="divider">/</span></li>
        <li class="active">Просмотр заказа № <?php echo $this->_tpl_vars['id']; ?>
</li>
    </ul>
</div>

<?php if ($this->_tpl_vars['error']): ?>
<div class="alert alert-error">              
	<?php $_from = $this->_tpl_vars['error']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
		<?php echo $this->_tpl_vars['item']; ?>
<br/>
	<?php endforeach; endif; unset($_from); ?>
</div>
<?php endif; ?>

<div><span> Заказ № <?php echo $this->_tpl_vars['id']; ?>
 </span> <span> <?php echo ((is_array($_tmp=$this->_tpl_vars['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
 </span> </div>
<br>
<br>
<div id="order-data">
	<div id="order-info"></div>
	<?php echo $this->_tpl_vars['orderData']; ?>

</div>
<br>

<?php if ($this->_tpl_vars['datadata']['discountType']): ?>
Скидка: <?php echo $this->_tpl_vars['datadata']['discountType']; ?>
. Код: <?php echo $this->_tpl_vars['datadata']['discountValue']; ?>

<?php endif; ?>
<br>
<?php if ($this->_tpl_vars['datadata']['comment']): ?>
Комментарий к заказу: <?php echo $this->_tpl_vars['datadata']['comment']; ?>
.
<?php endif; ?>
<br>
<br>
<div style="border:1px solid black; display:inline-block; margin-right:1%; width:44%; padding:2%;" class="">
<h2>Доставка</h2>

	<div>
		<table>
		<tr> 
			<td> Вид доставки:</td>
			<td> <?php $_from = $this->_tpl_vars['shipments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?> <?php if ($this->_tpl_vars['item']['id'] == $this->_tpl_vars['shipment_id']): ?> <?php echo $this->_tpl_vars['item']['sname']; ?>
 <?php endif; ?> <?php endforeach; endif; unset($_from); ?>	</td>
		</tr>
		
		<?php if ($this->_tpl_vars['datadata']['addr']): ?>
		<tr> 
			<td> Адрес:</td>
			<td> <?php echo $this->_tpl_vars['datadata']['addr']; ?>
 </td>
		</tr>
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['datadata']['ddate']['name']): ?>
		<tr> 
			<td> Дата:</td>
			<td> <?php echo $this->_tpl_vars['datadata']['ddate']; ?>
 </td>
		</tr>
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['datadata']['time1']): ?>
		<tr> 
			<td> Время:</td>
			<td> <?php echo $this->_tpl_vars['datadata']['time1']; ?>
 </td>
		</tr>
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['datadata']['town2']): ?>
		<tr> 
			<td> Адрес:</td>
			<td> <?php echo $this->_tpl_vars['datadata']['town2']; ?>
 </td>
		</tr>
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['datadata']['ddate2']): ?>
		<tr> 
			<td> Дата:</td>
			<td> <?php echo $this->_tpl_vars['datadata']['ddate2']; ?>
 </td>
		</tr>
		<?php endif; ?>
		
		
		
		<tr> 
			<td> Тип оплаты:</td>
			<td> <?php $_from = $this->_tpl_vars['payments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
 if ($this->_tpl_vars['item']['title'] == $this->_tpl_vars['payment_id']): ?> <?php echo $this->_tpl_vars['item']['name']; ?>
 <?php endif; ?> <?php endforeach; endif; unset($_from); ?> </td>
		</tr>
			
		</table>		
					
	</div>		
</div>


<div style="border:1px solid black; display:inline-block; margin-left:1%; width:44%; padding:2%;" class="">
<h2>Данные покупателя</h2>
	<div>
		<table>
		<tr> 
			<td>ФИО: </td>
			<td><?php echo $this->_tpl_vars['surname']; ?>
 <?php echo $this->_tpl_vars['name']; ?>
 <?php echo $this->_tpl_vars['patronymic']; ?>
 </td>
		</tr>
		
		<tr> 
			<td>Телефон: </td>
			<td><?php echo $this->_tpl_vars['phone']; ?>
</td>
		</tr>
		<tr> 
			<td>Email: </td>
			<td><?php echo $this->_tpl_vars['email']; ?>
</td>
		</tr>
		</table>
	</div>
</div>

