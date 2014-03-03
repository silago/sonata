<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         = "fb";
$version 	 = "4.0";
$buildSerial = "04-008-001";

$mname['ru']    	 = "Обратная связь";
$adminMenu['ru'] = array(
			array("admin/cfg/".$key."/index.php", "Настройка"),
			);
?>
