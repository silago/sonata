<?php /* Smarty version 2.6.16, created on 2014-03-05 15:31:18
         compiled from ru/modules/orders/admin/payments.list.tpl */ ?>
<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление магазином</a><span class="divider">/</span></li>
        <li><a href="/admin/orders/showList.php">Заказы</a><span class="divider">/</span></li>
        <li class="active">Список способов оплаты</li>
    </ul>
</div>
<table class="table table-condensed table-striped table-bordered">
    <thead>
    <tr>
        <th style="text-align:center">Название способа оплаты</th>        
    </tr>
    </thead>
    <tbody>
    <?php $_from = $this->_tpl_vars['array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <tr>
        <td style="text-align:left"><?php echo $this->_tpl_vars['item']['name']; ?>
</td>        
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    </tbody>
</table>