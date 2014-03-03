<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         	= "gallery";
$version 		= "4 Alfs";
$buildSerial 	= "04-001-001";

$mname['ru']    	 = "Фотогалерея";
$adminMenu['ru'] = array(
						array("admin/".$key."/listGroups.php", "Управление альбомами"),

						);
?>
