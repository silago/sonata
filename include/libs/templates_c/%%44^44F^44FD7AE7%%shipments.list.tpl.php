<?php /* Smarty version 2.6.16, created on 2014-03-05 15:31:07
         compiled from ru/modules/orders/admin/shipments.list.tpl */ ?>
<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление магазином</a><span class="divider">/</span></li>
        <li><a href="/admin/orders/showList.php">Заказы</a><span class="divider">/</span></li>
        <li class="active">Список видов доставки</li>
    </ul>
</div>
<a class="btn btn-success" href="/admin/orders/addShipment.php"><i class="icon-plus icon-white"></i> Добавить вид доставки</a><br/><br/>
<table class="table table-condensed table-striped table-bordered">
    <thead>
    <tr>
        <th style="text-align:center">Название вида доставки</th>
        <th style="text-align:center">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php $_from = $this->_tpl_vars['array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <tr>
        <td style="text-align:left"><?php echo $this->_tpl_vars['item']['sname']; ?>
</td>
        <td style="text-align:center" width="80px">
            <div class="btn-group" style="padding-left:5px;width: 76px;">
                <a class="btn btn-primary" rel="tooltip" data-original-title="Редактировать вид доставки" href="/admin/orders/editShipment.php?id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><i class="icon-pencil icon-white"></i></a>
                <a class="btn btn-danger" onclick="return confirm('Удалить вид доставки?');" rel="tooltip" data-original-title="Удалить свид доставки" href="/admin/orders/deleteShipment.php?id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><i class="icon-trash icon-white"></i></a>
            </div>
        </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    </tbody>
</table>