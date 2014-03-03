<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         = "security";
$version 	 = "alpha";
$buildSerial = "00-000-001";

$mname['ru']    	 = "Security";
$adminMenu['ru'] = array(
						array("admin/security/showUserList.php", "Управление пользователями"),
                                                array("admin/security/showConfig.php", "Управление модулем"),
                                                array("admin/security/installModule.php", "Установить модуль")

						);
?>
