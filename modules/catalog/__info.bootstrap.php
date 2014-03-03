<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         = "catalog";
$version 	 = "3 Beta";
$buildSerial = "03-008-002";
$area = "";
$table = array("shop_groups", "shop_items");

$mname['ru']    	 = "Каталог";
$adminMenu['ru'] = array(
							'index' => array("uri" => "/admin/catalog/groupList.php", "actionName" => "Группы", "icon" =>""),							
							array("uri" => "/admin/catalog/listItems.php", "actionName" => "Товары", "icon" =>""),
							array("uri" => "/admin/catalog/addGroup.php", "actionName" => "Добавить группу", "icon" =>""),
							array("uri" => "/admin/catalog/addItem.php", "actionName" => "Добавить товар", "icon" =>""),
                            array("uri"=>"/admin/tags", "actionName"=>"Бренды", "icon"=>""),
                            array("uri"=>"/admin/catalog/installModule.php", "actionName"=>"Установить модуль", "icon"=>""),
							"config" => array("uri" => "/admin/cfg/catalog/index.php", "actionName" => "Настройки модуля", "icon" =>"icon-wrench", "subActions" => ''),
						);
?>
