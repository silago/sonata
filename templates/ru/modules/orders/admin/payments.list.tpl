<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление магазином</a><span class="divider">/</span></li>
        <li><a href="/admin/orders/showList.php">Заказы</a><span class="divider">/</span></li>
        <li class="active">Список способов оплаты</li>
    </ul>
</div>
<table class="table table-condensed table-striped table-bordered">
    <thead>
    <tr>
        <th style="text-align:center">Название способа оплаты</th>        
    </tr>
    </thead>
    <tbody>
    {foreach from=$array item=item key=key}
    <tr>
        <td style="text-align:left">{$item.name}</td>        
    </tr>
    {/foreach}
    </tbody>
</table>