<?php /* Smarty version 2.6.16, created on 2014-03-03 13:34:39
         compiled from ru/modules/orders/admin/edit.order.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'ru/modules/orders/admin/edit.order.tpl', 50, false),)), $this); ?>
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
        <li class="active">Изменение заказа № <?php echo $this->_tpl_vars['id']; ?>
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

<form class="form-vertical" method="post" action="/admin/orders/editOrder.php?id=<?php echo $this->_tpl_vars['id']; ?>
">	
<div style="width:40%; vertical-align:top;  display:inline-block;" ><span> Заказ № <?php echo $this->_tpl_vars['id']; ?>
 </span> <span> <?php echo ((is_array($_tmp=$this->_tpl_vars['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
 </span> </div>
				<div style="width:300px;  display:inline-block;" >
				
				<div class="controls">
					<span style="width: 100px; 
display: inline-block;
float: left;"> 
		<label class="control-label" for="inputEmail">Статус заказа:</label></span>
					<select style="width: 200px;
float: right;" class="span6" name="state">
						<option value="0" <?php if ($this->_tpl_vars['state'] == '0'): ?>selected<?php endif; ?>>В обработке</option>
						<option value="1" <?php if ($this->_tpl_vars['state'] == '1'): ?>selected<?php endif; ?>>Ожидает оплаты</option>
						<option value="2" <?php if ($this->_tpl_vars['state'] == '2'): ?>selected<?php endif; ?>>Оплачен</option>
						<option value="3" <?php if ($this->_tpl_vars['state'] == '3'): ?>selected<?php endif; ?>>Доставка</option>
						<option value="4" <?php if ($this->_tpl_vars['state'] == '4'): ?>selected<?php endif; ?>>Выполнен</option>
						<option value="5" <?php if ($this->_tpl_vars['state'] == '5'): ?>selected<?php endif; ?>>Отменен</option>
					</select>	  
				</div>
			</div>

<br>

<div id="order-data">
	<div id="order-info"></div>
	<?php echo $this->_tpl_vars['orderData']; ?>

</div>





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
		
		<?php if ($this->_tpl_vars['datadata']['ddate']): ?>
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
			<td> 
					<select class="span6" name="tname" id="tname">
					<?php $_from = $this->_tpl_vars['towns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
						<option value="<?php echo $this->_tpl_vars['item']['id']; ?>
" <?php if ($this->_tpl_vars['item']['id'] == $this->_tpl_vars['town_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['tname']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
					</select>	 
				</td>
		</tr>
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['datadata']['ddate2']['name']): ?>
		<tr> 
			<td> Дата:</td>
			<td> <?php echo $this->_tpl_vars['datadata']['ddate2']['name']; ?>
 </td>
		</tr>
		<?php endif; ?>
		
		
		
		<tr> 
			<td> Тип оплаты:</td>
			<td>
			<select class="span6" name="pname" id="pname">
					<?php $_from = $this->_tpl_vars['payments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
						<option value="<?php echo $this->_tpl_vars['item']['title']; ?>
" <?php if ($this->_tpl_vars['item']['title'] == $this->_tpl_vars['payment_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['name']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
					</select>	  	 
					</td>
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
		
			<tr> 
			<td></td>
			<td><a href="/admin/security/userEdit.php/<?php echo $this->_tpl_vars['user_id']; ?>
 "> Изменить данные   </a></td>
			
		</tr>
		
		</table>
	</div>
</div>


		<div>
		
  <br>
  <br>
<button type="submit" class="btn btn-primary">Сохранить</button>
</div>

	
		<div style="display:none;" class="span6">
			<div class="control-group">
				<label class="control-label" for="sname">Вид доставки:</label>
				<div class="controls">
					<select class="span6" name="sname" id="sname">
					<?php $_from = $this->_tpl_vars['shipments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
						<option value="<?php echo $this->_tpl_vars['item']['id']; ?>
" <?php if ($this->_tpl_vars['item']['id'] == $this->_tpl_vars['shipment_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['sname']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
					</select>		  
				</div>
			</div>
		</div>
	</div>
				
	</div>  
	
		
	

			
<input type="hidden" name="edit" value="go">	
  
  
  


							<div  style="display:none;"  class="row">
							<div class="span6">
							<div class="control-group">
							<label class="control-label" for="email">Email адрес клиента:</label>
							<div class="controls">
							<input type="text" name="email" id="email" value="<?php echo $this->_tpl_vars['email']; ?>
" class="span6">
							</div>
							</div>
							</div>  




							<div  style="display:none;" class="row">
							<div class="span6">
							<div class="control-group">
							<label class="control-label" for="surname">Фамилия клиента:</label>
							<div class="controls">
							<input type="text" id="surname" name="surname" value="<?php echo $this->_tpl_vars['surname']; ?>
" class="span6">
							</div>
							</div>
							</div>
							<div  style="display:none;"  class="span6">
							<div class="control-group">
							<label class="control-label" for="name">Имя клиента:</label>
							<div class="controls">
							<input type="text" id="name" name="name" value="<?php echo $this->_tpl_vars['name']; ?>
" class="span6">
							</div>
							</div>
							</div>
							</div> 

							<div  style="display:none;"  class="row">
							<div class="span6">
							<div class="control-group">
							<label class="control-label" for="patronymic">Отчество клиента:</label>
							<div class="controls">
							<input type="text" id="patronymic" name="patronymic" value="<?php echo $this->_tpl_vars['patronymic']; ?>
" class="span6">
							</div>
							</div>
							</div>
							</div>

							<div  style="display:none;"  class="row">
							<div  style="display:none;"  class="span6">
							<div class="control-group">
							<label class="control-label" for="tname">Город:</label>
							<div class="controls">
							<select class="span6" name="tname" id="tname">
							<?php $_from = $this->_tpl_vars['towns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
							<option value="<?php echo $this->_tpl_vars['item']['id']; ?>
" <?php if ($this->_tpl_vars['item']['id'] == $this->_tpl_vars['town_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['tname']; ?>
</option>
							<?php endforeach; endif; unset($_from); ?>
							</select>	 
							</div>
							</div>
							</div>  
							<div  style="display:none;"  class="span6">
							<div class="control-group">
							<label class="control-label" for="sname">Вид доставки:</label>
							<div class="controls">
							<select class="span6" name="sname" id="sname">
							<?php $_from = $this->_tpl_vars['shipments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
							<option value="<?php echo $this->_tpl_vars['item']['id']; ?>
" <?php if ($this->_tpl_vars['item']['id'] == $this->_tpl_vars['shipment_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['sname']; ?>
</option>
							<?php endforeach; endif; unset($_from); ?>
							</select>		  
							</div>
							</div>
							</div>
		
</form>



		