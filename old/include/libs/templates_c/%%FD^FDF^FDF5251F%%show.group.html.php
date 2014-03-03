<?php /* Smarty version 2.6.16, created on 2013-04-04 11:21:22
         compiled from ru/modules/news/index/show.group.html */ ?>
<?php if ($this->_tpl_vars['news']): ?>
	<?php $_from = $this->_tpl_vars['news']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
		<div class="new-tover-cont">
			<div class="date"><?php echo $this->_tpl_vars['item']['date']; ?>
</div>
			<p><a href="/<?php echo $this->_tpl_vars['grpUri']; ?>
/<?php echo $this->_tpl_vars['item']['uri']; ?>
/"><?php echo $this->_tpl_vars['item']['title']; ?>
</a></p>
			<?php echo $this->_tpl_vars['item']['smallText']; ?>

		</div>
	<?php endforeach; endif; unset($_from);  endif; ?>

<?php if ($this->_tpl_vars['empty']): ?>
	<p>В выбранной группе нет новостей.</p>
<?php endif; ?>