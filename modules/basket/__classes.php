<?php
/**
 * O_o
 *
 * @author San
 */
class Basket
{

    public $useCountOfItems = 1;
    public $template = 'index.html';
    public $content = '';
    public $pageTitle = 'Корзина';
    public $countOfItems = 0;
    public $countType = '';


    public static $arrCommands = array (    array("uri" => "basket"),
                                            array("uri" => "addgood"),
                                            array("uri" => "removegood"),
                                            array("uri" => "confirm"),                                            
											array("uri" => "remove"),
											array("uri" => "update"),
                                            array("uri" => "updamount"),
                                            array("uri" => "delformcart"),
                                            array("uri" => "totalitems"),
                                            array("uri" => "totalbill"),
                                        );    
	
	private $postArray = array();

    public function config(){
        global $smarty, $sql;	
		
		$array = config::getConfigFromIni('basket');		
		foreach($array as $key => $value){			
			$confValue = api::getConfig("modules", "basket", $key);						
			$array[$key]['value'] = $confValue;
			if($key == 'defTemplate'){
				$array[$key]['options'] = api::getTemplatesList();
			}	
		}		
		
		if(isset($_POST['go']) && $_POST['go'] == 'go'){			
			foreach($_POST as $key => $value){
				$cfgValue = api::getConfig("modules", "basket", $key);				
				if(empty($cfgValue) && $key !='go'){
					$sql->query("INSERT INTO `#__#config` (`category`, `type`, `name`, `value`, `lang`) VALUES ('modules', 'basket', '".$key."', '".htmlspecialchars($value)."', 'ru')");					
				}else{
					$sql->query("UPDATE `#__#config` SET  `value` = '".htmlspecialchars($value)."' WHERE `category` = 'modules' AND `type` = 'basket' AND `name` = '".$key."'");					
				}
			}		
		}
		
        $smarty->assign('moduleName', 'Корзина');
		$smarty->assign('module', 'basket');
		$smarty->assign('confArray', $array);
        $this->content = $smarty->fetch(api::setTemplate('modules/admin/config.tpl'));	
		return true;
    }    

    public static function installModule () {
	
        $router = api::object_from_file("chache/router.txt");
        $router['basket'] = Basket::$arrCommands;
        api::object2file ($router, 'chache/router.txt');                
        return true;
    }
	
	public function adminShowList(){
		$this->content = 'Список неподтвержденных заказов';
	}

    public function add(){
        global $sql;
		 
        $postQuantity = intval($this->postArray['quantity']);

        $array = array();
        $sql->query("SELECT `id`,`name`, `price_old`, `is_hit`, `is_new`, `parent_group_id`, `uri`, `item_id`, `article`, `remains` FROM `shop_items` WHERE `id` = '".intval($this->postArray['id'])."'", true);

        foreach($sql->result as $key => $value){
            if(!is_int($key)){
                $array[$key] = $value;
            }
        }
        $item_name = $sql->result['name'];
        $item_id = $sql->result['item_id'];
        $sql->query("SELECT `value` FROM `#__#shop_prices` WHERE `item_id` = '".$item_id."'", true);
        $array['price'] = $sql->result['value'];
        
		if(!($array['remains']>=$postQuantity)) die(json_encode(array('error'=>'Данный товар отсутствует на складе')));
		if(!($array['price']>0)) 				die(json_encode(array('error'=>'Невозможно добавить товар: отсутствует цена')));
		
		
		
		
		
		
        $sql->query("SELECT `thumb` FROM `#__#shop_itemimages` WHERE `item_id` = '".$item_id."'", true);
        $array['thumb'] = $sql->result['thumb'];

        if (Security::$auth==true) {
            $userId = Security::$userData['id'];
            $this->addAuth($array, $postQuantity, $item_id);
            $count = $this->getCountOfItems($userId);
        }else{
            $this->addUnauth($array, $postQuantity);
            $count = $this->getCountOfItems();
        }
        
        $tot = $this->getTotal();
		$array = array();
        $array['success'] = "Товар {$item_name} успешно добавлен!";
		$array['total'] = "Товаров: {$count}  - <strong>{$tot} руб.</strong>";
        
        
        $sql->query("update  shop_items set remains = remains - ".$postQuantity." WHERE `item_id` = '".$item_id."'");        
		echo json_encode ($array); 
        
        
//        echo $count;
       
    }


