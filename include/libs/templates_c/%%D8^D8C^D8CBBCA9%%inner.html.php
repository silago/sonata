<?php /* Smarty version 2.6.16, created on 2014-03-03 17:32:20
         compiled from ru/inner.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'extends', 'ru/inner.html', 1, false),array('block', 'block', 'ru/inner.html', 2, false),array('function', 'show_menu', 'ru/inner.html', 7, false),)), $this); ?>
<?php $this->_tag_stack[] = array('extends', array('template' => "ru/base.tpl")); $_block_repeat=true;smarty_block_extends($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php $this->_tag_stack[] = array('block', array('name' => 'content')); $_block_repeat=true;smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
			<div class="container-content">
				<h2>Услуги</h2>
                    <div class="aside">
                        <div class="nav-aside">
                            <?php echo smarty_function_show_menu(array('menuid' => 6), $this);?>

                        </div>
                    
					<div class="aside-banner">
						<a href="#"><img src="/images/banner-one.png" height="120" width="295" alt="" /></a>	
						<a href="#"><img src="/images/banner-two.png" height="120" width="294" alt="" /></a>	
						<a href="#"><img src="/images/banner-three.png" height="120" width="294" alt="" /></a>
						<a href="#"><img src="/images/banner-four.png" height="120" width="294" alt="" /></a>
					</div>
					</div>

                    <div class="content">
                        <div class="serv-text">
                        <h3><?php echo $this->_tpl_vars['pageTitle']; ?>
</h3>
                        <p>
                            <?php echo $this->_tpl_vars['content']; ?>

                        </p>
                        </div>
                    </div>


			</div>	

    
    
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_extends($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
