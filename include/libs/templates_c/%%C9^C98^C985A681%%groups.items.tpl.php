<?php /* Smarty version 2.6.16, created on 2014-02-27 17:17:32
         compiled from ru/modules/catalog/groups.items.tpl */ ?>
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
                        <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?> 
						<div class="pr-box">
							<a href="/<?php echo $this->_tpl_vars['item']['uri']; ?>
"><img src="/userfiles/catalog/1cbitrix/<?php echo $this->_tpl_vars['item']['filename']; ?>
 " height="116" width="116" alt="" /></a>

							<div class="pr-info">
								<div class="pr-text">
									<a href="/<?php echo $this->_tpl_vars['item']['uri']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</a>	
									<p><?php echo $this->_tpl_vars['item']['description']; ?>
 </p>
								</div>

								<div class="pr-summ">
                                    <p>Цена:</p>
									<span><?php echo $this->_tpl_vars['item']['value']; ?>
 руб.</span>	
									<a href="#" onclick="addToChart(<?php echo $this->_tpl_vars['item']['id']; ?>
,1); return false;" >В корзину</a>
                                </div>	
							</div>	
						</div>
                        <?php endforeach; endif; unset($_from); ?>
                    </div>