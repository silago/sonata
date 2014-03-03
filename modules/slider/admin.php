<?php
if (!defined("API")) {
	exit("Main include fail");
}

$module = new slider();
$module->lang 		= $admLng;
$module->curLang	= $lang;

switch ($rFile) {
	case "index.php":
	case "list.php":
		$module->adminListImages();
	break;
	
	case "addImage.php":
		if (isset($_GET['go']) && $_GET['go'] == 'go')
			$module->adminAddImageGo();
		else
			$module->adminAddImage();
	break;

	case "editImage.php":
		if (isset($_GET['go']) && $_GET['go'] == 'go')
			$module->adminEditImageGo();
		else
			$module->adminEditImage();
	break;
	
	case "deleteImage.php":
		$module->adminDeleteImage();
	break;
	default:
		page404();
	break;
}

$API['content'] = $module->return['content'];
$API['template'] = 'ru/bootstrap.html';
?>
