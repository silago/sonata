<?php /* Smarty version 2.6.16, created on 2013-04-04 13:15:16
         compiled from ru/modules/catalog/admin/item.photoform.html */ ?>
<?php $_from = $this->_tpl_vars['item']['photo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['photo']):
?>
	<li class="span2" style="position:relative;text-align:center;">
		<div onclick="if(confirm('Удалить фото?'))$(this).parent().remove();return false;" style="position:absolute;top:-10px; right:-10px;z-index:1000;cursor:pointer;">
			<img title="Удалить фото" src="/include/ext/bootstrap/img/x.png">
		</div>
		<a class="thumbnail <?php if ($this->_tpl_vars['primary_photo'] == $this->_tpl_vars['photo']): ?>act<?php endif; ?>">
			<img src="<?php echo $this->_tpl_vars['item']['thumb'][$this->_tpl_vars['key']]; ?>
">
		</a>
		<input type="radio" name="primary" id="primary" value="<?php echo $this->_tpl_vars['primary_photo']; ?>
" <?php if ($this->_tpl_vars['primary_photo'] == $this->_tpl_vars['item']['position'][$this->_tpl_vars['key']]): ?>checked<?php endif; ?>><br/>Главное фото
		<input type="hidden" value="<?php echo $this->_tpl_vars['photo']; ?>
" name="photo[]"/>	
		<input type="hidden" value="<?php echo $this->_tpl_vars['item']['thumb'][$this->_tpl_vars['key']]; ?>
" name="thumb[]"/>
        <input type="hidden" value="<?php echo $this->_tpl_vars['item']['position'][$this->_tpl_vars['key']]; ?>
" name="position[]"/>
	</li>
<?php endforeach; endif; unset($_from); ?>