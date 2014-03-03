<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         = "news";
$version 	 = "3 Beta";
$buildSerial = "0300-002-001";
$area = "cms";
$table = array("news", "newsgroups");

$mname['ru']    	 = "Новости";
$adminMenu['ru'] = array(
						'index' => array( "uri" => "/admin/news/showGroups.php", "actionName" => "Управление группами", "icon" =>""),
						array("uri" => "/admin/news/list.php", "actionName" => "Управление новостями", "icon" =>""),
						array("uri" => "/admin/news/addGroup.php", "actionName" => "Добавить группу", "icon" =>""),
						array("uri" => "/admin/news/add.php", "actionName" => "Добавить новость", "icon" =>""),
						"config" => array("uri" => "/admin/cfg/news/index.php", "actionName" => "Настройки модуля", "icon" =>"icon-wrench", "subActions" => ''),
						
						);
?>
