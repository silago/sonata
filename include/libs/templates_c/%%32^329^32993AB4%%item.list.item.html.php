<?php /* Smarty version 2.6.16, created on 2013-07-29 13:01:49
         compiled from ru/modules/catalog/admin/item.list.item.html */ ?>
<?php $_from = $this->_tpl_vars['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
<tr>
	<td>
		<span style="strong"><a href="/admin/catalog/editItem.php?id=<?php echo $this->_tpl_vars['item']['item_id']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</a></span>
		<br/>
		<span style="font-size:11px;color:#a0a0a0"><?php echo $this->_tpl_vars['item']['small_desc']; ?>
</span>
	</td>
	<td width="75px"><img src="<?php echo $this->_tpl_vars['item']['photo']; ?>
" height="75px;"></td>
	<td style="text-align:center"><?php echo $this->_tpl_vars['item']['price']; ?>
</td>
	<td style="text-align:center"><?php echo $this->_tpl_vars['item']['price_old']; ?>
</td>
	<td style="text-align:center">
        <input type="checkbox" name="itemnew" value="1" <?php if (( $this->_tpl_vars['item']['is_new'] ) == 1): ?>checked<?php endif; ?> />
        <input type="hidden" name="item_id" value="<?php echo $this->_tpl_vars['item']['item_id']; ?>
"/>

    </td>
	<td style="text-align:center">
        <input type="checkbox" name="itemhit" <?php if (( $this->_tpl_vars['item']['is_hit'] ) == 1): ?>checked<?php endif; ?> />
        <input type="hidden" name="item_id" value="<?php echo $this->_tpl_vars['item']['item_id']; ?>
"/>
    </td>
	<td style="text-align:center; width:75px;"> 
		<div class="btn-group" style="margin-left:2px;">   
			<a class="btn btn-primary" rel="tooltip" data-original-title="Редактировать товар" href="/admin/catalog/editItem.php?id=<?php echo $this->_tpl_vars['item']['item_id']; ?>
"><i class="icon-pencil icon-white"></i></a>
			<a class="btn btn-danger" rel="tooltip" data-original-title="Удалить товар" onclick="return confirm('Удалить товар?')" href="/admin/catalog/delete.php.php?id=<?php echo $this->_tpl_vars['item']['item_id']; ?>
"><i class="icon-trash icon-white"></i></a>
		</div>
	</td>  
</tr>
<?php endforeach; endif; unset($_from); ?>