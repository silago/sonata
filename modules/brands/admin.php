<?php
if (!defined("API")) {
	exit("Main include fail");
}

$brands = new brands(); 
$brands->lang = $admLng;
$brands->curLang = $lang;

switch ($rFile) {
	case "index.php":
		$brands->adminList();
	break;
	case "add.php":
		$brands->adminAddBrand();
	break;

	case "addGo.php":
		$brands->adminAddGo();
	break;

	case "edit.php":
		$brands->adminEdit(@(int)$_GET['id']);
	break;

	case "delete.php":
		$brands->adminDelete(@(int)$_GET['id']);
	break;

	default:
		page404();
	break;
} 
$API['content'] = $brands->data['content']; 
$API['template'] = 'ru/bootstrap.html';

?>