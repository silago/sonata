<?php /* Smarty version 2.6.16, created on 2014-03-07 20:28:37
         compiled from ru/modules/catalog/index/show.item.html */ ?>
<div style="margin-top:-20px;" class="nav">
<?php echo $this->_tpl_vars['c_navigation']; ?>
	
</div>

<div class="char-container">
						<div class="char-info">
							
                            <a href="#">
                                <?php if ($this->_tpl_vars['photo']): ?>
                                <a class="fancybox" href="/userfiles/catalog/1cbitrix/<?php echo $this->_tpl_vars['photo']; ?>
">    
                                    <img src="/userfiles/catalog/1cbitrix/<?php echo $this->_tpl_vars['photo']; ?>
" width="174" alt="" /></a>
                                </a>
                                <?php else: ?>
                                    <img src="/images/nophoto.png" width="174" alt="" /></a>
                                <?php endif; ?>
							<div class="char-text">
								<h3><?php echo $this->_tpl_vars['name']; ?>
</h3>	
								<p>
                                    <?php echo $this->_tpl_vars['description']; ?>

                                </p>
                                
								<div class="summ-box">
									<p>Цена:</p>	
									<span><?php echo $this->_tpl_vars['price']; ?>
 руб.</span>
									<a href="#" onclick="addToChart('<?php echo $this->_tpl_vars['iid']; ?>
}',1);">В корзину</a>
								</div>
							</div>	
						</div>
                        <?php if ($this->_tpl_vars['arrItemProps']): ?>
						<div class="char-box">
							<h4>Технические характеристики</h4>

							<div class="chat-block">
							<?php $_from = $this->_tpl_vars['arrItemProps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                                <div class="box bgs">
									<p><?php echo $this->_tpl_vars['item']['propertyName']; ?>
</p>	
									<span><?php echo $this->_tpl_vars['item']['propertyValue']; ?>
</span>
								</div>	
                            <?php endforeach; endif; unset($_from); ?>
							</div>
						</div>	
                        <?php endif; ?>
					</div>