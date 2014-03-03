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
	</script>
	
	<style>
		.orders_list {cursor:pointer;}
	</style>
{/literal}

<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление магазином</a><span class="divider">/</span></li>
        <li><a href="/admin/orders/showList.php">Заказы</a><span class="divider">/</span></li>
        <li class="active">Список заказов</li>
    </ul>
</div>

<div class="row">
	<div class="span3">
		<select id="status" class="span3" onchange = "return sort()">
			<option value=""  {if !$smarty.get.status}selected{/if}>Все заказы</option>
			<option value="0" {if $smarty.get.status == '0'}selected{/if}>В обработке</option>
			<option value="1" {if $smarty.get.status == '1'}selected{/if}>Ожидает оплаты</option>
			<option value="2" {if $smarty.get.status == '2'}selected{/if}>Оплачен</option>
			<option value="3" {if $smarty.get.status == '3'}selected{/if}>Доставка</option>
			<option value="4" {if $smarty.get.status == '4'}selected{/if}>Выполнен</option>
			<option value="5" {if $smarty.get.status == '5'}selected{/if}>Отменен</option>
		</select> 
	</div>	
</div>
<table class="table table-condensed table-striped table-bordered">
    <thead>
    <tr>
        <th style="text-align:center">Дата оформления</th>
        <th style="text-align:center">№ заказа</th>
		<th style="text-align:center">Ф.И.О клиента / Наименование организации</th>
		<th style="text-align:center">Статус заказа</th>
		<th style="text-align:center">Сумма заказа</th>
		<th style="text-align:center">Стоимость доставки</th>
		<th style="text-align:center">Изменить</th>
    </tr>
    </thead>
    <tbody>
    {if $array}
	{foreach from=$array item=item key=key}
    <tr class="orders_list" onclick="document.location='/admin/orders/viewOrder.php?id={$item.id}';">
        <td style="text-align:center">{$item.date|date_format:"%d.%m.%Y"}</td>
		<td style="text-align:center">{$item.id}</td>
		<td style="text-align:center">{$item.surname} {$item.name} {$item.patronymic}</td>
		<td style="text-align:center">{$item.statetext}</td>
		<td style="text-align:center">{$item.order_data.total} руб.</td>
		<td style="text-align:center">{$item.order_data.sprice} руб.</td>
        <td style="text-align:center" width="80px;">
            <div class="btn-group" style="padding-left:5px;">
                <a class="btn btn-primary" rel="tooltip" data-original-title="Редактировать заказ" href="/admin/orders/editOrder.php?id={$item.id}"><i class="icon-pencil icon-white"></i></a>
				<a class="btn btn-danger" onclick="return confirm('Отменить заказ?');" rel="tooltip" data-original-title="Отменить заказ" href="/admin/orders/deleteOrder.php?id={$item.id}"><i class="icon-trash icon-white"></i></a>
            </div>
          
        </td>
    </tr>
    {/foreach}
	{else}
	<tr>
		<td style="text-align:center" colspan="7">Нет заказов с текущим статусом</td>
	</tr>
	{/if}
    </tbody>
</table>
