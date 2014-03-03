<?php
if (!defined("API")) {
	exit("Main include fail");
}

require_once("modules/catalog/__classes.php");
$catalog = new catalog();

require_once("modules/basket/__classes.php");
$basket = new Basket();

require_once("modules/security/__classes.php");
$mSecurity = new SecurityModule();



$orders = new orders();
switch ($ret['uriGroup']) {

    case 'checkout':
            $orders->checkout();
    break;
    
 
    

    case 'orders':
        $orders->show();
    break;

    case 'updamount':
        $orders->updamount();
        die();
    break;

    case 'delformcart':
        $orders->delformcart();
        die();
    break;
	
	case 'getshipmentslist':		
		$townId = intval($_POST['townId']);
		$orders->getShipmentsList($townId);
		die();
	break;
	
	case 'getpaymentslist':
		$sId = intval($_POST['sid']);
		$orders->getPaymentsList($sId);
		die();
	break;

	case 'confirmorder':
		$orders->confirmOrder();
		die();
	break;
	
	case 'registerandcheckout':
		$orders->registerAndCheckout();
		die();
	break;

    case 'loginandcheckout':
        $orders->loginAndCheckout();
        die();
    break;
	
	case 'orderslist':
        $orders->ordersList();        
    break;
	
	case 'order':
        $order_id = intval($_GET['order_id']);
		$orders->showOrder($order_id);        
    break;
	
	case 'bill':        
		$order_id = intval($_POST['order_id']);
		$orders->bill($order_id);        
    break;
	
	case 'discardorder':
        $orderid = intval($_POST['orderid']);
		$orders->discardOrder($orderid);
        die();
    break;
	
	case 'reneworder':
        $orderid = intval($_POST['orderid']);
		$orders->renewOrder($orderid);
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

@$API['pageTitle'] 	= $orders->pageTitle;
@$API['template']   = strlen ($orders->template) ? api::setTemplate($orders->template) : $API['template'];
@$API['content']    = strlen ($orders->content) ? $orders->content : $API['content'];
