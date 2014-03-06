<?php /* Smarty version 2.6.16, created on 2014-03-06 13:30:20
         compiled from ru/index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'extends', 'ru/index.html', 1, false),array('block', 'block', 'ru/index.html', 2, false),)), $this); ?>
<?php $this->_tag_stack[] = array('extends', array('template' => "ru/base.tpl")); $_block_repeat=true;smarty_block_extends($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php $this->_tag_stack[] = array('block', array('name' => 'bottom')); $_block_repeat=true;smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
	<div class="wrap">
		<div class="about">
			<a href="#"><img src="/images/about-banner.png" height="120" width="372" alt="" /></a>
			<div class="about-info">
				<h2>О нас</h2>	
				<p>В наше время сложно  чем-то удивить. Много придумано и изобретено,  но человеческие отношения, сервис, отзывчивость и взаимопомощь всегда и во все времена востребованы в человеческом обществе.  Поэтому главной целью нашей компании  является создание благоприятных условий для долгосрочных.</p>
			</div>	
		</div>	
	</div>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_extends($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>