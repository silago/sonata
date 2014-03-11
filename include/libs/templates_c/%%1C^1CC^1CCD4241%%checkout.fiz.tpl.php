<?php /* Smarty version 2.6.16, created on 2014-03-11 15:49:05
         compiled from ru/modules/orders/index/checkout.fiz.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'ru/modules/orders/index/checkout.fiz.tpl', 7, false),)), $this); ?>
﻿<tbody id="fizform">
<?php $_from = $this->_tpl_vars['fizFields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
	<?php if ($this->_tpl_vars['item']['required'] == 1 && $this->_tpl_vars['item']['value'] == ''): ?>
		<?php if ($this->_tpl_vars['item']['type'] == 'text'): ?>			
			<tr>
				<td class="key"><?php if ($this->_tpl_vars['item']['required'] == 1): ?><font color="#F20006">*</font><?php endif; ?> <?php echo $this->_tpl_vars['item']['description']; ?>
:</td>
				<td><input size="30" class="required" type="<?php echo $this->_tpl_vars['item']['type']; ?>
" name="<?php echo $this->_tpl_vars['item']['name']; ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" /></td>
			</tr>			
		<?php endif; ?>
	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</tbody>			
