<?php
if (!defined("API")) {
	exit("Main include fail");
}

$key         = "basket";
$version 	 = "alpha";
$buildSerial = "00-000-001";
$area = "shop";

$mname['ru']    	 = "Корзина пользователей";
$adminMenu['ru'] = array(
						"index" => array("uri" => "/admin/basket/showList.php", "actionName"=>"Список неподтвержденных заказов", "icon"=>""),                                                
                                                array("uri"=>"/admin/basket/installModule.php", "actionName"=>"Установить модуль", "icon"=>""),
                        "config" => array("uri"=>"/admin/basket/config.php", "actionName"=>"Настройки модуля", "icon"=>"icon-wrench"),
						);
?>
