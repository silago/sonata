<?php /* Smarty version 2.6.16, created on 2014-03-11 14:50:56
         compiled from ru/modules/catalog/index/show.group.body.html */ ?>
<?php if ($this->_tpl_vars['items']): ?> <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>                     	<div class="product-block">                            <a href="<?php echo $this->_tpl_vars['item']['uri']; ?>
"><img src="/userfiles/catalog/1cbitrix/<?php echo $this->_tpl_vars['item']['filename']; ?>
" height="142" width="142" alt="" /></a>							<p><a href="<?php echo $this->_tpl_vars['item']['uri']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</a></p>							</div><?php endforeach; endif; unset($_from); ?><?php endif; ?><?php if ($this->_tpl_vars['group']['description']): ?><div class="about-content">						<div class="about-block">							<p><a class="time" href="#">Режим работы</a></p>								<p><a class="delivery" href="#">Доставка</a></p>							<p><a class="pay" href="#">Оплата</a></p>						</div>						<div class="product-text">						<?php echo $this->_tpl_vars['group']['description']; ?>
                        </div>					</div><?php endif; ?>