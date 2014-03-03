<div id="error" style="margin-left:15px;"></div>
<form  class="tabContent" id="register" action="#" method="post" onsubmit="return registergo('register');">

    <table class="form">
        <tbody>
            <tr>
                <td><span class="required">*</span> Ваш E-mail адрес:</td>
                <td><input class="q1" type="text" name="email" value="{$email}">
                </td>
            </tr>
         
            <tr>
                <td><span class="required">*</span> Пароль:</td>
                <td><input class="justField input_3" name="pass" type="password" value="{$password}">
                </td>
            </tr>
         
            <tr>
                <td><span class="required">*</span> Подтверждение пароля:</td>
        <td><input class="justField input_3" name="pass2" type="password" value="{$password2}">
                </td>
            </tr>
         
            <tr>
                <td><span class="required">*</span> Фамилия:</td>
		<td><input class="justField input_3" name="surname" type="text" value="{$surname}">
                </td>
            </tr>
         
            <tr>
                <td><span class="required">*</span> Имя:</td>
		<td><input class="justField input_3" name="name" type="text" value="{$name}">
                </td>
            </tr>
         
            <tr>
                <td><span class="required">*</span> Отчество:</td>
		<td><input class="justField input_3" name="patronymic" type="text" value="{$patronymic}">
                </td>
            </tr>
         
            <tr>
                <td><span class="required">*</span> Телефон:</td>
		<td><input class="justField input_3" name="phone" type="text" value="{$phone}">
                </td>
            </tr>
         
     
		  	
           
        </tbody></table>
    
		{$form}
    	
    	<input id="submit" class="button_4" type="submit" value="Регистрация">

	
</table>	
</form>
