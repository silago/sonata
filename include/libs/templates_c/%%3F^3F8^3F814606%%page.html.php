<?php /* Smarty version 2.6.16, created on 2014-03-03 17:45:50
         compiled from ru/page.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'extends', 'ru/page.html', 1, false),array('block', 'block', 'ru/page.html', 2, false),)), $this); ?>
<?php $this->_tag_stack[] = array('extends', array('template' => "ru/base.tpl")); $_block_repeat=true;smarty_block_extends($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php $this->_tag_stack[] = array('block', array('name' => 'content')); $_block_repeat=true;smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    	<div class="box-container">
				<h2><?php echo $this->_tpl_vars['pageTitle']; ?>
</h2>
					<div class="serv-container">
					<?php $_from = $this->_tpl_vars['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                    
                    <div class="sr-box">
							<table>
								<tr>
									<td><a href="/<?php echo $this->_tpl_vars['item']['uri']; ?>
.html"><img src="/userfiles/<?php echo $this->_tpl_vars['item']['image']; ?>
" height="85" width="73" alt="" /></a></td>
									<td>
										<a href="/<?php echo $this->_tpl_vars['item']['uri']; ?>
.html"><?php echo $this->_tpl_vars['item']['title']; ?>
</a>
									<p>
                                        <?php echo $this->_tpl_vars['item']['text']; ?>

                                    </p>
                                    
                                    
                                    </td>
								</tr>
							</table>	
						</div>
                   <?php endforeach; endif; unset($_from); ?> 
                    </div>
				<div class="banner-box">
							<a href="#"><img src="images/banner.png" height="120" width="314" alt="" /></a>
							<a href="#"><img src="images/calc-img.png" height="120" width="315" alt="" /></a>
							<a href="#"><img src="images/garant-img.png" height="120" width="150" alt="" /></a>	
							<a href="#"><img src="images/zm-img.png" height="120" width="151" alt="" /></a>
				</div>
			</div>	

    
    
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_extends($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
