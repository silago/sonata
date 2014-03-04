<?php /* Smarty version 2.6.16, created on 2014-03-04 02:55:53
         compiled from ru/modules/news/index/breadcrumbs.html */ ?>
<div class="breadcrumb">
    <ul>
        <li><a href="/">Главная</a></li>
        <li>/</li>
        <?php $_from = $this->_tpl_vars['array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
            <li <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['count']): ?>class="active_trail"<?php endif; ?>>
                <a href="/<?php echo $this->_tpl_vars['item']['data']['url']; ?>
"><?php echo $this->_tpl_vars['item']['data']['title']; ?>
</a><?php if ($this->_tpl_vars['key'] != $this->_tpl_vars['count']): ?> /<?php endif; ?>
            </li>
        <?php endforeach; endif; unset($_from); ?>
    </ul>
</div>