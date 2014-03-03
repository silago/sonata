<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         = "page";
$version 	 = "3 Beta";
$buildSerial = "03-001-001";

$mname['ru']    	 = "Страницы <small>(".api::getStat("pages")." страниц)</small>";
$adminMenu['ru'] = array(
						array("admin/page/index.php", "Управление страницами"),
						);
?>
