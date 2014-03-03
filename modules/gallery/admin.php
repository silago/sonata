<?php
if (!defined("API")) {
	exit("Main include fail");
}

$gallery = new gallery();
$gallery->lang 		= $admLng;
$gallery->curLang	= $lang;

switch ($rFile) {
	case "addGroup.php":
		$gallery->addGroup();
	break;

	case "editGroup.php":
		$gallery->editGroup();
	break;
	case "index.php":
	case "listGroups.php":
		$gallery->listGroups();
	break;

	case "moveGroup.php":
		$gallery->moveGroup();
	break;

	case "managerGroup.php":
		$gallery->managerGroup();
	break;

	case "addImage.php":
		$gallery->addImage();
	break;

	case "editImage.php":
		$gallery->editImage();
	break;

	case "moveImage.php":
		$gallery->moveImage();
	break;

	case "deleteImage.php":
		$gallery->deleteImage();
	break;

	case "deleteGroup.php":
		$gallery->deleteGroup();
	break;

}

$API['content'] = $gallery->return['content'];

?>
