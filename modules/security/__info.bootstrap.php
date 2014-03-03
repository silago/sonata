<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         = "security";
$version 	 = "alpha";
$buildSerial = "00-000-001";
$area = "shop";

$mname['ru']    	 = "Пользователи";
$adminMenu['ru'] = array(
						"index" => array("uri" => "/admin/security/showUserList.php", "actionName"=>"Управление пользователями", "icon"=>""),
                                                array("uri"=>"/admin/security/showConfig.php", "actionName"=>"Управление модулем", "icon" =>""),
                                                array("uri"=>"admin/security/installModule.php", "actionName"=>"Установить модуль", "icon"=>""),
                        "config" => array("uri"=>"/admin/cfg/security/index.php", "actionName" => "Настройки модуля", "icon" => "icon-wrench"),

						);
?>
