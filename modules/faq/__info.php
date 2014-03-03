<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         = "faq";
$version 	 = "3 Beta";
$buildSerial = "0300-004-001";

$mname['ru']    	 = "FAQ <small>(".api::getStat("faq")." вопросов)</small>";
$adminMenu['ru'] = array(
						array("admin/faq/index.php", "Управление вопросами"),

						);
?>
