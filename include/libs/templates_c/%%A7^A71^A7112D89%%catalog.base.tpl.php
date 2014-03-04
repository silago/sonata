<?php /* Smarty version 2.6.16, created on 2014-03-04 11:34:28
         compiled from ru//modules/catalog/catalog.base.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'extends', 'ru//modules/catalog/catalog.base.tpl', 1, false),array('block', 'block', 'ru//modules/catalog/catalog.base.tpl', 2, false),array('function', 'show_menu', 'ru//modules/catalog/catalog.base.tpl', 6, false),)), $this); ?>
<?php $this->_tag_stack[] = array('extends', array('template' => "ru/base.tpl")); $_block_repeat=true;smarty_block_extends($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php $this->_tag_stack[] = array('block', array('name' => 'content')); $_block_repeat=true;smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<div class="container-content">
				<div class="aside">
					<div class="nav-menu">
                        <?php echo smarty_function_show_menu(array('menuid' => 5), $this);?>

					</div>	
				</div>

				<div class="content">
					
                    <div class="nav">
                    <?php echo $this->_tpl_vars['navigation']; ?>
	
                    <!--
                        <a href="#">Главная</a>
						<a href="#">Каталог</a>
						<a href="#">Видеонаблюдение</a>
						<a href="#">Видео регистраторы</a>	
					-->
                    </div>
                    <?php echo $this->_tpl_vars['content']; ?>

								</div>	
			</div>	


    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_extends($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>