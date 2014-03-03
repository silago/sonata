<?php /* Smarty version 2.6.16, created on 2013-10-23 17:21:29
         compiled from ru/modules/catalog/index/pagination.tpl */ ?>
<div class="boxPadding">    
    <?php if ($this->_tpl_vars['pages']): ?>
    <ul>        
        <?php $_from = $this->_tpl_vars['pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>          
			<?php if ($this->_tpl_vars['key'] == 1000): ?>
				<li><span>...</span></li>
				<li><a href="?<?php echo $this->_tpl_vars['s']; ?>
&<?php echo $this->_tpl_vars['additfstring']; ?>
page=<?php echo $this->_tpl_vars['item']; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</a></li>				
			<?php elseif ($this->_tpl_vars['key'] == 999): ?>
				<li><a href="?<?php echo $this->_tpl_vars['s']; ?>
&<?php echo $this->_tpl_vars['additfstring']; ?>
page=<?php echo $this->_tpl_vars['item']; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</a></li>
			<?php elseif ($this->_tpl_vars['key'] == -1): ?>				
				<li><a href="?<?php echo $this->_tpl_vars['s']; ?>
&<?php echo $this->_tpl_vars['additfstring']; ?>
page=<?php echo $this->_tpl_vars['item']; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</a></li>				
				<li><span>...</span></li>
			<?php elseif ($this->_tpl_vars['key'] == -2): ?>				
				<li><a href="?<?php echo $this->_tpl_vars['s']; ?>
&<?php echo $this->_tpl_vars['additfstring']; ?>
page=<?php echo $this->_tpl_vars['item']; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</a></li>
			<?php else: ?>
				<?php if ($this->_tpl_vars['item'] == $this->_tpl_vars['currpage']): ?>
					<li class="active"><a href=""><?php echo $this->_tpl_vars['item']; ?>
</a></li>
				<?php else: ?>
					<li><a href="?<?php echo $this->_tpl_vars['s']; ?>
&<?php echo $this->_tpl_vars['additfstring']; ?>
page=<?php echo $this->_tpl_vars['item']; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</a></li>
				<?php endif; ?>
			<?php endif; ?>
				
        <?php endforeach; endif; unset($_from); ?>
    </ul>
    <?php endif; ?>
</div>