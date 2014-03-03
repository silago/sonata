<?php
if (!defined("API")) {
	exit("Main include fail");
}

require_once("modules/catalog/__classes.php");
$catalog = new catalog();


$basket = new Basket();
switch ($ret['uriGroup']) {
	
	case 'totalitems':
          echo $basket->getCountOfItems();
          die();
    break;
    
    case 'totalbill':
            echo $basket->getTotal();
            die();
    break;
	
    case 'addgood': 
            $basket->add();
            die();
    break;

    case 'basket':
        $basket->show();
    break;

    case 'updamount':
        $basket->updamount();
        die();
    break;

    case 'delformcart':
        $basket->delformcart();
        die();
    break;

    default:
        page404();
}

/*
$md = api::getConfig("modules", "vote", "md");
$mk = api::getConfig("modules", "vote", "mk");

if (!empty($md)) $API['md'] = $md;
if (!empty($mk)) $API['mk'] = $mk;
*/
//if (empty($catalog->data['pageTitle'])) {
//	$catalog->data['pageTitle'] = $catalog->lang['startPageTitle'];
//}

/*@$API['title']	 = (empty($catalog->data['title']) ? $catalog->data['title'] : $catalog->data['pageTitle']);
@$API['navigation']  = $catalog->showBreadcrumbs($catalog->breadcrumbsArray);*/
/*@$API['md'] = (empty($mk) ? $catalog->data['md'] : $API['md']);
@$API['mk'] = (empty($mk) ? $catalog->data['mk'] : $API['mk']);
*/

@$API['pageTitle'] 	= $basket->pageTitle;
@$API['template']   = strlen ($basket->template) ? api::setTemplate($basket->template) : $API['template'];
@$API['content']    = strlen ($basket->content) ? $basket->content : $API['content'];
