<?php /* Smarty version 2.6.16, created on 2013-04-03 11:36:22
         compiled from ru/modules/admin/admin.shop.navigation.tpl */ ?>
<?php $_from = $this->_tpl_vars['array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <?php if ($this->_tpl_vars['item']['area'] == 'shop'): ?>
        <li><a href="<?php echo $this->_tpl_vars['item']['navigation']['1']['url']; ?>
"><?php echo $this->_tpl_vars['item']['moduleName']; ?>
</a></li>
    <?php endif;  endforeach; endif; unset($_from); ?>