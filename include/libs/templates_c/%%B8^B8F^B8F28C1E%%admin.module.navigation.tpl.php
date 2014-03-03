<?php /* Smarty version 2.6.16, created on 2013-08-07 12:47:40
         compiled from ru/modules/admin/admin.module.navigation.tpl */ ?>
<script>
	$("a[href $= 'listItems.php']").parent().parent().append('<li><a href="/admin/tags/">Бренды</a></li>');
</script>

<div class="subnav">
<ul class="nav nav-pills">
<?php $_from = $this->_tpl_vars['navigation']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>

    <?php if ($this->_tpl_vars['item']['type'] == 'config'): ?>
        <li class="pull-right"><a href="<?php echo $this->_tpl_vars['item']['url']; ?>
"><i class="<?php echo $this->_tpl_vars['item']['icon']; ?>
"></i> <?php echo $this->_tpl_vars['item']['actionName']; ?>
</a></li>
    <?php else: ?>
        <li><a href="<?php echo $this->_tpl_vars['item']['url']; ?>
"><?php echo $this->_tpl_vars['item']['actionName']; ?>
</a></li>
    <?php endif;  endforeach; endif; unset($_from); ?>
</ul>
</div>