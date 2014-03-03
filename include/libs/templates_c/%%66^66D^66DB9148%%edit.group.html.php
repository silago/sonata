<?php /* Smarty version 2.6.16, created on 2013-10-30 14:18:40
         compiled from ru/modules/news/admin/edit.group.html */ ?>
<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление сайтом</a><span class="divider">/</span></li>
        <li><a href="/admin/news/showGroups.php">Новости</a><span class="divider">/</span></li>
		<li><a href="/admin/news/showGroups.php">Список групп</a><span class="divider">/</span></li>
		<li class="active"><a>Редактирование группы <strong>"<?php echo $this->_tpl_vars['title']; ?>
"</strong></a></li>
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


<form action="/admin/news/editGroupGo.php" method="post">
    <fieldset>
    <div class="row">
        <div class="span4 offset4">
            <strong>Владелец группы</strong> <?php echo $this->_tpl_vars['selectOwnerId']; ?>

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
                <label class="control-label" for="name"><strong>Название группы:</strong></label>
                <div class="controls">
                    <input type="text" name="title" value="<?php if ($_POST['title']):  echo $_POST['title'];  else:  echo $this->_tpl_vars['title'];  endif; ?>" style="width:99%" maxlength="255">
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <label class="control-label" for="uri"><strong>Uri группы:</strong></label>
                <div class="controls">
                    <input type="text" name="uri" value="<?php if ($_POST['uri']):  echo $_POST['uri'];  else:  echo $this->_tpl_vars['uri'];  endif; ?>" style="width:99%" maxlength="255" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="span6">
            <div class="control-group">
                <label class="control-label" for="uri">Шаблон для группы новостей:</label>
                <div class="controls">
                    <input type="text" name="template" value="<?php if ($_POST['template']):  echo $_POST['template'];  else:  echo $this->_tpl_vars['template'];  endif; ?>" style="width:99%" maxlength="255">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="span12">            
            <input type="hidden" id="action" name="action" value="newsGroups">
			<input type="hidden" id="id" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
            <center><button type="submit" class="btn btn-primary" id="formSubmit">СОХРАНИТЬ</button></center>
        </div>
    </div>
    </fieldset>
</form>