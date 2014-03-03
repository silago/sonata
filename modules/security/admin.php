<?php

if (!defined("API")) {
	exit("Main include fail");
}

$securityModule = new SecurityModule();

#print_r($API);

$ur2 = $_SERVER["REQUEST_URI"];
$ur2 = explode('/',$ur2);
#print_r($ur2);

switch ($rFile) {
    case "showUserList.php":
		
        $securityModule->adminShowUserList();
    break;

    case "showConfig.php":
        $securityModule->adminShowConfig();
    break;
	
	case "userDelete.php":
		//print_r($securityModule->url_tmp);
		$securityModule->adminDeleteUser($ur2[4]);
		#print_r($_SESSION);
	break;
	
	case "userEdit.php":
		//print_r($securityModule->url_tmp);
		$securityModule->adminEditUser($ur2[4],true);
		#print_r($_SESSION);
	break;
	
	case "userView.php":
		//print_r($securityModule->url_tmp);
		$securityModule->adminEditUser($ur2[4]);
		#print_r($_SESSION);
	break;
	
	case "userAdd.php":
		//print_r($securityModule->url_tmp);
		$securityModule->adminAddUser();
		#print_r($_SESSION);
	break;
	
    case "installModule.php":
   
        if (Security::installSecurityModule ()) $securityModule->content = "<p>Модуль установлен</p>";
        else $securityModule->content = "<p>Возникли проблемы при установке модуля</p>";
    break;

    case "config.php":
        $securityModule->config ();
    break;


    default:
        page404();
}

$API['content'] = $securityModule->content;
$API['template'] = 'ru/bootstrap.html';