    /**
     * Добавление товаров в корзину с авторизацией
     *
     * @param $array
     * @param $postQuantity
     * @return bool
     */

    private function addAuth($array, $postQuantity, $item_id){
        global $sql;

        $sql->query("SELECT `quantity` FROM `#__#shop_basket` WHERE `item_id` = '".$item_id."' AND `user_id` = '".$_SESSION['sec_id']."'", true);
        if($sql->num_rows() > 0){
            $qty = $sql->result['quantity'] + $postQuantity;
            $sql->query("UPDATE `#__#shop_basket` SET `quantity` = '".$qty."' WHERE `item_id` = '".$item_id."' AND `user_id` = '".$_SESSION['sec_id']."'");
        }else{
            $sql->query("INSERT INTO `#__#shop_basket` (`item_id`, `user_id`, `parent_group_id`, `name`, `price_old`, `price`, `quantity`, `is_hit`, `is_new`, `uri`, `thumb`) VALUES ( '".$array['item_id']."', '".$_SESSION['sec_id']."', '".$array['parent_group_id']."', '".$array['name']."', '".$array['price_old']."', '".$array['price']."', '".$postQuantity."', '".$array['is_hit']."', '".$array['is_new']."', '".$array['uri']."', '".$array['thumb']."')");
        }

    return true;
    }

    /**
     * Добавление товаров в корзину без авторизации
     *
     * @param $array
     * @param $postQuantity
     * @return bool
     */

    private function addUnauth($array, $postQuantity){
        if(!isset($_SESSION['basket'])){
            $array['quantity'] = $postQuantity;
            $_SESSION['basket'][$array['item_id']] = $array;
        }else{
            if(isset($_SESSION['basket'][$array['item_id']])){
                $_SESSION['basket'][$array['item_id']]['quantity'] = $_SESSION['basket'][$array['item_id']]['quantity'] + $postQuantity;
            }else{
                $array['quantity'] = $postQuantity;
                $_SESSION['basket'][$array['item_id']] = $array;
            }
        }
        return true;
    }

