					<div class="product">
						<h2>4-ёх канальные</h2>	
						
						<div class="sorting-box">
							<ul>
								<li class="active"><a href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li>...</li>
								<li><a href="#">10</a></li>
							</ul>

							<p>Сортировать по: <a href="#">цене</a> <a href="#">алфавиту</a></p>	

							<div class="views">
								<span>Показывать по:</span>	
								<select>
								     <option>10</option>
								     <option>20</option>
								     <option>50</option>
								     <option>100</option>
								 </select>
							</div>
						</div>
                        {foreach from=$items item=item key=key} 
						<div class="pr-box">
							<a href="/{$item.uri}"><img src="/userfiles/catalog/1cbitrix/{$item.filename} " height="116" width="116" alt="" /></a>

							<div class="pr-info">
								<div class="pr-text">
									<a href="/{$item.uri}">{$item.name}</a>	
									<p>{$item.description} </p>
								</div>

								<div class="pr-summ">
                                    <p>Цена:</p>
									<span>{$item.value} руб.</span>	
									<a href="#" onclick="addToChart({$item.id},1); return false;" >В корзину</a>
                                </div>	
							</div>	
						</div>
                        {/foreach}
                    </div>
