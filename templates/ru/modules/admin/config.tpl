<div id="info">
	<ul class="breadcrumb">
		<li><a href="#">Настройка модуля "{$moduleName}"</a></li>
	</ul>
</div>
<form action="/admin/{$module}/config.php" method="post">
{foreach from=$confArray key=key item=item}
    {if $item.type == 'select'}
        <div class="row">
            <div class="span12">
                <div class="control-group">
                    <label class="control-label" for="{$item.name}">{$item.description }:</label>
                    <div class="controls">
                        <select name="{$key}" class="span5" id="{$item.name}">
                            {foreach from=$item.options key=optKey item=optItem}
                                <option value="{$optItem}" {if $optItem == $item.value} selected {/if}>{$optItem}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
            </div>
        </div>
    {/if}

    {if $item.type == 'text'}
        <div class="row">
            <div class="span12">
                <div class="control-group">
                    <label class="control-label" for="{$item.name}">{$item.description }:</label>
                    <div class="controls">
                        <input type="text" value="{$item.value}" name="{$key}" id="{$item.name}" class="span12"/>
                    </div>
                </div>
            </div>
        </div>
    {/if}
{/foreach}
<input type="hidden" name="go" value = "go">
<button class="btn btn-primary" type="submit" id="submit">Сохранить</button>
</form>