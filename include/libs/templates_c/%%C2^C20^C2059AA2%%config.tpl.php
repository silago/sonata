<?php /* Smarty version 2.6.16, created on 2013-10-30 16:08:20
         compiled from ru/modules/security/admin/config.tpl */ ?>
<div id="info">
    <ul class="breadcrumb">
        <li><a href="#">Управление магазином</a><span class="divider">/</span></li>
        <li><a href="/admin/security/showUserList.php">Пользователи</a><span class="divider">/</span></li>
		<li class="active"><a>Настройка модуля</a></li>
    </ul>
</div>

<div class="row">
	<div class="span12">
		<ul id="myTab" class="nav nav-tabs">
				  <li class="active"><a href="#configMain" data-toggle="tab">Основные настройки</a></li>
				  <li><a href="#configFiz" data-toggle="tab">Настройки пользователя "Физическое лицо"</a></li>
				  <li><a href="#configOrg" data-toggle="tab">Настройки пользователя "Юридическое лицо"</a></li>				  
		</ul>
		<div id="myTabContent" class="tab-content">
			<div class="tab-pane fade in active" id="configMain">
				Основные настройки
			</div>
			<div class="tab-pane fade" id="configFiz">
				<center><button class="btn btn-info" onclick="return addField('configFiz')">Добавить поле</button></center>				
				<strong id="configFiz">Тип поля:</strong><br/>
				<select style="width:50%" onchange="return changeFieldType('configFiz')">
					<option value="0">Однострочное поле</option>
					<option value="1">Многострочное поле</option>
					<option value="2">Выпадающий список</option>
					<option value="3">Список опций (несколько вариантов)</option>
					<option value="4">Список опций (один вариант)</option>
				</select><br/>				
				<div id="fieldlist"></div>
				<div class="menu">
					<ol class="sortable"></ol>
				</div>				
			</div>              
			<div class="tab-pane fade" id="configOrg">			
				<center><button class="btn btn-info" onclick="return addField('configOrg')">Добавить поле</button></center>				
				<strong id="configOrg">Тип поля:</strong><br/>
				<select style="width:50%" onchange="return changeFieldType('configOrg')">
					<option value="0">Однострочное поле</option>
					<option value="1">Многострочное поле</option>
					<option value="2">Выпадающий список</option>
					<option value="3">Список опций (несколько вариантов)</option>
					<option value="4">Список опций (один вариант)</option>
				</select><br/>				
				<div id="fieldlist"></div>
				<div class="menu">
					<ol class="sortable"></ol> 
				</div>				
			</div>				
			</div>
        </div>
	<br/><br/><br/><center><button type="submit" class="btn btn-primary">Сохранить</button></center>
	</div>
</div>