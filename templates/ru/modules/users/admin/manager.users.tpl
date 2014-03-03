{*
manager.users.tpl
*}
<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление сайтом</a><span class="divider">/</span></li>
        <li class="active"><a>Пользователи</a></li>
    </ul>
</div>

<table class="table table-bordered table-striped" cellpadding="1" cellspacing="3" width="100%">
	<tr>
	<th>Ф.И.О. / Логин / Права доступа</th>
	<th style="text-align:center">Действия</th>
	</tr>
	
	{foreach from="$users" item="item" key="key"}
	<tr>
		<td>
			<b>{$users.$key.fio}</b> (Login: {$users.$key.login} <font color="grey">[ID:{$users.$key.userId}]</font>)
			{if $users.$key.accessRights == "1"} <font color="red"><b>[администратор]</b></font>{/if}
			{if $users.$key.accessRights == "2"} <font color="green"><b>[модератор]</b></font>{/if}
		</td>
		
		<td width="92px;">
			<div class="btn-group" style="padding-left:12px;">
				<a class="btn btn-primary" rel="tooltip" data-original-title="Редактировать" href="editUser.php?id={$users.$key.userId}"><i class="icon-pencil icon-white"></i></a>
				<a class="btn btn-danger" onclick="return confirm('Удалить учетную запись пользователя?');" rel="tooltip" data-original-title="Удалить" href="delete.php?id={$users.$key.userId}"><i class="icon-trash icon-white"></i></a>
			</div>			
		</td>
	</tr>
	{/foreach}
	
	
</table>