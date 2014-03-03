<?php /* Smarty version 2.6.16, created on 2013-04-03 11:36:15
         compiled from ru/modules/page/admin/list.pages.body.html */ ?>
<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление сайтом</a><span class="divider">/</span></li>
        <li class="active"><a>Страницы</a></li>
    </ul>
</div>
<a class="btn btn-success" href="/admin/page/add.php"><i class="icon-plus icon-white"></i> Добавить новую страницу</a>
<br /><br />
<form method="post"  action="/admin/catalog/grpposchange.php" id="grplist">
    <div class="well" style="padding:0px;">
        <table border="0" id="tree" cellpadding="4" cellspacing="0" width="100%" class="table" style="margin-bottom:0px;">
            <tr id="node-0" style="background-color:#ffffff;">
                <td style="padding-left:27px;background-color:#ffffff;min-width:300px;font-weight:bold;">Страницы</td>
                <td style="font-weight:bold;text-align:center" width="165px;">Действия</td>
                <td style="font-weight:bold;text-align:center" width="100px;">Позиция</td>
            </tr>
             <?php echo $this->_tpl_vars['body']; ?>

        </table>
    </div>
</form>
