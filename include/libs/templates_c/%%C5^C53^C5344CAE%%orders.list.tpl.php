<?php /* Smarty version 2.6.16, created on 2013-10-22 17:45:11
         compiled from ru/modules/orders/admin/orders.list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'ru/modules/orders/admin/orders.list.tpl', 56, false),)), $this); ?>
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
	</script>
	
	<style>
		.orders_list {cursor:pointer;}
	</style>
'; ?>


<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление магазином</a><span class="divider">/</span></li>
        <li><a href="/admin/orders/showList.php">Заказы</a><span class="divider">/</span></li>
        <li class="active">Список заказов</li>
    </ul>
</div>

<div class="row">
	<div class="span3">
		<select id="status" class="span3" onchange = "return sort()">
			<option value=""  <?php if (! $_GET['status']): ?>selected<?php endif; ?>>Все заказы</option>
			<option value="0" <?php if ($_GET['status'] == '0'): ?>selected<?php endif; ?>>В обработке</option>
			<option value="1" <?php if ($_GET['status'] == '1'): ?>selected<?php endif; ?>>Ожидает оплаты</option>
			<option value="2" <?php if ($_GET['status'] == '2'): ?>selected<?php endif; ?>>Оплачен</option>
			<option value="3" <?php if ($_GET['status'] == '3'): ?>selected<?php endif; ?>>Доставка</option>
			<option value="4" <?php if ($_GET['status'] == '4'): ?>selected<?php endif; ?>>Выполнен</option>
			<option value="5" <?php if ($_GET['status'] == '5'): ?>selected<?php endif; ?>>Отменен</option>
		</select> 
	</div>	
</div>
<table class="table table-condensed table-striped table-bordered">
    <thead>
    <tr>
        <th style="text-align:center">Дата оформления</th>
        <th style="text-align:center">№ заказа</th>
		<th style="text-align:center">Ф.И.О клиента / Наименование организации</th>
		<th style="text-align:center">Статус заказа</th>
		<th style="text-align:center">Сумма заказа</th>
		<th style="text-align:center">Стоимость доставки</th>
		<th style="text-align:center">Изменить</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($this->_tpl_vars['array']): ?>
	<?php $_from = $this->_tpl_vars['array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <tr class="orders_list" onclick="document.location='/admin/orders/viewOrder.php?id=<?php echo $this->_tpl_vars['item']['id']; ?>
';">
        <td style="text-align:center"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</td>
		<td style="text-align:center"><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
		<td style="text-align:center"><?php echo $this->_tpl_vars['item']['surname']; ?>
 <?php echo $this->_tpl_vars['item']['name']; ?>
 <?php echo $this->_tpl_vars['item']['patronymic']; ?>
</td>
		<td style="text-align:center"><?php echo $this->_tpl_vars['item']['statetext']; ?>
</td>
		<td style="text-align:center"><?php echo $this->_tpl_vars['item']['order_data']['total']; ?>
 руб.</td>
		<td style="text-align:center"><?php echo $this->_tpl_vars['item']['order_data']['sprice']; ?>
 руб.</td>
        <td style="text-align:center" width="80px;">
            <div class="btn-group" style="padding-left:5px;">
                <a class="btn btn-primary" rel="tooltip" data-original-title="Редактировать заказ" href="/admin/orders/editOrder.php?id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><i class="icon-pencil icon-white"></i></a>
				<a class="btn btn-danger" onclick="return confirm('Отменить заказ?');" rel="tooltip" data-original-title="Отменить заказ" href="/admin/orders/deleteOrder.php?id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><i class="icon-trash icon-white"></i></a>
            </div>
          
        </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
	<?php else: ?>
	<tr>
		<td style="text-align:center" colspan="7">Нет заказов с текущим статусом</td>
	</tr>
	<?php endif; ?>
    </tbody>
</table>