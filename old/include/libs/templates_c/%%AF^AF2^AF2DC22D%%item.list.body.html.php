<?php /* Smarty version 2.6.16, created on 2013-04-03 14:43:14
         compiled from ru/modules/catalog/admin/item.list.body.html */ ?>
<div id="info">
<ul class="breadcrumb">
	<li><a href="#">Управление магазином</a><span class="divider">/</span></li>
	<li><a href="/admin/catalog/groupList.php">Каталог</a><span class="divider">/</span></li>	
	<li class="active"><a href="/admin/catalog/listItems.php">Список товаров</a></li>
</ul>
</div>

<a class="btn btn-success" href="/admin/catalog/addItem.php<?php if ($_GET['parent_group_id']): ?>?parent_group_id=<?php echo $_GET['parent_group_id'];  endif; ?>"><i class="icon-plus icon-white"></i> Добавить новый товар</a>
<br/><br/>
<div class="row">
	<div class="span3"> 
		<div class="well"> 
				<ul id="red" class="treeview"><?php echo $this->_tpl_vars['groupsTree']; ?>
</ul>
		</div>
	</div>
	<div class="span9">
	<?php $_from = $this->_tpl_vars['groups']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						<?php if ($this->_tpl_vars['item']['id'] == $_GET['parent_group_id']): ?>
							<h4>
								Группа - <?php echo $this->_tpl_vars['item']['title']; ?>

							</h4>							
							<br/>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
	<table class="table table-condensed table-striped table-bordered">
		<thead>			
								
			<tr style="vertical-align:middle;" valign="middle">
				<th style="font-weight:bold;text-align:center;vertical-align:middle;min-width:388px;">
					<a			
					<?php if (( $_GET['parent_group_id'] != '' )): ?>
						href="?parent_group_id=<?php echo $_GET['parent_group_id'];  if (( $_GET['sort'] == name ) && ( $_GET['type'] == desc )): ?>&sort=name&type=asc<?php elseif (( $_GET['sort'] == price )): ?>&sort=name&type=asc<?php else: ?>&sort=name&type=desc<?php endif; ?>"
					<?php else: ?>
						href="<?php if (( $_GET['sort'] == name ) && ( $_GET['type'] == desc )): ?>?sort=name&type=asc<?php elseif (( $_GET['sort'] == price )): ?>?sort=name&type=asc<?php else: ?>?sort=name&type=desc<?php endif; ?>"
					<?php endif; ?>
					rel="tooltip" data-original-title="Сортировка по наименованию товара">
					Наименование товара / Краткое описание 
						<?php if ($_GET['sort'] == name && $_GET['type'] == asc): ?>
							<img style="margin-bottom:3px;" src="/include/ext/bootstrap/img/arrow_up.png" />
						<?php elseif ($_GET['sort'] == name && $_GET['type'] == desc): ?>
							<img style="margin-bottom:3px;" src="/include/ext/bootstrap/img/arrow_down.png" />
						<?php elseif ($_GET['sort'] == '' && $_GET['type'] == ''): ?>	
							<img style="margin-bottom:3px;" src="/include/ext/bootstrap/img/arrow_up.png" />
						<?php endif; ?>
					</a>				
				</td>
				<th style="font-weight:bold;text-align:center;vertical-align:middle;">Фото</td>				
				<th style="font-weight:bold;text-align:center;vertical-align:middle; min-width:61px;">
					<a 
						<?php if (( $_GET['parent_group_id'] != '' )): ?>
						href="?parent_group_id=<?php echo $_GET['parent_group_id'];  if (( $_GET['sort'] == price ) && ( $_GET['type'] == desc )): ?>&sort=price&type=asc<?php elseif (( $_GET['sort'] == price ) && ( $_GET['type'] == asc )): ?>&sort=price&type=desc<?php elseif (( $_GET['sort'] == name )): ?>&sort=price&type=asc<?php elseif (( $_GET['sort'] == '' )): ?>&sort=price&type=asc<?php endif; ?>"
					<?php else: ?>
						href="<?php if (( $_GET['sort'] == price ) && ( $_GET['type'] == desc )): ?>?sort=price&type=asc<?php elseif (( $_GET['sort'] == price ) && ( $_GET['type'] == asc )): ?>?sort=price&type=desc<?php elseif (( $_GET['sort'] == name )): ?>?sort=price&type=asc<?php elseif (( $_GET['sort'] == '' )): ?>?sort=price&type=asc<?php endif; ?>"
					<?php endif; ?>
					
						rel="tooltip" data-original-title="Сортировка по цене товара">Цена
						<?php if ($_GET['sort'] == price && $_GET['type'] == asc): ?>
							<img style="margin-bottom:3px;" src="/include/ext/bootstrap/img/arrow_up.png" />
						<?php elseif ($_GET['sort'] == price && $_GET['type'] == desc): ?>
							<img style="margin-bottom:3px;" src="/include/ext/bootstrap/img/arrow_down.png" />
						<?php endif; ?>
					</a>					
				</td>				
				<th style="font-weight:bold;text-align:center;vertical-align:middle;">Старая<br/>цена</th>
				<th style="font-weight:bold;text-align:center;vertical-align:middle;">Новинка</th>
				<th style="font-weight:bold;text-align:center;vertical-align:middle;">Хит</th>
				<th style="font-weight:bold;text-align:center;vertical-align:middle;">Действия</th>
			</tr>
		</thead>
		<tbody>	
			<?php echo $this->_tpl_vars['content']; ?>

		</tbody>
	</table>
	</div>
</div>