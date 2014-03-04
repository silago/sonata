<?php /* Smarty version 2.6.16, created on 2014-03-04 14:54:04
         compiled from ru/modules/orders/index/checkout.unauth.tpl */ ?>
<?php echo '
<script>
	function registerandcheckout(elem){
		var form = jQuery(elem).serialize();		
		
		jQuery.ajax({
                type: \'POST\',                
				url: \'/registerandcheckout/\',
				dataType: "json",
                data: {form:form},
                success: function(data){

                    if(data.registered == true){
                        jQuery(\'.placeforerr\').addClass(\'alert\').addClass(\'alert-info\');
                        jQuery(\'p.placeforerr\').html(\'Запись с указанным email адресом уже существует в базе данных. Попробуйте авторизоваться\');
                       // jQuery(\'div#forms\').html(data.form);

                    }else{
                        if(data.length > 0){
                            jQuery(\'.placeforerr\').html(\'\');
							jQuery(\'.placeforerr\').addClass(\'alert\').addClass(\'alert-error\');
                            for(i = 0; i<data.length; i++){
                                var html = jQuery(\'.placeforerr\').html();
                                jQuery(\'.placeforerr\').html(html + data[i] + \'<br>\');
                                jQuery(\'.placeforerr\').addClass(\'alert\').addClass(\'alert-error\');
                            }
                        }else{
                            jQuery(elem).find(\'button[type="submit"]\').attr(\'disabled\', \'disabled\');
							document.location.href=\'/checkout/\';
                        }
                    }
				}
            });
		
		return false;
	}
	
</script>
<style>
.box-container label {margin-top:10px;}
.box-container #check {margin-top:10px;}
</style>
'; ?>




<div class="boxCont">
				<div class=" orderLeft ">
					<h1>Оформление заказа</h1>
				
					
					<div id="ex-one" class="box-container">
				
						<div style="padding:0px;" class="tabContent">
							<div class="list-wrap">	
								
								<div id="description1">
									<form action="/logingo/" name="tab_1" method="post">
										<div class="contTabLeft">
											<h4 style="margin:0 0 10px 0; padding:0px;">Вход</h4>
												<p class="placeforerr2" style="padding:0px; margin:0px;">			
														<?php 
															if ( (isset($_SESSION['info']['title'])) && (!empty($_SESSION['info']['title'])) && ($_SESSION['info']['class']=='loginerr') )
															echo $_SESSION['info']['title'];
															unset($_SESSION['info']);
														 ?>		
																						
												</p>
													<div class="clear"></div>
											<form action="/logingo/" method="post">
											<label>E-mail:</label>
											<input type="text" name="email" class="input_1" value="" />
											<label>Пароль:</label>
											<input type="password" name="pass" class="input_1" value="" />
											
											<input type="hidden" value="go" name="go">
											<input type="hidden" value="/checkout" name="url">
											<div class="clear"></div>
											<div class="checkLine">
												<input type="checkbox" name="remember" id="check" />
												<label for="check" class="check">Запомнить меня</label>
												<div class="clear"></div>
											</div>
											<input type="submit" class="button_2" value="Авторизация" />
											
										</div>
									</form>
										<div class="contTabRight">
											<h4 style="padding:0px; margin:0px;">Регистрация</h4>
																
												<p style="margin:0px;" class="placeforerr">																		
													
													
												</p>
													<div class="clear"></div>
											<form action="" name="chkform" onsubmit="return registerandcheckout(this);" id="chk">									
											<br>
											<label>Фамилия:</label>
											<input type="text" name="surname" class="input_3" value="" />
											<div class="clear"></div>	
											<label><font color="#F20006">*</font>Имя:</label>
											<input type="text" name="name" class="input_3" value="" />
											<div class="clear"></div>						
											<label>Отчество:</label>
											<input type="text" name="patronymic" class="input_3" value="" />
											<div class="clear"></div>	
											<label><font color="#F20006">*</font>E-Mail:</label>
											<input type="text" name="email" class="input_3" value="" />
											<div class="clear"></div>		
											<label><font color="#F20006">*</font>Телефон:</label>
											<input type="text" name="phone" class="input_3" value="" />
											<div class="clear"></div>		
										
																			
											<input type="submit" class="button_3" value="Зарегистрироваться" />
											</form>
											
											
										</div>
										<div class="clear"></div>
										
									
								</div>
							<div id="description2" style="display:none;" class="hide">
									<div class="form_2">
										<form action="" name="tab_2" method="post">										
											<h4>Информацая о покупателе</h4>
											
											<label>Имя:</label>
											<input type="text" name="search" class="input_3" value="" />
											<div class="clear"></div>						
											<label>Фамилия:</label>
											<input type="text" name="search" class="input_3" value="" />
											<div class="clear"></div>	
											<label>Отчество:</label>
											<input type="text" name="search" class="input_3" value="" />
											<div class="clear"></div>	
											<label>E-Mail:</label>
											<input type="text" name="search" class="input_3" value="" />
											<div class="clear"></div>										
											<input type="submit" class="button_3" value="Зарегистрироваться" />
										</form>
									</div>
								</div>
								<div id="description3" style="display:none;" class="hide">
									<div class="form_2">
										<form action="" name="tab_3" method="post">										
											<h4>Дополнительная информация</h4>
											<label>Город:</label>
											<div class="boxSelect3">
												<div class="lineForm">		
													<select  id="country" name="country" class="se247" tabindex="1">
														<option value="">Иркутск</option>	
														<option value="">Иркутск2</option>																								
													</select>
												</div>
											</div>
											<div class="clear"></div>
											<label>Вид доставки:</label>
											<div class="leftRadio">
												<div class="lineRadio">
													<input type="radio" class="styledRadio" name="radio" id="radio_1" /><label class="radioLable" for="radio_1">Курьером <span>Стоимость доставки: 500 руб. Время доставк: 3 дня</span></label>
													<div class="clear"></div>
												</div>
												<div class="lineRadio">
													<input type="radio" class="styledRadio" name="radio" id="radio_2" /><label class="radioLable" for="radio_2">Самовывоз <span>Стоимость: 0 </span></label>
													<div class="clear"></div>
												</div>
											</div>	
											<div class="clear"></div>
											<label>Тип оплаты:</label>
											<div class="boxSelect3">
												<div class="lineForm">		
													<select  id="country2" name="country2" class="se247" tabindex="1">
														<option value="">Наличными</option>	
														<option value="">Наличными2</option>																								
													</select>
												</div>
											</div>
											<div class="clear"></div>
											<label>Адрес:</label>
											<input type="text" name="search" class="input_3" value="" />
											<div class="clear"></div>						
											<label>Телефон:</label>
											<input type="text" name="search" class="input_3" value="" />
											<div class="clear"></div>																	
											<input type="submit" class="button_4" value="Оформить" />
										</form>
									</div>
								</div>
							
							</div>
						</div>
					</div>
					
				</div>
					<div style="display:none;" class="boxSumm">
					<p class="title">Сумма заказа</p>
					<div class="contentSumm">
						<p><?php echo $this->_tpl_vars['count']; ?>
 штук(-а)</p><p><?php echo $this->_tpl_vars['total']; ?>
 руб.</p>
						<div class="clear"></div>

						<div class="clear"></div>
					</div>
				</div>
				<div class="clear"></div>
				
			</div>
			</div>


















    <div style="display:none;" id="error" style="margin-left:25px;"></div>
	<div style="display:none;" id="forms"><form action="" id="chk" onsubmit="return registerandcheckout(this);">
        
            <table border="0" cellspacing="0" cellpadding="0" class="prods_content cart" style="margin-left:10px; color: #888;">
				<tr>
					<th class="th1" colspan="2">Резкивизы</th>
				</tr>
				
				<tr>
					<td colspan="2" align="center">Для оформления заказа Вам необходимо зарегистрироваться в интернет-магазине.</td>
				</tr>
				
					<tr>
						<td class="key" style="text-align:left;" ><font color="#F20006">*</font> Фамилия:</td>
						<td><input size="30" name="surname" type="text" value="<?php echo $this->_tpl_vars['surname']; ?>
"></td>
					</tr>
				
				
				
					<tr>
						<td class="key" style="text-align:left;"><font color="#F20006">*</font> Имя:</td>
						<td><input size="30" class="required" name="name" type="text" value="<?php echo $this->_tpl_vars['name']; ?>
"></td>
					</tr>
				
				
				
					<tr>
						<td class="key" style="text-align:left;"><font color="#F20006">*</font> Отчество:</td>
						<td><input size="30" class="required" name="patronymic" type="text" value="<?php echo $this->_tpl_vars['patronymic']; ?>
"></td>
					</tr>
					
					<tr>
						<td class="key" style="text-align:left;"><font color="#F20006">*</font> Email адрес:</td>
						<td><input size="30" class="required" name="email" type="text" value="<?php echo $this->_tpl_vars['email']; ?>
"></td>
					</tr>
					<?php echo $this->_tpl_vars['form']; ?>

					<tr>
						<td colspan="2" style="padding-left:15px;">
							<div style="float:left" class="itemCart">
								<button type="submit" onclick="" >Зарегистрироваться в интернет магазине</button>
							</div>
							
						</td>
					</tr>
			</table>			
    </form>
</div>



<table border="0" cellspacing="0" cellpadding="0" class="prods_content cart" style="margin-left:25px;margin-top:15px;width:705px; color: #888; display:none;">
					<tbody>
						<tr>
							<th class="th1" colspan="5">Информация о заказе</th>
						</tr>
						<tr>
							<th style="text-align:center;" >Наименование товара</th>
							<th style="text-align:center;">Артикул</th>
							<th style="text-align:center;" width="60px">Цена</th>
							<th style="text-align:center;" width="140px">Количество</th>                            
							<th style="text-align:center;"  width="70px">Итого</th>
						</tr>
						<?php $_from = $this->_tpl_vars['basket']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
						<tr style="vertical-align:top;" class="sectiontableentry2">
                            <td  style="text-align:center; border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5;">								
                                <span class="cart-title"><a href="/<?php echo $this->_tpl_vars['item']['uri']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</a></span>
                            </td>
                            <td style="text-align:center; border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5;">
                                <?php echo $this->_tpl_vars['item']['article']; ?>

                            </td>
                            <td  style="text-align:center;  border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5;"><?php echo $this->_tpl_vars['item']['price']; ?>
</td>
                            <td  style="text-align:center;  border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5;"><?php echo $this->_tpl_vars['item']['quantity']; ?>
</td>
                            <td colspan="1" align="center" style="border-right: 1px solid #E5E5E5; border-bottom:1px solid #E5E5E5;"><strong><?php echo $this->_tpl_vars['item']['total']; ?>
 р.</strong></td>
                        </tr>
						<?php endforeach; endif; unset($_from); ?>
		                <tr class="sectiontableentry2 bg-top">
			                <td colspan="4" align="right" style="border-right: 1px solid #E5E5E5;padding-right:10px;">Итого: </td>
			                <td align="center" class="total"><strong><?php echo $this->_tpl_vars['total']; ?>
 р.</strong></td>
		                </tr>						
                    </tbody>
                </table>