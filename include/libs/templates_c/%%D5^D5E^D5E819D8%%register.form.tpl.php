<?php /* Smarty version 2.6.16, created on 2013-07-29 12:48:27
         compiled from ru/modules/security/index/register.form.tpl */ ?>
<div id="error" style="margin-left:15px;"></div>
<form  class="tabContent" id="register" action="#" method="post" onsubmit="return registergo('register');">

    <table class="form">
        <tbody>
            <tr>
                <td><span class="required">*</span> Ваш E-mail адрес:</td>
                <td><input class="q1" type="text" name="email" value="<?php echo $this->_tpl_vars['email']; ?>
">
                </td>
            </tr>
         
            <tr>
                <td><span class="required">*</span> Пароль:</td>
                <td><input class="justField input_3" name="pass" type="password" value="<?php echo $this->_tpl_vars['password']; ?>
">
                </td>
            </tr>
         
            <tr>
                <td><span class="required">*</span> Подтверждение пароля:</td>
        <td><input class="justField input_3" name="pass2" type="password" value="<?php echo $this->_tpl_vars['password2']; ?>
">
                </td>
            </tr>
         
            <tr>
                <td><span class="required">*</span> Фамилия:</td>
		<td><input class="justField input_3" name="surname" type="text" value="<?php echo $this->_tpl_vars['surname']; ?>
">
                </td>
            </tr>
         
            <tr>
                <td><span class="required">*</span> Имя:</td>
		<td><input class="justField input_3" name="name" type="text" value="<?php echo $this->_tpl_vars['name']; ?>
">
                </td>
            </tr>
         
            <tr>
                <td><span class="required">*</span> Отчество:</td>
		<td><input class="justField input_3" name="patronymic" type="text" value="<?php echo $this->_tpl_vars['patronymic']; ?>
">
                </td>
            </tr>
         
            <tr>
                <td><span class="required">*</span> Телефон:</td>
		<td><input class="justField input_3" name="phone" type="text" value="<?php echo $this->_tpl_vars['phone']; ?>
">
                </td>
            </tr>
         
     
		  	
           
        </tbody></table>
    
		<?php echo $this->_tpl_vars['form']; ?>

    	
    	<input id="submit" class="button_4" type="submit" value="Регистрация">

	
</table>	
</form>