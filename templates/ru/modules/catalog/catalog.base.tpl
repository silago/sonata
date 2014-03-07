{extends template=ru/base.tpl}
    {block name=content}
	<div class="container-content">
				<div class="aside">
					<div class="nav-menu">
                        {show_menu menuid=5}
					</div>

                        {show_banner section=catalogmenu}
                        {show_sale}
				</div>

				<div class="content">
                    
                    <div class="nav">
				    {foreach from=$b_array item=item}
                        <a href="/{$item.uri}">{$item.title}</a>
                    {/foreach}

                    <!--
                        <a href="#">Главная</a>
						<a href="#">Каталог</a>
						<a href="#">Видеонаблюдение</a>
						<a href="#">Видео регистраторы</a>	
					-->
                    </div>
                    {$content}
								</div>	
			</div>	


    {/block}
{/extends}
