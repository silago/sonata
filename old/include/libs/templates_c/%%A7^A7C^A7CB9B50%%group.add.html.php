<?php /* Smarty version 2.6.16, created on 2013-04-04 11:50:09
         compiled from ru/modules/catalog/admin/group.add.html */ ?>
<ul class="breadcrumb">
	<li><a href="#">Управление магазином</a><span class="divider">/</span></li>
	<li><a href="/admin/catalog/groupList.php">Каталог</a><span class="divider">/</span></li>	
	<li><a href="/admin/catalog/groupList.php">Группы</a><span class="divider">/</span></li>	
	<li class="active"><a href="/admin/catalog/addGroup.php">Добавление группы</a><span class="divider">/</span></li>
</ul>


<div class="row">
	<div class="span12">
	<?php echo $this->_tpl_vars['error']; ?>

	</div>	
</div>

<form action="addGroupGo.php?lang=<?php echo $this->_tpl_vars['curLang']; ?>
&id=<?php echo $this->_tpl_vars['id']; ?>
" method="post" enctype="multipart/form-data" onsubmit='disableSubmit("submitFormKey", "Пожалуйста, подождите..")'>
    <input type="hidden" id="action" value="addGroup">
    <fieldset>
		<div class="row">
			<div class="span6">
			<div class="control-group">
			<label class="control-label" for="parent_group_id"><strong>Владелец группы:</strong></label>
				<div class="controls">
					<?php echo $this->_tpl_vars['selectGroup']; ?>

				</div>
			</div>
			</div>
			<div class="span3">
			<div class="control-group">
			<label class="control-label" for="hidden"><strong>Группа скрыта:</strong></label>
				<div class="controls">
					<input type="checkbox" name="hidden" id="hidden" value="1" <?php if (( $this->_tpl_vars['hidden'] == 1 )): ?>checked<?php endif; ?>/>
				</div>
			</div>
			</div>
		</div>
		<div class="row">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="name"><strong>Название группы:</strong></label>
					<div class="controls">
						<input type="text" name="name" id="name" maxlength="255" style="width: 99%" value="<?php echo $_POST['name']; ?>
" />
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="uri"><strong>uri:</strong></label>
					<div class="controls">
						<input type="text" name="uri" id="uri" maxlength="255" style="width: 50%" value="<?php echo $_POST['uri']; ?>
"/>
						<span id="urihelp" class="help-inline"></span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span12">
				<a href="#myModal" role="button" class="btn btn-info" data-toggle="modal">Выбрать фото</a>
				<div class="modal hide" id="myModal" style="width:auto; left:40%; top:35%;">
					<div class="modal-header" style="height:20px;">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3>Файловый менеджер</h3>
					</div>
					<div class="modal-body" style="max-height:520px; height:520px;">
						<div id="catalog_group_photo"></div>
					</div>
					<div class="modal-footer" style="height:35px;">
						<a href="#" id="close" class="btn btn-danger pull-left" data-dismiss="modal">Закрыть</a>
						<div class="alert alert-info pull-left" style="width:580px;font-size:11px;margin: 0px 0px 0px 10px;font-weight:bold;text-align:center;">
							Для загрузки фотографий на сайт перенесите одно или несколько фото в окно файлового менеджера.
						</div>
						<a href="#" id="add" class="btn btn-success pull-right">Добавить</a>
					</div>
				</div>
				<div class="row" style="padding-top:10px;">
					<div class="span6"><div id="resultphoto"><ul class="thumbnails"><?php echo $this->_tpl_vars['photoForm']; ?>
</ul></div></div>
				</div>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="span12">
			<div class="control-group">
					<label class="control-label"><strong>Описание группы:</strong></label>
					<div class="controls">
						<?php echo $this->_tpl_vars['fckSmallTextForm']; ?>

					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span4">
				<div class="control-group">
					<label class="control-label" for="title">Заголовок страницы при просмотре группы:</label>
					<div class="controls">
						<input name="title" type="text" id="title" style="width: 99%" value="<?php echo $_POST['title']; ?>
" maxlength="255" />
					</div>
				</div>
			</div>
			<div class="span4">
				<div class="control-group">
					<label class="control-label" for="md">Краткое описание (META-description):</label>
					<div class="controls">
						<input name="md" type="text" id="md" style="width: 99%" value="<?php echo $_POST['md']; ?>
" maxlength="255" />
					</div>
				</div>
			</div>
			<div class="span4">
				<div class="control-group">
					<label class="control-label" for="mk">Ключевые слова (META-keywords):</label>
					<div class="controls">
						<input name="mk" type="text" id="mk" style="width: 99%" value="<?php echo $_POST['mk']; ?>
" maxlength="255" />
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span3 offset6">
				<button type="submit" class="btn btn-primary">Сохранить</button>
			</div>
		</div>
	</fieldset>
</form>