<?php /* Smarty version 2.6.16, created on 2014-03-12 22:33:37
         compiled from ru/main.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'extends', 'ru/main.tpl', 2, false),array('block', 'block', 'ru/main.tpl', 3, false),array('function', 'show_groups', 'ru/main.tpl', 6, false),array('function', 'show_banner', 'ru/main.tpl', 7, false),array('function', 'show_serv', 'ru/main.tpl', 9, false),)), $this); ?>

<?php $this->_tag_stack[] = array('extends', array('template' => "ru/base.tpl")); $_block_repeat=true;smarty_block_extends($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php $this->_tag_stack[] = array('block', array('name' => 'content')); $_block_repeat=true;smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <div class="service-box">
        <h2> Товары </h2>
        <?php echo smarty_function_show_groups(array(), $this);?>

        <?php echo smarty_function_show_banner(array('section' => 'maingoods'), $this);?>

        <h2> Услуги </h2>
        <?php echo smarty_function_show_serv(array(), $this);?>

        <?php echo smarty_function_show_banner(array('section' => 'mainservice'), $this);?>
   

    </div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_block($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack);  $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_extends($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>