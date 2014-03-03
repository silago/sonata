<form name="register" action="/accounts/regpost/" method="post">
<table align="center">
	<tr>
    	<td align="right" width="250">Регистрироваться как:</td>
    	<td><input name="type" type="radio" value="0" onClick="registerType(0);" {$check_fiz}> Физическое лицо
    	    <input name="type" type="radio" value="1" onClick="registerType(1);" {$check_org}> Организация
    	</td>
	</tr>
	<tr>
    	<td align="right"><font color="#F20006">*</font> E-Mail:</td>
    	<td><input name="email" type="text" value="{$email}"><font color="#F20006">{$error_email} {$error_email2}</font></td>
	</tr>
	<tbody class="fiz" {$display_fiz}>
	<tr>
    	<td align="right" id="rtyu"><font color="#F20006">*</font> Имя:</td>
    	<td><input name="name" type="text" value="{$name}"><font color="#F20006">{$error_name}</font></td>
	</tr>
	<tr>
    	<td align="right">Фамилия:</td>
    	<td><input name="last_name" type="text" value="{$last_name}"></td>
	</tr>
	<tr>
    	<td align="right">Отчество:</td>
    	<td><input name="middle_name" type="text" value="{$middle_name}"></td>
	</tr>
	</tbody>
	<tbody class="org" {$display_org}>
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
	</tbody>
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
    	<td align="right"><font color="#F20006">*</font> Пароль:</td>
    	<td><input name="password" type="password" value=""><font color="#F20006">{$error_password} {$error_password2}</font></td>
	</tr>
	<tr>
    	<td align="right"><font color="#F20006">*</font> Повторите пароль:</td>
    	<td><input name="password2" type="password" value=""></td>
	</tr>
	<tr>
    	<td align="right"> </td>
    	<td><div class="qaptcha"></div><font color="#F20006">{$error_capcha}</font></td>
	</tr>
	<tr>
    	<td align="right"> </td>
    	<td><input type="submit" value="Регистрация"></td>
	</tr>
</table>
</form>