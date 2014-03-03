<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         	= "users";
$version 		= "3 Beta";
$buildSerial 	= "08-018-001";
$area = "cms";


$mname['ru']    	 = "Пользователи";
$adminMenu['ru'] = array(
						"index" => array("uri" => "/admin/".$key."/managerUsers.php", "actionName" => "Управление", "icon" =>""),
						array("uri"=>"/admin/users/addUser.php", "actionName" => "Добавить пользователя", "icon" => "")
						);
?>
