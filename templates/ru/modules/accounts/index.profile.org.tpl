<div align="center" style="color:#0EA321; font-weight:bold;">{$profile_edit_ok}</div>
<form name="org" action="?" method="post">
<table align="center">
	<tr>
    	<td align="right"><font color="#F20006">*</font> E-Mail:</td>
    	<td><input name="email" type="text" value="{$email}"><font color="#F20006">{$error_email} {$error_email2}</font></td>
	</tr>
	<tr>
    	<td align="right"><font color="#F20006">*</font> Название организации:</td>
    	<td><input name="org_name" type="text" value="{$org_name}"><font color="#F20006">{$error_org_name}</font></td>
	</tr>
	<tr>
    	<td align="right">Полное название организаци:</td>
    	<td><input name="full_name" type="text" value="{$full_name}"></td>
	</tr>
	<tr>
    	<td align="right"><font color="#F20006">*</font> ИНН:</td>
    	<td><input name="inn" type="text" value="{$inn}"><font color="#F20006">{$error_inn} {$error_inn2}</font></td>
	</tr>
	<tr>
    	<td align="right"><font color="#F20006">*</font> Контактный телефон:</td>
    	<td><input name="tel" type="text" value="{$tel}"><font color="#F20006">{$error_tel}</font></td>
	</tr>
	<tr>
    	<td align="right">Индекс:</td>
    	<td><input name="index" type="text" value="{$index}"></td>
	</tr>
	<tr>
    	<td align="right">Адрес:</td>
    	<td><textarea name="adress" rows="5" cols="20">{$adress}</textarea></td>
	</tr>
	<tr>
    	<td align="right"> </td>
    	<td><input type="submit" value="Сохранить"></td>
	</tr>
</table>
</form>