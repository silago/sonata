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
						<input type="submit" name="go" value="Регистрация" class="reg-submit" />
					</form>

					<form action="/register/">
						<h3>Для новых покупателей</h3>	
						<input type="submit" value="Продолжить" class="next-submit" />
					</form>	
				</div>
			</div>	




<form class="tabContent" id="login" action="/logingo/" method="post">

    <p style="font:13px Arial; color:red;" class="placeforerr2">			
        {php}
		if ( (isset($_SESSION['info']['title'])) && (!empty($_SESSION['info']['title'])) && ($_SESSION['info']['class']=='loginerr') )
		echo $_SESSION['info']['title'];
		unset($_SESSION['info']);
        {/php}		
        <br>
        <br>

    </p>

    <div class="box-container">
        <div class="login-content">
            <div class="left">
                <h2>Новый пользователь</h2>
                <div class="content">
                    <p><b>Зарегистрироваться</b></p>
                    <p>Создав аккаунт, Вы сможете производить покупки быстрее и быть в курсе о статусе заказа, а также отслеживать заказы, сделанные Вами ранее.</p>
                    <a href="/register" class="button"><span>Продолжить</span></a></div>
            </div>
            <div class="right">
                <h2>Постоянный клиент</h2>
                 
                    <div class="content">
                        <p>Я уже являюсь клиентом</p>
                        <b class="padd-form">E-Mail Адрес:</b>
                        <input class="q1 margen-bottom" type="text" name="email" value="{$email}">
                        <b class="padd-form">Пароль:</b>
                        <input class="q1 margen-bottom" type="password" name="pass" value="{$password}">
                        <br> 
                        <span>Запомнить меня</span>
        <input type="checkbox" name="remember" value="1" id="check" /><br /><br />
                        <a onclick="$('#login').submit();" class="button"><span>Вход</span></a>
                    </div> 
            </div>
        </div>
    </div>

 

    <input type="hidden" name="go" value="go">
</form>
