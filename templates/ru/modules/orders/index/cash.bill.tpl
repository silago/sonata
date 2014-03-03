<table style="font-size:12px;" width="570" style="border:0px;">


<tr>
	<td><u> ООО «НЕРПА»	</u></td>

</tr>

<tr>
	<td>	Адрес: 664003, г.Иркутск, ул Советская, 27-24  Тел/факс: 8( 3952)75-75-37, 20-44-19</td>
</tr>
</table>


<br>
<br>





<table cellspacing="0" border="0" cellpadding="3" width="570" style="font-size:12px;">
	<tbody>
		
		<tr>
			<td align="center" colspan="2"><strong><font size="3">СЧЕТ № {$billnum} от {$date|date_format:"%d.%m.%Y"}</strong></td>
		</tr>
		
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td width="10%">Плательщик:</td>
			<td align="left">{$surname} {$name} {$patronymic}</td>
		</tr>
		<tr>
			<td>Грузополучатель:</td>
			<td align="left">{$surname} {$name} {$patronymic}</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td colspan="2">
				<table style="font-size:12px;" cellspacing="0" border="1" cellpadding="2" width="100%">
					<tr>
							<td>№</td>
							<td>Наименование товара</td>
							<td>Еденица измерения</td>
							<td>Количество</td>
							<td>Цена</td>
							<td>Сумма</td>
					</tr>
					{foreach from=$orderData item=item key=key}
						{if is_int($key)}
						<tr>
							<td>{math equation="$key+1" }</td>
							<td>{$item.name}</td>
							<td>шт.</td>
							<td>{$item.quantity}</td>
							<td nowrap>{$item.price}</td>
							<td nowrap>{$item.total}</td>
						</tr>
						{/if}
					{/foreach}
					{if $sprice !='0.00'}
						<tr>
							<td></td>
							<td>Доставка {$sname}</td>
							<td>шт.</td>
							<td>1</td>
							<td>{$sprice}</td>
							<td>{$sprice}</td>
						</tr>
					{/if}
					{if $sprice !='0.00'}	
						<tr>
							<td colspan="4" align="right"><strong>Итого:</strong></td>
							<td colspan="2">{$cost}</td>
						</tr>
						<tr>
							<td colspan="4" align="right"><strong>Без налога НДС:</strong></td>
							<td colspan="2">-</td>
						</tr>
						<tr>
							<td colspan="4" align="right"><strong>Всего к оплате:</strong></td>
							<td colspan="2">{$cost}</td>
						</tr>
					{else}
						<tr>
							<td colspan="4" align="right"><strong>Итого:</strong></td>
							<td colspan="2">{$total}</td>
						</tr>
						<tr>
							<td colspan="4" align="right"><strong>Без налога НДС:</strong></td>
							<td colspan="2">-</td>
						</tr>
						<tr>
							<td colspan="4" align="right"><strong>Всего к оплате:</strong></td>
							<td colspan="2">{$total}</td>
						</tr>					
					{/if}
					
				</table>
			</td>
		<tr><td>&nbsp;</td></tr>
	</tbody>
</table>
<input id="button" type="button" value="Распечатать" onclick="window.print();">
