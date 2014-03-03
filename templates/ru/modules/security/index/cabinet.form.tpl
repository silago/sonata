{literal}
	<script>
		function changeType(id){
			$('tbody#fizform').hide();$('tbody#orgform').hide();var type = $('select#'+id+'>option:selected').val();
			switch (type){case '1':$('tbody#fizform').show();break; case '2': $('tbody#orgform').show(); break;}			
			return false;
		}
		
		function changePass(){
			if($('tbody#passchange').css('display') == 'none'){
				$('tbody#passchange').css('display', 'table-row-group'); $('input#passchange').val(1);
			}else{
				$('tbody#passchange').css('display', 'none'); $('input#passchange').val(0);
			}
			return false;
		}
	</script>
	
	<style>
	.tabContent table tr td {vertical-align:top; padding:10px;}
	
	</style>
{/literal}

{if $error}
    <div class="alert alert-error">
    {foreach from=$error item=item key=key}
          {$item}
    {/foreach}
    </div>
{/if}


<form  class="tabContent" action="/savedata/" method="post">
<table align="">
    <tr>
		<td align="">Ваш E-mail:</td>
		<td>       
			{$email}</td>
	</tr>
	<tr>
		<td align="">Дата регистрации:</td>
		<td>       {$reg_date|date_format:"%H:%M:%S %d.%m.%Y"} </td>
	</tr>
	<tr>
		<td colspan="2" align="a">
            <input style="padding-bottom:0px;" type="button" class="button_4" style="text-align: center;" id="submit" onclick="return changePass();" value="Пароль">
			<input type="hidden" name="passchange" id="passchange" value="{$passchange}">
		</td>
	</tr>
	<tbody id="passchange" {if !($passchange)}style="display:none"{/if}>
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
		<td><input class="justField input_3" name="surname" type="text" value="{$surname}"></td>
	</tr>
	<tr>
		<td align=""><font color="#F20006">*</font> Имя:</td>
		<td><input class="justField input_3" name="name" type="text" value="{$name}"></td>
	</tr>	
	<tr>
		<td align=""> Отчество:</td>
		<td><input class="justField input_3" name="patronymic" type="text" value="{$patronymic}"></td>
	</tr>
	
	
	
	<tr>
		<td align=""><font color="#F20006">*</font> Телефон:</td>
		<td><input class="justField input_3" name="phone" type="text" value="{$phone}"></td>
	</tr>
	
	
	<!--<tr>
        <td align=""><font color="#F20006">*</font> Тип пользователя</td>
        <td>
		<select name="org" id="org" onchange="return changeType('org');" style="width: 250px; margin-left: 10px;">
			<option value="0" {if $org==0}selected{/if}>Не установлено</option>
			<option value="1" {if $org==1}selected{/if}>Физичеcкое лицо</option>
			<option value="2" {if $org==2}selected{/if}>Юридическое лицо</option>
		</select>
    </tr> -->
    <input class="justField input_3" name="email" type="hidden" value="{$email}">
    
    <tr>
		<td align=""><font color="#F20006">*</font> Адрес доставки:</td>
		<td><input class="justField input_3" name="addr" type="text" value="{$addr}"></td>
	</tr>
	
	<tr>
		<td align=""> Номер скидочной карты:</td>
		<td><input class="justField input_3" name="discount" type="text" value="{$discount}"></td>
	</tr>
	
	<input type="hidden" name="org" value="1">
	{$form}
	{$fizForm}
	{$orgForm}
	<tr>
    	<td align=""> </td>
    	<td>
			<input class="button_4" onclick="document.location='/orderslist/'" style="float:right; width:200px; margin-right:10px;" type="button" value="Список заказов" />
					
			<input class="submit button_4" type="submit" value="Изменить"></td>
	</tr>
</table>
<input class="button_4" type="hidden" name="go" value="go">
</form>
