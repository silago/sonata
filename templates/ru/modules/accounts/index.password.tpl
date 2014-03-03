<div align="center" style="color:#0EA321; font-weight:bold;">{$pass_edit_ok}</div>
<form name="password" action="?" method="post">
<table align="center">
	<tr>
    	<td align="right"><font color="#F20006">*</font> Старый пароль:</td>
    	<td><input name="old_password" type="password" value=""><font color="#F20006">{$error_password4}</font></td>
	</tr>
	<tr>
    	<td align="right"><font color="#F20006">*</font> Новый пароль:</td>
    	<td><input name="new_password" type="password" value=""><font color="#F20006">{$error_password3}</font></td>
	</tr>
	<tr>
    	<td align="right"><font color="#F20006">*</font> Повторите новый пароль:</td>
    	<td><input name="new_password2" type="password" value=""><font color="#F20006">{$error_password} {$error_password2}</font></td>
	</tr>
	<tr>
    	<td align="right"> </td>
    	<td><input type="submit" value="Сменить пароль"></td>
	</tr>
</table>
</form>