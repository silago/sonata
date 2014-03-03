<?php

if (!defined("API")) {
	exit("Main include fail");
}

$basket = new Basket();

switch ($rFile) {
    case "showList.php":
        $basket->adminShowList();
    break;    

    case "installModule.php":
        if (Basket::installModule ()) $basket->content = "<p>Модуль установлен</p>";
        else $basket->content = "<p>Возникли проблемы при установке модуля</p>";
    break;
	
    default:
        page404();

    case "config.php":
        $basket->config();
    break;    
}

$API['content'] = $basket->content;
$API['template'] = 'ru/bootstrap.html';