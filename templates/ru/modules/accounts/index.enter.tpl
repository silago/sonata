<div align="center" style="color:#F20006;">{$enter_error}</div>
<div align="center">{$urlcode}</div>
<form name="register" action="/accounts/enter/" method="post">
<table align="center">
	<tr>
    	<td align="right"><font color="#F20006">*</font> E-Mail:</td>
    	<td><input name="email" type="text" value="{$email}"></td>
	</tr>
	<tr>
    	<td align="right"><font color="#F20006">*</font> Пароль:</td>
    	<td><input name="password" type="password" value=""></td>
	</tr>
	<tr>
    	<td align="right"> </td>
    	<td><input type="submit" value="Войти"></td>
	</tr>
</table>
</form>

<div align="center"><a href="/accounts/recovery/">Забыли пароль?</a></div>