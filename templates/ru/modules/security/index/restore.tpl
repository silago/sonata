<div style="padding:20px;" class="box-cont">
{if $step==1}
<div class="registration-block">
<p>
<form class="form-row" method=post action="/forgotpass">
<h3> Забыли пароль? Мы вам поможем! </h3>
<p> Просто введите ваш e-mail адрес в поле ниже и мы отправим вам дальнешие инструкции для востановления пароля. </p>

<br>
<input style="border:0px; border-radius:5px; padding:10px; width:500px; height:21px;" type="textfield" name="email" placeholder="email" class="reg-input">
<input type="submit" style="width:300px;" class="reg-submit" style="display:inline-block;" name="submit" value="Отправить данные">

</form>
</div>
</p>
{/if}

{if $step==2}
<p>
<form method=post action="/forgotpass">
<h3>Востановление пароля </h3>
<p> На ваш почтовый ящик было отправлено письмо с дальнейшими инструкциями.<br>


 </p>
</form>
</p>
{/if}
<br/>
<br/>
<br/>


</div>
