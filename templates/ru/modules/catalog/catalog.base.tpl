{extends template=ru/base.tpl}
    {block name=content}
	<div class="container-content">
				<div class="aside">
					<div class="nav-menu">
                        {show_menu menuid=5}
					</div>	
				</div>

				<div class="content">
					
                    <div class="nav">
                    {$navigation}	
                    {$c_navigation}	
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
