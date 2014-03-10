<?php /* Smarty version 2.6.16, created on 2014-03-10 06:14:00
         compiled from ru/modules/catalog/groups.items.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'ceil', 'ru/modules/catalog/groups.items.tpl', 34, false),)), $this); ?>
					<div class="product">
						<h2><?php echo $this->_tpl_vars['pageTitle']; ?>
</h2>	
						<?php if ($this->_tpl_vars['p']['total']/$this->_tpl_vars['p']['per_page']>1): ?>
						<div class="sorting-box">
							<ul>
                                <?php if ($this->_tpl_vars['p']['page'] < 3): ?>
<li <?php if ($this->_tpl_vars['pagination']['page'] == 1): ?> class="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['uri']; ?>
?page=1&per_page=<?php echo $this->_tpl_vars['p']['per_page']; ?>
&order_by=<?php echo $this->_tpl_vars['p']['order_by']; ?>
&order_dir=<?php echo $this->_tpl_vars['p']['order_dir']; ?>
">1</a></li>
<?php if ($this->_tpl_vars['p']['total']/$this->_tpl_vars['p']['per_page'] > 1): ?>
<li <?php if ($this->_tpl_vars['pagination']['page'] == 2): ?> class="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['uri']; ?>
?page=2&per_page=<?php echo $this->_tpl_vars['p']['per_page']; ?>
&order_by=<?php echo $this->_tpl_vars['p']['order_by']; ?>
&order_dir=<?php echo $this->_tpl_vars['p']['order_dir']; ?>
">2</a></li>
<?php endif;  if ($this->_tpl_vars['p']['total']/$this->_tpl_vars['p']['per_page'] > 2): ?>
<li <?php if ($this->_tpl_vars['pagination']['page'] == 3): ?> class="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['uri']; ?>
?page=3&per_page=<?php echo $this->_tpl_vars['p']['per_page']; ?>
&order_by=<?php echo $this->_tpl_vars['p']['order_by']; ?>
&order_dir=<?php echo $this->_tpl_vars['p']['order_dir']; ?>
">3</a></li>
<?php endif;  else: ?>

<li >               <a href="<?php echo $this->_tpl_vars['uri']; ?>
?page=<?php echo $this->_tpl_vars['p']['page']-1; ?>
&per_page=<?php echo $this->_tpl_vars['p']['per_page']; ?>
&order_by=<?php echo $this->_tpl_vars['p']['order_by']; ?>
&order_dir=<?php echo $this->_tpl_vars['p']['order_dir']; ?>
"><?php echo $this->_tpl_vars['p']['page']-1; ?>
</a></li>


<li class="active" ><a href="<?php echo $this->_tpl_vars['uri']; ?>
?page=<?php echo $this->_tpl_vars['p']['page']; ?>
&per_page=<?php echo $this->_tpl_vars['p']['per_page']; ?>
&order_by=<?php echo $this->_tpl_vars['p']['order_by']; ?>
&order_dir=<?php echo $this->_tpl_vars['p']['order_dir']; ?>
"><?php echo $this->_tpl_vars['p']['page']; ?>
</a></li>



<?php if ($this->_tpl_vars['p']['total']/$this->_tpl_vars['p']['per_page'] > $this->_tpl_vars['p']['page']): ?>
<li >               <a href="<?php echo $this->_tpl_vars['uri']; ?>
?page=<?php echo $this->_tpl_vars['p']['page']+1; ?>
&per_page=<?php echo $this->_tpl_vars['p']['per_page']; ?>
&order_by=<?php echo $this->_tpl_vars['p']['order_by']; ?>
&order_dir=<?php echo $this->_tpl_vars['p']['order_dir']; ?>
&order_dir=<?php echo $this->_tpl_vars['p']['order_dir']; ?>
"><?php echo $this->_tpl_vars['p']['page']+1; ?>
</a></li>
<?php endif; ?>


<?php endif; ?>


                                
                                <?php if ($this->_tpl_vars['p']['total']/$this->_tpl_vars['p']['per_page'] > 3): ?>
                                <li>...</li>
								<li><a href="/<?php echo $this->_tpl_vars['uri']; ?>
?page=<?php echo ((is_array($_tmp=$this->_tpl_vars['p']['total']/$this->_tpl_vars['p']['per_page'])) ? $this->_run_mod_handler('ceil', true, $_tmp) : ceil($_tmp)); ?>
&per_page=<?php echo $this->_tpl_vars['p']['per_page']; ?>
&order_by=<?php echo $this->_tpl_vars['p']['order_by']; ?>
&order_dir=<?php echo $this->_tpl_vars['p']['order_dir']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['p']['total']/$this->_tpl_vars['p']['per_page'])) ? $this->_run_mod_handler('ceil', true, $_tmp) : ceil($_tmp)); ?>
</a></li>
							    <?php endif; ?>
                            </ul>

							<p>Сортировать по: <a href="/<?php echo $this->_tpl_vars['uri']; ?>
?order_by=value&order_dir=<?php if ($this->_tpl_vars['p']['order_dir'] == ''): ?>DESC<?php endif; ?>">цене</a>
                            <a href="/<?php echo $this->_tpl_vars['uri']; ?>
?order_by=name&order_dir=<?php if ($this->_tpl_vars['p']['order_dir'] == ''): ?>DESC<?php endif; ?>">алфавиту</a></p>	

							<div class="views">
								<span>Показывать по:</span>	
								<select onchange="document.location='/<?php echo $this->_tpl_vars['uri']; ?>
?per_page='+<?php echo '$(this).val();'; ?>
 ">
								     <option value=10>10</option>
								     <option <?php if ($this->_tpl_vars['p']['per_page'] == 20): ?> selected=selected <?php endif; ?> value=20>20</option>
								     <option <?php if ($this->_tpl_vars['p']['per_page'] == 50): ?> selected=selected <?php endif; ?> value=50>50</option>
								     <option <?php if ($this->_tpl_vars['p']['per_page'] == 100): ?> selected=selected <?php endif; ?> value=100>100</option>
								     <option <?php if ($this->_tpl_vars['p']['per_page'] == 1000): ?> selected=selected <?php endif; ?> value=1000>Все</option>
								 </select>
							</div>
						</div>
                        <?php endif; ?>
                        <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?> 
						<div class="pr-box">
							<a href="/<?php echo $this->_tpl_vars['item']['uri']; ?>
">
                                <img src="<?php if ($this->_tpl_vars['item']['filename']): ?>/userfiles/catalog/1cbitrix/<?php echo $this->_tpl_vars['item']['filename'];  else: ?>/images/nophoto.png<?php endif; ?>" height="116" width="116" alt="" /></a>

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
,1); $(this).addClass('no-active').attr('disabled','disabled'); return false;" >В корзину</a>
                                </div>	
							</div>	
						</div>
                        <?php endforeach; endif; unset($_from); ?>
                    
                        
                        
                    	<?php if ($this->_tpl_vars['p']['total']/$this->_tpl_vars['p']['per_page']>1): ?>
						<div class="sorting-box">
							<ul>
                                <?php if ($this->_tpl_vars['p']['page'] < 3): ?>
<li <?php if ($this->_tpl_vars['pagination']['page'] == 1): ?> class="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['uri']; ?>
?page=1&per_page=<?php echo $this->_tpl_vars['p']['per_page']; ?>
&order_by=<?php echo $this->_tpl_vars['p']['order_by']; ?>
">1</a></li>
<?php if ($this->_tpl_vars['p']['total']/$this->_tpl_vars['p']['per_page'] > 1): ?>
<li <?php if ($this->_tpl_vars['pagination']['page'] == 2): ?> class="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['uri']; ?>
?page=2&per_page=<?php echo $this->_tpl_vars['p']['per_page']; ?>
&order_by=<?php echo $this->_tpl_vars['p']['order_by']; ?>
"">2</a></li>
<?php endif;  if ($this->_tpl_vars['p']['total']/$this->_tpl_vars['p']['per_page'] > 2): ?>
<li <?php if ($this->_tpl_vars['pagination']['page'] == 3): ?> class="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['uri']; ?>
?page=3&per_page=<?php echo $this->_tpl_vars['p']['per_page']; ?>
&order_by=<?php echo $this->_tpl_vars['p']['order_by']; ?>
"">3</a></li>
<?php endif;  else: ?>

<li >               <a href="<?php echo $this->_tpl_vars['uri']; ?>
?page=<?php echo $this->_tpl_vars['p']['page']-1; ?>
&per_page=<?php echo $this->_tpl_vars['p']['per_page']; ?>
&order_by=<?php echo $this->_tpl_vars['p']['order_by']; ?>
""><?php echo $this->_tpl_vars['p']['page']-1; ?>
</a></li>


<li class="active" ><a href="<?php echo $this->_tpl_vars['uri']; ?>
?page=<?php echo $this->_tpl_vars['p']['page']; ?>
&per_page=<?php echo $this->_tpl_vars['p']['per_page']; ?>
&order_by=<?php echo $this->_tpl_vars['p']['order_by']; ?>
""><?php echo $this->_tpl_vars['p']['page']; ?>
</a></li>



<?php if ($this->_tpl_vars['p']['total']/$this->_tpl_vars['p']['per_page'] > $this->_tpl_vars['p']['page']): ?>
<li >               <a href="<?php echo $this->_tpl_vars['uri']; ?>
?page=<?php echo $this->_tpl_vars['p']['page']+1; ?>
&per_page=<?php echo $this->_tpl_vars['p']['per_page']; ?>
&order_by=<?php echo $this->_tpl_vars['p']['order_by']; ?>
""><?php echo $this->_tpl_vars['p']['page']+1; ?>
</a></li>
<?php endif; ?>


<?php endif; ?>


                                
                                <?php if ($this->_tpl_vars['p']['total']/$this->_tpl_vars['p']['per_page'] > 3): ?>
                                <li>...</li>
								<li><a href="/<?php echo $this->_tpl_vars['uri']; ?>
?page=<?php echo ((is_array($_tmp=$this->_tpl_vars['p']['total']/$this->_tpl_vars['p']['per_page'])) ? $this->_run_mod_handler('ceil', true, $_tmp) : ceil($_tmp)); ?>
&per_page=<?php echo $this->_tpl_vars['p']['per_page']; ?>
&order_by=<?php echo $this->_tpl_vars['p']['order_by']; ?>
""><?php echo ((is_array($_tmp=$this->_tpl_vars['p']['total']/$this->_tpl_vars['p']['per_page'])) ? $this->_run_mod_handler('ceil', true, $_tmp) : ceil($_tmp)); ?>
</a></li>
							    <?php endif; ?>
                            </ul>

							<p>Сортировать по: <a href="/<?php echo $this->_tpl_vars['uri']; ?>
?order_by=value">цене</a>
                            <a href="/<?php echo $this->_tpl_vars['uri']; ?>
?order_by=name">алфавиту</a></p>	

							<div class="views">
								<span>Показывать по:</span>	
								<select onchange="document.location='/<?php echo $this->_tpl_vars['uri']; ?>
?per_page='+<?php echo '$(this).val();'; ?>
 ">
								     <option value=10>10</option>
								     <option <?php if ($this->_tpl_vars['p']['per_page'] == 20): ?> selected=selected <?php endif; ?> value=20>20</option>
								     <option <?php if ($this->_tpl_vars['p']['per_page'] == 50): ?> selected=selected <?php endif; ?> value=50>50</option>
								     <option <?php if ($this->_tpl_vars['p']['per_page'] == 100): ?> selected=selected <?php endif; ?> value=100>100</option>
								     <option <?php if ($this->_tpl_vars['p']['per_page'] == 1000): ?> selected=selected <?php endif; ?> value=1000>Все</option>
								 </select>
							</div>
						</div>
                        <?php endif; ?>
                         
                    </div>