<?php /* Smarty version 2.6.16, created on 2013-07-29 12:48:27
         compiled from ru/modules/security/index/cabinet.form.fiz.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'ru/modules/security/index/cabinet.form.fiz.tpl', 6, false),)), $this); ?>
﻿<tbody id="fizform">
    <?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['item']['type'] == 'text'): ?>
        <tr>
            <td align="right"><?php if ($this->_tpl_vars['item']['required'] == 1): ?><font color="#F20006">*</font><?php endif; ?> <?php echo $this->_tpl_vars['item']['description']; ?>
</td>
            <td><input class="justField" type="<?php echo $this->_tpl_vars['item']['type']; ?>
" name="<?php echo $this->_tpl_vars['item']['name']; ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" /></td>
        </tr>
        <?php endif; ?>
		
		<?php if ($this->_tpl_vars['item']['type'] == 'description'): ?>		
			<tr>
				<td align="center" colspan="2"><?php echo $this->_tpl_vars['item']['description']; ?>
</td>
			</tr>
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['item']['type'] == 'select'): ?>
			<tr>
			<td align="right"><?php if ($this->_tpl_vars['item']['required'] == 1): ?><font color="#F20006">*</font><?php endif; ?> <?php echo $this->_tpl_vars['item']['description']; ?>
</td>
			<td>	
				<select name="<?php echo $this->_tpl_vars['item']['name']; ?>
">
				<?php $_from = $this->_tpl_vars['item']['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['otpKey'] => $this->_tpl_vars['optItem']):
?>
					<option value="<?php echo $this->_tpl_vars['optItem']; ?>
" <?php if ($this->_tpl_vars['item']['value'] == $this->_tpl_vars['optItem']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['optItem']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>	
				</select>
			</td>		
			</tr>
		<?php endif; ?>
		
    <?php endforeach; endif; unset($_from); ?>
</tbody>