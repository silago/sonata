<tbody id="fizform">
{foreach from=$fields item=item key = key}
	{if $item.required == 1 && $item.value == ''}
		{if $item.type == 'text'}			
			<tr>
				<td class="key" align="center">{if $item.required == 1}<font color="#F20006">*</font>{/if} {$item.description}:</td>
				<td><input size="30" class="required" type="{$item.type}" name="{$item.name}" value="{$item.value|escape:html}" /></td>
			</tr>			
		{/if}		
	{/if}
	{if $item.type == 'description'}
			<tr>
				<td colspan="2" align="center">
					{$item.description}:
				</td>
			</tr>
	{/if}
	
	{if $item.type == 'select'}
			<tr>
			<td align="right">{if $item.required == 1}<font color="#F20006">*</font>{/if} {$item.description}:</td>
			<td>	
				<select name="{$item.name}">
				{foreach from=$item.options item=optItem key=otpKey}
					<option value="{$optItem}" {if $item.value == $optItem}selected{/if}>{$optItem}</option>
				{/foreach}	
				</select>
			</td>		
			</tr>
		{/if}
	
{/foreach}
</tbody>			

