
<div   class="leftRadio shipList">
{foreach from=$shipments item=item key=key}
	<div  class="tm{$item.id}"  param=sm{$item.id} class="lineRadio">
	<input type="radio" param=sm{$item.id} class="styledRadio" name="sname" value="{$item.id}" id="radio_1" /><label class="radioLable" for="radio_1">{$item.sname} <span>{if $item.sprice} Стоимость доставки: {$item.sprice} руб.{/if} {if $item.stime}Время доставки: {$item.stime} дня.{/if}</span></label>
	<div class="clear"></div>
	</div>

{/foreach}
</div>

{literal}
	
	<script>

	$(document).ready(
	function () {
			 
				$('.tm1').children('span.radio').click( function() { $('.sm').hide(); $('.sm1').show()});
				$('.tm2').children('span.radio').click( function() { $('.sm').hide(); $('.sm2').show()});
			 }
			 );
	</script>

{/literal}
