<form name="register" action="?" method="post">
<table align="center">
	<tr>
    	<td align="right"><font color="#F20006">*</font> E-Mail:</td>
    	<td><input name="email" type="text" value="{$email}"><font color="#F20006">{$error_recovery_mail}</font></td>
	</tr>
	<tr>
    	<td align="right"> </td>
    	<td>Введите Email, с которого Вы регистрировали аккаунт, новый пароль будет выслан Вам на него</td>
	</tr>
	<tr>
    	<td align="right"> </td>
    	<td><div class="qaptcha"></div><font color="#F20006">{$error_capcha}</font></td>
	</tr>
	<tr>
    	<td align="right"> </td>
    	<td><input type="submit" value="Восстановить пароль"></td>
	</tr>
</table>
</form>