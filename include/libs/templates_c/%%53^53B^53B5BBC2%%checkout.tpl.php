<?php /* Smarty version 2.6.16, created on 2014-03-03 13:30:16
         compiled from ru/modules/orders/index/checkout.tpl */ ?>
<?php echo '
<script>
	function checkout(elem){
		var form = jQuery(elem).serialize();		
		jQuery.ajax({
                type: \'POST\',                
				url: \'/confirmorder/\',
				dataType: "json",
                data: {form:form},
                success: function(data){					
					if(data.orderid && data.orderid.length > 0){
                        alert(\'ok\');
						//document.location = \'/order?order_id=\'+data.orderid;
						jQuery(elem).find(\'button[type="submit"]\').attr(\'disabled\', \'disabled\');
					}else{
						jQuery(\'#error\').removeClass(\'alert\').removeClass(\'alert-error\');
						jQuery(\'#error\').html(\'\');
						for(i = 0; i<data.length; i++){
							var html = jQuery(\'#error\').html();
							jQuery(\'#error\').html(html + data[i] + \'<br>\');
							jQuery(\'#error\').addClass(\'alert\').addClass(\'alert-error\');
						}
					}					
				}
            });
		
		return false;
	}

</script>
'; ?>


	<form action="" name="tab_3" onsubmit="return checkout(this);" method="post">	
	<div class="box-container">
				<h2>Информация для доставки и оплаты</h2>

				<div class="box-cont">
					<div class="serv-form">
						<div class="block">
								<span>Имя <strong>*</strong></span>
								<input type="text" name="order_name" placeholder="Антон Антоныч" />	
							</div>	

							<div class="block">
								<span>Телефон <strong>*</strong></span>
								<input name="order_phone" type="text" placeholder="+7 (495) 456-24-23" />	
							</div>

							<div class="block">
								<span>E-Mail <strong>*</strong></span>
								<input type="text" placeholder="info@antinich.ru" class="alert-input" />	
								<p order="order_email" class="alert-text">Не корректно указан адрес электронной почты! <img src="images/ln.png" height="10" width="3" alt="" /></p>
							</div>

							<div class="radio-block">
								<label><input class="niceRadio" name="sname" value="1" type="radio" /> Доставка</label>
								<label><input class="niceRadio" name="sname" value="2" type="radio" /> Самовывоз</label>	
							</div>

							<div class="block">
								<span>Улица <strong>*</strong></span>
								<input type="text" placeholder="" name="order_street" />	
							</div>

							<div class="block">
								<div class="bl-box">
											<div class="adr">
												<span>Дом </span>
												<input type="text" name="order_house" placeholder="" class="c1" />	
											</div>

											<div class="adr">
												<span>Корпус</span>
												<input type="text" name="order_corp" placeholder="" class="c2" />	
											</div>	

											<div class="adr">
												<span>Квартира/офис</span>
												<input type="text" placeholder="" name="order_office" class="c3" />	
											</div>
										</div>	
							</div>

							<div class="block">
								<span>Желаемая дата<br /> доставки </span>
								<input type="text" id="datepicker" name="order_date" class="cl" />

								<div class="time-block">
									<span class="span-text">Время</span>	
                                    <input name="order_time" value="00:00" type="hidden" />
									<select>
										<option>00</option>
										<option>01</option>
										<option>02</option>
										<option>03</option>
										<option>04</option>
									</select>

									:

									<select>
										<option>00</option>
										<option>01</option>
										<option>02</option>
										<option>03</option>
										<option>04</option>
									</select>
								</div>	
							</div>

							<div class="pay-serv">
								<p>Оплата <strong>NNNNNN</strong> руб.</p>	

								<label><input class="niceRadio" type="radio" name="pname" /> Оплатить онлайн банковской картой</label>
								<label><input class="niceRadio" type="radio" value="cashpayment" checked=checked name="pname" /> Выписать счет для оплаты</label>	
								<label><input class="niceRadio" type="radio" name="pname" /> Наличными. Курьеру при доставке</label>
								<label><input class="niceRadio" type="radio" name="pname" /> Банковкой картой, курьеру при доставке</label>

								<input type="submit" value="Продолжить" />	

								<div class="help-text">
									Подробное описание способа оплаты. Выписывая счет, вы имеете возможность оплатить свой заказ одним из способов, предложенных в данной форме. Выписывая счет, вы имеете возможность оплатить свой заказ одним из способов, предложенных в данной форме.
									<img src="images/help-img.png" height="10" width="4" alt="" />	
								</div>
							</div>
					</div>	
				</div>	
			</div>
            </form>








<!--
<div class="boxCont">
				<div class="orderLeft">
					<h1>Безопасное оформление заказа</h1>
					
					<div id="ex-one">
				
						<div style="padding:0px;" class="tabContent">
							<div class="list-wrap">	
						<form action="" name="tab_3" onsubmit="return checkout(this);" method="post">	
									
									
										
								<div id="description1" class="hide">
								</div>
								
								<p id="error"></p>
								
								<div id="description2" class="hide">
								
									<div class="form_2">
																		
										
											<div class="clear"></div>
											<label>Вид доставки:</label>
											
											<?php echo $this->_tpl_vars['shipList']; ?>

											
											<div class="clear"></div>
											
											<div class="sm sm1" style="display:none;">
											<label>Город:</label>
											<div class="boxSelect3 selectTown">
												<div class="lineForm">		
													<select  id="town"  class="se247" tabindex="1">

														<?php $_from = $this->_tpl_vars['towns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>                          
														<option value="<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['tname']; ?>
</option>						   						   
														<?php endforeach; endif; unset($_from); ?>																							
													</select>
													<input type="hidden" id="town2" name="town2"/>
												</div>
											</div>
											
											
											<div class="clear"></div>
											<label>Дата:</label>
											<input  id="ddate2" class="input_3" name="ddate2" type="text"> </input>
											
									


						 
											<div class="clear"></div>
										
											
											</div>
											
											<div class="clear"></div>
											<div class="sm sm2" style="display:none;">
												
											<label>Адрес:</label>
											<input type="text" name="adrr" class="input_3" value="<?php echo $this->_tpl_vars['addr']; ?>
" />
											
											<div class="clear"></div>	
											
											
											<label>Дата:</label>
											<input  id="ddate" class="input_3" name="ddate" type="text"> </input>
											<div class="clear"></div>					
											</div>					
										

									</div>
								</div>
								
								
								<div id="description3" class="hide">
											<label>Тип оплаты:</label>
											<div class="boxSelect3">
												<div class="lineForm">		
													<select  id="country2" name="pname" class="se247" tabindex="1">
														<?php $_from = $this->_tpl_vars['payments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>					
														 <option value='<?php echo $this->_tpl_vars['item']['title']; ?>
'><?php echo $this->_tpl_vars['item']['name']; ?>
</option>
														<?php endforeach; endif; unset($_from); ?>
																																				
													</select>
												</div>
											</div>			
															<div class="clear"></div>	
															<label>Комментарий к заказу:</label>
															<textarea class="input_3" name="comment">
															</textarea>	
															<div class="clear"></div>	
															
																											
											<input type="submit" class="button_4" value="Оформить" />
										
								</div>
							</form>
							</div>
						</div>
					</div>
					
				
					
				</div>
			
				<div class="clear"></div>
				
			</div>
</div>

-->


<?php echo '
<script>
$(document).ready( function() {

$(\'ul.nav li:nth-child(2) a\').click();
	$(\'#description2\').show();
});
</script>


'; ?>











