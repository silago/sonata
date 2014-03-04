<?php /* Smarty version 2.6.16, created on 2014-03-04 03:04:34
         compiled from ru/modules/news/index/show.group.html */ ?>
<div class="news-container">
<h2>Новости</h2>
<?php if ($this->_tpl_vars['news']): ?>
	<?php $_from = $this->_tpl_vars['news']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
		<div class="news-block">
			<span><?php echo $this->_tpl_vars['item']['date']; ?>
</span>
			<a href="/<?php echo $this->_tpl_vars['grpUri']; ?>
/<?php echo $this->_tpl_vars['item']['uri']; ?>
/"><?php echo $this->_tpl_vars['item']['title']; ?>
</a>
            <p><?php echo $this->_tpl_vars['item']['smallText']; ?>
</p>
		</div>
	<?php endforeach; endif; unset($_from);  endif; ?>

<?php if ($this->_tpl_vars['empty']): ?>
	<p>В выбранной группе нет новостей.</p>
<?php endif; ?>
</div>