<?php
/**
 *
 * @author kvmang
 * 
 */
class Orders
{
    public $content = '';
    public $template = '';
    public $pageTitle = 'Заказы';
    public $error = array();
    public static $orgFields = array();
    public static $fizFields = array();
	public $payments = array();
	public $adminEmail = '';
	public $appName = 'Технодом';
	
	/* Получатель для выписки счета */
	public $recipient = '';
	
	/* Адрес получателя для выписки счета */
	public $recipientAdr = '';
	
	/* Телефон получателя для выписки счета */
	public $recipientTel = '';
	
	/* ИНН получатель для выписки счета */
	public $recipientINN = '';
	
	/* КПП получатель для выписки счета */
	public $recipientKPP = '';
	
	/* Расчетный счет получателя для выписки счета */
	public $account = '';
	
	/* Кор. счет получателя для выписки счета */
	public $korAccount = '';
	
	/* БИК для выписки счета */
	public $bik = '';
	
	/* ИНН Банка для выписки счета */
	public $bankInn = '';

    public static $arrCommands = array(
										array("uri" => "orders"),
										array("uri" => "checkout"), 
										array("uri" => "getshipmentslist"), 
										array("uri" => "getpaymentslist"),
										array("uri" => "confirmorder"),										
										array("uri" => "registerandcheckout"),
                                        array("uri" => "loginandcheckout"),
										array("uri" => "orderslist"),
										array("uri" => "order"),
										array("uri" => "bill"),
										array("uri" => "discardorder"),
										array("uri" => "reneworder"),
									);


    public static function installModule(){

        $router = api::object_from_file("chache/router.txt");
        $router['orders'] = Orders::$arrCommands;
        api::object2file($router, 'chache/router.txt');
        return true;
    }
	
	public function config(){
        global $smarty, $sql;
        
		$array = config::getConfigFromIni('orders');
		
		foreach($array as $key => $value){			
			$confValue = api::getConfig("modules", "orders", $key);						
			$array[$key]['value'] = $confValue;
			if($key == 'defTemplate'){
				$array[$key]['options'] = api::getTemplatesList();
			}			
		}			
		
		if(isset($_POST['go']) && $_POST['go'] == 'go'){			
			foreach($_POST as $key => $value){
				$cfgValue = api::getConfig("modules", "orders", $key);				
				if(empty($cfgValue) && $key !='go'){
					$sql->query("INSERT INTO `#__#config` (`category`, `type`, `name`, `value`, `lang`) VALUES ('modules', 'orders', '".$key."', '".htmlspecialchars($value)."', 'ru')");					
				}else{
					$sql->query("UPDATE `#__#config` SET  `value` = '".htmlspecialchars($value)."' WHERE `category` = 'modules' AND `type` = 'orders' AND `name` = '".$key."'");					
				}
			}		
		message('Настройки изменены', '', '/admin/orders/config.php', 'alert-success');
		}
		
        $smarty->assign('moduleName', 'Заказы');
		$smarty->assign('module', 'orders');
		$smarty->assign('confArray', $array);
        $this->content = $smarty->fetch(api::setTemplate('modules/admin/config.tpl'));	
		return true;
    }

    public function adminShowList(){
        global $sql, $smarty;
		
		if(isset($_GET['status'])){
			switch (intval($_GET['status'])){
				case 0: case 1: case 2: case 3: case 4: case 5:
					$sql->query("SELECT * FROM `shop_orders` WHERE `state` = '".intval($_GET['status'])."' order by `id` desc");
				break;
				
				default:
					message('Неверно указан статус заказа', '', '/admin/orders/showList.php', 'alert-error');
				break;
			}		
		}else{
			$sql->query("SELECT * FROM `shop_orders` order by `id` desc");		
		}		
		
		while($sql->next_row_assoc()){
			$row[] = $sql->result;
		}
		
		foreach($row as $key=>$value){
			$row[$key]['data'] = json_decode($row[$key]['data'], true);
			$row[$key]['order_data'] = json_decode($row[$key]['order_data'], true);
			
			switch ($value['state']){
				case 0: $statetext = 'В обработке'; break;
				case 1: $statetext = 'Ожидает оплаты'; break;
				case 2: $statetext = 'Оплачен'; break;
				case 3: $statetext = 'Доставка'; break;
				case 4: $statetext = 'Выполнен'; break;
				case 5: $statetext = 'Отменен'; break;
			}			
			$row[$key]['statetext'] = $statetext;					
		}	
		
		$smarty->assign('array', $row);
		$this->content = $smarty->fetch(api::setTemplate('modules/orders/admin/orders.list.tpl'));
    }

    public function deleteOrder($orderid){
		global $sql;
		$sql->query("SELECT * FROM `shop_orders` WHERE `id` = '".$orderid."'", true);		
		if($sql->num_rows() != 1) message("Неверный номер заказа", "", "/admin/orders/showList.php", "alert-error");
		
		$sql->query("UPDATE `shop_orders` SET `state` = '5' WHERE `id` = '".$orderid."'");		
		message("Заказу № ".$orderid." присвоен статус отменен", "", "/admin/orders/showList.php", "alert-success");	
	}
	
