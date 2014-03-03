<?php /* Smarty version 2.6.16, created on 2014-02-26 13:37:24
         compiled from ru/modules/catalog/admin/group.photo.form.html */ ?>
<li class="span2" style="text-align:center;position:relative;">
    <div onclick="if(confirm(\'Удалить фото?\')) $(this).parent().remove(); return false;" style="position:absolute;top:-10px; right:-10px;z-index:1000;">
        <img title="Удалить фото" src="/include/ext/bootstrap/img/x.png"></div>
    <a class="thumbnail"><img src="<?php echo $this->_tpl_vars['thumb']; ?>
" /></a>
</li>
<input type="hidden" value="<?php echo $this->_tpl_vars['thumb']; ?>
" name="thumb"/>
<input type="hidden" value="<?php echo $this->_tpl_vars['photo']; ?>
" name="photo"/>