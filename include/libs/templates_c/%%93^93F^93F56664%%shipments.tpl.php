<?php /* Smarty version 2.6.16, created on 2013-10-23 14:28:59
         compiled from ru/modules/orders/index/shipments.tpl */ ?>

<div   class="leftRadio shipList">
<?php $_from = $this->_tpl_vars['shipments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
	<div  class="tm<?php echo $this->_tpl_vars['item']['id']; ?>
"  param=sm<?php echo $this->_tpl_vars['item']['id']; ?>
 class="lineRadio">
	<input type="radio" param=sm<?php echo $this->_tpl_vars['item']['id']; ?>
 class="styledRadio" name="sname" value="<?php echo $this->_tpl_vars['item']['id']; ?>
" id="radio_1" /><label class="radioLable" for="radio_1"><?php echo $this->_tpl_vars['item']['sname']; ?>
 <span><?php if ($this->_tpl_vars['item']['sprice']): ?> Стоимость доставки: <?php echo $this->_tpl_vars['item']['sprice']; ?>
 руб.<?php endif; ?> <?php if ($this->_tpl_vars['item']['stime']): ?>Время доставки: <?php echo $this->_tpl_vars['item']['stime']; ?>
 дня.<?php endif; ?></span></label>
	<div class="clear"></div>
	</div>

<?php endforeach; endif; unset($_from); ?>
</div>

<?php echo '
	
	<script>

	$(document).ready(
	function () {
			 
				$(\'.tm1\').children(\'span.radio\').click( function() { $(\'.sm\').hide(); $(\'.sm1\').show()});
				$(\'.tm2\').children(\'span.radio\').click( function() { $(\'.sm\').hide(); $(\'.sm2\').show()});
			 }
			 );
	</script>

'; ?>
