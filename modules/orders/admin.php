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


$orders = new Orders();

switch ($rFile) {

    case "paymentsList.php":
        $orders->paymentsList();
    break;

    case "addPayment.php":
        $orders->addPayment();
    break;

    case "editPayment.php":
        $id = (isset($_GET['id'])) ? intval($_GET['id']) : '';
        $orders->editPayment($id);
    break;

    case "shipmentsList.php":
        $orders->shipmentsList();
    break;

    case "addShipment.php":
        $orders->addShipment();
    break;

    case "editShipment.php":
        $id = (isset($_GET['id'])) ? intval($_GET['id']) : '';
        $orders->editShipment($id);
    break;

    case "showList.php":
        $orders->adminShowList();
    break;
	
	case "editOrder.php":
        $orderid = (isset($_GET['id'])) ? intval($_GET['id']) : '';
		$orders->editOrder($orderid);
    break;
    
    case "viewOrder.php":
        $orderid = (isset($_GET['id'])) ? intval($_GET['id']) : '';
		$orders->editOrder($orderid,false);
    break;
	
	case "deleteOrder.php":
        $orderid = (isset($_GET['id'])) ? intval($_GET['id']) : '';
		$orders->deleteOrder($orderid);
    break;
	
	case "deleteItem.php":
        $orderid = (isset($_POST['orderid'])) ? intval($_POST['orderid']) : '';
		$itemid = (isset($_POST['itemid'])) ? intval($_POST['itemid']) : '';
		$orders->deleteItem($orderid, $itemid);
		die();
    break;

    case "townsList.php":
        $orders->townsList();
    break;

    case "addTown.php":
        $orders->addTown();
    break;

    case "editTown.php":
        $id = (isset($_GET['id'])) ? intval($_GET['id']) : '';
        $orders->editTown($id);
    break;

    case "installModule.php":
        if (orders::installModule ()) $orders->content = "<p>Модуль установлен</p>";
        else $orders->content = "<p>Возникли проблемы при установке модуля</p>";
    break;
	
    default:
        page404();

    case "config.php":
        $orders->config();
    break;    
}

$API['content'] = $orders->content;
$API['template'] = 'ru/bootstrap.html';
