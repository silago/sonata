			
			
				<div class="headerTop">
                    <!--<a href="#" class="consult">он-лайн консультант</a>-->
                    {if $authed == 'false'}
                    <div class="boxLogin"><span>Личный кабинет: </span>&nbsp;&nbsp; <a href="/logingo/">Вход</a> <!--<span>|</span> <a href="/register/">Регистрация</a> --></div>
                    
                    {else}
                     <div class="boxLogin">Здравствуйте; <a href="/cabinet">{$userName}</a> &nbsp;&nbsp; <a href="/logout/">Выход</a></div>
			

                    {/if}
                    	<!--	<a onclick="addToChart(139);" href="#"> addToChart(139);</a> -->
                    <div class="clear"></div>
                </div>


