<tbody id="orgform" {if $org !=2}style="display:none;"{/if}>
	{foreach from=$orgFields item=item key = key}
		{if $item.required == 1 && $item.value == ''}
			{if $item.type == 'text'}
				<tr>
					<td class="key">{if $item.required == 1}<font color="#F20006">*</font>{/if} {$item.description}:</td>
					<td><input size="30" class="required" type="{$item.type}" name="{$item.name}" value="{$item.value|escape:html}" /></td>
				</tr>				
			{/if}
		{/if}
	{/foreach}
</tbody>
