<?php

if (!defined("API")) {
	exit("Main include fail");
}

$catalog = new catalog();
$catalog->lang		= $admLng;
$catalog->curLang	= $lang;

switch ($rFile) {

    case "installModule.php":
        if (catalog::installModule ()) $catalog->data['content'] = "<p>Модуль установлен</p>";
        else $catalog->data['content'] = "<p>Возникли проблемы при установке модуля</p>";
    break;

    case "setItemNew.php":
        $catalog->data['content'] = $catalog->setItemNew();
    break;

    case "setItemHit.php":
        $catalog->data['content'] = $catalog->setItemHit();
    break;

    case "recacheUriOfGroups.php":
        $catalog->data['content'] = $catalog->recacheUriOfGroups();
    break;

    case "recacheUriOfItems.php":
        $catalog->data['content'] = $catalog->recacheUriOfItems();
    break;

    case "photoResize.php":
		$catalog->data['content'] = $catalog->photoResize();			
		$catalog->data['template'] = 'ru/ajax.html';
	break;
	
	case "photoDelete.php":
		$catalog->data['content'] = $catalog->photoDelete();			
		$catalog->data['template'] = 'ru/ajax.html';
	break;
	
	case "grpposchange.php":
			$catalog->data['content'] = $catalog->grpposchange();
            $catalog->data['template'] = 'ru/ajax.html';
	break;		
	
	case "addGroup.php":		
		$catalog->data['content'] = $catalog->addGroup();
		$catalog->data['template'] = 'ru/bootstrap.html';
	break;
	
	case "addGroupGo.php":		
		$catalog->data['content'] = $catalog->addGroupGo();
        $catalog->data['template'] = 'ru/bootstrap.html';
	break;
	case "editGroup.php":
		$catalog->data['content'] = $catalog->editGroup();
		$catalog->data['template'] = 'ru/bootstrap.html';
	break;
	
	case "editGroupGo.php":
		$catalog->data['content'] = $catalog->editGroupGo();
        $catalog->data['template'] = 'ru/bootstrap.html';
	break;	
	
	case "groupList.php":
  		$catalog->groupList();
		$catalog->data['template'] = 'ru/bootstrap.html';
	break;

	case "deleteImageFromGroup.php":
		$catalog->deleteImageFromGroup(@(int)$_GET['id']);
	break;

	case "addItem.php":
		$catalog->data['content'] = $catalog->addItemShowForm();
		$catalog->data['template'] = 'ru/bootstrap.html';
	break;
	
	case "addItemGo.php":
		$catalog->data['content'] = $catalog->addItemGo();
        $catalog->data['template'] = 'ru/bootstrap.html';
	break;

	case "editItem.php":
		$catalog->data['content'] = $catalog->editItem();
		$catalog->data['template'] = 'ru/bootstrap.html';
	break;
	
	case "editItemGo.php":
		$catalog->data['content'] = $catalog->editItemGo();
        $catalog->data['template'] = 'ru/bootstrap.html';
	break;

	case "deletePhotoFromItem.php":
		$catalog->deletePhotoFromItem();
	break;

	case "index.php":
	case "listItems.php":
		$catalog->listItems();
		$catalog->data['template'] = 'ru/bootstrap.html';
	break;

	case "delete.php":
        $id = $_GET['id'];
		$catalog->deleteItem($id);
	break;

	case "deleteGroup.php":
		$catalog->deleteGroup();
	break;

	case "moveGroup.php":
		$catalog->moveGroup();
	break;

	case "moveItem.php":
		$catalog->moveItem();
	break;

	case "uriCheck.php":
		$catalog->uriCheckAjax();
		$catalog->data['template'] = 'ru/ajax.html';
	break;
	
	case 'config.php':
		$catalog->config();
		$catalog->data['template'] = 'ru/bootstrap.html';
	break;
	
	default:
		page404();
	break;
}


$API['content'] = isset ($catalog->data['content']) ? $catalog->data['content'] : '';
$smarty->assign('content',$API['content']);
$API['template'] = isset ($catalog->data['template']) ? $catalog->data['template'] : '';

?>
