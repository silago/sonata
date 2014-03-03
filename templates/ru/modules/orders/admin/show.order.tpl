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
        <li class="active">Просмотр заказа № {$id}</li>
    </ul>
</div>

{if $error}
<div class="alert alert-error">              
	{foreach from=$error item=item key=key}
		{$item}<br/>
	{/foreach}
</div>
{/if}

<div><span> Заказ № {$id} </span> <span> {$date|date_format:"%d.%m.%Y"} </span> </div>
<br>
<br>
<div id="order-data">
	<div id="order-info"></div>
	{$orderData}
</div>
<br>

{ if $datadata.discountType }
Скидка: {$datadata.discountType}. Код: {$datadata.discountValue}
{/if}
<br>
{ if $datadata.comment }
Комментарий к заказу: {$datadata.comment}.
{/if}
<br>
<br>
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
		
		{if $datadata.ddate.name }
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
			<td> {$datadata.town2} </td>
		</tr>
		{/if}
		
		{if $datadata.ddate2 }
		<tr> 
			<td> Дата:</td>
			<td> {$datadata.ddate2} </td>
		</tr>
		{/if}
		
		
		
		<tr> 
			<td> Тип оплаты:</td>
			<td> {foreach from=$payments item=item key=key}{if $item.title == $payment_id} {$item.name} {/if} {/foreach} </td>
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
		</table>
	</div>
</div>


