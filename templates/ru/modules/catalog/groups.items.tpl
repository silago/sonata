					<div class="product">
						<h2>{$pageTitle}</h2>	
						{if $p.total/$p.per_page>1}
						<div class="sorting-box">
							<ul>
                                {if $p.page<3}
<li {if $pagination.page == 1} class="active"{/if}><a href="{$uri}?page=1&per_page={$p.per_page}&order_by={$p.order_by}">1</a></li>
{if $p.total/$p.per_page > 1}
<li {if $pagination.page == 2} class="active"{/if}><a href="{$uri}?page=2&per_page={$p.per_page}&order_by={$p.order_by}"">2</a></li>
{/if}
{if $p.total/$p.per_page > 2}
<li {if $pagination.page == 3} class="active"{/if}><a href="{$uri}?page=3&per_page={$p.per_page}&order_by={$p.order_by}"">3</a></li>
{/if}
{else}

<li >               <a href="{$uri}?page={$p.page-1}&per_page={$p.per_page}&order_by={$p.order_by}"">{$p.page-1}</a></li>


<li class="active" ><a href="{$uri}?page={$p.page}&per_page={$p.per_page}&order_by={$p.order_by}"">{$p.page}</a></li>



{if $p.total/$p.per_page > $p.page}
<li >               <a href="{$uri}?page={$p.page+1}&per_page={$p.per_page}&order_by={$p.order_by}"">{$p.page+1}</a></li>
{/if}


{/if}


                                
                                {if $p.total/$p.per_page > 3}
                                <li>...</li>
								<li><a href="/{$uri}?page={$p.total/$p.per_page|ceil}&per_page={$p.per_page}&order_by={$p.order_by}"">{$p.total/$p.per_page|ceil}</a></li>
							    {/if}
                            </ul>

							<p>Сортировать по: <a href="/{$uri}?order_by=value">цене</a>
                            <a href="/{$uri}?order_by=name">алфавиту</a></p>	

							<div class="views">
								<span>Показывать по:</span>	
								<select onchange="document.location='/{$uri}?per_page='+{literal}$(this).val();{/literal} ">
								     <option value=10>10</option>
								     <option {if $p.per_page == 20} selected=selected {/if} value=20>20</option>
								     <option {if $p.per_page == 50} selected=selected {/if} value=50>50</option>
								     <option {if $p.per_page == 100} selected=selected {/if} value=100>100</option>
								     <option {if $p.per_page == 1000} selected=selected {/if} value=1000>Все</option>
								 </select>
							</div>
						</div>
                        {/if}
                        {foreach from=$items item=item key=key} 
						<div class="pr-box">
							<a href="/{$item.uri}">
                                <img src="{if $item.filename}/userfiles/catalog/1cbitrix/{$item.filename}{else}/images/nophoto.png{/if}" height="116" width="116" alt="" /></a>

							<div class="pr-info">
								<div class="pr-text">
									<a href="/{$item.uri}">{$item.name}</a>	
									<p>{$item.description} </p>
								</div>

								<div class="pr-summ">
                                    <p>Цена:</p>
									<span>{$item.value} руб.</span>	
									<a href="#" onclick="addToChart({$item.id},1); $(this).addClass('no-active').attr('disabled','disabled'); return false;" >В корзину</a>
                                </div>	
							</div>	
						</div>
                        {/foreach}
                    
                        
                        
                    	{if $p.total/$p.per_page>1}
						<div class="sorting-box">
							<ul>
                                {if $p.page<3}
<li {if $pagination.page == 1} class="active"{/if}><a href="{$uri}?page=1&per_page={$p.per_page}&order_by={$p.order_by}">1</a></li>
{if $p.total/$p.per_page > 1}
<li {if $pagination.page == 2} class="active"{/if}><a href="{$uri}?page=2&per_page={$p.per_page}&order_by={$p.order_by}"">2</a></li>
{/if}
{if $p.total/$p.per_page > 2}
<li {if $pagination.page == 3} class="active"{/if}><a href="{$uri}?page=3&per_page={$p.per_page}&order_by={$p.order_by}"">3</a></li>
{/if}
{else}

<li >               <a href="{$uri}?page={$p.page-1}&per_page={$p.per_page}&order_by={$p.order_by}"">{$p.page-1}</a></li>


<li class="active" ><a href="{$uri}?page={$p.page}&per_page={$p.per_page}&order_by={$p.order_by}"">{$p.page}</a></li>



{if $p.total/$p.per_page > $p.page}
<li >               <a href="{$uri}?page={$p.page+1}&per_page={$p.per_page}&order_by={$p.order_by}"">{$p.page+1}</a></li>
{/if}


{/if}


                                
                                {if $p.total/$p.per_page > 3}
                                <li>...</li>
								<li><a href="/{$uri}?page={$p.total/$p.per_page|ceil}&per_page={$p.per_page}&order_by={$p.order_by}"">{$p.total/$p.per_page|ceil}</a></li>
							    {/if}
                            </ul>

							<p>Сортировать по: <a href="/{$uri}?order_by=value">цене</a>
                            <a href="/{$uri}?order_by=name">алфавиту</a></p>	

							<div class="views">
								<span>Показывать по:</span>	
								<select onchange="document.location='/{$uri}?per_page='+{literal}$(this).val();{/literal} ">
								     <option value=10>10</option>
								     <option {if $p.per_page == 20} selected=selected {/if} value=20>20</option>
								     <option {if $p.per_page == 50} selected=selected {/if} value=50>50</option>
								     <option {if $p.per_page == 100} selected=selected {/if} value=100>100</option>
								     <option {if $p.per_page == 1000} selected=selected {/if} value=1000>Все</option>
								 </select>
							</div>
						</div>
                        {/if}
                         
                    </div>
