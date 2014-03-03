{foreach from=$payments item=item key=key}
	<tr>
	<td align="right" style="padding-right:10px;">
		<input id="{$item.title}" type="radio" name="pname" value="{$item.title}" style="width:10px;">		 
	</td>
	<td>
		<label for="{$item.title}"><span>{$item.name}</span><br/>
		<span>{$item.comment}</span>
		</label>		
	</td>	
	</tr>	
{/foreach}