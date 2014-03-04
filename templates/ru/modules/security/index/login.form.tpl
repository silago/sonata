	<div class="autorize">
				<h2>Регистрация / Авторизация</h2>	
    <p style="font:18px Arial; color:#980000; margin-left:-15px; margin-bottom:-20px; padding:20px;" class="placeforerr2">			
    {php}
		if ( (isset($_SESSION['info']['title'])) && (!empty($_SESSION['info']['title'])) && ($_SESSION['info']['class']=='loginerr') )
		echo $_SESSION['info']['title'];
		unset($_SESSION['info']);
        {/php}		
        <br>
        <br>

    </p>
				<div class="aut-box">
					<form action="/logingo/" method="post">
						<h3>Для зарегистрированных покупателей</h3>	

						<div class="block">
							<span>E-Mail</span>
							<input name="email" type="text" />	
						</div>

						<div class="block">
							<span>Пароль</span>
							<input name="pass" type="password" />
							<p><a href="/restorepass">Забыли пароль?</a></p>	
						</div>
                        <input type="hidden" name="remember"/>
						<input type="submit" name="go" value="Вход" class="reg-submit" />
					</form>

					<form action="/register/">
						<h3>Для новых покупателей</h3>	
						<input type="submit" value="Продолжить" class="next-submit" />
					</form>	
				</div>
			</div>	



