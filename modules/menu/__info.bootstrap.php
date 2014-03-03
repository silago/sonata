<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         = "menu";
$version 	 = "3 Beta";
$buildSerial = "03-008-002";
$area = "cms";
$table = '';

$mname['ru']    	 = "Меню навигации";
$adminMenu['ru'] = array(
							'index' => array("uri" => "/admin/menu/index.php", "actionName" => "Список меню", "icon" =>""),							
							array("uri" => "/admin/menu/addMenu.php", "actionName" => "Добавить новое меню", "icon" =>""),																		
							"config" => array("uri" => "/admin/cfg/menu/index.php", "actionName" => "Настройки модуля", "icon" =>"icon-wrench", "subActions" => ''),
						);
?>
