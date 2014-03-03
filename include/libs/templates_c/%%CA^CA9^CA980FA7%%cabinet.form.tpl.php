<?php /* Smarty version 2.6.16, created on 2013-10-22 17:10:38
         compiled from ru/modules/security/index/cabinet.form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'ru/modules/security/index/cabinet.form.tpl', 43, false),)), $this); ?>
﻿<?php echo '
	<script>
		function changeType(id){
			$(\'tbody#fizform\').hide();$(\'tbody#orgform\').hide();var type = $(\'select#\'+id+\'>option:selected\').val();
			switch (type){case \'1\':$(\'tbody#fizform\').show();break; case \'2\': $(\'tbody#orgform\').show(); break;}			
			return false;
		}
		
		function changePass(){
			if($(\'tbody#passchange\').css(\'display\') == \'none\'){
				$(\'tbody#passchange\').css(\'display\', \'table-row-group\'); $(\'input#passchange\').val(1);
			}else{
				$(\'tbody#passchange\').css(\'display\', \'none\'); $(\'input#passchange\').val(0);
			}
			return false;
		}
	</script>
	
	<style>
	.tabContent table tr td {vertical-align:top; padding:10px;}
	
	</style>
'; ?>


<?php if ($this->_tpl_vars['error']): ?>
    <div class="alert alert-error">
    <?php $_from = $this->_tpl_vars['error']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
          <?php echo $this->_tpl_vars['item']; ?>

    <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>


<form  class="tabContent" action="/savedata/" method="post">
<table align="">
    <tr>
		<td align="">Ваш E-mail:</td>
		<td>       
			<?php echo $this->_tpl_vars['email']; ?>
</td>
	</tr>
	<tr>
		<td align="">Дата регистрации:</td>
		<td>       <?php echo ((is_array($_tmp=$this->_tpl_vars['reg_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M:%S %d.%m.%Y") : smarty_modifier_date_format($_tmp, "%H:%M:%S %d.%m.%Y")); ?>
 </td>
	</tr>
	<tr>
		<td colspan="2" align="a">
            <input style="padding-bottom:0px;" type="button" class="button_4" style="text-align: center;" id="submit" onclick="return changePass();" value="Пароль">
			<input type="hidden" name="passchange" id="passchange" value="<?php echo $this->_tpl_vars['passchange']; ?>
">
		</td>
	</tr>
	<tbody id="passchange" <?php if (! ( $this->_tpl_vars['passchange'] )): ?>style="display:none"<?php endif; ?>>
	<tr>
        <td align=""><font color="#F20006">*</font> Старый пароль:</td>
        <td><input class="justField input_3" type="password" value="" style="display:none">
            <input class="justField input_3" name="oldpass" type="password" value=""><font color="#F20006"></font>
        </td>
    </tr>
	<tr>
        <td align=""><font color="#F20006">*</font> Новый пароль:</td>
        <td><input class="justField input_3" type="password" value="" style="display:none">
            <input class="justField input_3" name="newpass" type="password" value=""><font color="#F20006"></font>
        </td>
    </tr>
	<tr>
        <td align=""><font color="#F20006">*</font> Подтверждение<br/> нового пароля:</td>
        <td><input class="justField input_3" type="password" value="" style="display:none">
            <input class="justField input_3" name="newpassconfirm" type="password" value=""><font color="#F20006"></font>
        </td>
    </tr>
	</tbody>
	<tr>
		<td align="">Фамилия:</td>
		<td><input class="justField input_3" name="surname" type="text" value="<?php echo $this->_tpl_vars['surname']; ?>
"></td>
	</tr>
	<tr>
		<td align=""><font color="#F20006">*</font> Имя:</td>
		<td><input class="justField input_3" name="name" type="text" value="<?php echo $this->_tpl_vars['name']; ?>
"></td>
	</tr>	
	<tr>
		<td align=""> Отчество:</td>
		<td><input class="justField input_3" name="patronymic" type="text" value="<?php echo $this->_tpl_vars['patronymic']; ?>
"></td>
	</tr>
	
	
	
	<tr>
		<td align=""><font color="#F20006">*</font> Телефон:</td>
		<td><input class="justField input_3" name="phone" type="text" value="<?php echo $this->_tpl_vars['phone']; ?>
"></td>
	</tr>
	
	
	<!--<tr>
        <td align=""><font color="#F20006">*</font> Тип пользователя</td>
        <td>
		<select name="org" id="org" onchange="return changeType('org');" style="width: 250px; margin-left: 10px;">
			<option value="0" <?php if ($this->_tpl_vars['org'] == 0): ?>selected<?php endif; ?>>Не установлено</option>
			<option value="1" <?php if ($this->_tpl_vars['org'] == 1): ?>selected<?php endif; ?>>Физичеcкое лицо</option>
			<option value="2" <?php if ($this->_tpl_vars['org'] == 2): ?>selected<?php endif; ?>>Юридическое лицо</option>
		</select>
    </tr> -->
    <input class="justField input_3" name="email" type="hidden" value="<?php echo $this->_tpl_vars['email']; ?>
">
    
    <tr>
		<td align=""><font color="#F20006">*</font> Адрес доставки:</td>
		<td><input class="justField input_3" name="addr" type="text" value="<?php echo $this->_tpl_vars['addr']; ?>
"></td>
	</tr>
	
	<tr>
		<td align=""> Номер скидочной карты:</td>
		<td><input class="justField input_3" name="discount" type="text" value="<?php echo $this->_tpl_vars['discount']; ?>
"></td>
	</tr>
	
	<input type="hidden" name="org" value="1">
	<?php echo $this->_tpl_vars['form']; ?>

	<?php echo $this->_tpl_vars['fizForm']; ?>

	<?php echo $this->_tpl_vars['orgForm']; ?>

	<tr>
    	<td align=""> </td>
    	<td>
			<input class="button_4" onclick="document.location='/orderslist/'" style="float:right; width:200px; margin-right:10px;" type="button" value="Список заказов" />
					
			<input class="submit button_4" type="submit" value="Изменить"></td>
	</tr>
</table>
<input class="button_4" type="hidden" name="go" value="go">
</form>