<?php /* Smarty version 2.6.16, created on 2013-04-04 11:15:33
         compiled from ru/plugins/showMenu/index.tpl */ ?>
<?php if ($this->_tpl_vars['tree']): ?>
<ul style="">
<?php $_from = $this->_tpl_vars['tree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
	<li id="<?php echo $this->_tpl_vars['item']['id']; ?>
">	
	<a href="<?php echo $this->_tpl_vars['item']['data']['url']; ?>
" title="<?php echo $this->_tpl_vars['item']['data']['title']; ?>
"><?php echo $this->_tpl_vars['item']['data']['title']; ?>
</a><input type="hidden" name="id" value="<?php echo $this->_tpl_vars['item']['id']; ?>
">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['dir'])."/templates/ru/plugins/showMenu/index.tpl", 'smarty_include_vars' => array('tree' => $this->_tpl_vars['item']['children'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>		
	</li>	
<?php endforeach; endif; unset($_from); ?>
</ul>
<?php endif; ?>