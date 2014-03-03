<?php /* Smarty version 2.6.16, created on 2013-10-30 14:18:28
         compiled from ru/modules/news/admin/show.groups.item.html */ ?>
<?php $_from = $this->_tpl_vars['tree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
<tr id="node-<?php echo $this->_tpl_vars['item']['id']; ?>
" class="child-of-node-<?php echo $this->_tpl_vars['item']['parent']; ?>
">
    <td valign="middle"><a class="text" rel="tooltip" data-original-title="Редактировать группу" href="/admin/news/editGroup.php?id=<?php echo $this->_tpl_vars['item']['id']; ?>
&ownerId=<?php echo $this->_tpl_vars['item']['parent']; ?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</a></td>
    <td style="text-align:center">
        <div class="btn-group" style="padding-left:12px;">
            <a class="btn btn-primary" rel="tooltip" data-original-title="Редактировать группу" href="/admin/news/editGroup.php?id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><i class="icon-pencil icon-white"></i></a>
            <a class="btn btn-primary" rel="tooltip" data-original-title="Добавить подгруппу" href="/admin/news/addGroup.php?ownerId=<?php echo $this->_tpl_vars['item']['id']; ?>
"><i class="icon-plus icon-white"></i></a>
            <a class="btn btn-danger" onclick="return confirm('Удалить группу?');" rel="tooltip" data-original-title="Удалить группу" href="/admin/news/deleteGroup.php?id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><i class="icon-trash icon-white"></i></a>
        </div>
    </td>
</tr>
<?php endforeach; endif; unset($_from); ?>