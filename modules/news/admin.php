<?php
if (!defined("API")) {
	exit("Main include fail");
}

$news = new news();
$news->lang = $admLng;
$news->smarty =&$smarty;
$news->sql = &$sql;

switch ($rFile) {

	case "installModule.php":
        if (news::installModule ()) $API['content'] = "<p>Модуль установлен</p>";
        else $API['content'] = "<p>Возникли проблемы при установке модуля</p>";
		$API['template'] = 'ru/bootstrap.html';
    break;

    case 'uriCheck.php':
        $API['template'] = 'ru/ajax.html';
        $API['content'] = $news->uriCheckAjax();
    break;

    case "addGroup.php":
			$API['content'] = $news->addGroup();
            $API['template'] = 'ru/bootstrap.html';
	break;

    case "addGroupGo.php":
        $API['content'] = $news->addGroupGo();
        $API['template'] = 'ru/bootstrap.html';
    break;

    case "editGroup.php":
        $API['content'] = $news->editGroup(intval($_GET['id']));
        $API['template'] = 'ru/bootstrap.html';
    break;

    case "editGroupGo.php":
        $API['content'] = $news->editGroupGo();
        $API['template'] = 'ru/bootstrap.html';
    break;

    case "showGroups.php":
	case "listGroups.php":
		$API['content'] = $news->listGroups();
        $API['template'] = 'ru/bootstrap.html';
	break;

	case "deleteGroup.php":
        $id = intval($_GET['id']);
        $API['content'] = $news->deleteGroup($id);
        $API['template'] = 'ru/bootstrap.html';


        /*$id = @(int)$_GET['id'];
		if (empty($id)) {
			page500();
		}

		$sql->query("SELECT `title` FROM #__#newsGroups WHERE `id` = '".$id."'");
		if ((int)$sql->num_rows() !== 1) {
			page500();
		}

		$sql->query("DELETE FROM #__#newsGroups WHERE `id` = '".$id."'");
		message($admLng['delGroupOk'], "", "admin/news/showGroups.php"); */

	break;

	case "add.php":
			$API['content'] = $news->addNews();
            $API['template'] = 'ru/bootstrap.html';
	break;

    case "addGo.php":
        $API['content'] = $news->addNewsGo();
        $API['template'] = 'ru/bootstrap.html';
    break;

	case "edit.php":
			$API['content'] = $news->editNews(intval($_GET['id']));
            $API['template'] = 'ru/bootstrap.html';
	break;

    case "editGo.php":
        $API['content'] = $news->editNewsGo(intval($_POST['newsId']), intval($_POST['ownerIdOriginal']));
        $API['template'] = 'ru/bootstrap.html';
    break;

	case "index.php":
	case "list.php":
  		$API['content'] = $news->listNews();
        $API['template'] = 'ru/bootstrap.html';
	break;

	case "delete.php":
 		 $id = intval($_GET['id']);
         $API['content'] = $news->delete($id);
         $API['template'] = 'ru/bootstrap.html';
	break;
	
	default:
		page404();
	break;


}
?>
