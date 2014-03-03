<?php /* Smarty version 2.6.16, created on 2013-04-03 11:36:28
         compiled from ru/modules/catalog/index/show.group.body.html */ ?>
<?php echo $this->_tpl_vars['pagination']; ?>
<?php if ($this->_tpl_vars['items']): ?><?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?><?php if ($this->_tpl_vars['item']['num'] == 1): ?><div class="block"><?php endif; ?><div class="item">		<div class="itemBrd">            <?php if ($this->_tpl_vars['item']['is_new'] == 1): ?><div class="itemNEW"></div><?php endif;  echo $this->_tpl_vars['item']['new']; ?>
            <?php if ($this->_tpl_vars['item']['is_hit'] == 1): ?><div class="itemHIT"></div><?php endif;  echo $this->_tpl_vars['item']['new']; ?>
            <a href="<?php echo $this->_tpl_vars['item']['uri']; ?>
">                <?php if (! empty ( $this->_tpl_vars['item']['thumb'] )): ?><img title="<?php echo $this->_tpl_vars['item']['name']; ?>
" src="<?php echo $this->_tpl_vars['item']['thumb']; ?>
"><?php else: ?><img title="<?php echo $this->_tpl_vars['item']['name']; ?>
" src="/images/nophoto.png"><?php endif; ?>            </a>        </div>        <div class="itemName"><a href="<?php echo $this->_tpl_vars['item']['uri']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</a></div>		<div class="itemSpecText"><?php echo $this->_tpl_vars['item']['description']; ?>
</div>        <div class="itemText">Цена:</div><div class="itemPrice" style="margin-bottom: 0px;"><!--<img src="/images/rub.png" style="height: 17px;width:11px; border-radius: 0px; border: none;"/>--> <?php echo $this->_tpl_vars['item']['price']; ?>
 р.</div>        <div class="itemPriceDiscoint" style="padding-left: 155px;">            <?php if ($this->_tpl_vars['item']['price_old'] != 0.00): ?>            <!--<img src="/images/rub.png" style="height: 13px;width:8px; border-radius: 0px; border: none;"/>-->    <span class="lineThrough"><?php echo $this->_tpl_vars['item']['price_old']; ?>
</span> р.            <?php else: ?>               <br/>            <?php endif; ?>        </div>                <div class="itemDetail"><a href="<?php echo $this->_tpl_vars['item']['uri']; ?>
">подробнее</a></div>        <div class="itemCart" >                <?php if ($this->_tpl_vars['item']['inBasket'] == true): ?>                    <a href="#" class="<?php echo $this->_tpl_vars['item']['id']; ?>
" onclick='return removeFromChart("<?php echo $this->_tpl_vars['item']['id']; ?>
")'>убрать</a>                <?php else: ?>                    <a href="#" class="<?php echo $this->_tpl_vars['item']['id']; ?>
" onclick='return addToChart("<?php echo $this->_tpl_vars['item']['id']; ?>
")'>в корзину</a>                <?php endif; ?>        </div></div><!-- // item --><?php if ($this->_tpl_vars['item']['num'] == 3): ?></div><?php endif; ?><?php endforeach; endif; unset($_from); ?><?php else: ?><div class="itemDisplay">    В выбранной категории нет товаров.</div><?php endif; ?>