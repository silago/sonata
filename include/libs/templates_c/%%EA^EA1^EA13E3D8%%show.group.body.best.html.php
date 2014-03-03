<?php /* Smarty version 2.6.16, created on 2013-10-28 17:21:55
         compiled from ru/modules/catalog/index/show.group.body.best.html */ ?>
<!--<?php echo $this->_tpl_vars['pagination']; ?>
--> <?php if ($this->_tpl_vars['items']): ?> <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>     <li>   				<a href="<?php echo $this->_tpl_vars['item']['uri']; ?>
">		<span><?php echo $this->_tpl_vars['key']+1; ?>
.</span> 		    <?php if (! empty ( $this->_tpl_vars['item']['thumb'] )): ?><img style="margin-right:5px; float:left;" title="<?php echo $this->_tpl_vars['item']['name']; ?>
" alt="<?php echo $this->_tpl_vars['item']['name']; ?>
" src="<?php echo $this->_tpl_vars['item']['thumb']; ?>
"  width="50"/><?php else: ?><img  style="margin-right:5px; float:left;" title="<?php echo $this->_tpl_vars['item']['name']; ?>
"    width="50" alt="" src="/images/nophoto.jpg"/><?php endif; ?>       		<?php echo $this->_tpl_vars['item']['name']; ?>
</a>    </li><?php endforeach; endif; unset($_from); ?> <?php else: ?><div class="itemDisplay">    В выбранной категории нет товаров.</div><?php endif; ?>