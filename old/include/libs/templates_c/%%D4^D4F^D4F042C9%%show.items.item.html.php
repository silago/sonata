<?php /* Smarty version 2.6.16, created on 2013-04-04 10:38:24
         compiled from ru/modules/news/admin/show.items.item.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'ru/modules/news/admin/show.items.item.html', 3, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['news']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <tr>
        <td style="text-align:center"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</td>
        <td style="text-align:center"><?php echo $this->_tpl_vars['item']['title']; ?>
</td>
        <td style="text-align:center">
            <div class="btn-group" style="padding-left:12px;">
                <a class="btn btn-primary" rel="tooltip" data-original-title="Редактировать группу" href="/admin/news/edit.php?id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><i class="icon-pencil icon-white"></i></a>
                <a class="btn btn-danger" onclick="return confirm('Удалить новость?');" rel="tooltip" data-original-title="Удалить новость" href="/admin/news/delete.php?id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><i class="icon-trash icon-white"></i></a>
            </div>
        </td>
    </tr>
<?php endforeach; endif; unset($_from); ?>
