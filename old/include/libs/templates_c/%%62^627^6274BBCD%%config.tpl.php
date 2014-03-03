<?php /* Smarty version 2.6.16, created on 2013-04-11 11:30:26
         compiled from ru/modules/admin/config.tpl */ ?>
<div id="info">
	<ul class="breadcrumb">
		<li><a href="#">Настройка модуля "<?php echo $this->_tpl_vars['moduleName']; ?>
"</a></li>
	</ul>
</div>
<form action="/admin/<?php echo $this->_tpl_vars['module']; ?>
/config.php" method="post">
<?php $_from = $this->_tpl_vars['confArray']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <?php if ($this->_tpl_vars['item']['type'] == 'select'): ?>
        <div class="row">
            <div class="span12">
                <div class="control-group">
                    <label class="control-label" for="<?php echo $this->_tpl_vars['item']['name']; ?>
"><?php echo $this->_tpl_vars['item']['description']; ?>
:</label>
                    <div class="controls">
                        <select name="<?php echo $this->_tpl_vars['key']; ?>
" class="span5" id="<?php echo $this->_tpl_vars['item']['name']; ?>
">
                            <?php $_from = $this->_tpl_vars['item']['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['optKey'] => $this->_tpl_vars['optItem']):
?>
                                <option value="<?php echo $this->_tpl_vars['optItem']; ?>
" <?php if ($this->_tpl_vars['optItem'] == $this->_tpl_vars['item']['value']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['optItem']; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['item']['type'] == 'text'): ?>
        <div class="row">
            <div class="span12">
                <div class="control-group">
                    <label class="control-label" for="<?php echo $this->_tpl_vars['item']['name']; ?>
"><?php echo $this->_tpl_vars['item']['description']; ?>
:</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $this->_tpl_vars['item']['value']; ?>
" name="<?php echo $this->_tpl_vars['key']; ?>
" id="<?php echo $this->_tpl_vars['item']['name']; ?>
" class="span12"/>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;  endforeach; endif; unset($_from); ?>
<input type="hidden" name="go" value = "go">
<button class="btn btn-primary" type="submit" id="submit">Сохранить</button>
</form>