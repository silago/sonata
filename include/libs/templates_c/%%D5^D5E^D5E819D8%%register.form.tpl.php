<?php /* Smarty version 2.6.16, created on 2014-03-06 15:21:13
         compiled from ru/modules/security/index/register.form.tpl */ ?>
		<div class="box-cont">
					<div class="rg-box">
                        

						<div class="calc-box">
						<form  class="tabContent" id="register" action="#" method="post" onsubmit="return registergo('register');">
                            <div class="title">
								<h3>Для новых покупателей</h3>
								<a href="/login/">Для зарегистрированных покупателей</a>
							</div>
                            <div id="error">
                            </div>
							<div class="block">
								<span>Фамилия.</span>
								<input name="surname" type="text" placeholder="" />	
							</div>	
			                <div class="block">
								<span>Имя</span>
								<input name="name" type="text" placeholder="" />	
							</div>	

							<div class="block">
								<span>Отчество</span>
								<input type="text" name="patronymic" placeholder="" />	
							</div>	

							
							<div class="block">
								<span>Телефон</span>
								<input name="phone" type="text" placeholder="" />	
							</div>

							<div class="block">
								<span>E-Mail</span>
								<input name="email" type="text" placeholder="" />	
							</div>

							<div class="block">
								<span>Пароль</span>
								<input name="pass" type="password" placeholder="" />	
							</div>

							<div class="block">
								<span>Повторить пароль</span>
								<input name="pass2" type="password" placeholder="" />	
							</div>

							<div class="radio-block">
								<label><input name="org" value="0" class="niceRadio" type="radio" checked=checked/> Физическое лицо</label>
								<label><input name="org" value="1" class="niceRadio" type="radio" /> Юридическое лицо</label>	
							</div>

							<div class="block">
								<span>Название органиции</span>
								<input name="organizaion_name" type="text" placeholder="" />	
							</div>

							<div class="block">
								<span>ИНН</span>
								<input name="inn" type="text" placeholder="" />	
							</div>

							<div class="block">
								<input type="submit" value="Продолжить" />	
							</div>
                            </form>
						</div>

					</div>	
				</div>	
