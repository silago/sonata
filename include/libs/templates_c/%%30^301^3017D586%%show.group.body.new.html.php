<?php /* Smarty version 2.6.16, created on 2013-10-28 17:44:53
         compiled from ru/modules/catalog/index/show.group.body.new.html */ ?>
<!--<?php echo $this->_tpl_vars['pagination']; ?>
-->		<?php if ($this->_tpl_vars['items']): ?> <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?><li style="position:relative;" class="<?php if ($this->_tpl_vars['key']%3 == 0): ?>first-in-line<?php endif;  if ($this->_tpl_vars['key']%3 == 2): ?>last-in-line<?php endif; ?>"> <?php if ($this->_tpl_vars['item']['price_old'] != 0.00): ?><img style="  left: -2px;    position: absolute;    top: 0;    width: 50px;    z-index: 113;" alt="" src="/img/tehnodomDiscount.png"/><?php endif; ?><div class="inner-indent"><div class="image<?php echo $this->_tpl_vars['item']['id']; ?>
">    <a href="<?php echo $this->_tpl_vars['item']['uri']; ?>
">                <?php if (! empty ( $this->_tpl_vars['item']['thumb'] )): ?><img title="<?php echo $this->_tpl_vars['item']['name']; ?>
" src="<?php echo $this->_tpl_vars['item']['thumb']; ?>
" width="150" alt="" /><?php else: ?><img title="<?php echo $this->_tpl_vars['item']['name']; ?>
" width="150" src="/images/nophoto.jpg" alt="" /><?php endif; ?>            </a> </div><div class="name maxheight-f"><a href="<?php echo $this->_tpl_vars['item']['uri']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</a></div><div class="price">    <?php if (! empty ( $this->_tpl_vars['item']['price'] )): ?>        <?php echo $this->_tpl_vars['item']['price']; ?>
 руб.	    <?php else: ?>     <?php endif; ?>      </div>  <div style="position:absolute; bottom:0px;" class="cart"><a onclick="addToChart('<?php echo $this->_tpl_vars['item']['id']; ?>
','1');" data-id="<?php echo $this->_tpl_vars['item']['id']; ?>
" class="button addToCart">	<span>Добавить	</span></a>	</div></div> </li><?php endforeach; endif; unset($_from); ?><?php else: ?><div class="itemDisplay">    В выбранной категории нет товаров.</div><?php endif; ?>