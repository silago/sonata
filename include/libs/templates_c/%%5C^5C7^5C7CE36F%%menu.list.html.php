<?php /* Smarty version 2.6.16, created on 2013-08-01 17:16:05
         compiled from ru/modules/menu/admin/menu.list.html */ ?>
<div id="info">
<ul class="breadcrumb">
	<li><a href="#">Управление сайтом</a><span class="divider">/</span></li>
	<li><a href="/admin/menu/index.php">Меню навигации</a><span class="divider">/</span></li>	
	<li class="active">Список меню</li>		
</ul>
</div>
<a class="btn btn-success" href="/admin/menu/addMenu.php"><i class="icon-plus icon-white"></i> Добавить новое меню</a><br/><br/>
<table class="table table-condensed table-striped table-bordered">
	<thead>
		<tr>
			<th style="text-align:center">Название меню</th>
			<th style="text-align:center">Действия</th>
		</tr>
	</thead>	
	<tbody>
		<?php $_from = $this->_tpl_vars['array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
		<tr>
			<td style="text-align:left"><?php echo $this->_tpl_vars['item']['title']; ?>
</td>
			<td style="text-align:center" width="80px">
				<div class="btn-group" style="padding-left:5px;width: 76px;">
					<a class="btn btn-primary" rel="tooltip" data-original-title="Редактировать меню" href="/admin/menu/editMenu.php?menuid=<?php echo $this->_tpl_vars['item']['id']; ?>
"><i class="icon-pencil icon-white"></i></a>
					<a class="btn btn-danger" onclick="return confirm('Удалить меню?');" rel="tooltip" data-original-title="Удалить меню" href="/admin/menu/deleteMenu.php?menuid=<?php echo $this->_tpl_vars['item']['id']; ?>
"><i class="icon-trash icon-white"></i></a>	
				</div>
			</td>
		</tr>
		<?php endforeach; endif; unset($_from); ?>
	</tbody>
</table>