<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         = "menu";
$version 	 = "3 Beta";
$buildSerial = "03-008-002";
$area = "cms";

$mname['ru']    	 = "Меню навигации";
$adminMenu['ru'] = array(
							'index' => array("uri" => "/admin/menu/groupList.php", "actionName" => "Группы", "icon" =>""),							
							array("uri" => "/admin/menu/listItems.php", "actionName" => "Товары", "icon" =>""),
							array("uri" => "/admin/menu/addGroup.php", "actionName" => "Добавить группу", "icon" =>""),
							array("uri" => "/admin/menu/addItem.php", "actionName" => "Добавить товар", "icon" =>""),												
							"config" => array("uri" => "/admin/cfg/menu/index.php", "actionName" => "Настройки модуля", "icon" =>"icon-wrench", "subActions" => ''),
						);
?>
