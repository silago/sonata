<?php /* Smarty version 2.6.16, created on 2013-10-30 14:18:40
         compiled from ru/modules/news/admin/groups.tree.for.select.list.html */ ?>
<select name="ownerId">
    <option value="0" <?php if ($this->_tpl_vars['defaultValue'] == '0' && ! ( $_POST['ownerId'] )): ?>selected<?php endif; ?>>--- НЕТ ---</option>
<?php $_from = $this->_tpl_vars['groups']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <option value="<?php echo $this->_tpl_vars['item']['id']; ?>
" <?php if ($this->_tpl_vars['defaultValue'] == $this->_tpl_vars['item']['id']): ?>selected<?php elseif ($this->_tpl_vars['item']['id'] == $_POST['ownerId']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['del']; ?>
 <?php echo $this->_tpl_vars['item']['title']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
</select>