<h2> Товары </h2>

{foreach from=$items item=i}
    <div class="serv-block">
        <p>
            <img src="/{$i.thumb}" height="70" width="70" alt=""/>
        </p>
        <a href="/{$i.uri}">{$i.name}</a>

    </div>
{/foreach}

{show_banner section=maingoods}
