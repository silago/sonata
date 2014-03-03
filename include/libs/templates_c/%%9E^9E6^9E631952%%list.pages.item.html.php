<?php /* Smarty version 2.6.16, created on 2013-07-17 13:59:33
         compiled from ru/modules/page/admin/list.pages.item.html */ ?>
<?php $_from = $this->_tpl_vars['pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
<tr id="node-<?php echo $this->_tpl_vars['item']['id']; ?>
" class="child-of-node-<?php echo $this->_tpl_vars['item']['parent']; ?>
">
    <td valign="middle"><a class="text" rel="tooltip" data-original-title="Редактировать страницу" href="/admin/page/edit.php?id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</a></td>
    <td style="text-align:center">
        <div class="btn-group" style="padding-left:12px;">
            <a class="btn btn-primary" rel="tooltip" data-original-title="Просмотр страницы" href="/<?php echo $this->_tpl_vars['item']['url']; ?>
/" target="_blank"><i class="icon-eye-open icon-white"></i></a>
			<a class="btn btn-primary" rel="tooltip" data-original-title="Редактировать страницу" href="/admin/page/edit.php?id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><i class="icon-pencil icon-white"></i></a>
            <a class="btn btn-primary" rel="tooltip" data-original-title="Добавить подстраницу" href="/admin/page/add.php?setOwnerId=<?php echo $this->_tpl_vars['item']['id']; ?>
"><i class="icon-plus icon-white"></i></a>
            <a class="btn btn-danger" onclick="return confirm('Удалить страницу?');" rel="tooltip" data-original-title="Удалить страницу" href="/admin/page/delete.php?id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><i class="icon-trash icon-white"></i></a>
        </div>
    </td>
    <td style="text-align:center">
        <input type="text" class="position span1 pagePosition" onchange='return pagePosChange("<?php echo $this->_tpl_vars['item']['id']; ?>
", "<?php echo $this->_tpl_vars['item']['parent']; ?>
");' id="pos<?php echo $this->_tpl_vars['item']['id']; ?>
" name="positions[<?php echo $this->_tpl_vars['item']['id']; ?>
]" value="<?php echo $this->_tpl_vars['item']['position']; ?>
" style="text-align:center" />
    </td>
</tr>
<?php endforeach; endif; unset($_from); ?>