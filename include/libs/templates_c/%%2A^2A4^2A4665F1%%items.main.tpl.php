<?php /* Smarty version 2.6.16, created on 2014-03-07 15:43:55
         compiled from ru/modules/catalog/items.main.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'show_banner', 'ru/modules/catalog/items.main.tpl', 13, false),)), $this); ?>
<h2> Товары </h2>

<?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?>
    <div class="serv-block">
        <p>
            <img src="<?php echo $this->_tpl_vars['i']['thumb']; ?>
" height="70" width="70" alt=""/>
        </p>
        <a href="/<?php echo $this->_tpl_vars['i']['uri']; ?>
"><?php echo $this->_tpl_vars['i']['name']; ?>
</a>

    </div>
<?php endforeach; endif; unset($_from); ?>

<?php echo smarty_function_show_banner(array('section' => 'maingoods'), $this);?>
