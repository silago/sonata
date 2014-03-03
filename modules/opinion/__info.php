<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         	= "opinion";
$version 		= "3 Beta";
$buildSerial 	= "08-018-001";

$mname['ru']    	 = "Отзывы";
$adminMenu['ru'] = array(
						array("admin/".$key."/manager.php", "Управление"),
//						array("admin/".$key."/onlyNew/manager.php", "Новые отзывы"),
						);
?>
