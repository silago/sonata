<?php /* Smarty version 2.6.16, created on 2013-04-03 11:36:28
         compiled from ru/modules/catalog/index/breadcrumbs.tpl */ ?>
<div class="breadcrumbs">
    <div class="warp">
        <a href="/catalog"> Каталог </a> »
        <?php $_from = $this->_tpl_vars['array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <a href="/<?php echo $this->_tpl_vars['item']['data']['url']; ?>
"><?php echo $this->_tpl_vars['item']['data']['title']; ?>
</a><?php if ($this->_tpl_vars['key'] != $this->_tpl_vars['count']): ?> »<?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </div><!-- warp -->
</div>