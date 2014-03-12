<?php /* Smarty version 2.6.16, created on 2014-03-12 22:47:59
         compiled from ru/modules/catalog/items.main.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'show_banner', 'ru/modules/catalog/items.main.tpl', 14, false),array('function', 'show_sale_2', 'ru/modules/catalog/items.main.tpl', 19, false),)), $this); ?>
<h2> Товары </h2>

<?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?>
    <div class="serv-block">
        <p>
            <a href="/<?php echo $this->_tpl_vars['i']['uri']; ?>
">
                <img src="<?php echo $this->_tpl_vars['i']['thumb']; ?>
" height="70" width="70" alt=""/>
            </a>
        </p>
        <a href="/<?php echo $this->_tpl_vars['i']['uri']; ?>
"><?php echo $this->_tpl_vars['i']['name']; ?>
</a>

    </div>
<?php endforeach; endif; unset($_from);  echo smarty_function_show_banner(array('section' => 'maingoods'), $this);?>


<div>
<h2>Распродажа товаров</h2>
	<div class="ms">
<?php echo smarty_function_show_sale_2(array(), $this);?>

</div>
</div>