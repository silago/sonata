<?php /* Smarty version 2.6.16, created on 2013-04-03 14:43:34
         compiled from ru/modules/page/admin/add.page.html */ ?>
<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление сайтом</a><span class="divider">/</span></li>
        <li><a href="/admin/page/index.php">Страницы</a><span class="divider">/</span></li>
		<li class="active"><a>Добавление новой страницы</a></li>
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

<form action="/admin/page/addGo.php" enctype="multipart/form-data" method="post">  
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
                    <label class="control-label" for="uri"><strong>Адрес страницы (uri):</strong></label>
                    <div class="controls">
                        <input type="text" name="uri" value="<?php echo $this->_tpl_vars['uri']; ?>
" id="uri" style="width:99%" maxlength="255">
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
			<input type="hidden" name="action" value="page" id="action">
		</div>
		<div class="row">
			<div class="span12">
			<center><button type="submit" class="btn btn-primary">СОХРАНИТЬ</button></center>
			</div>
		</div> 
	</fieldset>
</form>