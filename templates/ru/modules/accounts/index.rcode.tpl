<div align="center">{$message}</div>
{if $inform != 1}
<form name="rcode" action="?" method="post">
<table align="center">
	<tr>
    	<td align="right"><font color="#F20006">*</font> E-Mail:</td>
    	<td><input name="email" type="text" value="{$email}"><font color="#F20006">{$error_mail}</font></td>
	</tr>
	<tr>
    	<td align="right"> </td>
    	<td>Введите Email, с которого Вы регистрировали аккаунт, код будет выслан Вам на него</td>
	</tr>
	<tr>
    	<td align="right"> </td>
    	<td><div class="qaptcha"></div><font color="#F20006">{$error_capcha}</font></td>
	</tr>
	<tr>
    	<td align="right"> </td>
    	<td><input type="submit" value="Выслать код"></td>
	</tr>
</table>
</form>
{/if}