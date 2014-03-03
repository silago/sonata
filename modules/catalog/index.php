<?php
if (!defined("API")) {
	exit("Main include fail");
}

include_once("modules/basket/__classes.php"); 
$basket = new Basket();


$catalog = new catalog();

/*if (isset ($_GET['icount']) && intval ($_GET['icount']) != 0) {
	$catalog->countOfItems = intval($_GET['icount']);
	$_SESSION['icount'] = intval($_GET['icount':spli    ]);
} else {
	$catalog->countOfItems = 20;
	$_SESSION['icount'] = 20;
}*/

// Количество товаров на странице
if (isset ($_POST['country2']) && intval ($_POST['country2']) > 0) {
	$catalog->countOfItems = intval($_POST['country2']);
	$_SESSION['icount'] = intval($_POST['country2']);
} else {
	if (!isset ($_SESSION['icount'])) {
		$catalog->countOfItems = 20;
		$_SESSION['icount'] = 20;	
	} else {
		$catalog->countOfItems = intval($_SESSION['icount']);
	}
}

// Сортировать по определнному полю
if (isset ($_POST['country']) && intval ($_POST['country']) > 0) {
	$catalog->sortby = intval ($_POST['country']);
	$_SESSION['sortby'] = intval ($_POST['country']);
} else {
	if (!isset ($_SESSION['sortby'])) {
		$catalog->sortby = 1;
		$_SESSION['sortby'] = 1;
	} else {
		$catalog->sortby = intval ($_SESSION['sortby']);
	}
}

$catalog->uri		= $uri;

//echo "op = ".$ret['uriItem']; 
if(isset($ret['uriItem'])){
   $ret['table'] = 'shop_items';
}else{
    if($ret['uriGroup'] == 'new'){
        $ret['table'] = 'new';
    }elseif($ret['uriGroup'] == 'hit'){
        $ret['table'] = 'hit';
    }elseif($ret['uriGroup'] == 'catalog'){
        $ret['table'] = 'catalog';
    }elseif($ret['uriGroup'] == 'catalogsearch'){
        $ret['table'] = 'catalogsearch';
    }elseif($ret['uriGroup'] == 'tag'){
        $ret['table'] = 'tag';
    }else{
        $ret['table'] = 'shop_groups';
    }

}
//var_dump($ret);
switch ($ret['table']) {

	case "shop_groups":
        
            //echo (isset ($ret['uriGroup']) ? $ret['uriGroup'] : 'op');
        //$catalog->indexShowGroup($ret['uriGroup']);
        
        $catalog->data['template'] = 'catalog.html';

        $catalog->data['content']=$catalog->get_groups($ret['uriGroup'],array(),'index/show.group.body.html');
        //die("s");

        $_template = "/modules/catalog/catalog.base.tpl";
    break;
	
	case "shop_items":
    $_template = "/modules/catalog/catalog.base.tpl";
        $catalog->showItemInfo($ret['uriItem']);
        $catalog->data['template'] = 'item.html';
	break;
	
	case "new":
        $catalog->showNew();
        $_template = "/modules/catalog/catalog.base.tpl";
        $catalog->data['template'] = 'catalog.html';
	break;
    
    case "catalog":
        //$catalog->data['content']=$catalog->get_groups(false, array('parent_group_id'=>'0'))          ;
        include_once("modules/page/__classes.php"); 
        $pages = new Page();
        $catalog->data['content']=$catalog->get_groups(false, array('parent_group_id'=>'0'));
        $catalog->data['content'].=$pages->get_pages(false, array('onmain'=>'1'));


    break;

    case "hit":
         $_template = "/modules/catalog/catalog.base.tpl";
    #case "catalog":
        $catalog->catalogSearch(true);
        $catalog->data['template'] = 'catalog.html';
    break;



	case "tag":
 $_template = "/modules/catalog/catalog.base.tpl";
        $catalog->showTag($_GET['id']);
        $catalog->data['template'] = 'catalog.html';  
		
	break;
	case "catalogsearch":
	    $_template = "/modules/catalog/catalog.base.tpl"; 
        $catalog->catalogSearch ();
		//$catalog->data['template'] = 'inner.html';
	break;

	default:
		page404();
	break;

}

$smarty->assign("content",$catalog->data['content']);

$md = api::getConfig("modules", "vote", "md");
$mk = api::getConfig("modules", "vote", "mk");

if (!empty($md)) $API['md'] = $md;
if (!empty($mk)) $API['mk'] = $mk;

//if (empty($catalog->data['pageTitle'])) {
//	$catalog->data['pageTitle'] = $catalog->lang['startPageTitle'];
//}

@$API['title']	 = (empty($catalog->data['title']) ? $catalog->data['title'] : $catalog->data['pageTitle']);




@$API['navigation']  = $catalog->showBreadcrumbs($catalog->breadcrumbsArray);
@$API['template'] 	 = $catalog->data['template'] ? api::setTemplate($catalog->data['template']) : $API['template'];
@$API['content'] 	 = $catalog->data['content'];
@$API['groupImage']	 = isset ($catalog->data['groupImage']) ? $catalog->data['groupImage'] : '';
@$API['sortBox']	 = isset ($catalog->data['sortBox']) ? $catalog->data['sortBox'] : '';
@$API['bottomPagination']	 = isset ($catalog->data['bottomPagination']) ? $catalog->data['bottomPagination'] : '';
@$API['filterItemsChecked'] = isset ($catalog->data['filterItemsChecked']) ? $catalog->data['filterItemsChecked'] : '';
@$API['md'] = (empty($mk) ? $catalog->data['md'] : $API['md']);
@$API['mk'] = (empty($mk) ? $catalog->data['mk'] : $API['mk']);
@$API['pageTitle'] 	= $catalog->data['pageTitle'];
?>
