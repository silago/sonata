<?php
if (!defined("API")) {
	exit("Main include fail");
}

$menu = new menu();
$menu->lang		= $admLng;
$menu->curLang	= $lang;



switch ($rFile) {	
	
	case "index.php":
	case "index.html":
			$menu->data['content'] = $menu->menuList();
			$menu->data['template'] = 'ru/bootstrap.html';
	break;			
	
	case "addMenu.php":
			$menu->data['content'] = $menu->addMenu();
			$menu->data['template'] = 'ru/bootstrap.html';
	break;
	
	case "addMenuGo.php":
			$menu->data['content'] = $menu->addMenuGo();
			$menu->data['template'] = 'ru/bootstrap.html';
	break;
	
	case "editMenu.php":
			$menu->data['content'] = $menu->addMenu();
			$menu->data['template'] = 'ru/bootstrap.html';
	break;
	
	case "deleteMenu.php":
			$menu->data['content'] = $menu->deleteMenu();
			$menu->data['template'] = 'ru/bootstrap.html';
	break;
	
	default:
		page404();
	break;
}
$smarty->assign("content",$menu->data['content']);
$API['content'] = $menu->data['content'];
$API['template'] = $menu->data['template'];;

?>
