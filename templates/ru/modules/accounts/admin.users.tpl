<table border="0" cellpadding="4" cellspacing="0" width="100%" class="inputTable">	<tr>		<th colspan="5" align="center"><strong>Список пользователей</strong></th>	</tr>
	<tr>
		<td align="center"><u>ID</u></td>
		<td align="center"><u>Наименование</u></td>
		<td align="center"><u>Логин (E-Mail)</u></td>
		<td align="center"><u>Статус пользователя</u></td>
		<td align="center"><u>Опции</u></td>
	</tr>
	{foreach from=$users item=item}
	<tr>		<td align="center">{$item.id}</td>
		<td align="center">{$item.name}</td>
		<td align="center">{$item.email}</td>
		<td align="center"> </td>
		<td align="center"> </td>	</tr>
	{/foreach}
</table>