<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         = "brands";
$version 	 = "alpha";
$buildSerial = "00-000-001";
$area = "shop";

$mname['ru']    	 = "Бренды";
$adminMenu['ru'] = array(
						"index" => array("uri" => "admin/brands/index.php", "actionName"=>"Управление брендами", "icon"=>"") 
						);
?>
