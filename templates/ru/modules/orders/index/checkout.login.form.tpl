{literal}
<script type="text/javascript">
function loginandcheckout(elem){
    var form = jQuery(elem).serialize();
    jQuery.ajax({
        type: 'POST',
        url: '/loginandcheckout/',
        dataType: "json",
        data: {form:form},
        success: function(data){

            if(data.length > 0){
                jQuery('#error').addClass('alert-error').removeClass('alert-info');
                jQuery('#error').html('');
                for(i = 0; i<data.length; i++){
                    var html = jQuery('#error').html();
                    jQuery('#error').html(html + data[i] + '<br>');
                }
            }else{
                jQuery(elem).find('button[type="submit"]').attr('disabled', 'disabled');
				document.location.href='/checkout/';
            }
        }
    });
return false;
}
</script>
{/literal}
	<form action="" onsubmit="return loginandcheckout(this);">
        <fieldset>
            <table class="adminform user-details">
				
					<tr>
						<td class="key"><font color="#F20006">*</font> Email адрес:</td>
						<td><input size="30" name="email" type="text" value="{$email}"></td>
					</tr>
				
				
				
					<tr>
						<td class="key"><font color="#F20006">*</font> Пароль:</td>
						<td><input size="30" class="required" name="password" type="password" value="{$password}"></td>
					</tr>
				
				
				
			</table>
			<button class="button guest" type="submit" onclick="">Вход</button>
			</fieldset>
    </form>