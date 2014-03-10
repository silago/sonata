
	<div class="autorize" style="display:none;" id="login-auth-form" >
				<h2>Регистрация / Авторизация</h2>	

				<div style="" class="aut-box">
					<form action="/logingo/" method="post">
						<h3>Для зарегистрированных покупателей</h3>	
 			<div class="block">
							<span>E-Mail</span>
							<input name="email" type="text" />	
						</div>

						<div class="block">
							<span>Пароль</span>
							<input name="pass" type="password" />
							<p><a href="/forgotpass/">Забыли пароль?</a></p>	
						</div>
                       <p style="font:18px Arial; color:#980000;" class="placeforerr2">			
    {php}
		if ( (isset($_SESSION['info']['title'])) && (!empty($_SESSION['info']['title'])) && ($_SESSION['info']['class']=='loginerr') )
		echo $_SESSION['info']['title'];
		unset($_SESSION['info']);
        {/php}		

<br/>
<br/>
    </p>
			    <input type="hidden" name="remember"/>
						<input type="submit" name="go" value="Вход" class="reg-submit" />
					</form>

					<form action="/register/">
						<h3>Для новых покупателей</h3>	
						<input onclick="$('.alert-input').removeClass('alert-input'); $('.alert-text').remove(); $('#login-auth-form').hide(); $('#login-register-form').show(); return false; " type="submit" value="Продолжить" class="next-submit" />
					</form>	
				</div>
			</div>	
        
        <div id="login-register-form"  style="">
            
        <h2> Регистрация / Авторизация </h2>
		<div class="box-cont">
					<div class="rg-box">
                        

						<div class="calc-box">
						<form  class="tabContent" id="register" action="#" method="post" onsubmit="return registergo('register');">
                            <div class="title">
								<h3>Для новых покупателей</h3>
								<a onclick="$('.alert-input').removeClass('alert-input'); $('.alert-text').remove(); $('#login-auth-form').show(); $('#login-register-form').hide(); return false; " href="/login/">Для зарегистрированных покупателей</a>
							</div>
                            <div id="error">
                            </div>
							<div class="block">
								<span>Ф.И.О.</span>
								<input name="name" type="text" placeholder="" />	
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
								<span>Пароль <br/> <small style="font-size:10px; margin-top:5px; color:#343434;" >Минимальная длина пароля - 6 символов.</small></span>

								<input name="pass" type="password" placeholder="" />
							</div>

							<div class="block">
								<span>Повторить пароль</span>
								<input name="pass2" type="password" placeholder="" />	
							</div>

							<div class="radio-block">
								<label><input name="org" onclick="$('.ur').hide();"   value="0" class="niceRadio" type="radio" /> Физическое лицо</label>
								<label><input name="org" onclick="$('.ur').show();"  value="1" class="niceRadio" type="radio" checked=checked /> Юридическое лицо</label>	
							</div>

							<div class="ur block">
								<span>Название органиции</span>
								<input name="organizaion_name" type="text" placeholder="" />	
							</div>

							<div  class="ur block">
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
        </div>

