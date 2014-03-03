<?php /* Smarty version 2.6.16, created on 2013-10-28 10:37:15
         compiled from ru/modules/catalog/admin/item.list.item.empty.html */ ?>
<tr>
	<td colspan="7" style="text-align:center">
		<strong>В выбранной группе нет товаров.</strong>
	</td>	
</tr>
<?php if (( ! empty ( $this->_tpl_vars['grpArr'] ) )): ?>
	<tr> 
		<td colspan="7" style="text-align:left;height:14px; ">
		
		</td>
	</tr>	
	<tr>
	<td colspan="7" style="text-align:left">
		<strong>Подгруппы</strong>
	</td>
	</tr>
	<?php $_from = $this->_tpl_vars['grpArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
<tr>
	<td colspan="7" style="text-align:left">
		<a href="#" onclick="return openGroup('?parent_group_id=<?php echo $this->_tpl_vars['item']['group_id']; ?>
');"><?php echo $this->_tpl_vars['item']['name']; ?>
 <span class="caret" style="margin-top: 7px;"></span></a>
	</td>	
</tr>		
	<?php endforeach; endif; unset($_from);  endif; ?>
