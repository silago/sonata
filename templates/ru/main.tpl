
{extends template=ru/base.tpl}
    {block name=content}
    <div class="service-box">
        <h2> Товары </h2>
        {show_groups}
        {show_banner section=maingoods}
        <h2> Услуги </h2>
        {show_serv}
        {show_banner section=mainservice}   

    </div>
{/block}
{/extends}
