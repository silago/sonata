<?php
if (!defined("API")) {
	exit("Main include fail");
}

$module = new opinion();
$module->lang 	= @$admLng;
$module->smarty =&$smarty;
$module->exel 	= &$exel;

switch ($rFile) {
	// Вывод всех отзывов
	case "manager.php":
		$API['content'] = $module->getManagerOpiniosHtml();
	break;
	
	case "edit.php":
		$API['content'] = $module->getEditOpinionHtml($_GET, $_POST);
	break;
	
	case "editGo.php":
		$sql->query("	UPDATE
							`#__#opinions`
						SET 
							`fio` = '".$sql->escape($_POST['fio'])."',
							`org` = '".$sql->escape($_POST['org'])."',
							`opinionText` = '".$sql->escape($_POST['opinionText'])."',
							`approved` = '".$sql->escape($_POST['approved'])."'
						WHERE
							`id` = '".(int)@$_GET['id']."'");
		message("OK", null, "/admin/opinion/manager.php");
	break;
	
	case "delete.php":
		$sql->query("DELETE FROM `#__#opinions` WHERE `id` = '".(int)@$_GET['id']."'");
		message("OK", null, "/admin/opinion/manager.php");
	break;
	
	default:
		page404();
	break;
}
?>
