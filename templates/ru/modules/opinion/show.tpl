{*
Шаблон отображения отзывов
*}

<table border="1">
	{foreach from="$opinions" item="opinionItem"}
	<tr>
		<td>
			{$opinionItem.postedDate|escape} / {$opinionItem.fio|escape} {if !empty($opinionItem.org)} ({$opinionItem.org|escape}){/if}<br>
			{$opinionItem.opinionText|escape|nl2br}
		</td>
	{/foreach}
	</tr>
</table>
<br>
Страницы: {$pages}

<a name="form"></a>
<form action="addGo.php#form" method="POST">
	<table border="1">
		<tr>
			<th colspan="2">Добавить отзыв</th>
		</tr>
		<tr>
			<td colspan="2" align="center"><font color="Red" style="font-weight: bolder;">{$error}</font></td>
		</tr>
		<tr>
			<td width="30%" align="right"><b>Ваше имя:</b></td>
			<td width="70%" align="left"><input type="text" name="fio" size="50" maxlength="100" value="{$smarty.post.fio|escape}"></td>
		</tr>

		<tr>
			<td width="30%" align="right">Организация:</td>
			<td width="70%" align="left"><input type="text" name="org" size="50" maxlength="100" value="{$smarty.post.org|escape}"></td>
		</tr>

		<tr>
			<td colspan="2" align="center"><b>Текст отзыва</b></td>
		</tr>

		<tr>
			<td colspan="2" align="center"><textarea name="opinionText" rows="10" cols="46">{$smarty.post.opinionText|escape}</textarea></td>
		</tr>
		
		<tr>
			<td colspan="2" align="center"><input type="submit" value="Отправить"></td>
		</tr>
		
	</table>
</form>

