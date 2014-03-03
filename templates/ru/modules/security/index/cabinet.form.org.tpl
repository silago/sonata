<tbody id="orgform">
	{foreach from=$fields item=item key = key}
        {if $item.type == 'text'}
        <tr>
            <td align="right">{if $item.required == 1}<font color="#F20006">*</font>{/if} {$item.description}</td>
            <td><input class="justField" type="{$item.type}" name="{$item.name}" value="{$item.value|escape:html}" /></td>
        </tr>
        {/if}
    {/foreach}
</tbody>
