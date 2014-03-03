<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         = "brands";
$version 	 = "alpha";
$buildSerial = "00-000-001";
$area = "shop";

$mname['ru']    	 = "Тэги";
$adminMenu['ru'] = array(
						"index" => array("uri" => "admin/tags/index.php", "actionName"=>"Управление тэгами", "icon"=>"") 
						);
?>
