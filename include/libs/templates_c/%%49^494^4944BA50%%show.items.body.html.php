<?php /* Smarty version 2.6.16, created on 2014-03-04 02:55:08
         compiled from ru/modules/news/admin/show.items.body.html */ ?>
<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление сайтом</a><span class="divider">/</span></li>
        <li class="active"><a>Список новостей</a></li>
    </ul>
</div>

<div class="row">
	<div class="span3">
		<div class="well"> 
				<ul id="red" class="treeview"><?php echo $this->_tpl_vars['groupsTree']; ?>
</ul>
		</div>
	</div>
	<div class="span9">	
		<table border="0" cellpadding="4" cellspacing="0" width="100%" class="table table-condensed table-striped table-bordered" style="margin-bottom:0px;">
		<tr>
                <th style="font-weight:bold;text-align:center;vertical-align:middle;" width="125px;">Дата<br/>публикации</th>
				<th style="font-weight:bold;text-align:center;vertical-align:middle;">Название новости</th>                
				<th style="font-weight:bold;text-align:center;vertical-align:middle;" width="92px;">Действия</th>
		</tr>
		<?php echo $this->_tpl_vars['body']; ?>

		</table>
	</div>
</div>