	public function editOrder($orderid,$edit=true){
		
		
		
		global $sql, $smarty;	
		
		#print_r($_SESSION);
		
		if ($edit)
			$smarty->assign('edit', 'edit');					
		
				
		$sql->query("SELECT `shop_orders`.*, shop_users.phone as phone FROM `shop_orders`
			left join `shop_users`
				on shop_orders.email = shop_users.email
		WHERE `shop_orders`.`id` = '".$orderid."'", true);		
		if($sql->num_rows() != 1) message("Неверный номер заказа", "", "/admin/orders/showList.php", "alert-error");		
		
		$state = $sql->result['state'];
		
		$row = $sql->result;	
		#echo ($sql->result);
		#$userdata = $sql->result['userdata'];	
		#$userdata = json_decode($userdata, true);
		#$phone = $userdata);
		#$userdata = $userdata['form'];
		#$userdata = (array_map2("explode","=",explode("&",$get)));
		#); 	
		#echo typeof($userdata);
		#$userdata = explode("&", $userdata);	
		#$userdata = array_map(create_function('$v', 'return explode("=",$v);'), $userdata);
		
		$row['data'] = json_decode($row['data'], true);
		#$row['userdata'] = $userdata;
		#print_r($_GET);
		$row['order_data'] = json_decode($row['order_data'], true);	
		$a = $row['order_data'];	
		if ((isset($_GET['orderitemid'])) )
		{
		
		
		#
		$a[$_GET['orderitemid']]['quantity']=$_GET['orderitemcount'];	
		$a = json_encode($a);	
	
		$sql->query("update `shop_orders` set order_data = '".(addslashes($a))."' 
		WHERE `shop_orders`.`id` = '".$orderid."'");		
		}	
		
		#print_r($row);
		#print_r($row);
		foreach($row as $key=>$value){
			if(is_int($key)) unset($row[$key]);		
			$smarty->assign($key, $value);
		}
		
		$tname = $this->getTownName($row['town_id']);	
		$sname = $this->getShipmentName($row['shipment_id']);
		$pname = $this->getPaymentName($row['payment_id']);		
		
		$smarty->assign('payments', $this->payments);
		$smarty->assign('pname', $pname);
		$smarty->assign('sname', $sname);
		$smarty->assign('tname', $tname);
		$smarty->assign('datadata', $row['data']);

		if($row['user_org'] == '1' || $row['user_org'] == '0'){
			
			if (	(isset($row['data'])) && (!empty($row['data']))	)
			foreach($row['data'] as $key => $value){
					foreach(Orders::$fizFields as $key1 => $value1){
						if($key == $value1['name']){
							$data[$key]['description'] = $value1['description'];
							$data[$key]['value'] = $value;
							$data[$key]['type'] = $value1['type'];
						}
					}	
				}
		}

		if($row['user_org'] == '2'){
			foreach($row['data'] as $key => $value){
					foreach(Orders::$orgFields as $key1 => $value1){
						if($key == $value1['name'] && $value1['required'] == 1){
							$data[$key]['description'] = $value1['description'];
							$data[$key]['type'] = $value1['type'];
							$data[$key]['value'] = $value;
						}
					}	
				}
		}		
		if (	(isset($row['data'])) && (!empty($row['data']))	)
		if (isset($data))
		$smarty->assign('data', $data);	 		
		
		
		$orderitemid=((isset($_GET['orderitemid'])) ?$_GET['orderitemid'] :false);
		$orderitemcount=((isset($_GET['orderitemcount'])) ?$_GET['orderitemcount'] :false);
		
		
		
		
		$orderData = $this->adminGetOrderData($orderid,$orderitemid,$orderitemcount);	
		
		
			
		$smarty->assign('orderData', $orderData);
		
		$sql->query("SELECT * FROM `shop_towns`");
		while($sql->next_row_assoc()){
			$towns[] = $sql->result;
		}
		
		$smarty->assign('towns', $towns);	 
		
		$sql->query("SELECT * FROM `shop_shipmentstypes`");
		while($sql->next_row_assoc()){
			$shipments[] = $sql->result;
		}
		
		$smarty->assign('shipments', $shipments);
		
		if(isset($_POST['edit']) && $_POST['edit'] == 'go'){			
			$error = array();
			$checkRes = array();			
			
			if(!strlen($this->postArray['email'])) $error[] = 'Не заполнено поле "Email адрес клиента"';
			#if(!strlen($this->postArray['surname'])) $error[] = 'Не заполнено поле "Фамилия клиента"';
			if(!strlen($this->postArray['name'])) $error[] = 'Не заполнено поле "Имя клиента"';
			#if(!strlen($this->postArray['patronymic'])) $error[] = 'Не заполнено поле "Отчество клиента"';
			if(!strlen($this->postArray['tname'])) $error[] = 'Не заполнено поле "Город"';
			if(!strlen($this->postArray['sname'])) $error[] = 'Не заполнено поле "Вид доставки"';
			if(!strlen($this->postArray['pname'])) $error[] = 'Не заполнено поле "Тип оплаты"';
			
			if($row['user_org'] == 2){
				foreach(Orders::$orgFields as $key => $value){				
							if($value['required'] == 1){
								$array[$value['name']] = $_POST[$value['name']];													
							}
				}
				
				$checkRes = $this->adminOrgCheck($array);							
			}
						
			
			if($row['user_org'] == 1 || $row['user_org'] == 0){
				foreach(Orders::$fizFields as $key => $value){					
					if($value['required'] == 1){						
							$array[$value['name']] = $_POST[$value['name']];																	
					}
				}			
				if (!isset($array))	$array=array();
				$checkRes = $this->fizCheck($array);			
			}								
			
			$error = array_merge($error, $checkRes);	
			
			if(empty($error)){
				$sql->query("SELECT `sprice` FROM `shop_shipmentstypes` WHERE `id` = '".$this->postArray['sname']."'", true);
				
				$row['order_data']['sprice'] = $sql->result['sprice'];				
				$row['order_data']['cost'] = $row['order_data']['sprice'] + $row['order_data']['total'];
				$row['order_data']['cost'] = number_format($row['order_data']['cost'], 2, '.',' ');
				
				$sql->query("UPDATE `shop_orders` set 													
													`email` = '".$this->postArray['email']."',
													`name` = '".$this->postArray['name']."',
													`surname` = '".$this->postArray['name']."',
													`patronymic` = '".$this->postArray['patronymic']."',
													`town_id` = '".$this->postArray['tname']."',
													`shipment_id` = '".$this->postArray['sname']."',
													`payment_id` = '".$this->postArray['pname']."',
													`state` = '".$this->postArray['state']."',
													`data` = '".addslashes(json_encode($array))."',
													`order_data` = '".addslashes(json_encode($row['order_data']))."'		
													
													WHERE `id` = '".$orderid."'
													");			
			
				if($state != $this->postArray['state']){
				
				switch($this->postArray['state']){
					case 0: $status ='В обработке'; break;
					case 1: $status ='Ожидает оплаты'; break;
					case 2: $status ='Оплачен'; break;
					case 3: $status ='Доставка'; break;
					case 4: $status ='Выполнен'; break;
					case 5: $status ='Отменен'; break;				
				}
				
				$sql->query("SELECT * FROM `shop_orders` WHERE `id` = '".$orderid."'", true);
				
				
				$rowRes = $sql->getList();
				
				#print_r($rowRes);
				if (isset($rowRes['data']))
				{
				$rowRes['data'] = json_decode($rowRes['data'], true);
				$rowRes['order_data'] = json_decode($rowRes['order_data'], true);	
				
				$shipmentName = $this->getShipmentName($rowRes['shipment_id']);
				$shipmentPeriod = $this->getShipmentPeriod($rowRes['shipment_id']);
				$shipmentPrice = $this->getShipmentPrice($rowRes['shipment_id']);				
				$paymentName = $this->getPaymentName($rowRes['payment_id']);
				
				
				
				$to = $rowRes['email'] ;	
			
				$smarty->assign('data', $rowRes['data']);	
				$smarty->assign('datadata', $rowRes['order_data'] );	
				$smarty->assign('orderid', $orderid);									
				$smarty->assign('status', $status);								
				$smarty->assign('order_data', $rowRes['order_data']);				
				$smarty->assign('shipmentName', $shipmentName);	
				$smarty->assign('shipmentPrice', $shipmentPrice);	
				$smarty->assign('shipmentPeriod', $shipmentPeriod);
				$smarty->assign('paymentName', $paymentName);
	
				$smarty->assign('total', $rowRes['order_data']['total']);	
				
				$smarty->assign('cost', $rowRes['order_data']['cost']);				
			
				$smarty->assign('appName', $this->appName);												
				$smarty->assign('adminEmail', $this->adminEmail);
				$smarty->assign('adminPhone', $this->recipientTel);
				#$smarty->assign('sitename', $_SERVER['SERVER_NAME']);
				$smarty->assign('sitename', $this->sitename);		
				
				$htmlBody = $smarty->fetch(api::setTemplate("modules/orders/index/mail/order.edited.tpl"));		
				
				
				$subject = 'Статус Вашего заказ №'.$orderid.' в интернет-магазине "'.$this->appName.'" изменен на '.$status.'';		
				$sub = "=?UTF-8?B?".base64_encode($subject)."?=";
				$from_text = 'Администрация интернет-магазина "'.$this->appName.'"';		
				$headers = "Content-Type: text/html; charset = \"UTF-8\";\n";		
				$headers  .= "From:"."=?UTF-8?B?".base64_encode($from_text)."?="."<".$this->adminEmail.">\n";
				$headers .= "MIME-Version: 1.0\n";
				$headers .= "Content-Type: text/html; charset = \"UTF-8\";\n";
				$headers .= "\n";			
				mail($to, $sub, $htmlBody, $headers);		
			}}		
			
			message('Заказ №'.$orderid.' изменен', '', '/admin/orders/showList.php', 'alert-error');
			}		
		}	
			if (	(isset($error)) && (!empty($error))	)
		$smarty->assign('error', $error);
		
		
		
			$sql->query("SELECT * FROM `shop_orders` WHERE `id` = '".$orderid."'", true);
			#echo ("SELECT * FROM `shop_orders` WHERE `id` = '".$orderid."'"	);
			$rowRes = $sql->result;
			
			#print_r($rowRes);
			$rowRes['data'] = json_decode($rowRes['data'], true);
			$smarty->assign('datadata', $rowRes['data']);			
				
				
							
		if ($edit)
			$this->content = $smarty->fetch(api::setTemplate('modules/orders/admin/edit.order.tpl'));
		else 
			$this->content = $smarty->fetch(api::setTemplate('modules/orders/admin/show.order.tpl'));
		
		
	}
	private function adminGetOrderData($orderid){
		global $sql, $smarty;
		$sql->query("SELECT `order_data` FROM `shop_orders` WHERE `id` = '".$orderid."'", true);
		$row = json_decode($sql->result['order_data'], true);		
		$smarty->assign('id', $orderid);		
		$smarty->assign('orderData', $row);		
		return $smarty->fetch(api::setTemplate('modules/orders/admin/order.info.tpl'));	
	}
	
	public function deleteItem($orderid, $itemid){
		global $sql;		
		$sql->query("SELECT `order_data` FROM `shop_orders` WHERE `id` = '".$orderid."'", true);	
		$row = $sql->result;					
		
		$row['order_data'] = json_decode($row['order_data'], true);
		unset($row['order_data'][$itemid]);		
		
		foreach($row['order_data'] as $key => $value){				
			if(is_int($key)){
				$total = $total + $value['total'];					
				$row['order_data']['total'] = $total;
				
				$cost = $total + $row['order_data']['sprice'];
				$row['order_data']['cost'] = $cost;
				
				$row['order_data']['total'] = number_format($row['order_data']['total'], 2, '.',' ');
				$row['order_data']['cost'] = number_format($row['order_data']['cost'], 2, '.',' ');				
			}			
		}
		
		$info = 'Позиция удалена';
		
		if(count($row['order_data']) == 3){
			$row['order_data']['sprice'] = 0;
			$row['order_data']['total'] = 0;
			$row['order_data']['cost'] = 0;
			
			$row['order_data']['total'] = number_format($row['order_data']['total'], 2, '.',' ');
			$row['order_data']['cost'] = number_format($row['order_data']['cost'], 2, '.',' ');	
			$row['order_data']['sprice'] = number_format($row['order_data']['sprice'], 2, '.',' ');			
			
			
			$sql->query("UPDATE `shop_orders` set `state` = '5' WHERE `id` = '".$orderid."'");
			$info = 'Все позиции в заказе удалены заказ переведен в статус "Отменен"';
		}		
		
		$sql->query("UPDATE `shop_orders` set `order_data` = '".addslashes(json_encode($row['order_data']))."' WHERE `id` = '".$orderid."'");				
		$orderData = $this->adminGetOrderData($orderid);
		$array = array('content' => $orderData, 'info' => $info);		
		echo(json_encode($array));		
	}
	
	private function getPayments(){
		
		$expr = '/payment/';		
		if ($handle = opendir('modules/')) {					
			while (false !== ($file = readdir($handle))) { 
				if(preg_match($expr, $file)){
					$payments[]['title'] = $file;					
				}	
			}		
				closedir($handle); 
		}
		
		foreach($payments as $key=>$value){			
			
			if(is_readable('modules/'.$value['title'].'/__classes.php')){
				require_once("modules/".$value['title']."/__classes.php");
			}									
			
			$name[] = $value['title']::$paymentName;		
			$payments[$key]['name'] = $name[$key];
			$payments[$key]['comment'] = $value['title']::$paymentComment;
			$payments[$key]['button'] = $value['title']::$paymentButtonName;
		}	
	
		return $payments;
	}
		
	public function paymentsList(){
        global $sql, $smarty;		        
        $smarty->assign('array', $this->payments);
        $this->content = $smarty->fetch(api::setTemplate('modules/orders/admin/payments.list.tpl'));
    }   

    public function shipmentsList(){
        global $sql, $smarty;
        $sql->query("SELECT * FROM `shop_shipmentstypes`");
        $array = array();
        while ($row = $sql->next_row()) {
            array_push($array, $row);
        }
        $smarty->assign('array', $array);
        $this->content = $smarty->fetch(api::setTemplate('modules/orders/admin/shipments.list.tpl'));
    }

    public function addShipment(){
        global $sql, $smarty;       

        if (isset($this->postArray['go']) && $this->postArray['go'] == 'go') {

            if (!strlen($this->postArray['sname'])) {
                $this->error[] = 'Необходимо ввести наименование вида доставки';
            }

            if (!preg_match('/^[0-9\.\,]+$/', $this->postArray['sprice'])) {
                $this->error[] = 'Поле стоимость доставки может содержать только цифры символ , и символ .';
            } else {
                $price = str_replace(',', '.', $this->postArray['sprice']);
            }

            if (!isset($this->postArray['payment'])) {
                $this->error[] = 'Необходимо выбрать хотя бы один способ оплаты';
            } else {
                $payments = implode(':::', $this->postArray['payment']);
            }

            if (!empty($this->error)) {
                foreach ($this->postArray as $key => $value) {
                    $smarty->assign($key, $value);
                }
            } else {
                $sql->query("INSERT INTO `shop_shipmentstypes` (`sname`, `sprice`, `payment`, `speriod`) VALUES ('" . htmlspecialchars($this->postArray['sname']) . "', '" . $price . "', '" . $payments . "', '" . htmlspecialchars($this->postArray['speriod']) . "')");
                message('Новый способ доставки "' . $this->postArray['sname'] . '" добавлен', '', '/admin/orders/shipmentsList.php', 'alert-success');
            }
        }
		
        $smarty->assign('error', $this->error);
        $smarty->assign('payments', $this->payments);
        $this->content = $smarty->fetch(api::setTemplate('modules/orders/admin/add.shipment.tpl'));
    }

    public function editShipment($id){
        global $sql, $smarty;

        $sql->query("SELECT * FROM `shop_shipmentstypes` WHERE `id` = '" . $id . "'", true);
        if ($sql->num_rows() != 1) {
            page404();
        } else {
            
			foreach ($sql->result as $key => $value) {
                $smarty->assign($key, $value);
                $smarty->assign('payment', explode(':::', $sql->result['payment']));
            }
            
            if (isset($this->postArray['go']) && $this->postArray['go'] == 'go') {

                if (!strlen($this->postArray['sname'])) {
                    $this->error[] = 'Необходимо ввести наименование вида доставки';
                }

                if (!preg_match('/^[0-9\.\,]+$/', $this->postArray['sprice'])) {
                    $this->error[] = 'Поле стоимость доставки может содержать только цифры символ , и символ .';
                } else {
                    $price = str_replace(',', '.', $this->postArray['sprice']);
                }

                if (!isset($this->postArray['payment'])) {
                    $this->error[] = 'Необходимо выбрать хотя бы один способ оплаты';
                } else {
                    $payments = implode(':::', $this->postArray['payment']);
                }

                if (!empty($this->error)) {
                    foreach ($this->postArray as $key => $value) {
                        $smarty->assign($key, $value);
                    }
                } else {
                    $sql->query("UPDATE `shop_shipmentstypes` SET `sname` = '" . htmlspecialchars($this->postArray['sname']) . "', `sprice` ='" . $price . "' , `payment` = '" . $payments . "', `speriod` = '".htmlspecialchars($this->postArray['speriod'])."' WHERE `id` = '".$id."'");
                    message('Cпособ доставки "' . $this->postArray['sname'] . '" изменен', '', '/admin/orders/shipmentsList.php', 'alert-success');
                }
            }

            $smarty->assign('error', $this->error);
            $smarty->assign('payments', $this->payments);
            $this->content = $smarty->fetch(api::setTemplate('modules/orders/admin/edit.shipment.tpl'));
        }
    }

    public function townsList(){
        global $sql, $smarty;

        $sql->query("SELECT * FROM `shop_towns`");
        $array = array();
        while ($row = $sql->next_row()) {
            array_push($array, $row);
        }
        $smarty->assign('array', $array);
        $this->content = $smarty->fetch(api::setTemplate('modules/orders/admin/towns.list.tpl'));
    }

    public function addTown(){
        global $sql, $smarty;
        $sql->query("SELECT * FROM `shop_shipmentstypes`");
        $shipments = array();

        while ($row = $sql->next_row()) {
            array_push($shipments, $row);
        }

        if (isset($this->postArray['go']) && $this->postArray['go'] == 'go') {

            if (!strlen($this->postArray['tname'])) {
                $this->error[] = 'Необходимо ввести название города';
            }

            if (!isset($this->postArray['shipment'])) {
                $this->error[] = 'Необходимо выбрать хотя бы один вид доставки';
            } else {
                $shipment = implode(':::', $this->postArray['shipment']);
            }

            if (!empty($this->error)) {
                foreach ($this->postArray as $key => $value) {
                    $smarty->assign($key, $value);
                }
            } else {
                $sql->query("INSERT INTO `shop_towns` (`tname`, `shipment`) VALUES ('" . htmlspecialchars($this->postArray['tname']) . "', '" . $shipment . "')");
                message('Город "' . $this->postArray['tname'] . '" добавлен', '', '/admin/orders/townsList.php', 'alert-success');
            }

        }

        $smarty->assign('error', $this->error);
        $smarty->assign('shipments', $shipments);
        $this->content = $smarty->fetch(api::setTemplate('modules/orders/admin/add.town.tpl'));
    }

    public function editTown($id){
        global $sql, $smarty;

        $sql->query("SELECT * FROM `shop_towns` WHERE `id` = '" . $id . "'", true);
        if ($sql->num_rows() != 1) {
            page404();
        } else {
            foreach ($sql->result as $key => $value) {
                $smarty->assign($key, $value);
                $smarty->assign('shipment', explode(':::', $sql->result['shipment']));
            }

            $sql->query("SELECT * FROM `shop_shipmentstypes`");
            $shipments = array();

            while ($row = $sql->next_row()) {
                array_push($shipments, $row);
            }

            if (isset($this->postArray['go']) && $this->postArray['go'] == 'go') {

                if (!strlen($this->postArray['tname'])) {
                    $this->error[] = 'Необходимо ввести название города';
                }

                if (!isset($this->postArray['shipment'])) {
                    $this->error[] = 'Необходимо выбрать хотя бы один вид доставки';
                } else {
                    $shipment = implode(':::', $this->postArray['shipment']);
                }

                if (!empty($this->error)) {
                    foreach ($this->postArray as $key => $value) {
                        $smarty->assign($key, $value);
                    }
                } else {
                    $sql->query("UPDATE `shop_towns` set `tname` = '" . htmlspecialchars($this->postArray['tname']) . "', `shipment` = '" . $shipment . "' WHERE `id` = '".$id."'");
                    message('Город "' . $this->postArray['tname'] . '" изменен', '', '/admin/orders/townsList.php', 'alert-success');
                }

            }

            $smarty->assign('townid', $id);
            $smarty->assign('error', $this->error);
            $smarty->assign('shipments', $shipments);
            $this->content = $smarty->fetch(api::setTemplate('modules/orders/admin/edit.town.tpl'));
        }

    }

	public function ordersList(){
		global $smarty, $sql, $basket, $mSecurity, $catalog;
		
		if(Security::$auth == false){
			message("Для просмотра списка заказов необходимо авторизоваться", "", "login", "alert-error");		
		}else{
			
			$sql->query("SELECT `id`, `shipment_id`, `state`, `order_data`, `date`, `payment_id` FROM `shop_orders` WHERE `user_id` = '".Security::$userData['id']."' order by `id` DESC");
			while($sql->next_row_assoc()){				
				$orders[] = $sql->result;				
			}				
			
			if (isset($orders))
			foreach($orders as $key => $value){
				$orders[$key]['order_data'] = json_decode($orders[$key]['order_data'], true);
				$orders[$key]['button'] = $this->getPaymentButton($orders[$key]['payment_id']);
			}						
			if (isset($orders))
			$smarty->assign('orders', $orders);						
			$this->pageTitle = 'Заказы';
			$this->content = $smarty->fetch(api::setTemplate('modules/orders/index/orders.list.tpl'));
		}	
	}
	
	public function showOrder($order_id){
		global $sql, $smarty, $catalog;
		
		if(Security::$auth == false){
			message("Для просмотра списка заказов необходимо авторизоваться", "", "login", "alert-error");		
		}else{
			$sql->query("SELECT * FROM `shop_orders` WHERE `id` = '".$order_id."'", true);			
			if($sql->num_rows() != 1 || $sql->result['user_id'] != Security::$userData['id']) message("Неверный номер заказа", "", "orderslist", "alert-error");
			foreach($sql->result as $key => $value){
				if(!is_int($key)){
					$order[$key] = $value;
				}
			}		
			
			$order['data'] = json_decode($order['data'], true);
			$data = $order['data'];
			$order['order_data'] = json_decode($order['order_data'], true);
			$order['sname'] = $this->getShipmentName($order['shipment_id']);
			$order['sprice'] = $this->getShipmentPrice($order['shipment_id']);
			$order['speriod'] = $this->getShipmentPeriod($order['shipment_id']);
			$order['tname'] = $this->getTownName($order['town_id']);
			$order['pname'] = $this->getPaymentName($order['payment_id']);
			
		
			foreach($order['order_data'] as $key => $value){				
					if(is_int($key)){
						$order['order_data'][$key]['uri'] = '/'.$catalog->getParentGroupUri($value['parent_group_id']).'/'.$value['uri'];								
					}					
			}							
			
			foreach($order as $key => $value){								
					$smarty->assign($key, $value);				
			}						
			
			
			if($order['payment_id'] == 'billpayment'){
				$action = 'Квитанция';
			}elseif($order['payment_id'] == 'cashpayment'){
				$action = 'Счет';
			}			
			
			$smarty->assign('data', $data);
			
			$smarty->assign('action', $action);			
		}		
		
		$this->pageTitle = 'Заказы';		
		$this->content = $smarty->fetch(api::setTemplate('modules/orders/index/show.order.tpl'));
	}
	
	public function discardOrder($orderid){
		global $sql, $smarty, $catalog;
		
		
		
		$sql->query("SELECT * FROM `shop_orders` WHERE `id` = '".$orderid."'", true);					
		if($sql->num_rows() != 1 || $sql->result['user_id'] != Security::$userData['id']){			
			$error = 'Неверный номер заказа';
			$array = array('content' => $error, 'type' => 'alert-error');
		}else{
			$sql->query("UPDATE `shop_orders` SET `state` = '5' WHERE `id` = '".$orderid."'");
			$error = 'Ваш заказ отменен для возобновления заказа нажмите на кнопку "Подтвердить заказ"';
			$array = array('content' => $error, 'type' => 'alert-success');
		}	
		
		echo json_encode($array);
	}
	
	public function renewOrder($orderid){
		global $sql, $smarty, $catalog;		
		
		$sql->query("SELECT * FROM `shop_orders` WHERE `id` = '".$orderid."'", true);					
		if($sql->num_rows() != 1 || $sql->result['user_id'] != Security::$userData['id']){			
			$error = 'Неверный номер заказа';
			$array = array('content' => $error, 'type' => 'alert-error');
		}else{
			$sql->query("UPDATE `shop_orders` SET `state` = '0' WHERE `id` = '".$orderid."'");
			$error = 'Ваш заказ возобновлен';
			$array = array('content' => $error, 'type' => 'alert-success');
		}	
		
		echo json_encode($array);
	}
	
    public function checkout(){
		#print_r($_POST);
		#print_r($_SESSION);
		
        global $smarty, $sql, $basket, $mSecurity, $catalog;					
		
		
		
				
		
		
		
		
		if(Security::$auth==false){
			    

				header('location: /login/');
                				
				if (isset($_POST['discountType'])) 
					$_SESSION['discountType']=$_POST['discountType'];
				if (isset($_POST['discountValue'])) 
					$_SESSION['discountValue']=$_POST['discountValue'];
					
					
            if($basket->getCountOfItems() == 0) message('Ваша корзина заказов пуста', '', '/basket/', 'alert-error');
            $array = $_SESSION['basket'];
			
			if($mSecurity->formType == 'Отображать поля для Физических лиц')
			{
				$smarty->assign('fields', SecurityModule::$fizFields); 
			}elseif($mSecurity->formType == 'Отображать поля для Юридических лиц'){
				$smarty->assign('fields', SecurityModule::$orgFields); 
			}
			
			$form = $smarty->fetch(api::setTemplate('modules/orders/index/checkout.form.tpl'));
			$count = 0;
			foreach($array as $key => $value){
				$groupUri = $catalog->getParentGroupUri($array[$key]['parent_group_id']);
				$array[$key]['uri'] = $groupUri.'/'.$array[$key]['uri'];				
				$array[$key]['total'] =  $array[$key]['price'] * $array[$key]['quantity'];	
				$count+= $array[$key]['quantity'];
				@$total = $total + $array[$key]['total'];
				
				$array[$key]['total'] = number_format($array[$key]['total'], 2, '.',' ');
				@$total = number_format($total, 2, '.',' ');
			}
			
			$smarty->assign('total', $total);
			$smarty->assign('count', $count);
			
			$smarty->assign('form', $form);
			$smarty->assign('basket', $array);
			$this->content = $smarty->fetch(api::setTemplate('modules/orders/index/checkout.unauth.tpl'));
        
		}else{		
			
			
			
				
				if (isset($_POST['discountType'])) 
					$_SESSION['discountType']=$_POST['discountType'];
				if (isset($_POST['discountValue'])) 
					$_SESSION['discountValue']=$_POST['discountValue'];
						
			
            if($basket->getCountOfItems(Security::$userData['id']) == 0) message('Ваша корзина заказов пуста', '', '/basket/', 'alert-error');
            $data = Security::$userData;

            $array = array();
            $sql->query("SELECT * FROM `shop_basket` WHERE `user_id` = '".Security::$userData['id']."'");
            while($row = $sql->next_row()){
                array_push($array, $row);
            }
			
			$total = 0;
			$count = 0;
            foreach($array as $key => $value){
                $groupUri = $catalog->getParentGroupUri($array[$key]['parent_group_id']);
                $array[$key]['uri'] = $groupUri.'/'.$array[$key]['uri'];                
				$array[$key]['total'] =  $array[$key]['price'] * $array[$key]['quantity'];				
                $total = $total + $array[$key]['total'];	
                $count+= $array[$key]['quantity'];
                			
				$array[$key]['total'] = number_format($array[$key]['total'], 2, '.',' ');
				
            }		
            
			$total = number_format($total, 2, '.',' ');
			$smarty->assign('total', $total);
			$smarty->assign('count', $count);
            $smarty->assign('basket', $array);


            foreach($data as $key => $value){
                $smarty->assign($key, $value);
            }

            if($data['org'] == 0 || $data['org'] == 1){

                if(!empty($data['data'])){
                    foreach($data['data'] as $key => $value){
                        foreach(SecurityModule::$fizFields as $key1 => $value1){
                            if($key == $value1['name']){
                                SecurityModule::$fizFields[$key1]['value'] = stripslashes($value);
                            }
                        }
                    }
                }

                $smarty->assign('fields', SecurityModule::$fizFields);
                $form = $smarty->fetch(api::setTemplate('modules/orders/index/checkout.fiz.tpl'));

            }elseif($data['org'] == 2){
                if(!empty($data['data'])){
                    foreach($data['data'] as $key => $value){
                        foreach(SecurityModule::$orgFields as $key1 => $value1){
                            if($key == $value1['name']){
                                SecurityModule::$orgFields[$key1]['value'] = stripslashes($value);
                            }
                        }
                    }
                }

                $smarty->assign('fields', SecurityModule::$orgFields);
                $form = $smarty->fetch(api::setTemplate('modules/orders/index/checkout.org.tpl'));
            }
			
            $smarty->assign('form', $form);

            $sql->query("SELECT * FROM `shop_towns` order by `id` ASC");
			$towns = array();

			while($row = $sql->next_row()){
				array_push($towns, $row);			            
			}

			foreach($towns as $key => $value){
				$towns[$key]['shipment'] = explode(':::',$value['shipment']);	
			}
				
			#print_r($towns);	
            $sql->query("SELECT `shipment` FROM `shop_towns` WHERE `id` = '".$towns[0]['id']."'", true);
            $ships = explode(':::', $sql->result['shipment']);
            $i = 0;
            foreach($ships as $key => $value){
                $sql->query("SELECT * FROM `shop_shipmentstypes` WHERE `id` = '".$value."'", true);
                $shipments[$i] = $sql->result;
                $i++;
            }
			
			if (isset(Security::$userData['addr']))
			  $smarty->assign('addr', Security::$userData['addr']);
			
            $smarty->assign('shipments', $shipments);
            
            $smarty->assign('payments', $this->getPayments());
            
            $shipList = $smarty->fetch(api::setTemplate('modules/orders/index/shipments.tpl'));

            $smarty->assign('shipList', $shipList);
            $smarty->assign('towns', $towns);
			$this->content = $smarty->fetch(api::setTemplate('modules/orders/index/checkout.tpl'));		
		}
		
        $smarty->assign('userdata',security::$userData);

        $this->pageTitle = 'Оформление заказа';
    }
	
	public function registerAndCheckout(){
		global $sql, $smarty, $catalog, $mSecurity;
		$dataArray = array();
		
		$postTmp = explode('&', $_POST['form']);				
		foreach($postTmp as $key=>$value){		
			$ex = explode('=', $value);
			$post[$ex[0]] = urldecode($ex[1]);
		}

        $error = array();
		#if(!strlen($post['surname'])) $error[] = 'Не заполнено поле "Фамилия"';
		if(!strlen($post['name'])) $error[] = 'Не заполнено поле "Имя"';
		#		if(!strlen($post['patronymic'])) $error[] = 'Не заполнено поле "Отчество"';
        if(!strlen($post['email'])) $error[] = 'Не заполнено поле "Email адрес"';
        if(strlen($post['email']) && !preg_match('/^([\w-\.]+)@((?:[\w\-а-я]+\.)+)([a-zа-я]{2,4})$/i', $post['email'])) $error[] = 'Неверно заполнено поле "Email адрес"';
		if(empty($post['phone']) || !preg_match("/^[0-9]{4,13}+$/", $post['phone']))		
		$err[] = 'Неверно заполнено поле телефон';
		
		
		$checkFieldsResult = $mSecurity->checkFields($post);
		$error = array_merge($error, $checkFieldsResult);


        if(empty($error)){		
			
			$sql->query("SELECT * FROM `shop_users` WHERE `email` = '".$post['email']."'", true);
            if($sql->num_rows() > 0){
                $smarty->assign('email', $post['email']);
                $template = $smarty->fetch(api::setTemplate('modules/orders/index/checkout.login.form.tpl'));
                $prArray = array('form' => $template, 'registered' => true);
                echo json_encode($prArray);
            }else{
			
				if($mSecurity->formType == 'Отображать поля для Физических лиц'){
					foreach (SecurityModule::$fizFields as $key => $value){
						$dataArray[$value['name']] = $post[$value['name']];				
					}				
				}elseif($mSecurity->formType == 'Отображать поля для Юридических лиц'){
					foreach (SecurityModule::$orgFields as $key => $value){
						$dataArray[$value['name']] = $post[$value['name']];				
					}
				} 
			
				$dataArray = json_encode($dataArray);			
			
                $pass = genKey(8);

                $sql->query("INSERT INTO `#__#shop_users` (`email`, `password`, `name`, `surname`, `patronymic`, `reg_date`, `org`, `state`, `data`) VALUES
			    ('" . $post['email'] . "', '" . md5($pass) . "', '" . $post['name'] . "', '" . $post['surname'] . "', '" . $post['patronymic'] . "', NOW(), '0', '0', '".addslashes($dataArray)."')");

                $sql->query("SELECT `id` as 'id' FROM `#__#shop_users` WHERE `email` = '" . $post['email'] . "' && `password` ='" .  md5($pass) . "'", true);
                $userId = $sql->result['id'];

                $userSeed = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $userId);
                $sql->query("UPDATE `#__#shop_users` SET `seed` = '" . $userSeed . "' WHERE `id` = '" . $userId . "'");

                $_SESSION['sec_id'] = $userId;

                if(!empty($_SESSION['basket'])){
                    foreach($_SESSION['basket'] as $key => $value){
                        $sql->query("SELECT `quantity` as 'quantity' FROM `shop_basket` WHERE `user_id` = '".$userId ."' AND `item_id` = '".$_SESSION['basket'][$key]['item_id']."'", true);

                        if($sql->num_rows() > 0){
                            $quantity = $sql->result['quantity'] + $_SESSION['basket'][$key]['quantity'];
                            $sql->query("UPDATE `shop_basket` SET `quantity` = '".$quantity."' WHERE `user_id` = '".$userId ."' AND `item_id` = '".$_SESSION['basket'][$key]['item_id']."'");
                        }else{
                            $sql->query("INSERT INTO `shop_basket` (
                                                                    `item_id`,
                                                                    `user_id`,
                                                                    `parent_group_id`,
                                                                    `name`,
                                                                    `price_old`,
                                                                    `price`,
                                                                    `quantity`,
                                                                    `is_hit`,
                                                                    `is_new`,
                                                                    `uri`,
                                                                    `thumb`
                                                                 )
                                                                values (
                                                                '".$_SESSION['basket'][$key]['item_id']."',
                                                                '".$userId."',
                                                                '".$_SESSION['basket'][$key]['parent_group_id']."',
                                                                '".$_SESSION['basket'][$key]['name']."',
                                                                '".$_SESSION['basket'][$key]['price_old']."',
                                                                '".$_SESSION['basket'][$key]['price']."',
                                                                '".$_SESSION['basket'][$key]['quantity']."',
                                                                '".$_SESSION['basket'][$key]['is_hit']."',
                                                                '".$_SESSION['basket'][$key]['is_new']."',
                                                                '".$_SESSION['basket'][$key]['uri']."',
                                                                '".$_SESSION['basket'][$key]['thumb']."')");
                        }
                    }
                    unset($_SESSION['basket']);
									
				}
                
				echo json_encode($error);
				
				$to = $post['email'];	
				$smarty->assign('pass', $pass);								
				$smarty->assign('email', $post['email']);
				$smarty->assign('appName', $this->appName);												
				$smarty->assign('adminEmail', $this->adminEmail);
				$smarty->assign('adminPhone', $this->recipientTel);
				$smarty->assign('sitename', $_SERVER['SERVER_NAME']);
				
				$htmlBody = $smarty->fetch(api::setTemplate("modules/orders/index/mail/registered.tpl"));		
				$subject = 'Поздравляем с успешной регистрацией в интернет магазине "'.$this->appName.'"';		
				$sub = "=?UTF-8?B?".base64_encode($subject)."?=";
				$from_text = 'Администрация интернет-магазина "'.$this->appName.'"';		
				$headers = "Content-Type: text/html; charset = \"UTF-8\";\n";		
				$headers  .= "From:"."=?UTF-8?B?".base64_encode($from_text)."?="."<".$this->adminEmail.">\n";
				$headers .= "MIME-Version: 1.0\n";
				$headers .= "Content-Type: text/html; charset = \"UTF-8\";\n";
				$headers .= "\n";			
				mail($to, $sub, $htmlBody, $headers);
            }
        }else{
            echo json_encode($error);
        }
	}

    public function loginAndCheckout(){
        global $sql, $smarty, $catalog, $mSecurity;

        $postTmp = explode('&', $_POST['form']);
        foreach($postTmp as $key=>$value){
            $ex = explode('=', $value);
            $post[$ex[0]] = urldecode($ex[1]);
        }

        $error = array();

        if(!strlen($post['email'])) $error[] = 'Не заполнено поле "Email адрес"';
        if(strlen($post['email']) && !preg_match('/^([\w-\.]+)@((?:[\w\-а-я]+\.)+)([a-zа-я]{2,4})$/i', $post['email'])) $error[] = 'Неверно заполнено поле "Email адрес"';

        $sql->query("SELECT `password`, `id`, `name` FROM `shop_users` WHERE `email` = '".$post['email']."'", true);

        if($sql->result['password'] != md5($post['password'])){
            $error[] = 'Неверный пароль';
        }else{
            $userId = $sql->result['id'];
            $userSeed = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $userId);
            $sql->query("UPDATE `#__#shop_users` SET `seed` = '" . $userSeed . "' WHERE `id` = '" . $userId . "'");
            $_SESSION['sec_id'] = $userId;

            if(!empty($_SESSION['basket'])){
                foreach($_SESSION['basket'] as $key => $value){
                    $sql->query("SELECT `quantity` as 'quantity' FROM `shop_basket` WHERE `user_id` = '".$userId ."' AND `item_id` = '".$_SESSION['basket'][$key]['item_id']."'", true);

                    if($sql->num_rows() > 0){
                        $quantity = $sql->result['quantity'] + $_SESSION['basket'][$key]['quantity'];
                        $sql->query("UPDATE `shop_basket` SET `quantity` = '".$quantity."' WHERE `user_id` = '".$userId ."' AND `item_id` = '".$_SESSION['basket'][$key]['item_id']."'");
                    }else{
                        $sql->query("INSERT INTO `shop_basket` (
                                                                    `item_id`,
                                                                    `user_id`,
                                                                    `parent_group_id`,
                                                                    `name`,
                                                                    `price_old`,
                                                                    `price`,
                                                                    `quantity`,
                                                                    `is_hit`,
                                                                    `is_new`,
                                                                    `uri`,
                                                                    `thumb`
                                                                 )
                                                                values (
                                                                '".$_SESSION['basket'][$key]['item_id']."',
                                                                '".$userId."',
                                                                '".$_SESSION['basket'][$key]['parent_group_id']."',
                                                                '".$_SESSION['basket'][$key]['name']."',
                                                                '".$_SESSION['basket'][$key]['price_old']."',
                                                                '".$_SESSION['basket'][$key]['price']."',
                                                                '".$_SESSION['basket'][$key]['quantity']."',
                                                                '".$_SESSION['basket'][$key]['is_hit']."',
                                                                '".$_SESSION['basket'][$key]['is_new']."',
                                                                '".$_SESSION['basket'][$key]['uri']."',
                                                                '".$_SESSION['basket'][$key]['thumb']."')");
                    }
                }
                unset($_SESSION['basket']);
            }
        }

        echo json_encode($error);
    }
	
    public function getShipmentsList($townId){
		global $sql, $smarty;
		$sql->query("SELECT `shipment` FROM `shop_towns` WHERE `id` = '".$townId."'", true);
		$ships = explode(':::', $sql->result['shipment']);		
		
		$i = 0;
		foreach($ships as $key => $value){
			$sql->query("SELECT * FROM `shop_shipmentstypes` WHERE `id` = '".$value."'", true);		    
			$shipments[$i] = $sql->result;
			$i++;
		}		
		
		$smarty->assign('shipments', $shipments);
		echo $smarty->fetch(api::setTemplate('modules/orders/index/shipments.tpl'));		
	}
	
	public function getPaymentsList($sId){
		global $sql, $smarty;
	
		$sql->query("SELECT `payment`, `sprice` FROM `shop_shipmentstypes` WHERE `id` = '".$sId."'", true);
		$price = $sql->result['sprice'];
		$payment = explode(':::', $sql->result['payment']);
		
		foreach($payment as $key => $value){
			 foreach($this->payments as $key1 => $value1){
				if($value == $value1['title']){
					$payments[$key] = $value1;					
				}							
			 }
		}

        $sql->query("SELECT `quantity`, `price`  FROM `shop_basket` WHERE `user_id` = '".Security::$userData['id']."'");

        while($sql->next_row()){
            @$price_items = $price_items + $sql->result['quantity'] * $sql->result['price'];
        }

        $cost = $price_items +  $price;
		$cost = number_format($cost, 2, '.',' ');
		
		$smarty->assign('payments', $payments);
		$content = $smarty->fetch(api::setTemplate('modules/orders/index/payments.tpl'));
		$array = array('content' => $content, 'cost' => $cost); 
		
		
		echo (json_encode($array));		
	}
		
	public function confirmOrder(){
		global $sql, $smarty;
		
		$postTmp = explode('&', $_POST['form']);				
		foreach($postTmp as $key=>$value){		
			$ex = explode('=', $value);
			$post[$ex[0]] = urldecode($ex[1]);
		}
		
		$datadata = $post;
        $error = array();
        $checkRes = array();
		
		#if(empty(Security::$userData['surname'])&& empty($post['surname'])) $error[] = 'Не заполнено поле Фамилия';
		if(empty(Security::$userData['name'])&& empty($post['name'])) $error[] = 'Не заполнено поле Имя';
		#if(empty(Security::$userData['patronymic'])&& empty($post['patronymic'])) $error[] = 'Не заполнено поле Отчество';
        
		if(!isset($post['sname'])) $error[] = 'Необходимо выбрать вид доставки';
        if(!isset($post['pname'])) $error[] = 'Необходимо выбрать тип оплаты';


        $error = array_merge($error, $checkRes);       
		
		if(empty($error)){
			
			
			$email = Security::$userData['email'];
			$name = (isset($post['name'])) ? $post['name'] : Security::$userData['name'];
			$surname = (isset($post['surname'])) ? $post['surname'] : Security::$userData['surname'];
			$patronymic = (isset($post['patronymic'])) ? $post['patronymic'] : Security::$userData['patronymic'];
			$user_id = Security::$userData['id'];
			
			$data = addslashes(json_encode($post));		
			
			$sql->query("SELECT `item_id`, `parent_group_id`, `name`, `price`, `quantity`, `uri`, `thumb` FROM `shop_basket` WHERE `user_id` = '".$user_id."'");		
			while($sql->next_row_assoc()){								
				$row[] = $sql->result;					
			}			
			
			foreach ($row as $key => $value){
				$row[$key]['total'] =  $row[$key]['price'] * $row[$key]['quantity'];
                @$total = $total + $row[$key]['total'];				
				$row[$key]['total'] = number_format($row[$key]['total'], 2, '.',' ');		
			}			
			
			$sql->query("SELECT `sprice` FROM `shop_shipmentstypes` WHERE `id` = '".$post['sname']."'", true);
			$sprice = $sql->result['sprice'];
			
			$cost = $sprice + $total;
			
			$sprice = number_format($sprice, 2, '.',' ');
			$total = number_format($total, 2, '.',' ');
			$cost= number_format($cost, 2, '.',' ');
			
			$row['sprice'] = $sprice;
			$row['total'] = $total;		
			$row['cost'] = $cost;		
			
			$order_data = addslashes(json_encode($row));
			$post['town2'] = '';
			$sql->query("INSERT INTO `shop_orders` (`email`, `name`, `surname`, `patronymic`, `user_id`, `user_org`, `town_id`, `shipment_id`, `payment_id`, `state`, `date`, `data`, `order_data`) VALUES ('".$email."','".$name."','".$surname."','".$patronymic."', '".$user_id."','".Security::$userData['org']."','".$post['town2']."','".$post['sname']."','".$post['pname']."','0', NOW(), '".$data."', '".$order_data."')");
			$sql->query("DELETE FROM `shop_basket` WHERE `user_id` = '".$user_id."'");
			
			$sql->query("SELECT `id` FROM `shop_orders` WHERE `user_id` = '".$user_id."' AND `data` = '".$data."' AND `order_data` = '".$order_data."'", true);
			$orderid = $sql->result['id'];
			
			if(empty(Security::$userData['name'])){
					$sql->query("UPDATE `shop_users` SET `name` = '".$name."' WHERE `id` = '".Security::$userData['id']."'");
			}			
			
			if(empty(Security::$userData['surname'])){
					$sql->query("UPDATE `shop_users` SET `surname` = '".$surname."' WHERE `id` = '".Security::$userData['id']."'");
			}
				
			if(empty(Security::$userData['patronymic'])){
					$sql->query("UPDATE `shop_users` SET `patronymic` = '".$patronymic."' WHERE `id` = '".Security::$userData['id']."'");
			}
			
			if(empty(Security::$userData['data'])){
					$sql->query("UPDATE `shop_users` SET `data` = '".$data."', `org` = '1' WHERE `id` = '".Security::$userData['id']."'");
			}				
			
			messageSessOnly('Ваш заказ №'.$orderid.' успешно сформирован. После рассмотрения заказа администрацией интернет-магазина Вы сможете его оплатить.', '', 'alert-success');								
			$error['orderid'] = $orderid;
			
			$shipmentName = $this->getShipmentName($post['sname']);
			$shipmentPeriod = $this->getShipmentPeriod($post['sname']);
			$paymentName = $this->getPaymentName($post['pname']);
			$to = $email;	
			
			$smarty->assign('orderid', $orderid);								
			$smarty->assign('order_data', $row);				
			$smarty->assign('shipmentName', $shipmentName);	
			$smarty->assign('shipmentPrice', $sprice);	
			$smarty->assign('shipmentPeriod', $shipmentPeriod);
			$smarty->assign('paymentName', $paymentName);

			$smarty->assign('total', $total);	
			$smarty->assign('cost', $cost);				
			
			$smarty->assign('appName', $this->appName);												
			$smarty->assign('adminEmail', $this->adminEmail);
			$smarty->assign('adminPhone', $this->recipientTel);
			$data = json_decode($data,true);
			
			$smarty->assign('datadata', $datadata);
			$smarty->assign('sitename', $_SERVER['SERVER_NAME']);
				
			$htmlBody = $smarty->fetch(api::setTemplate("modules/orders/index/mail/order.confirmed.tpl"));		
			
			$subject = 'Ваш заказ №'.$orderid.' принят в интернет-магазине "'.$this->appName.'"';		
			$sub = "=?UTF-8?B?".base64_encode($subject)."?=";
			$from_text = 'Администрация интернет-магазина "'.$this->appName.'"';		
			$headers = "Content-Type: text/html; charset = \"UTF-8\";\n";		
			$headers  .= "From:"."=?UTF-8?B?".base64_encode($from_text)."?="."<".$this->adminEmail.">\n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: text/html; charset = \"UTF-8\";\n";
			$headers .= "\n";	
				#print_r($datadata);
				#echo $htmlBody;
			mail($to, $sub, $htmlBody, $headers);			
		}
		
		echo (json_encode($error));
	}

    public function bill($order_id){
		global $sql, $smarty;
		
		$sql->query("SELECT * FROM `shop_orders` WHERE `id` = '".$order_id."'", true);
		if($sql->num_rows() != 1 || $sql->result['user_id'] != Security::$userData['id']) message("Неверный номер заказа", "", "orderslist", "alert-error");		 
		
		if($sql->result['state'] == 5) message("Заказ отменен", "", "order?order_id=".$order_id, "alert-error");		 
		
		$payment_id = $sql->result['payment_id'];	
		$shipment_id = 	$sql->result['shipment_id'];
		
		if(is_readable('modules/'.$payment_id.'/__classes.php')){
			require_once("modules/".$payment_id."/__classes.php");
			$bill = new $payment_id ();						
			
			
			if($payment_id == 'sberbankpayment' || $payment_id = 'cashpayment'){
								
				$name = $sql->result['name'];
				$surname = $sql->result['surname'];
				$patronymic = $sql->result['patronymic'];				
				$date = $sql->result['date'];
				$biilnum = $sql->result['id'];
				
				$orderData = json_decode($sql->result['order_data'],true);			
				
				if($sql->result['user_org'] == 0 || $sql->result['user_org'] == 1){
					$data = json_decode($sql->result['data'], true);
					if (isset($data['adress_fiz']))
						$adress = $data['adress_fiz']; 
				}					
				
				$sql->query("SELECT `sprice`, `sname` FROM `shop_shipmentstypes` WHERE `id` = '".$shipment_id."'", true);
				$sprice = $sql->result['sprice'];
				$sname = $sql->result['sname'];
				
				$dataArray = array(	'recipient' => $this->recipient,
									'recipientAdr' => $this->recipientAdr,
									'recipientTel' => $this->recipientTel,
									'recipientINN' => $this->recipientINN,
									'recipientKPP' => $this->recipientKPP,
									'account' => $this->account,
									'korAccount' => $this->korAccount,
									'bik' => $this->bik,
									'bankInn' => $this->bankInn,
									'name' => $name,
									'surname' => $surname,
									'patronymic' => $patronymic,
																		
									'order_data' => $orderData,
									'payment' => 'Оплата заказа №'.$order_id,
									'sprice' => $sprice,
									'sname' => $sname,
									'date' => $date,
									'billnum' => $biilnum,
							);
			
				$this->content = $bill->start($dataArray);
			}else{
				$this->content = $bill->start();
			}			
		}else{
			message("Системная ошибка, пожалуйста сообщите администратору сайта", "", "orderslist", "alert-error");		 
		}		
		
		$this->template = 'print.html';
	}
	
	private function fizCheck($array){
        $result = array();
        foreach (Orders::$fizFields as $key => $value){
            
			if($value['required'] == 1 && !strlen($array[$value['name']]) && empty(Security::$userData['data'][$value['name']])){
                $result[] = "Не заполнено обязательное поле ".$value['description'];
            }

            if(strlen($array[$value['name']]) && $value['length'] > 0 && strlen($array[$value['name']]) != $value['length']){
                $result[] = "Неверная длина значения ".$value['description'];
            }

            if((!empty($value['mask']) && strlen($array[$value['name']])) && !preg_match($value['mask'], $array[$value['name']])){
                $result[] = "Неверно заполнено Поле ".$value['description'];
            }
        }
        return $result;

    }

    private function adminOrgCheck($array){
        $result = array();
        foreach (Orders::$orgFields as $key => $value){
            
			if($value['required'] == 1 && !strlen($array[$value['name']])){
                $result[] = "Не заполнено обязательное поле ".$value['description'];
            }

            if(strlen($array[$value['name']]) && $value['length'] > 0 && strlen($array[$value['name']]) != $value['length']){
                $result[] = "Неверная длина значения ".$value['description'];
            }

            if((!empty($value['mask']) && strlen($array[$value['name']])) && !preg_match($value['mask'], $array[$value['name']])){
                $result[] = "Поле ".$value['description'];
            }
        }
        return $result;
    }
	
	
	private function orgCheck($array){
        $result = array();
        foreach (Orders::$orgFields as $key => $value){
            if($value['required'] == 1 && !strlen($array[$value['name']]) && empty(Security::$userData['data'][$value['name']])){
                $result[] = "Не заполнено обязательное поле ".$value['description'];
            }

            if(strlen($array[$value['name']]) && $value['length'] > 0 && strlen($array[$value['name']]) != $value['length']){
                $result[] = "Неверная длина значения ".$value['description'];
            }

            if((!empty($value['mask']) && strlen($array[$value['name']])) && !preg_match($value['mask'], $array[$value['name']])){
                $result[] = "Поле ".$value['description'];
            }
        }
        return $result;
    }
	
	private function getShipmentName($sid){
		global $sql;
		$sql->query("SELECT `sname` FROM `shop_shipmentstypes` WHERE `id` = '".$sid."'", true);		
		return $sql->result['sname'];
	}
	
	private function getTownName($tid){
		global $sql;
		$sql->query("SELECT `tname` FROM `shop_towns` WHERE `id` = '".$tid."'", true);		
		return $sql->result['tname'];
	}
	
	private function getPaymentName($pid){
		global $sql;
		foreach($this->payments as $key => $value){
			if($value['title'] == $pid) $pname = $value['name'];
		}		
		return $pname;
	}
	
	private function getPaymentButton($pid){
		global $sql;
		foreach($this->payments as $key => $value){
			if($value['title'] == $pid) $pbutton = $value['button'];
		}		
		return $pbutton;
	}
	
	private function getShipmentPrice($sid){
		global $sql;
		$sql->query("SELECT `sprice` FROM `shop_shipmentstypes` WHERE `id` = '".$sid."'", true);		
		return $sql->result['sprice'];
	}
	
	private function getShipmentPeriod($sid){
		global $sql;
		$sql->query("SELECT `speriod` FROM `shop_shipmentstypes` WHERE `id` = '".$sid."'", true);		
		return $sql->result['speriod'];
	}
	
	function __construct(){
        global $mSecurity;

        Orders::$fizFields = SecurityModule::$fizFields;
        Orders::$orgFields = SecurityModule::$orgFields;

        if (isset($_POST) && !empty($_POST)) {
            $this->postArray = api::slashData($_POST);
        }
		
		$this->payments = $this->getPayments();
		
		/* Название интернет-магазина для писем с уведомлениями */
		$cfgValue = api::getConfig("modules", "orders", "appName");
        $this->appName = ($cfgValue != "") ? $cfgValue : $this->appName;
		
		/* Получатель для выписки счета */
		$cfgValue = api::getConfig("modules", "orders", "recipient");
        $this->recipient = ($cfgValue != "") ? $cfgValue : $this->recipient;
		
		/* Адрес получателя для выписки счета */
		$cfgValue = api::getConfig("modules", "orders", "recipientAdr");		
		$this->recipientAdr = ($cfgValue != "") ? $cfgValue : $this->recipientAdr;
	
		/* Телефон получателя для выписки счета */
		$cfgValue = api::getConfig("modules", "orders", "recipientTel");
		$this->recipientTel = ($cfgValue != "") ? $cfgValue : $this->recipientTel;		
		
		/* ИНН получатель для выписки счета */
		$cfgValue = api::getConfig("modules", "orders", "recipientINN");
        $this->recipientINN = ($cfgValue != "") ? $cfgValue : $this->recipientINN;
		
		/* КПП получатель для выписки счета */
		$cfgValue = api::getConfig("modules", "orders", "recipientKPP");
        $this->recipientKPP = ($cfgValue != "") ? $cfgValue : $this->recipientKPP;
		
		/* Расчетный счет получателя для выписки счета */
		$cfgValue = api::getConfig("modules", "orders", "account");
        $this->account = ($cfgValue != "") ? $cfgValue : $this->account;
		
		/* Кор. счет получателя для выписки счета */
		$cfgValue = api::getConfig("modules", "orders", "korAccount");
        $this->korAccount = ($cfgValue != "") ? $cfgValue : $this->korAccount;
		
		/* БИК для выписки счета */
		$cfgValue = api::getConfig("modules", "orders", "bik");
        $this->bik = ($cfgValue != "") ? $cfgValue : $this->bik;
		
		/* ИНН Банка для выписки счета */
		$cfgValue = api::getConfig("modules", "orders", "bankInn");
        $this->bankInn = ($cfgValue != "") ? $cfgValue : $this->bankInn;
		
		/* Email админстратора */
		$cfgValue = api::getConfig("modules", "orders", "adminEmail");
        $this->adminEmail = ($cfgValue != "") ? $cfgValue : $this->adminEmail;

		$cfgValue = api::getConfig("modules", "orders", "defTemplate");
        $this->template = ($cfgValue != "") ? $cfgValue : $this->template;		

    }
}

?>
