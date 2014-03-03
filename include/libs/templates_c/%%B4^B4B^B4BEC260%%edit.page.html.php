<?php /* Smarty version 2.6.16, created on 2014-03-03 16:03:14
         compiled from ru/modules/page/admin/edit.page.html */ ?>
<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление сайтом</a><span class="divider">/</span></li>
        <li><a href="/admin/page/index.php">Страницы</a><span class="divider">/</span></li>
		<li class="active"><a>Редактирование страницы <strong>"<?php echo $this->_tpl_vars['title']; ?>
"<strong></a></li>
    </ul>
</div>


<?php if ($this->_tpl_vars['error']): ?>
<div class="row">
    <div class="span12">
        <div class="alert alert-error">
            <?php $_from = $this->_tpl_vars['error']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
            <?php echo $this->_tpl_vars['item']; ?>
<br/>
            <?php endforeach; endif; unset($_from); ?>
        </div>
    </div>
</div>
<?php endif; ?>

<form action="/admin/page/editGo.php" enctype="multipart/form-data" method="post">  
	<fieldset>
		<div class="row">
            <div class="span4 offset4">
                <strong>Владелец страницы: </strong> <?php echo $this->_tpl_vars['selectOwnerPage']; ?>

            </div>
        </div>
        <div class="row">
            <div class="span12">
                &nbsp;
            </div>
        </div>
		<div class="row">
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="name"><strong>Название страницы:</strong></label>
                    <div class="controls">
                        <input type="text" id="name" name="title" value="<?php echo $this->_tpl_vars['title']; ?>
" maxlength="255" style="width: 99%">
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="url"><strong>Адрес страницы (uri):</strong></label>
                    <div class="controls">
                        <input type="text" name="uri" value="<?php echo $this->_tpl_vars['uri']; ?>
" id="url" style="width:99%" maxlength="255" readonly>
                    </div>
                </div>
            </div>
        </div>
		<div class="row">
			<div class="span6">
				<div class="control-group">
                    <label class="control-label" for="template">Используемый шаблон:</label>
                    <div class="controls">
                        <input type="text" id="template" name="template" value="<?php echo $this->_tpl_vars['template']; ?>
" maxlength="255" style="width: 99%">
                    </div>
                </div>
			</div>
			<div class="span6">
				<div class="control-group">
                    <label class="control-label" for="redirect">Редирект</label>
                    <div class="controls">
                        <input type="text" id="redirect" name="redirect" value="<?php echo $this->_tpl_vars['redirect']; ?>
" maxlength="255" style="width: 99%">
                    </div>
                </div>
			</div>
		</div>
        <div class="row">
            <div class="span12">
            <img src="/userfiles/<?php echo $this->_tpl_vars['image']; ?>
" />
            <span> Иконка </span> <input type="file" name="filename" />
            <br/>
            <span> На главной </span>
            <span> Да <input type=radio name="onmain" <?php if ($this->_tpl_vars['onmain'] == 1): ?>checked<?php endif; ?> value="1"/> </span>
            <span> Нет <input type=radio name="onmain" <?php if ($this->_tpl_vars['onmain'] == 0): ?>checked<?php endif; ?> value="0"/> </span>
            
            
            </div>
        </div>
		<div class="row">
			<div class="span12">
			<center><strong>Текст страницы:</strong></center></br>
			<?php echo $this->_tpl_vars['fckFormText']; ?>

			</div>
		</div>
		<div class="row">
			<div class="span12">&nbsp;</div>
		</div>
		<div class="row">
            <div class="span6 offset3">
                <div class="control-group">
                    <label class="control-label" for="uri">Заголовок страницы (META-title):</label>
                    <div class="controls">
                        <input type="text" name="pageTitle" value="<?php echo $this->_tpl_vars['pageTitle']; ?>
" id="pageTitle" style="width:99%" maxlength="255">
                    </div>
                </div>
            </div>
        </div>
		<div class="row">
			<div class="span6">
				<div class="control-group">
                    <label class="control-label" for="md">Заголовок страницы (META-description):</label>
                    <div class="controls">
                        <input type="text" name="md" value="<?php echo $this->_tpl_vars['md']; ?>
" id="md" style="width:99%" maxlength="255">
                    </div>
                </div>
			</div>
			<div class="span6">
				<div class="control-group">
                    <label class="control-label" for="mk">Заголовок страницы (META-keywords):</label>
                    <div class="controls">
                        <input type="text" name="mk" value="<?php echo $this->_tpl_vars['md']; ?>
" id="mk" style="width:99%" maxlength="255">
                    </div>
                </div>
			</div>
			
		</div>
		<div class="row">
			<div class="span12">
			<center><button type="submit" class="btn btn-primary">СОХРАНИТЬ</button></center>
			<input type="hidden" name="action" value="page" id="action">
			<input type="hidden" name="pageId" value="<?php echo $this->_tpl_vars['id']; ?>
" id="pageId">
			</div>
		</div> 
	</fieldset>
</form>