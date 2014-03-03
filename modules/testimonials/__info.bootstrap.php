<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         = "page";
$version 	 = "3 Beta";
$buildSerial = "03-001-001";
$area = "cms";
$table = array("pages");

$mname['ru']    	 = "Страницы";

$adminMenu['ru'] = array(
						'index' => array("uri" => "/admin/page/index.php", "actionName" => "Управление страницами", "icon" =>""),
						'config' => array("uri" => "/admin/cfg/page/index.php", "actionName" => "Настройки модуля", "icon" =>"icon-wrench")
						);
?>
