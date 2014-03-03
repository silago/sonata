<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         = "news";
$version 	 = "3 Beta";
$buildSerial = "0300-002-001";

$mname['ru']    	 = "Новости <small>(".api::getStat("news")." новостей)</small>";
$adminMenu['ru'] = array(
						array("admin/news/showGroups.php", "Управление группами"),
						array("admin/news/list.php", "Управление новостями"),
						
						);
?>
