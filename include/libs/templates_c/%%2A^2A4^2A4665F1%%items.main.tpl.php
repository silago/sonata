<?php /* Smarty version 2.6.16, created on 2014-03-03 15:59:01
         compiled from ru/modules/catalog/items.main.tpl */ ?>
<h2> Товары </h2>

<?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?>
    <div class="serv-block">
        <p>
            <img src="/<?php echo $this->_tpl_vars['i']['thumb']; ?>
" height="70" width="70" alt=""/>
        </p>
        <a href="/<?php echo $this->_tpl_vars['i']['uri']; ?>
"><?php echo $this->_tpl_vars['i']['name']; ?>
</a>

    </div>
<?php endforeach; endif; unset($_from); ?>