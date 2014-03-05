<h2> Услуги </h2>

{foreach from=$items item=i}
    <div class="serv-block">
        <p>
            <img src="/userfiles/{$i.image}" height="70" width="70" alt=""/>
        </p>
        <a href="/{$i.uri}">{$i.title}</a>

    </div>
{/foreach}
{show_banner section=mainservice}
