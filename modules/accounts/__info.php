<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         = "accounts";
$version 	 = "1 Beta";
$buildSerial = "0000-000-001";

$mname['ru']    	 = "Клиенты <small>(".api::getStat("shop_users").")</small>";
$adminMenu['ru'] = array(
						array("admin/accounts/users/", "Список клиентов"),

						);
?>
