<?php
if (!defined("API")) {
	exit("Main include fail");
}

$tags = new tags(); 
$tags->lang = $admLng;
$tags->curLang = $lang;

switch ($rFile) {
	case "index.php":
		$tags->adminList();
	break;
	case "add.php":
		$tags->adminAddTag();
	break;

	case "addGo.php":
		$tags->adminAddGo();
	break;

	case "edit.php":
		$tags->adminEdit(@(int)$_GET['id']);
	break;

	case "delete.php":
		$tags->adminDelete(@(int)$_GET['id']);
	break;

	default:
		page404();
	break;
} 
$API['content'] = $tags->data['content']; 
$API['template'] = 'ru/bootstrap.html';

?>