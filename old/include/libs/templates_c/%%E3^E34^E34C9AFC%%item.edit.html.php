<?php /* Smarty version 2.6.16, created on 2013-04-04 13:15:16
         compiled from ru/modules/catalog/admin/item.edit.html */ ?>
<ul class="breadcrumb">
	<li><a href="#">Управление магазином</a><span class="divider">/</span></li>
	<li><a href="/admin/catalog/groupList.php">Каталог</a><span class="divider">/</span></li>	
	<li><a href="/admin/catalog/listItems.php">Товары</a><span class="divider">/</span></li>	
	<li class="active"><a href="/admin/catalog/addItem.php">Редактирование товара</a></li>
</ul>

<?php echo $this->_tpl_vars['error']; ?>


<form action="editItemGo.php?id=<?php echo $this->_tpl_vars['item_id']; ?>
" method="post" enctype="multipart/form-data">
  <fieldset>
  <div class="row">
	<div class="span6">
		<div class="control-group">
			<label class="control-label" for="parent_group_id"><strong>Группа товара:</strong></label>
				<div class="controls">
					<?php echo $this->_tpl_vars['selectOwnerId']; ?>

				</div>
			</div>
	</div>
	<div class="span2">
		<div class="control-group">
			<label class="control-label" for="parent_group_id">Артикул товара:</label> 
				<div class="controls">
					<input type="text" id="article" name="article" value="<?php echo $this->_tpl_vars['article']; ?>
" maxlength="255" style="width: 80%;" tabindex="3"/>
				</div>
		</div>
	</div> 
	<div class="span1">
			<div class="control-group">			
				<div class="controls">
					<label class="checkbox" for="new">Новинка<input name="new" id="new" type="checkbox" value="1" tabindex="4" <?php if ($this->_tpl_vars['is_new'] == 1): ?>checked<?php endif; ?>/></label>
				</div>
			</div>
	</div>
	<div class="span2">
			<div class="control-group">			
				<div class="controls">
					<label class="checkbox" for="hit">Хит продаж<input name="hit" id="hit" type="checkbox" value="1" tabindex="5" <?php if ($this->_tpl_vars['is_hit'] == 1): ?>checked<?php endif; ?>/></label>
				</div>
			</div>
	</div>
  </div>
	<div class="row">
		<div class="span6">
			<div class="control-group">
			<label class="control-label" for="name"><strong>Название товара:</strong></label>
				<div class="controls">
					<input type="text" name="name" value="<?php echo $this->_tpl_vars['name']; ?>
" maxlength="255" style="width: 80%;" tabindex="1" />
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
			<label class="control-label" for="price">Цена:</label>
				<div class="controls">
					<input rel="tooltip" rel="tooltip" data-original-title='Значение цены должно иметь вид "0.00" или "0,00" или "0"' type="text" id="price" name="price" value="<?php echo $this->_tpl_vars['price']; ?>
" maxlength="255" style="width: 80%;" tabindex="6"/>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="span6">
			<div class="control-group">
			<label class="control-label" for="uri"><strong>uri:</strong></label>
				<div class="controls">
					<input type="text" name="uri" value="<?php echo $this->_tpl_vars['uri']; ?>
" maxlength="255" style="width: 80%;" tabindex="2"  readonly/>
					<span id="urihelp" class="help-block"></span>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
			<label class="control-label" for="price_old">Старая цена:</label>
				<div class="controls">
					<input rel="tooltip" rel="tooltip" data-original-title='Значение цены должно иметь вид "0.00" или "0,00" или "0"' type="text" id="price_old" name="price_old" value="<?php echo $this->_tpl_vars['price_old']; ?>
" maxlength="255" style="width: 80%;" tabindex="7"/>
				</div>
			</div>
		</div>
	</div>	
	<div class="row">
		<div class="span12">
				<a href="#myModal" rel="tooltip" data-original-title="Для удаления добавленной фотографии нажмите на миниатюру ниже."  role="button" class="btn btn-info" data-toggle="modal" tabindex="9">Выбрать фото</a>				
				<div class="modal hide" id="myModal" style="width:auto; left:40%; top:35%;">				
					<div class="modal-header" style="height:20px;">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3>Файловый менеджер</h3>
					</div>
					<div class="modal-body" style="max-height:520px; height:520px;">
						<div id="catalog_item_photo"></div>
					</div>
					<div class="modal-footer" style="height:35px;">
						<a href="#" id="close" class="btn btn-danger pull-left" data-dismiss="modal">Закрыть</a>
						<div class="alert alert-info pull-left" style="width:580px;font-size:11px;margin: 0px 0px 0px 10px;font-weight:bold;text-align:center;">							
							<span style="text-align:center">Для загрузки фотографий на сайт перенесите одно или несколько фото в окно файлового менеджера.</span>
						</div>
						<a href="#" id="additem" class="btn btn-success pull-right">Добавить</a>						
					</div>
				</div>				
				
				<div id="resultphoto" style="padding-top:10px;">
					<ul class="thumbnails"><?php echo $this->_tpl_vars['photoForm']; ?>
</ul>
				</div>
		</div>		
	</div>
	<div class="row">
		<div class="span12">
			<div class="control-group">
			<label class="control-label" for="price_old"><strong>Описание товара:</strong></label>
				<div class="controls">
					<?php echo $this->_tpl_vars['fckFullTextForm']; ?>

				</div>
			</div>			
		</div>
	</div>
	<div class="row">
		<div class="span4">
			<div class="control-group">
					<label class="control-label" for="title">Заголовок страницы при просмотре товара:</label>
					<div class="controls">
						<input name="title" type="text" id="title" style="width: 99%" value="<?php echo $this->_tpl_vars['title']; ?>
" maxlength="255" tabindex="10" />
					</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
					<label class="control-label" for="md">Краткое описание (META-description) :</label>
					<div class="controls">
						<input name="md" type="text" id="md" style="width: 99%" value="<?php echo $this->_tpl_vars['md']; ?>
" maxlength="255" tabindex="11" />
					</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
					<label class="control-label" for="mk">Ключевые слова (META-keywords) :</label>
					<div class="controls">
						<input name="mk" type="text" id="mk" style="width: 99%" value="<?php echo $this->_tpl_vars['mk']; ?>
" maxlength="255" tabindex="12" />
					</div>
			</div>
		</div>
	</div>
	<div class="row">
			<div class="span3 offset6">
				<button type="submit" class="btn btn-primary" tabindex="13">Сохранить</button>
			</div>			
	</div>  
  </fieldset>
</form>
