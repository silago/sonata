<?php
if (!defined("API")) {
	exit("Main include fail");
}

$module = new banners();
$module->lang = $admLng;

switch ($rFile) {
	case "index.php":
		$module->adminList();
	break;
	case "add.php":
		$module->adminAddOrEditForm();
	break;

	case "addGo.php":
		$module->adminAddGo();
	break;

	case "edit.php":
		$module->adminEdit(@(int)$_GET['id']);
	break;

	case "delete.php":
		$module->adminDelete(@(int)$_GET['id']);
	break;

	default:
		page404();
	break;
}

$API['content'] = $module->data['content'];
$API['pageTitle'] = $module->lang['pageTitle'] . ' / ' . $module->page_title;
?>