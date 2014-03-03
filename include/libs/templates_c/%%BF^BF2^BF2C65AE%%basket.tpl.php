<?php /* Smarty version 2.6.16, created on 2014-02-28 15:57:02
         compiled from ru/modules/basket/index/basket.tpl */ ?>
	<div class="box-container">
				<h2>Корзина</h2>

				<div class="box-cont">
					<div class="basket-cont">
						<table>
							<tr class="title">
								<td class="imgs"></td>
								<td class="name"></td>
								<td class="ed">Цена за ед.</td>
								<td class="kv">Кол-во</td>
								<td class="summ">Сумма</td>
								<td class="delete">Удалить</td>
							</tr>
                        <?php $this->assign('totalictemscount', 0); ?>
                        <?php $_from = $this->_tpl_vars['array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
						    <?php $this->assign('totalictemscount', $this->_tpl_vars['totalictemscount']+$this->_tpl_vars['item']['quantity']); ?>
                            
                            <tr>
								<td class="imgs"><a href="/<?php echo $this->_tpl_vars['item']['uri']; ?>
"><img src="/userfiles/catalog/1cbitrix/<?php echo $this->_tpl_vars['item']['images']['filename']; ?>
" height="67" width="67" alt="" /></a></td>
								<td class="name">
									<a href="/<?php echo $this->_tpl_vars['item']['uri']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</a>
									<p><?php echo $this->_tpl_vars['item']['description']; ?>
</p>
								</td>
								<td class="ed"><?php echo $this->_tpl_vars['item']['price']; ?>
 руб.</td>
								<td class="kv">
									<a href="#"><img src="/images/prev-kv.png" height="8" width="4" alt="" /></a>
									<input type="text" placeholder="<?php echo $this->_tpl_vars['item']['quantity']; ?>
" />
									<a href="#"><img src="/images/next-kv.png" height="8" width="4" alt="" /></a>
								</td>
								<td class="summ"><span><?php echo $this->_tpl_vars['item']['total']; ?>
 руб.</span></td>
								<td class="delete"><a href="deleteFromCart('<?php echo $this->_tpl_vars['item']['item_id']; ?>
'); "><img src="/images/delete.png" height="10" width="10" alt="" /></a></td>
							</tr>
                        
                        <?php endforeach; endif; unset($_from); ?>
						</table>

						<div class="done-box">
							<p>Итого <?php echo $this->_tpl_vars['totalictemscount']; ?>
 товаров на сумму <?php echo $this->_tpl_vars['total']; ?>
 руб.</p>	
							<a class="order-button" href="/checkout">Оформить заказ</a>	
							<!--<a class="clear-order" href="#">Очистить корзну</a>-->
						</div>
					</div>	
				</div>	
			</div>	

<!--
<div class="boxCont">
    <a href="/catalog/" class="buttonBack">Вернуться в каталог</a>	<h1>Содержание корзины</h1>
    <form action="/checkout/" name="Basket" method="post">
        <div class="tableTop">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr class="first">
                    <td style=""><p>Изображение</p></td>
                    <td style=""><p>Товар</p></td>
                    <td><p>Цена за ед.</p></td>
                    <td style=""><p>К-во</p></td>
                    <td><p>Итого</p></td>
                    <td><p>Удалить</p></td>
                </tr>

                <?php if ($this->_tpl_vars['array']): ?>
                    <?php $_from = $this->_tpl_vars['array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                        <tr>

                       
                            <td style=""><a target=_blank href="/<?php echo $this->_tpl_vars['item']['inf']['uri1']; ?>
/<?php echo $this->_tpl_vars['item']['inf']['uri2']; ?>
/"><img style="max-width:100px;" src="/userfiles/catalog/1cbitrix/<?php echo $this->_tpl_vars['item']['images']['filename']; ?>
"   alt="" border="0" /></a></td>
                            <td style="" ><a target=_blank href="/<?php echo $this->_tpl_vars['item']['inf']['uri1']; ?>
/<?php echo $this->_tpl_vars['item']['inf']['uri2']; ?>
/" class="name"><?php echo $this->_tpl_vars['item']['name']; ?>
</a></td>
             

                            <td><p><?php echo $this->_tpl_vars['item']['price']; ?>
 руб.</p></td>
                            <td style="width:130px;"> 
                                <a onclick='minus(this, "<?php echo $this->_tpl_vars['item']['item_id']; ?>
"); return false;' href="#" class="minus"></a>
                                <input class="qq q-<?php echo $this->_tpl_vars['item']['item_id']; ?>
" onfocusout="changeQty('<?php echo $this->_tpl_vars['item']['item_id']; ?>
');"  type="text" name="search" value="<?php echo $this->_tpl_vars['item']['quantity']; ?>
"  />
                                <a href="#" onclick='plus(this, "<?php echo $this->_tpl_vars['item']['item_id']; ?>
"); return false;'; class="plus"></a>
                                <a  style="display:none;" onclick="return false;" style="float:right; padding:2px;" href="#"><img alt="" src='/templates/ru/img/icon_refresh.png'/></a>

                            </td>
						
                            <td><p class="price"><?php echo $this->_tpl_vars['item']['total']; ?>
 руб.</p></td>
                            <td><a href="#" onclick="deleteFromCart('<?php echo $this->_tpl_vars['item']['item_id']; ?>
'); return false;" class="iconBasket"><img src="/templates/ru/img/icon_basket.jpg"   alt="" border="0" /></a></td>
                        </tr>


                    <?php endforeach; endif; unset($_from); ?>

                    <tr class="discountTr"> 


                        <td style="padding:0px;" colspan=2>
                        </td>

                        <td   style="width:200px;padding:0px; padding-top:20px!important; padding-left: 130px;" colspan=6>
                            

                           

                            </td>
							</tr>

                <?php else: ?>
                    <tr>

                        <td colspan=6><p> Ваша корзина заказов пуста </p></td></tr>


                <?php endif; ?>


            </table>
        </div>
                <div class="tableBottom">
            <p>Итоговая стоимость: <span><?php echo $this->_tpl_vars['total']; ?>
 руб.</span></p>
            <input type="submit" value="Оформить заказ" />
            <input onclick="document.location.reload(true);" style="float: left;width: 145px;margin-right: 10px;margin-top: 0px;background: none;border: 0px;background-color: grey;border: 0px solid lightgray;" type="button" value="Обновить корзину" />
            <div class="clear"></div>
        </div>
    </form>
</div>








<div style="display:none;" id="basket">
    <table border="0" cellspacing="0" cellpadding="0" class="prods_content cart" style="margin-left:10px; color: #888;">
        <tbody>
            <tr>
                <th class="th1" width="50%">Наименование товара</th>
                <th>Артикул</th>
                <th>Цена</th>
                <th>Количество</th>
                <th class="th3" style="border-right-width: 0px;">Итого</th>
            </tr>		
            <?php if ($this->_tpl_vars['array']): ?>
                <?php $_from = $this->_tpl_vars['array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                    <tr style="">
                        <td  style="border-right: 1px solid #E5E5E5; text-align:center;  border-bottom:1px solid #E5E5E5;">
                            <a href="/<?php echo $this->_tpl_vars['item']['uri']; ?>
/" style="color: #817A7A; text-decoration: none;"><img src="<?php echo $this->_tpl_vars['item']['thumb']; ?>
" alt=""/></a><br/>
                            <span style="margin:10px;"><a href="/<?php echo $this->_tpl_vars['item']['uri']; ?>
/" style="color: #817A7A; text-decoration: none;"><?php echo $this->_tpl_vars['item']['name']; ?>
</a></span>
                        </td>
                        <td  style="border-right: 1px solid #E5E5E5; text-align:center; border-bottom:1px solid #E5E5E5;">
                            <?php echo $this->_tpl_vars['item']['article']; ?>

                        </td>
                        <td  style="border-right: 1px solid #E5E5E5; text-align:center; border-bottom:1px solid #E5E5E5;">
                            <?php if ($this->_tpl_vars['item']['price_old'] != '0.00' && $this->_tpl_vars['item']['price_old'] < $this->_tpl_vars['item']['price']): ?>
                                <?php echo $this->_tpl_vars['item']['price_old']; ?>
 руб.
                            <?php else: ?>
                                <?php echo $this->_tpl_vars['item']['price']; ?>
 руб.
                            <?php endif; ?>
                        </td>
                        <td style="text-align:center; border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5;">
                            <form action="#" method="post" class="inline">
                                <input type="text" id="prod<?php echo $this->_tpl_vars['item']['item_id']; ?>
" title="Изменить количество товара" class="inputbox"  style="width:40px;height:20px;text-align:center"size="3" maxlength="4" name="quantity" value="<?php echo $this->_tpl_vars['item']['quantity']; ?>
"><br/><br/>	
                                <a href="#" onclick='return changeQty("<?php echo $this->_tpl_vars['item']['item_id']; ?>
"); return false;'>Обновить</a><br/>	
                                <a href="#" onclick='return deleteFromCart("<?php echo $this->_tpl_vars['item']['item_id']; ?>
"); return false;'>Удалить</a>
                            </form>                                
                        </td>
                        <td colspan="1" style="text-align:center;  border-bottom:1px solid #E5E5E5;"><strong><?php echo $this->_tpl_vars['item']['total']; ?>
 руб.</strong></td>
                    </tr>
                <?php endforeach; endif; unset($_from); ?>
                <tr>
                    <td colspan="4"  style="border-right: 1px solid #E5E5E5; text-align:right;  padding-right:10px; font-weight:bold;font-size:16px; color: #888;">Итого:</td>
                    <td style="text-align:center;" class="total"><strong><?php echo $this->_tpl_vars['total']; ?>
 руб.</strong></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="5"  style="text-align:center; font-size:14px;">Ваша корзина заказов пуста</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="itemCart" style="float:left;margin-left:10px;margin-top:16px;margin-bottom:16px;"><a href="/checkout/">Оформить заказ</a></div>
</div>
-->