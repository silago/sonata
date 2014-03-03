<?php /* Smarty version 2.6.16, created on 2013-08-01 17:19:40
         compiled from ru/modules/menu/admin/menu.add.form.html */ ?>
<div id="info">
<ul class="breadcrumb">
	<li><a href="#">Управление сайтом</a><span class="divider">/</span></li>
	<li><a href="/admin/menu/index.php">Меню навигации</a><span class="divider">/</span></li>	
	<li class="active"><?php if (! empty ( $_GET['menuid'] )): ?>Редактирование меню "<?php echo $this->_tpl_vars['menuTitle']; ?>
"<?php else: ?>Добавление нового меню<?php endif; ?></li>	
</ul>
<?php echo $this->_tpl_vars['error']; ?>

</div>

<div class="row">
	<div class="span3 struct">
		<h4>Разделы сайта:</h4><br/>			
				
				<div style="background:#f5f5f5;" class="main">
						<h4>Произвольные ссылки <span style="float:right;cursor:pointer;" onclick="$('div#customlinks').toggle();"><i title="Подробнее" class="icon-chevron-down"></i></span></h4>					
				</div>
				<div class="info" id="customlinks">
					<form class="form-vertical" action="#" onsubmit="return add();">				
						<div class="control-group">  						
							<div class="controls">
								<input type="text" id="titleManual" placeholder="Заголовок ссылки">
							</div>
							<div class="controls">
								<input type="text" id="urlManual" placeholder="Ссылка">
							</div>						
							<div class="controls">
								<button type="submit" class="btn btn-primary pull-right" >Добавить ссылку</button>
							</div>						
						</div>
					</form>
				</div>
				
				<?php if (! empty ( $this->_tpl_vars['pagesTree'] )): ?>
				<div style="background:#f5f5f5;" class="main">
						<h4>Страницы сайта <span style="float:right;cursor:pointer;" onclick="$('div#pageblock').toggle();"><i title="Подробнее" class="icon-chevron-down"></i></span></h4>					
				</div>
				<div class="info" id="pageblock">
					<form class="form-vertical" action="#" onsubmit="return multiadd('pageblock');">					
						<?php echo $this->_tpl_vars['pagesTree']; ?>

						<div class="control-group" style="padding-bottom:2px;">
							<div class="controls">
								<button type="submit" class="btn btn-primary pull-right" >Добавить ссылку</button>
						</div>
						</div>
					</form>
				</div>
				<?php endif; ?>
				
				<?php if (! empty ( $this->_tpl_vars['catalogGroupsTree'] )): ?>				
					<div style="background:#f5f5f5;" class="main">
						<h4>Группы каталога <span style="float:right;cursor:pointer;" onclick="$('div#cataloggroupsblock').toggle();"><i title="Подробнее" class="icon-chevron-down"></i></span></h4>					
					</div>
					<div class="info" id="cataloggroupsblock">
						<form class="form-vertical" action="#" onsubmit="return multiadd('cataloggroupsblock');">					
						<?php echo $this->_tpl_vars['catalogGroupsTree']; ?>
						
						<div class="control-group" style="padding-bottom:2px;">
							<div class="controls">
								<button type="submit" class="btn btn-primary pull-right" >Добавить ссылку</button>
							</div>
						</div>						
						</form>
					</div>				
				<?php endif; ?>								
				
				<?php if (! empty ( $this->_tpl_vars['catalogItemsTree'] )): ?>
				<div style="background:#f5f5f5;" class="main">
					<h4>Товары каталога <span style="float:right;cursor:pointer;" onclick="$('div#catalogitemsblock').toggle();"><i title="Подробнее" class="icon-chevron-down"></i></span></h4>					
				</div>
				<div class="info" id="catalogitemsblock">
					<form class="form-vertical" action="#" onsubmit="return multiadd('catalogitemsblock');">					
					<?php echo $this->_tpl_vars['catalogItemsTree']; ?>

					<div class="control-group" style="padding-bottom:2px;">
						<div class="controls">
							<button type="submit" class="btn btn-primary pull-right" >Добавить ссылку</button>
						</div>
					</div>
				</form>
				</div>
				<?php endif; ?>
				
				<?php if (! empty ( $this->_tpl_vars['newsGroupsTree'] )): ?>
				<div style="background:#f5f5f5;" class="main">
					<h4>Группы новостей <span style="float:right;cursor:pointer;" onclick="$('div#newsgroupsblock').toggle();"><i title="Подробнее" class="icon-chevron-down"></i></span></h4>					
				</div>
				<div class="info" id="newsgroupsblock">
				<form class="form-vertical" action="#" onsubmit="return multiadd('newsgroupsblock');">					
					<?php echo $this->_tpl_vars['newsGroupsTree']; ?>

					<div class="control-group" style="padding-bottom:2px;">
						<div class="controls">
							<button type="submit" class="btn btn-primary pull-right" >Добавить ссылку</button>
						</div>
					</div>
				</form>
				</div>
				<?php endif; ?>
				
				<?php if (! empty ( $this->_tpl_vars['newsTree'] )): ?>
				<div style="background:#f5f5f5;" class="main">
					<h4>Новости <span style="float:right;cursor:pointer;" onclick="$('div#newsblock').toggle();"><i title="Подробнее" class="icon-chevron-down"></i></span></h4>					
				</div>
				<div class="info" id="newsblock">
				<form class="form-vertical" action="#" onsubmit="return multiadd('newsblock');">					
					<?php echo $this->_tpl_vars['newsTree']; ?>

					<div class="control-group" style="padding-bottom:2px;">
						<div class="controls">
							<button type="submit" class="btn btn-primary pull-right" >Добавить ссылку</button>
						</div>
					</div>
				</form>
				</div>
				<?php endif; ?>
				
				<?php if (! empty ( $this->_tpl_vars['galleryGroupsTree'] )): ?>
					<div style="background:#f5f5f5;" class="main">
						<h4>Альбомы галлереи <span style="float:right;cursor:pointer;" onclick="$('div#gallerygroupsblock').toggle();"><i title="Подробнее" class="icon-chevron-down"></i></span></h4>					
					</div>
					<div class="info" id="gallerygroupsblock">
						<form class="form-vertical" action="#" onsubmit="return multiadd('gallerygroupsblock');">					
							<?php echo $this->_tpl_vars['galleryGroupsTree']; ?>

							<div class="control-group" style="padding-bottom:2px;">
								<div class="controls">
									<button type="submit" class="btn btn-primary pull-right" >Добавить ссылку</button>
								</div>
							</div>
						</form>
					</div>
				<?php endif; ?>
				
	</div>
	<div class="span9">
		<h4>Структура меню:</h4><br/>
		<form class="form well" action="/admin/menu/addMenuGo.php" onsubmit="return menuCheck();" style="background:none; border-color:#e4e4e4" method="post">   
			<button type="submit" style="margin-bottom:15px;" class="btn btn-primary">Сохранить</button>
			<button style="margin-bottom:15px;" class="btn btn-danger pull-right" onclick="return deletedMenuItems();">Удалить все пункты меню</button>
			<div class="control-group well">  						
						<div class="controls">
							<label class="control-label" for="menuTitle">Название меню:</label> 
						</div>		
			<input type="text" name="menuTitle" id="menuTitle" value="<?php if (! empty ( $this->_tpl_vars['menuTitle'] )):  echo $this->_tpl_vars['menuTitle'];  else:  echo $_POST['menuTitle'];  endif; ?>" />
			<input type="hidden" name="menuid" id="menuid" value="<?php if (! empty ( $this->_tpl_vars['menuid'] )):  echo $this->_tpl_vars['menuid'];  else:  endif; ?>" />
			</div>
		
		
		<div class="menu"> 			
			<ol class="sortable"><?php echo $this->_tpl_vars['itemsTree']; ?>
</ol>	
		</div>
			<button type="submit" class="btn btn-primary">Сохранить</button>
			<button class="btn btn-danger pull-right" onclick="return deletedMenuItems();>Удалить все пункты меню</button>			
		</form>
	</div>
</div>