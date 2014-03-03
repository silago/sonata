<?php /* Smarty version 2.6.16, created on 2013-07-29 13:01:49
         compiled from ru/modules/catalog/admin/pags.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'ru/modules/catalog/admin/pags.html', 9, false),)), $this); ?>
<center>

<?php if ($this->_tpl_vars['offset'] > 0): ?>
<a href="/admin/catalog/listItems.php?items=<?php echo $this->_tpl_vars['offset']-20;  if ($this->_tpl_vars['parent_group_id']): ?>&parent_group_id=<?php echo $this->_tpl_vars['parent_group_id'];  endif; ?>"><< Назад</a>
<?php endif; ?>
<span> &nbsp; &nbsp; </span>
<span> Страница: <?php echo $this->_tpl_vars['offset']/20+1; ?>
 </span>
<span> &nbsp; &nbsp; </span>
<?php if (count($this->_tpl_vars['items']) == 20): ?>
<a href="/admin/catalog/listItems.php?items=<?php echo $this->_tpl_vars['offset']+20;  if ($this->_tpl_vars['parent_group_id']): ?>&parent_group_id=<?php echo $this->_tpl_vars['parent_group_id'];  endif; ?>">Вперед >></a>

<?php endif; ?>

</center>
<br>
<br>
<br>