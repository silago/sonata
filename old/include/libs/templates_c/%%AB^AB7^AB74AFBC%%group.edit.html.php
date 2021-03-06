<?php /* Smarty version 2.6.16, created on 2013-04-11 11:30:50
         compiled from ru/modules/catalog/admin/group.edit.html */ ?>
<div id="info">
<ul class="breadcrumb">
	<li><a href="#">Управление магазином</a><span class="divider">/</span></li>
	<li><a href="/admin/catalog/groupList.php">Каталог</a><span class="divider">/</span></li>	
	<li><a href="/admin/catalog/groupList.php">Группы</a><span class="divider">/</span></li>	
	<li class="active"><a href="/admin/catalog/editGroup.php?id=<?php echo $this->_tpl_vars['group_id']; ?>
">Редактирование группы <strong>"<?php echo $this->_tpl_vars['name']; ?>
"</strong></a></li>
</ul>
</div>


<div class="row">
	<div class="span12">
	<?php echo $this->_tpl_vars['error']; ?>

	</div>	
</div>
<form class="form-vertical" action="editGroupGo.php?id=<?php echo $this->_tpl_vars['group_id']; ?>
" method="post" enctype="multipart/form-data" onsubmit='disableSubmit("submitFormKey", "Пожалуйста, подождите..")'>
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
					<input type="checkbox" name="hidden" id="hidden" value="1" <?php echo $this->_tpl_vars['select']; ?>
 />
				</div>
			</div>
			</div>
		</div>		
		<div class="row">
			<div class="span6">
				<div class="control-group">
					<label class="control-label" for="name"><strong>Название группы:</strong></label>
					<div class="controls">
						<input type="text" name="name" id="name" maxlength="255" style="width: 99%" value="<?php echo $this->_tpl_vars['name']; ?>
" />
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label class="control-label" tooltip="123" for="uri"><strong>uri:</strong></label>
					<div class="controls">
						<input type="text" name="uri" maxlength="255" style="width: 99%" value="<?php echo $this->_tpl_vars['uri']; ?>
" readonly/>
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
						<input name="title" type="text" id="title" style="width: 99%" value="<?php echo $this->_tpl_vars['title']; ?>
" maxlength="255" />
					</div>
				</div>
			</div>
			<div class="span4">
				<div class="control-group">
					<label class="control-label" for="md">Краткое описание (META-description):</label>
					<div class="controls">
						<input name="md" type="text" id="md" style="width: 99%" value="<?php echo $this->_tpl_vars['md']; ?>
" maxlength="255" />
					</div>
				</div>
			</div>
			<div class="span4">
				<div class="control-group">
					<label class="control-label" for="mk">Ключевые слова (META-keywords):</label>
					<div class="controls">
						<input name="mk" type="text" id="mk" style="width: 99%" value="<?php echo $this->_tpl_vars['mk']; ?>
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




<!-- <form action="editGroupGo.php?lang=<?php echo $this->_tpl_vars['curLang']; ?>
&id=<?php echo $this->_tpl_vars['group_id']; ?>
" method="post" enctype="multipart/form-data" onsubmit='disableSubmit("submitFormKey", "Пожалуйста, подождите..")'>
<table border="0" width="100%" cellpadding="4" cellspacing="0" class="inputTable">	
	<tr>
		<td colspan="2" align="center"><font color="#FF0000"><strong><?php echo $this->_tpl_vars['error']; ?>
</strong></font></td>
	</tr>		    
	<tr>
      <td align="right">Фото при отображении группы:</td>
	  <td><input name="photo" type="file" id="photo" style="width: 70%"/></td>
	</tr>  
  <?php echo $this->_tpl_vars['photoForm']; ?>
  
</table>
</form> -->