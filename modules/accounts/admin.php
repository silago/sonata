<?php
if (!defined("API")) {
	exit("Main include fail");
}

$accounts = new accounts();
$accounts->lang = $l;
$accounts->curLang = $lang;


switch ($uri[3]) {	case "users":
		$accounts->users();
	break;

	default:
		page404();
	break;}

$API['content'] = $accounts->data['content'];

?>

