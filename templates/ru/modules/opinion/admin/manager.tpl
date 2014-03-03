<table width="100%" border="0" cellpadding="4" cellspacing="0" class="inputTable">
    <tr >
	  <th  colspan="2">
	    <strong>Управление отзывами</strong>	  </th>
	</tr>

	{foreach from="$opinions" item="item"}
	<tr>
	  <td align="left">
	  	<b>{$item.fio}</b> {if !empty($item.org)} ({$item.org}) {/if} / {$item.postedDate}<br>
		Статус:
				{if $item.approved == "y"}<font color="Green">одобрено</font>{/if}
				{if $item.approved == "n"}<font color="Red"><b>не проверено</b></font>{/if}
				{if $item.approved == "b"}<font color="Gray">заблокировано</font>{/if}
	  </td>
	  
	  <td align="center" valign="middle">
	  	<a href="edit.php?id={$item.id}">Управление</a><br> 
	  	<a href="delete.php?id={$item.id}">Удалить</a> 
	  </td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="2" align="center">Нет отзывов</td>
	</tr>
	{/foreach}
</table>