{literal}
	<script>
	function sort(){
		var status = jQuery('select#status option:selected').val();		
		if(status.length > 0){
			document.location = '/admin/orders/showList.php?status='+status;			
		}else{
			document.location = '/admin/orders/showList.php';			
		}		
		return false;
	}
	
	function deleteItem(orderid, itemid){
		if(confirm('Удалить позицию?')){
			jQuery.ajax({
                type: 'POST',
                url: '/admin/orders/deleteItem.php',
				dataType: "json",                 
                data: {orderid:orderid, itemid:itemid},				
                success: function(data){					
					jQuery('div#order-data').html(data.content);
					jQuery('div#order-info').html(data.info);
					jQuery('div#order-info').addClass('alert').addClass('alert-success');					
                }
            });		
		}		
		return false;
	}
	
	</script>
{/literal}

<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление магазином</a><span class="divider">/</span></li>
        <li><a href="/admin/orders/showList.php">Заказы</a><span class="divider">/</span></li>
        <li class="active">Изменение заказа № {$id}</li>
    </ul>
</div>

{if $error}
<div class="alert alert-error">              
	{foreach from=$error item=item key=key}
		{$item}<br/>
	{/foreach}
</div>
{/if}

<form class="form-vertical" method="post" action="/admin/orders/editOrder.php?id={$id}">	
<div style="width:40%; vertical-align:top;  display:inline-block;" ><span> Заказ № {$id} </span> <span> {$date|date_format:"%d.%m.%Y"} </span> </div>
				<div style="width:300px;  display:inline-block;" >
				
				<div class="controls">
					<span style="width: 100px; 
display: inline-block;
float: left;"> 
		<label class="control-label" for="inputEmail">Статус заказа:</label></span>
					<select style="width: 200px;
float: right;" class="span6" name="state">
						<option value="0" {if $state == '0'}selected{/if}>В обработке</option>
						<option value="1" {if $state == '1'}selected{/if}>Ожидает оплаты</option>
						<option value="2" {if $state == '2'}selected{/if}>Оплачен</option>
						<option value="3" {if $state == '3'}selected{/if}>Доставка</option>
						<option value="4" {if $state == '4'}selected{/if}>Выполнен</option>
						<option value="5" {if $state == '5'}selected{/if}>Отменен</option>
					</select>	  
				</div>
			</div>

<br>

<div id="order-data">
	<div id="order-info"></div>
	{$orderData}
</div>





<div style="border:1px solid black; display:inline-block; margin-right:1%; width:44%; padding:2%;" class="">
<h2>Доставка</h2>

	<div>
		<table>
		<tr> 
			<td> Вид доставки:</td>
			<td> {foreach from=$shipments item=item key=key} {if $item.id == $shipment_id} {$item.sname} {/if} {/foreach}	</td>
		</tr>
		
		{if $datadata.addr }
		<tr> 
			<td> Адрес:</td>
			<td> {$datadata.addr} </td>
		</tr>
		{/if}
		
		{if $datadata.ddate }
		<tr> 
			<td> Дата:</td>
			<td> {$datadata.ddate} </td>
		</tr>
		{/if}
		
		{if $datadata.time1 }
		<tr> 
			<td> Время:</td>
			<td> {$datadata.time1} </td>
		</tr>
		{/if}
		
		{if $datadata.town2 }
		<tr> 
			<td> Адрес:</td>
			<td> 
					<select class="span6" name="tname" id="tname">
					{foreach from=$towns item=item key=key}
						<option value="{$item.id}" {if $item.id == $town_id}selected{/if}>{$item.tname}</option>
					{/foreach}
					</select>	 
				</td>
		</tr>
		{/if}
		
		{if $datadata.ddate2.name }
		<tr> 
			<td> Дата:</td>
			<td> {$datadata.ddate2.name} </td>
		</tr>
		{/if}
		
		
		
		<tr> 
			<td> Тип оплаты:</td>
			<td>
			<select class="span6" name="pname" id="pname">
					{foreach from=$payments item=item key=key}
						<option value="{$item.title}" {if $item.title == $payment_id}selected{/if}>{$item.name}</option>
					{/foreach}
					</select>	  	 
					</td>
		</tr>
			
		</table>		
					
	</div>		
</div>


<div style="border:1px solid black; display:inline-block; margin-left:1%; width:44%; padding:2%;" class="">
<h2>Данные покупателя</h2>
	<div>
		<table>
		<tr> 
			<td>ФИО: </td>
			<td>{$surname} {$name} {$patronymic} </td>
		</tr>
		
		<tr> 
			<td>Телефон: </td>
			<td>{$phone}</td>
		</tr>
		<tr> 
			<td>Email: </td>
			<td>{$email}</td>
		</tr>
		
			<tr> 
			<td></td>
			<td><a href="/admin/security/userEdit.php/{$user_id} "> Изменить данные   </a></td>
			
		</tr>
		
		</table>
	</div>
</div>


		<div>
		
  <br>
  <br>
<button type="submit" class="btn btn-primary">Сохранить</button>
</div>

	
		<div style="display:none;" class="span6">
			<div class="control-group">
				<label class="control-label" for="sname">Вид доставки:</label>
				<div class="controls">
					<select class="span6" name="sname" id="sname">
					{foreach from=$shipments item=item key=key}
						<option value="{$item.id}" {if $item.id == $shipment_id}selected{/if}>{$item.sname}</option>
					{/foreach}
					</select>		  
				</div>
			</div>
		</div>
	</div>
				
	</div>  
	
		
	

			
<input type="hidden" name="edit" value="go">	
  
  
  


							<div  style="display:none;"  class="row">
							<div class="span6">
							<div class="control-group">
							<label class="control-label" for="email">Email адрес клиента:</label>
							<div class="controls">
							<input type="text" name="email" id="email" value="{$email}" class="span6">
							</div>
							</div>
							</div>  




							<div  style="display:none;" class="row">
							<div class="span6">
							<div class="control-group">
							<label class="control-label" for="surname">Фамилия клиента:</label>
							<div class="controls">
							<input type="text" id="surname" name="surname" value="{$surname}" class="span6">
							</div>
							</div>
							</div>
							<div  style="display:none;"  class="span6">
							<div class="control-group">
							<label class="control-label" for="name">Имя клиента:</label>
							<div class="controls">
							<input type="text" id="name" name="name" value="{$name}" class="span6">
							</div>
							</div>
							</div>
							</div> 

							<div  style="display:none;"  class="row">
							<div class="span6">
							<div class="control-group">
							<label class="control-label" for="patronymic">Отчество клиента:</label>
							<div class="controls">
							<input type="text" id="patronymic" name="patronymic" value="{$patronymic}" class="span6">
							</div>
							</div>
							</div>
							</div>

							<div  style="display:none;"  class="row">
							<div  style="display:none;"  class="span6">
							<div class="control-group">
							<label class="control-label" for="tname">Город:</label>
							<div class="controls">
							<select class="span6" name="tname" id="tname">
							{foreach from=$towns item=item key=key}
							<option value="{$item.id}" {if $item.id == $town_id}selected{/if}>{$item.tname}</option>
							{/foreach}
							</select>	 
							</div>
							</div>
							</div>  
							<div  style="display:none;"  class="span6">
							<div class="control-group">
							<label class="control-label" for="sname">Вид доставки:</label>
							<div class="controls">
							<select class="span6" name="sname" id="sname">
							{foreach from=$shipments item=item key=key}
							<option value="{$item.id}" {if $item.id == $shipment_id}selected{/if}>{$item.sname}</option>
							{/foreach}
							</select>		  
							</div>
							</div>
							</div>
		
</form>



		
