<?php /* Smarty version 2.6.16, created on 2014-03-12 23:50:29
         compiled from ru/modules/catalog/index/show.group.body.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'show_menu', 'ru/modules/catalog/index/show.group.body.html', 1, false),)), $this); ?>
<?php if ($this->_tpl_vars['items']): ?> <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>                     	<div class="product-block">                            <a href="<?php echo $this->_tpl_vars['item']['uri']; ?>
"><img src="<?php echo $this->_tpl_vars['item']['thumb']; ?>
" height="142" width="142" alt="" /></a>							<p><a href="<?php echo $this->_tpl_vars['item']['uri']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</a></p>							</div><?php endforeach; endif; unset($_from); ?><?php endif; ?><?php if ($this->_tpl_vars['group']['description']): ?><div class="about-content">						<div class="about-block">							  <?php echo smarty_function_show_menu(array('menuid' => 7), $this);?>
						</div>						<div class="product-text">						<?php echo $this->_tpl_vars['group']['description']; ?>
                        </div>					</div><?php endif; ?>