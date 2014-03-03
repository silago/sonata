<?php
if (!defined("API")) {
	exit("Main include fail");
}

$page = new page();

switch ($rFile) {

	case "installModule.php":
        if (page::installModule ()) $API['content'] = "<p>Модуль установлен</p>";
        else $API['content'] = "<p>Возникли проблемы при установке модуля</p>";
		$API['template'] = 'ru/bootstrap.html';
    break;

    case "posChange.php":
        $API['template'] = 'ru/ajax.html';
        $API['content']=$page->posChange();
    break;


    case "index.php":
		$API['content']=$page->listPages();
        $API['template'] = 'ru/bootstrap.html';
	break;

	case "add.php":
    	$API['content'] = $page->addPage();
        $API['template'] = 'ru/bootstrap.html';
	break;

    case "addGo.php":
        $API['content'] = $page->addGo();
        $API['template'] = 'ru/bootstrap.html';
        break;

	case "edit.php":
    	//if (!isset($_POST['go']) || $_POST['go'] !== "go") $page->showEditPageForm(@intval($_GET['id'])); else $page->editPageDataToDatabase();
        $API['content'] = $page->editPage(intval($_GET['id']));
        $API['template'] = 'ru/bootstrap.html';
	break;

    case "editGo.php":
        $API['content'] = $page->editGo();

        $API['template'] = 'ru/bootstrap.html';
    break;

	case "delete.php":
		$id = @intval($_GET['id']);

		$sql->query("SELECT COUNT(*) FROM #__#pages WHERE `id` = '".$id."'");
		$sql->next_row();

		if ((int)$sql->field(0) !== 1) {
			page404();
		}

		$sql->query("DELETE FROM #__#pages WHERE `id`='".$id."'");
		message($admLng['delOk'], "", "admin/page/index.php");
	break;

    case "uriCheck.php":
        echo $page->uriCheckAjax();
        die();
        //$API['template'] = 'ru/ajax.html';
    break;

    default:
		page404();
	break;


}   
    $smarty->assign("content",$API['content']);
?>
