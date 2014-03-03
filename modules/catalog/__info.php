<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         = "catalog";
$version 	 = "3 Beta";
$buildSerial = "03-008-002";

$mname['ru']    	 = "Каталог <small>(".api::getStat("catalog")." позиций)</small>";
$adminMenu['ru'] = array(
						array("admin/catalog/groupList.php", "Управление группами"),

						array("admin/catalog/listItems.php", "Управление товарами"),

						);
?>