    public function show(){
		
		if (isset($_SESSION['discountType'])) 	unset($_SESSION['discountType']);
		if (isset($_SESSION['discountValue'])) 	unset($_SESSION['discountValue']);
		
		
				
        global $sql, $smarty, $catalog;
        
        if (isset(Security::$userData['discount']))
			  $smarty->assign('discount', Security::$userData['discount']);
      
        
        
        if(Security::$auth == true){
            $array = array();
            $sql->query("SELECT * FROM `shop_basket` WHERE `user_id` = '".Security::$userData['id']."'");
          
         
          $array = $sql->getList();
          
           # while($row = $sql->next_row()){
           #     array_push($array, $row);
           # }
           # die(Security::$userData['id']);
        }else{
			
            $array = ((isset($_SESSION['basket'])) ? $_SESSION['basket'] : array());
        } 
		
        $w = 0;
		foreach ($array as &$i)
		{
			if(!isset($i['item_id'])){
                unset($array[$w]);
                $i++;
                continue;
            }
			$sql->query("SELECT shop_itemimages.* FROM `shop_itemimages` 
			 
			
			where
			`item_id` = '".$i['item_id']."'",true);
			#echo ("SELECT * FROM `shop_itemimages` WHERE `item_id` = '".$i['item_id']."'");
			#echo '<br>';
			$i['images'] = $sql->result;
            $w++;
		}		
		
		
	

		
		foreach ($array as $key => $i)
		{	
			#print_r
			if(isset($i['item_id'])) 
			$sql->query("SELECT
			
			`shop_groups`.`uri` as uri1, 
			`shop_items`.`uri` as uri2	
			
			FROM `shop_items` 
			
			
			left join shop_groups
			on 	shop_items.parent_group_id = shop_groups.group_id

			
			
			where
			shop_items.`item_id` = '".$i['item_id']."'",true);
		#	print_r($sql->result);
		#	die($sql->result);
			$array[$key]['inf'] = $sql->result;
		}
		#print_r($array);
		
		$total = 0;
		
        foreach($array as $key => $value){
            
             
          #if($key == '')                continue;  
		  if (1)
		  {
          $groupUri = $catalog->getParentGroupUri($array[$key]['parent_group_id']);
          $array[$key]['uri'] = $groupUri.'/'.$array[$key]['uri'];		  
		  $array[$key]['total'] =  $array[$key]['price'] * $array[$key]['quantity'];		  		  
          $total = $total + $array[$key]['total'];		  
		  $array[$key]['total'] = number_format($array[$key]['total'], 2, '.',' ');		
		  }
		  else unset ($array[$key]);  
        }		
      #  print_r($array);
		$total = number_format($total, 2, '.',' ');
        $smarty->assign('array', $array);
        $smarty->assign('total', $total);
        $this->content = $smarty->fetch(api::setTemplate('modules/basket/index/basket.tpl'));
        return $this->content;
    }
    
    
    public function getTotal(){
        global $sql, $smarty, $catalog;
        if(Security::$auth == true){
            $array = array();
            $sql->query("SELECT * FROM `shop_basket` WHERE `user_id` = '".Security::$userData['id']."'");
            while($row = $sql->next_row()){
                array_push($array, $row);
            }

        }else{
            $array = ((isset($_SESSION['basket'])) ? $_SESSION['basket'] : array());
        }
		
		$total = 0;
		
		foreach ($array as $item)
		{		
				#echo $item['price'];
				$total+=((!empty($item['price']))? ($item['price']*$item['quantity']):0);
		}
		
		#echo $total;
       /* foreach($array as $key => $value){
          #$groupUri = $catalog->getParentGroupUri($array[$key]['parent_group_id']);
          $array[$key]['uri'] = $groupUri.'/'.$array[$key]['uri'];		  
		  $array[$key]['total'] =  $array[$key]['price'] * $array[$key]['quantity'];		  		  
          $total = $total + $array[$key]['total'];		  
		  $array[$key]['total'] = number_format($array[$key]['total'], 2, '.',' ');		  
        }
        */		
		$total = number_format($total, 2, '.',' ');
       
       return $total;
    }

    public function updamount(){
        global $sql;

        if(!empty($_POST['id'])){
          $quantity = intval($this->postArray['quantity']);
		  if($quantity == 0 || $quantity < 0){$quantity = 1;}
		  $sql->query("select remains from shop_items where item_id = '".$_POST['id']."' limit 1", true);
		  $remains  = $sql->result['remains'];
			
		  
		  if(Security::$auth==true){              			  
			  #$sql->query("UPDATE `#__#shop_items` SET `quantity` = '".$quantity."' WHERE `item_id` = '".$_POST['id']."' AND `user_id` = '".Security::$userData['id']."'");
			  $sql->query("select quantity from `#__#shop_basket` WHERE `item_id` = '".$_POST['id']."' AND `user_id` = '".Security::$userData['id']."' limit 1",true);
			  $basket_quantity=$sql->result['quantity'];
			  $dif = $quantity-$basket_quantity;
			  if ($dif>$remains) die(json_encode(array('error'=>'Запрашиваемое вами количество товаров отсутствует на складе')));
			  
			  $sql->query("UPDATE `#__#shop_basket` SET `quantity` = '".$quantity."' WHERE `item_id` = '".$_POST['id']."' AND `user_id` = '".Security::$userData['id']."'");

			 echo json_encode(array('success'=>'ok'));
          }else{
			$basket_quantity=$_SESSION['basket'][$this->postArray['id']]['quantity'];
			$dif = $quantity-$basket_quantity;
            if ($dif>$remains) die(json_encode(array('error'=>'Запрашиваемое вами количество товаров отсутствует на складе')));
            
            $_SESSION['basket'][$this->postArray['id']]['quantity'] = $quantity;
            echo json_encode(array('success'=>'ok'));
          }
          $sql->query("UPDATE `#__#shop_items` SET `remains` = `remains` - ".$dif." WHERE `item_id` = '".$_POST['id']."'");

			
        }
        
        
       # sql->query("update  shop_items set remains = remains - ".$postQuantity." WHERE `item_id` = '".$item_id."'", true);        
    }

    public function delformcart(){
        global $sql;

        if(!empty($_POST['id'])){
            if(Security::$auth==true){
                $sql->query("select quantity FROM `#__#shop_basket` WHERE `item_id` = '".$this->postArray['id']."' AND `user_id` = '".Security::$userData['id']."'",true);
        //        echo "select quantity FROM `#__#shop_basket` WHERE `item_id` = '".$this->postArray['id']."' AND `user_id` = '".Security::$userData['id']."'";
               //echo $_POST['id']."<br>";
       //     print_r($sql->result);
                $q = $sql->result['quantity'];
         //          die($q);
                $sql->query("DELETE FROM `#__#shop_basket` WHERE `item_id` = '".$this->postArray['id']."' AND `user_id` = '".Security::$userData['id']."'");
                $array = array('content' => $this->show(), 'amount' => $this->getCountOfItems(Security::$userData['id']));
            }else{
				#print_r($_SESSION);
				 $q =    $_SESSION['basket'][$_POST['id']]['quantity'];
                unset($_SESSION['basket'][$this->postArray['id']]);
                $array = array('content' => $this->show(), 'amount' => $this->getCountOfItems());
            }
            $sql->query("UPDATE `#__#shop_items` SET `remains` = `remains` + ".$q." WHERE `item_id` = '".$this->postArray['id']."'");

            echo json_encode($array);
        }
    }

    public function remove(){
       global $sql;
       $sql->query("SELECT `item_id` FROM `shop_items` WHERE `id` = '".intval($this->postArray['id'])."'", true);

    }

    public function getCountOfItems($userId=''){
        global $sql;
        $result = 0;
        
		if($this->countType == 'Количества товаров в позициях'){
            if(Security::$auth == true){
              $sql->query("SELECT SUM(`quantity`) as 'qty' FROM `shop_basket` WHERE `user_id` = '".Security::$userData['id']."'", true);
              $result = $result + $sql->result['qty'];
            }else{
                if(isset($_SESSION['basket'])){
                    foreach($_SESSION['basket'] as $key => $value){
                        @$result = $result + $value['quantity'];
                    }
                }
            }
        }elseif($this->countType == 'Количества позиций'){
            if(Security::$auth == true){
                $sql->query("SELECT count(`quantity`) as 'qty' FROM `shop_basket` WHERE `user_id` = '".Security::$userData['id']."'", true);
                $result = $sql->result['qty'];
            }else{
                 @$result = count($_SESSION['basket']);
            }
        }
        return $result;
    }
    



    function __construct($file = '')
    {
        global $config;

        $this->useCountOfItems = $config->getValue('basket', 'confArray', 'useCountOfItems');


        $cfgValue = api::getConfig("modules", "basket", "countOfItems");
        $this->countType = ($cfgValue != "") ? $cfgValue : '';

        
        if (isset($_POST) && !empty($_POST)) {
            $this->postArray = api::slashData($_POST);
        }

        $cfgValue = api::getConfig("modules", "basket", "defTemplate");
        #$this->template = ($cfgValue != "") ? $cfgValue : $this->template;
        $this->template = 'basket.html';
        
        



    }
}

?>
