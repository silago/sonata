<form action="editGo.php?id={$smarty.get.id}" method="POST">

<table width="100%" border="0" cellpadding="4" cellspacing="0" class="inputTable">
    <tr><th  colspan="2"><strong>Редактирование отзыва</strong></th></tr>

	<tr>
		<td align="right" width="30%">
		  	<b>Статус:</b>
	  	</td>
	  	<td align="left" valign="middle">
	  		<select name="approved">
	  			<option value="y">Разрешен к показу</option>
	  			<option value="b">Заблокирован к показу</option>
	  		</select>
		</td>
	 </tr>

	<tr>
		<td align="right" width="30%">
	  		<b>ФИО:</b>
	  	</td>
		<td align="left" valign="middle">
			<input type="text" name="fio" value="{$values.fio|escape}" style="width: 90%;">
	  	</td>
	</tr>

	<tr>
		<td align="right" width="30%">
	  		Организация:
	  	</td>
	  	<td align="left" valign="middle">
	  		<input type="text" name="org" value="{$values.org|escape}" style="width: 90%;">
	  	</td>
	 </tr>

	<tr>
		<td colspan="2">
	  		<b>Текст</b>
	  	</td>
	</tr>

	<tr>
		<td colspan="2">
	  		<textarea name="opinionText" style="width: 90%; height: 150px;">{$values.opinionText|escape}</textarea>
	  	</td>
	</tr>
</table>
<center><input type="submit" value="Сохранить информацию"></center>

</form>