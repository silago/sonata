<?php /* Smarty version 2.6.16, created on 2013-10-23 16:05:22
         compiled from ru/modules/orders/index/show.order.tpl */ ?>
<?php echo '
<script>
    function discard(orderid){
		if(confirm(\'Вы уверены, что хотите отменить заказ?\')){			
			jQuery.ajax({
                type: \'POST\',
                url: \'/discardorder/\',
				dataType: "json",                 
                data: {orderid:orderid},
                success: function(data){															
					if(data.type == \'alert-success\'){						
						jQuery(\'button#bill\').remove();
						jQuery(\'a#discard\').remove();						
						jQuery(\'div#buttons\').append(\'<button id="renew" class="button guest" onclick="return reneworder(\'+orderid+\');">Подтвердить заказ</button>\')
						jQuery(\'#error\').addClass(\'alert\').addClass(data.type);
						jQuery(\'#error\').html(data.content)
					}else{
						jQuery(\'#error\').addClass(\'alert\').addClass(data.type);
						jQuery(\'#error\').html(data.content)
					}
					
                }
            });			
		}	
		return false;
	}
	
	function reneworder(orderid){					
			jQuery.ajax({
                type: \'POST\',
                url: \'/reneworder/\',
				dataType: "json",                 
                data: {orderid:orderid},
                success: function(data){															
					if(data.type == \'alert-success\'){						
						
						jQuery(\'button#renew\').remove();						
						
						jQuery(\'div#buttons\').append(\'<button id="bill" class="button guest" type="submit">Счет</button>&nbsp;&nbsp;\');
						jQuery(\'div#buttons\').append(\'<a id="discard" style="margin-bottom:12px;" href="#" onclick="return discard(\'+orderid+\');" class="validate button reg">Отменить заказ</a>\')
						
						
						jQuery(\'#error\').addClass(\'alert\').addClass(data.type);
						jQuery(\'#error\').html(data.content)
					}else{
						jQuery(\'#error\').addClass(\'alert\').addClass(data.type);
						jQuery(\'#error\').html(data.content)
					}
					
                }
            });			
		return false;
	}
</script>



<style>
.showbill {background: #ff5bf2;
background: -moz-linear-gradient(top, #ff5bf2, #cd27c0);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff5bf2), color-stop(100%,#cd27c0));
background: -webkit-linear-gradient(top, #ff5bf2, #cd27c0);
background: -o-linear-gradient(top, #ff5bf2, #cd27c0);
background: -ms-linear-gradient(top, #ff5bf2, #cd27c0);
background: linear-gradient(top, #ff5bf2, #cd27c0);
-pie-background: linear-gradient(#ff5bf2, #cd27c0);
border-radius:5px;
border:0px;
color:#fff;
font-weight:bold;
padding:5px;

}
</style>

'; ?>



			 <div class="your-order">
                        <p>Ваш заказ <em>№<?php echo $this->_tpl_vars['id']; ?>
</em> успешно сформирован</p>
                        <br>
                        <p> В ближайшее время с вами свяжется наш менеджер и уточнит детали вашего заказа.	 </p>
						
						<?php if ($this->_tpl_vars['pname'] == 'Безналичный расчет'): ?>
						 <p> <a href="#"> 
							 
							 <form method="post" action="/bill/" target="_blank" id="bill">
							 <input type="hidden" class="button_4" name="order_id" value="<?php echo $this->_tpl_vars['id']; ?>
">
							 <input class="button_4" type="submit" value="Счет">  </input>
							 </form>		 </a> </p>
                        <?php endif; ?>
                    </div><!-- end your-order -->
			
			<div class="order-btn">
                        <input  style="width:200px;" type="button" class="button_4" href="/orderslist" value="Список заказов" onclick="document.location='/orderslist';">
            </div>
			
			<br>
			<div id="error"></div>	
			
			
					
			<div style="display:none;" class="itemCart" style="float:left;margin-left:10px;margin-bottom:16px;"><a href="/orderslist/">Список заказов</a></div>
			
			
			
			<table  style="display:none;" border="0" cellspacing="0" cellpadding="0" class="prods_content cart" style="margin-left:10px; color: #888;">
				
					<tbody>
					<tr>
						<th colspan="2"><span><span>Заказ №<?php echo $this->_tpl_vars['id']; ?>
</span></span></th>
					</tr>
					<tr>
						<td align="right" style="padding-right:15px;">Вид доставки:</td>
						<td><strong><input size="80" name="" type="text" value="<?php echo $this->_tpl_vars['sname']; ?>
" disabled></strong></td>
					</tr>
					
					<?php if ($this->_tpl_vars['sprice'] != '0.00'): ?>
					<tr>
						<td align="right" style="padding-right:15px;">Стоимость доставки:</td>
						<td><strong><input size="80" name="" type="text" value="<?php echo $this->_tpl_vars['sprice']; ?>
 руб." disabled></strong></td>
					</tr>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['speriod'] != ''): ?>
					<tr>
						<td align="right" style="padding-right:15px;">Срок доставки:</td>
						<td><strong><input size="80" name="" type="text" value="<?php echo $this->_tpl_vars['speriod']; ?>
" disabled></strong></td>
					</tr>
					<?php endif; ?>					
					<tr>
						<td align="right" style="padding-right:15px;">Тип оплаты:</td>
						<td><strong><input size="80" name="" type="text" value="<?php echo $this->_tpl_vars['pname']; ?>
" disabled></strong></td>
					</tr>
					<tr>
						<td align="right" style="padding-right:15px;">Город:</td>
						<td><strong><input size="80" name="" type="text" value="<?php echo $this->_tpl_vars['tname']; ?>
" disabled></strong></td>
					</tr>
					<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
					<?php if ($this->_tpl_vars['item']['showInOrder'] == 1): ?>
					<tr>
						<td class="key"><?php echo $this->_tpl_vars['item']['description']; ?>
:</td>
						<td><strong><input size="30" name="" type="text" value="<?php echo $this->_tpl_vars['item']['value']; ?>
" disabled></strong></td>
					</tr>
					<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>					
					</tbody>
			</table>
			<br/>
            <table  style="display:none;" border="0" cellspacing="0" cellpadding="0" class="prods_content cart" style="margin-left:10px; color: #888;">
					<tbody>
						<tr>
							<th align="center" colspan="4">Позиции заказа</th>
						</tr>
						<tr>
							<th align="center" width="50%">Наименование товара</th>
							<th align="center">Цена</th>
							<th align="center">Количество</th>
							<th align="center">Итого</th>														
						</tr>
						<?php $_from = $this->_tpl_vars['order_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
						<?php if (is_int ( $this->_tpl_vars['key'] )): ?>
						<tr class="sectiontableentry2">
							<td align="left" style="border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5;padding:10px;">
								<a style="color: #817A7A; text-decoration: none;" href="<?php echo $this->_tpl_vars['item']['uri']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</a></td>
							<td align="center" style="border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5;"><?php echo $this->_tpl_vars['item']['price']; ?>
 руб.</td>
							<td align="center" style="border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5;"><?php echo $this->_tpl_vars['item']['quantity']; ?>
</td>
							<td align="center" style="border-bottom:1px solid #E5E5E5;"><?php echo $this->_tpl_vars['item']['total']; ?>
 руб.</td>
						</tr>
						<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
						<?php if ($this->_tpl_vars['order_data']['sprice'] != '0.00'): ?>
						<tr class="sectiontableentry2">
							<td style="border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5;padding:10px;">Доставка</td>
							<td align="center" style="border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5"><?php echo $this->_tpl_vars['order_data']['sprice']; ?>
 руб.</td>
							<td align="center" style="border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5">1</td>
							<td align="center" style="border-bottom:1px solid #E5E5E5"><?php echo $this->_tpl_vars['order_data']['sprice']; ?>
 руб.</td>
						</tr>
						<?php endif; ?>
						
						<?php if ($this->_tpl_vars['order_data']['sprice'] != '0.00'): ?>
						<tr class="sectiontableentry2">
							<td colspan="2" align="right" style="border-right: 1px solid #E5E5E5;padding-right:10px;">Итого:</td>
							<td align="center" colspan="2"><?php echo $this->_tpl_vars['order_data']['cost']; ?>
 руб.</td>
						</tr>
						<?php else: ?>
						<tr class="sectiontableentry2">
							<td colspan="2" align="right" style="border-right: 1px solid #E5E5E5;padding-right:10px;">Итого:</td>
							<td align="center" colspan="2"><?php echo $this->_tpl_vars['order_data']['total']; ?>
 руб.</td>
						</tr>
						<?php endif; ?>
					</tbody>	
			</table>
			
<br/>
<form  style="display:none;" method="post" action="/bill/" target="_blank" id="bill">
	<input type="hidden" name="order_id" value="<?php echo $this->_tpl_vars['id']; ?>
">
	
	<div id="buttons">
		<?php if ($this->_tpl_vars['state'] != 5): ?>
			<div class="itemCart" style="float:left">
				<a id="bill" onclick="$('form#bill').submit()" href="#"><?php echo $this->_tpl_vars['action']; ?>
</a>
			</div>			
		<?php endif; ?> 
	
		<?php if ($this->_tpl_vars['state'] == 0): ?>
			<div class="itemCart" style="float:left">
				<a id="discard" onclick='return discard("<?php echo $this->_tpl_vars['id']; ?>
");' href="#">Отменить заказ</a>
			</div>				
		<?php endif; ?>
	
		<?php if ($this->_tpl_vars['state'] == 5): ?>
			<button id="renew" class="button guest" onclick='return reneworder("<?php echo $this->_tpl_vars['id']; ?>
");'>Подтвердить заказ</button>
		<?php endif; ?> 
	</div>	
</form>
<div style="clear:left;"></div>
<div  style="display:none;" class="itemCart" style="float:left;margin-left:14px;margin-top:18px;margin-bottom:16px;"><a href="/orderslist/">Список заказов</a></div>