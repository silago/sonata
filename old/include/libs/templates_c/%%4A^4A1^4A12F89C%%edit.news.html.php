<?php /* Smarty version 2.6.16, created on 2013-04-04 10:46:48
         compiled from ru/modules/news/admin/edit.news.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'ru/modules/news/admin/edit.news.html', 58, false),)), $this); ?>
<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление сайтом</a><span class="divider">/</span></li>
        <li><a href="/admin/news/showGroups.php">Новости</a><span class="divider">/</span></li>
        <li><a href="/admin/news/list.php">Список новостей</a><span class="divider">/</span></li>
        <li class="active"><a>Редактирование новости <strong>"<?php echo $this->_tpl_vars['title']; ?>
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


<form action="/admin/news/editGo.php" method="post">
    <fieldset>
        <div class="row">
            <div class="span4 offset4">
                <strong>Группа новости: </strong> <?php echo $this->_tpl_vars['selectOwnerId']; ?>

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
                    <label class="control-label" for="title"><strong>Заголовок новости:</strong></label>
                    <div class="controls">
                        <input type="text" id="title" name="title" value="<?php echo $this->_tpl_vars['title']; ?>
" maxlength="255" style="width: 99%">
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="url"><strong>Uri новости:</strong></label>
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
                    <label class="control-label" for="datepicker"><strong>Новость от:</strong></label>
                    <div class="controls">
                        <input type="text" id="datepicker" name="date" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
" maxlength="255" style="width: 99%">
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="status"><strong>Статус новости:</strong></label>
                    <div class="controls">
                        <select name="status" id="status">
                            <option value="1" <?php if ($this->_tpl_vars['status'] == 1): ?>selected<?php endif; ?>>Опубликована</option>
                            <option value="0" <?php if ($this->_tpl_vars['status'] == 0): ?>selected<?php endif; ?>>Скрыта</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <center><strong>Краткое описание новости:</strong></center>
                <?php echo $this->_tpl_vars['smallForm']; ?>

            </div>
        </div>
        <div class="row">
            <div class="span12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <center><strong>Новость полностью:</strong></center>
                <?php echo $this->_tpl_vars['fullForm']; ?>

            </div>
        </div>
        <div class="row">
            <div class="span12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="span6 offset3">
                <div class="control-group">
                    <label class="control-label" for="pageTitle">Заголовок страницы (META-title):</label>
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
                    <label class="control-label" for="md">Краткое описание новости (META-description):</label>
                    <div class="controls">
                        <input type="text" id="md" name="md" value="<?php echo $this->_tpl_vars['md']; ?>
" maxlength="255" style="width: 99%">
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="uri">Ключевые слова (META-keywords):</label>
                    <div class="controls">
                        <input type="text" name="mk" value="<?php echo $this->_tpl_vars['mk']; ?>
" id="mk" style="width:99%" maxlength="255">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <input type="hidden" id="action" name="action" value="news">
                <input type="hidden" name="newsId" value="<?php echo $this->_tpl_vars['id']; ?>
">
                <input type="hidden" name="ownerIdOriginal" value="<?php echo $this->_tpl_vars['ownerId']; ?>
">
                <center><button type="submit" class="btn btn-primary" id="formSubmit">СОХРАНИТЬ</button></center>
            </div>
        </div>
    </fieldset>
</form>