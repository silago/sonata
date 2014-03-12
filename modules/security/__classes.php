<?php


require('__model.php');
/**
 * O_o
 *
 * @author San
 */
class SecurityModule
{

    private static $passCheck = "/^[a-z0-9]+$/i";
    private static $passLength = 6;
	private $data = array();
    private $appName = 'Сонета';
    private $adminEmail = 'admin@soneta.ru';    
    public $redirectAfterRegister = 'index';
    public $error = array();

    public static $orgFields = array(
                                    array('name' => 'name_org', 'type' => 'text', 'description'=>'Название организации', 'value' => '', 'required' => 1, 'length' =>'0'),
                                    array('name' => 'adress_org', 'type' => 'text', 'description'=>'Адрес организации', 'value' => '', 'required' => 1, 'length' =>'0'),
                                    #array('name' => 'phone_org', 'type' => 'text', 'description'=>'Телефон организации', 'value' => '', 'required' => 0, 'mask'=>'/^[\+]{0,1}[0-9]{1,}[0-9\-\(\)]+$/ui', 'length' =>'0'),
                                    array('name' => 'inn_org', 'type' => 'text', 'description'=>'ИНН', 'value' => '', 'required' => 1, 'mask'=>'/^[0-9]+$/ui', 'length' => '10'),
                                    array('name' => 'kpp_org', 'type' => 'text', 'description'=>'КПП', 'value' => '', 'required' => 1, 'mask'=>'/^[0-9]+$/ui', 'length' => '9'),
                                    array('name' => 'account_org', 'type' => 'text', 'description'=>'№ счета организации', 'value' => '', 'required' => 0, 'mask'=>'/^[0-9]+$/ui', 'length' => '20', ),
                                    array('name' => 'bank_org', 'type' => 'text', 'description'=>'Банк', 'value' => '', 'required' => 0, 'length' =>'0'),
                                    array('name' => 'bik_org', 'type' => 'text', 'description'=>'БИК', 'value' => '', 'required' => 0, 'mask'=>'/^[0-9]+$/ui', 'length' => '9'),
                                    array('name' => 'account_bank_org', 'type' => 'text', 'description'=>'№ счета банка', 'value' => '', 'required' => 0, 'mask'=>'/^[0-9]+$/ui', 'length' => '20'),
    );

    public static $fizFields = array(
       # array('name' => 'birthday', 'type' => 'text', 'description' => 'Дата рождения', 'value' => '', 'required' => 1, 'length' =>'0', 'showInOrder' => '0'),
	#	array('name' => 'adressFact', 'type' => 'description', 'description' => 'Фактический адрес проживания', 'value' => '', 'required' => 0, 'length' =>'0', 'showInOrder' => '0'),
		#array('name' => 'adressFactTown', 'type' => 'text', 'description' => 'Город', 'value' => '', 'required' => 1, 'length' =>'0', 'showInOrder' => '0'),
		#array('name' => 'adressFactAdress', 'type' => 'text', 'description' => 'Адрес', 'value' => '', 'required' => 1, 'length' =>'0', 'showInOrder' => '0'),
		#array('name' => 'adressLegal', 'type' => 'description', 'description' => 'Юридический адрес проживания', 'value' => '', 'required' => 0, 'length' =>'0', 'showInOrder' => '0'),
		#array('name' => 'adressLegalTown', 'type' => 'text', 'description' => 'Город', 'value' => '', 'required' => 1, 'length' =>'0', 'showInOrder' => '0'),
		#array('name' => 'adressLegalAdress', 'type' => 'text', 'description' => 'Адрес', 'value' => '', 'required' => 1, 'length' =>'0', 'showInOrder' => '0'),		
        #array('name' => 'phone', 'type' => 'text', 'description' => 'Телефон', 'value' => '', 'required' => 1, 'length' =>'0', 'mask'=>'/^[\+]{0,1}[0-9]{1,}[0-9\-\(\)]+$/ui', 'showInOrder' => '0'),
		#array('name' => 'registrationPurpose', 'type' => 'select', 'description' => 'Цель регистрации', 'value' => '', 'required' => 1, 'length' =>'0', 'showInOrder' => '0', 'options' => array('0' => 'Покупка косметики', '1' => 'Продажа знакомым', '2'=>'Ведение бизнеса')),

    );

    private $postArray = array();
    /**
     * Путь к файлу шаблона
     * @var String
     */
    public $template = '';


    /**
     * Тип вывода формы
     * @var string
     */
    public $formType = '';

    /**
     * Финальный контент помещается в эту переменную (Если не ajax вызов)
     * @var String
     */
    public $content = '';

    /* USER SECTION */

    /**
     * Вывод поля "Авторизация"
     */
    
	public function config(){
        global $smarty, $sql;
        
		$array = config::getConfigFromIni('security');
		
		foreach($array as $key => $value){			
			$confValue = api::getConfig("modules", "security", $key);						
			$array[$key]['value'] = $confValue;
			
			if($key == 'defTemplate'){
				$array[$key]['options'] = api::getTemplatesList();
			}			
		}			
		
		if(isset($_POST['go']) && $_POST['go'] == 'go'){			
			foreach($_POST as $key => $value){
				$cfgValue = api::getConfig("modules", "security", $key);				
				if(empty($cfgValue) && $key !='go'){
					$sql->query("INSERT INTO `#__#config` (`category`, `type`, `name`, `value`, `lang`) VALUES ('modules', 'security', '".$key."', '".htmlspecialchars($value)."', 'ru')");					
				}else{
					$sql->query("UPDATE `#__#config` SET  `value` = '".htmlspecialchars($value)."' WHERE `category` = 'modules' AND `type` = 'security' AND `name` = '".$key."'");					
				}
			}		
		message('Настройки изменены', '', '/admin/security/config.php', 'alert-success');
		}
		
        $smarty->assign('moduleName', 'Пользователи');
		$smarty->assign('module', 'security');
		$smarty->assign('confArray', $array);
        $this->content = $smarty->fetch(api::setTemplate('modules/admin/config.tpl'));	
		return true;
    }	
	public function restorePass($email=false, $token=false)
	{
	global $smarty, $sql;
	if ((isset($_GET['url'])))	$_SESSION['HTTP_REFERER'] = urldecode($_GET['url']);
	#print_r($_SESSION);
	#print_r($_GET);
	#die('s');
	$salt='=(';
		#print_r($_POST);
		#if (!isset($_POST['email'])) echo 1;	
			if ((!isset($_POST['email'])) && (!isset($_GET['token'])))
				{
				if (!isset($_SESSION['HTTP_REFERER']))	$_SESSION['HTTP_REFERER']=$_SERVER['HTTP_REFERER'];
				
		
				$this->tpl->assign('step', '1');
				$template = $this->tpl->fetch(api::setTemplate('modules/security/index/restore.tpl'));
				$this->pageTitle = 'Персональная информация';
				$this->content=$template;	
				}
				else
				if (!isset($_GET['token']))
				{	#echo '1';
					
                    $sql->query('select * from shop_shop where email="'.$_POST['email'].'"',true);
                    if ($sql->result==false)
                    {
                    	$this->pageTitle = 'Персональная информация';
                        $this->content='Пользователь с данным email не найден';
                        return false;
                    }
					
					$htmlBody = " для востановления пароля перейдите по  <a href='".$this->appName."/forgotpass?token=".md5(md5($salt).md5($_POST['email']))."&mail=".$_POST['email']."&url=".urlencode($_SESSION['HTTP_REFERER'])."'> Cсылке </a>";	
					$subject = 'Востановление пароля в интернет магазине "Универсам «Удача»"';		
					$sub = "=?UTF-8?B?".base64_encode($subject)."?=";
					$from_text = 'Администрация интернет-магазина "'.$this->appName.'"';		
					$headers = "Content-Type: text/html; charset = \"UTF-8\";\n";		
					$headers  .= "From:"."=?UTF-8?B?".base64_encode($from_text)."?="."<".$this->adminEmail.">\n";
					$headers .= "MIME-Version: 1.0\n";
					$headers .= "Content-Type: text/html; charset = \"UTF-8\";\n";
					$headers .= "\n";			
					mail($_POST['email'], $sub, $htmlBody, $headers);
					
					
				$this->tpl->assign('step', '2');
				$template = $this->tpl->fetch(api::setTemplate('modules/security/index/restore.tpl'));
				$this->pageTitle = 'Персональная информация';
				$this->content=$template;	
				}
				
				else if (isset($_GET['token']))
				{	$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
					$this->content='Ваш новый пароль отправлен вам на  почту';
					
					$sql->query("update shop_users set password = MD5('{$s}')  where MD5(CONCAT(MD5('{$salt}'),MD5(`email`)))    = '{$_GET['token']}' ");
					#echo ("update shop_users set password = MD5('{$s}')  where MD5(CONCAT(MD5('{$salt}'),MD5(`email`)))    = '{$_GET['token']}' ");
					
					$htmlBody = "Ваш новый пароль: {$s}                  ";	
					$subject = 'Востановление пароля в интернет магазине "'.$this->appName.'"';		
					$sub = "=?UTF-8?B?".base64_encode($subject)."?=";
					$from_text = 'Администрация интернет-магазина "'.$this->appName.'"';		
					$headers = "Content-Type: text/html; charset = \"UTF-8\";\n";		
					$headers  .= "From:"."=?UTF-8?B?".base64_encode($from_text)."?="."<".$this->adminEmail.">\n";
					$headers .= "MIME-Version: 1.0\n";
					$headers .= "Content-Type: text/html; charset = \"UTF-8\";\n";
					$headers .= "\n";			
					mail($_GET['mail'], $sub, $htmlBody, $headers);
				}
			
				
	}
	public function getAjaxAuthForm()
    {
        global $smarty, $basket;

        $count = $basket->getCountOfItems();
        $total = $basket->total();
        $smarty->assign('count', $count);
         $smarty->assign('total', $total);


        $template = $smarty->fetch(api::setTemplate('modules/security/ajax.auth.div.html'));
        echo $template;
    }

    public function total()
    {
        global $smarty, $basket;

       
        $total = $basket->total();
 		echo $total;
    }

    /**
     * Вывод поля "Личный кабинет"
     */
    public function getAjaxCabinet($id)
    {
        global $smarty, $basket;
        $count = $basket->getCountOfItems(Security::$userData['id']);
        
        $smarty->assign('count', $count);
        $smarty->assign('name', Security::$userData['name']);
        $smarty->assign('surname', Security::$userData['surname']);
        $smarty->assign('patronymic', Security::$userData['patronymic']);

        $template = $smarty->fetch(api::setTemplate('modules/security/ajax.cabinet.div.html'));
        echo $template;
    }


    /* ADMIN SECTION */

    /**
     * Админка. Вывод списка пользователей
     */

    /**
     * Админка. Конфигурация модуля
     */
    public function adminShowConfig()
    {
        global $smarty;


        $template = $smarty->fetch(api::setTemplate('modules/security/admin/config.tpl'));
        $this->content = $template;
        return;
    }


    public function register()
    {
        global $smarty;		
		$this->pageTitle = 'Регистрация';
		if($this->formType == 'Отображать поля для Физических лиц'){
			$smarty->assign('fields', SecurityModule::$fizFields);
			$form = $smarty->fetch(api::setTemplate('modules/security/index/cabinet.form.fiz.tpl')); 
		}elseif($this->formType == 'Отображать поля для Юридических лиц'){
			$smarty->assign('fields', SecurityModule::$orgFields);
			$form = $smarty->fetch(api::setTemplate('modules/security/index/cabinet.form.org.tpl')); 
		}else{
			$form= '';
		}		
		
		$smarty->assign('form', $form);
		$template = $smarty->fetch(api::setTemplate('modules/security/index/register.form.tpl'));
        $this->content = $template;
        return;
    }

    public function registerGo()
    {
        global $sql, $orders, $smarty;
		#$dataArray=array();
        //$data = $_POST['value'];


        parse_str($_POST['value'],$data);
        #var_dump($data);
        #die();
        $err  = array();
        $dataArray = $data;
        $data1 = $data;
        #foreach ($data as $key => $value) {
            #al = explode('=', $value);
            #data1[$val['0']] = htmlspecialchars(urldecode($val['1']));
        #}
          
        $fio_ = $data1['surname'];
        $fio =  explode(' ',$data1['surname']);
        $data1['surname'] = @$fio[0]; 
        $data1['name'] = @$fio[1]; 
        $data1['patronymic'] = @$fio[2]; 

		if(empty($fio_) && !preg_match('/^[a-zа-я\ ]+$/ui', $fio_)){
			$err['surname'] = 'Неверно заполнено поле Ф.И.О.';
		}	
		
		if(empty($data1['phone']) || !preg_match("/^[0-9]{4,13}+$/", $data1['phone'])){
			$err['phone'] = 'Неверно заполнено поле телефон';
		}
		
		if(empty($data1['email']) || !preg_match('/^[a-z]{1,}[a-zа-я0-9\.\-\_]+@[a-zа-я0-9\-]{2,}+\.[a-zа-я]{2,5}$/ui', $data1['email'])){
			$err['email'] = 'Неверно заполнено поле Ваш E-mail адрес';
		}else{
			$sql->query("SELECT `id` FROM `#__#shop_users` WHERE `email` ='" . $data1['email'] . "'", true);
			
			if($sql->num_rows()>0){
				$err['email'] = 'Введеный E-mail адрес уже используется';
				
			}			
			
		}
		
		if(!preg_match(SecurityModule::$passCheck, $data1['pass'])){
			$err['pass'] = 'Поле Пароль содержит недопустимые символы';
			
		}
		
		if(strlen($data1['pass']) < 6){
			$err['pass'] = 'Длина пароля меньше допустимого количества символов';
			
		}
        
        if($data1['pass'] !== $data1['pass2']){
			$err['pass2'] = 'Не совпадают значения полей Пароль и Подтверждение пароля';
			
		}       
        
		
		$checkFieldsResult = $this->checkFields($data1);
		$err = array_merge($err, $checkFieldsResult);
        
        if (!empty($err))
            {
                $err['success']=false;
	            echo    json_encode($err);
                die();
            }
        else $err['success']=true;
		
		$err['count'] = count($err);		
        if ($err['success'] == true) {
            
			if($this->formType == 'Отображать поля для Физических лиц'){
				foreach (SecurityModule::$fizFields as $key => $value){
					$dataArray[$value['name']] = $data1[$value['name']];				
				}
				
			}elseif($this->formType == 'Отображать поля для Юридических лиц'){
				foreach (SecurityModule::$orgFields as $key => $value){
					$dataArray[$value['name']] = $data1[$value['name']];				
				}
			} 
			
			#$dataArray = json_encode($dataArray);
            $dataArray=$data1;

            unset($dataArray['pass']);
            unset($dataArray['pass2']);
            $dataArray['data']=@$this->p['data'];
            $dataArray =json_encode($dataArray);
            //$dataArray['data']=$_POST['data'];
            $_SESSION['info'] = array("area" => 'public', "title" => 'Вы успешно зарегистрировались', "desc" => '', "uri" => '', "class" => 'alert-success',);

            $sql->query("INSERT INTO `#__#shop_users` (`email`, `password`, `name`, `surname`, `patronymic`, `reg_date`, `org`, `state`, `data`, `phone`)					                                VALUES
			('" . $data1['email'] . "', '" . md5($data1['pass']) . "', '" . $data1['name'] . "', '" . $data1['surname'] . "', '" . $data1['patronymic'] . "', NOW(), '".$data1['org']."', '0', '".($dataArray)."', '".$data1['phone']."')");

            /* Добавить услове если в настройках разрешена авторизация сразу после регистрации */
            $sql->query("SELECT `id` as 'id' FROM `#__#shop_users` WHERE `email` = '" . $data1['email'] . "' && `password` ='" . md5($data1['pass']) . "'", true);
            $userId = $sql->result['id'];

            $userSeed = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $userId);
            $sql->query("UPDATE `#__#shop_users` SET `seed` = '" . $userSeed . "' WHERE `id` = '" . $userId . "'");

            $_SESSION['sec_id'] = $userId;
            /* Добавить услове если в настройках разрешена авторизация сразу после регистрации */
        
			$to = $data1['email'];				
			$from = $orders->adminEmail;			
			
			$smarty->assign('email', $data1['email']);
			$smarty->assign('pass', $data1['pass']);
			
			$smarty->assign('appName', $orders->appName);
			$smarty->assign('adminEmail', $orders->adminEmail);
			$smarty->assign('adminPhone', $orders->recipientTel);
			
			$smarty->assign('sitename', $_SERVER['SERVER_NAME']);
			
			
			$htmlBody = $smarty->fetch(api::setTemplate("modules/orders/index/mail/registered.tpl"));		
			$subject = 'Поздравляем с успешной регистрацией в интернет магазине "'.$orders->appName.'"';		
			$sub = "=?UTF-8?B?".base64_encode($subject)."?=";
			$from_text = 'Администрация интернет-магазина ';		
			$headers = "Content-Type: text/html; charset = \"UTF-8\";\n";		
			$headers  .= "From:"."=?UTF-8?B?".base64_encode($from_text)."?="."<".$from.">\n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: text/html; charset = \"UTF-8\";\n";
			$headers .= "\n";			
			mail($to, $sub, $htmlBody, $headers);
		
		}
        #print_r($err)
            if ($err['success']==true)
            if (isset($_SESSION['goto']))
                    {
                        $url_ = $_SESSION['goto'];
                        unset($_SESSION['goto']);
                        $err['goto']=$url_;
                    }
        echo json_encode($err);
    }

    public function checkFields($array){
		$result = array();
		
		if($this->formType == 'Отображать поля для Физических лиц'){
			
			foreach (SecurityModule::$fizFields as $key => $value){

				if($value['required'] == 1 && !strlen($array[$value['name']])){
					$result[] = "Не заполнено обязательное поле ".$value['description'];
				}



				#if(strlen($array[$value['name']]) && $value['length'] > 0 && strlen($array[$value['name']]) != $value['length']){
			#		$result[] = "Неверная длина значения ".$value['description'];
			#	}

				if((!empty($value['mask']) && strlen($array[$value['name']])) && !preg_match($value['mask'], $array[$value['name']])){
					$result[] = "Поле ".$value['description']." содержит недопустимые символы";
				}
			}	
		
		}elseif($this->formType == 'Отображать поля для Юридических лиц'){
			
			foreach (SecurityModule::$orgFields as $key => $value){

				if($value['required'] == 1 && !strlen($array[$value['name']])){
					$result[$value['name']] = "Не заполнено обязательное поле ".$value['description']."<br/>";
				}

				if(strlen($array[$value['name']]) && $value['length'] > 0 && strlen($array[$value['name']]) != $value['length']){
					$result[$value['name']] = "Неверная длина значения ".$value['description']."<br/>";
				}

				if((!empty($value['mask']) && strlen($array[$value['name']])) && !preg_match($value['mask'], $array[$value['name']])){
					$result[$value['name']] = "Поле ".$value['description']." содержит недопустимые символы<br/>";
				}
			}
		}	
		
		return $result;	
	}
	
	public function login()
    {

        global $smarty, $basket;

		

        if (Security::$auth == true) {

        } else {
			if(!empty($this->data)){
				foreach($this->data as $key => $value){
					$smarty->assign($key, $value);
				}
			}
			
			$template = $smarty->fetch(api::setTemplate('modules/security/index/login.form.tpl'));
            $this->content = $template;
			$this->pageTitle = 'Вход в личный кабинет';
            return $this->content;
        }
    }

    public function logingo()
    {
        global $sql, $_COOKIE;
        
        if (isset($_POST['url']))
			$url_tmp = $_POST['url'];
			else $url_tmp  = '';
		
		$this->data = $this->postArray;
        $sql->query("SELECT `id` as 'id', `password` as 'password', `name`, `phone`, `org` FROM `#__#shop_users` WHERE `email` = '" . $this->postArray['email'] . "'", true);

        if($sql->num_rows() == 1){
            if($sql->result['password'] != md5($this->postArray['pass'])){
				//echo $sql->result['password'].' != '.md5(($this->postArray['pass']));
				//echo $this->postArray['pass'];
				//echo "<br>";
				
				$a=$this->postArray['pass'];
				//if ($a=='w0915v88') echo '#';
			
				//echo $a.'=='.'w0915v88';
				//	echo '<br>';
				//echo md5($a).'!='.md5('	w0915v88');
				//$a = md5(utf8_decode($a));
				//echo $a;
				//echo mb_detect_encoding($this->postArray['pass']);
				#echo mb_detect_encoding($sql->result['password']);
				//die('');
				messageSessOnly('Вы указали не верный пароль, попробуйте еще раз', '', 'loginerr');
				
					$n = ( (isset($sql->result['name'])) ? $sql->result['name'] : '');
				if (isset($_POST['url']))
				header('Location: '.$_POST['url']);
					else
				
               # message("Здравствуйте ".$n.", Вы успешно вошли в систему.", "", 'catalog', "alert-success");
                message("Вы указали не верный пароль, попробуйте еще раз", "", "login", "-error");
               
               
               
            }else{
				if (isset($this->postArray['remember']))
                if($this->postArray['remember'] == 1){
                    setcookie("sess", $_COOKIE['PHPSESSID'], time()+604800, '/');
                    setcookie("rem", $this->postArray['remember'], time()+604800, '/');
                }

                $userId = $sql->result['id'];
                $userSeed = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $userId);
                $sql->query("UPDATE `#__#shop_users` SET `seed` = '" . $userSeed . "' WHERE `id` = '" . $userId . "'");

                $_SESSION['sec_id'] = $userId;
                
                $sql->query("DELETE FROM `shop_basket` WHERE `user_id` = '{$userId}'");

                

                if(!empty($_SESSION['basket'])){
                    $sql->query("delete FROM `shop_basket` WHERE `user_id` = '".$userId ."'");
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
                
                
                
				$n = ( (isset($sql->result['name'])) ? $sql->result['name'] : '');
				
				messageSessOnly('Вы успешно вошли в систему', '', 'loginerr');
                
                #var_dump($_SESSION);  
                if (isset($_SESSION['goto']))
                    {
                        $url_ = $_SESSION['goto'];
                        unset($_SESSION['goto']);
                        header('Location: '.$url_);
                        die();
                    }
                
                 #die('s');
                if (isset($_POST['url']))
                header('Location: '.$_POST['url']);
					else
                message("Здравствуйте ".$n.", Вы успешно вошли в систему.", "", 'catalog', "alert-success");
               
            }
        } else {            
			messageSessOnly('Записи с введеным E-mail адресом не существует', '', 'loginerr');
			//die('9');			
			if (isset($_POST['url']))
				header('Location: '.$_POST['url']);
			else
            return $this->login();
        }
    }

    public function logout()
    {
        global $sql;
        $sql->query("UPDATE `#__#shop_users` SET `seed` = '' WHERE `id` = '" . $_SESSION['sec_id'] . "'");
        unset($_SESSION['sec_id']);
        setcookie("sess", '', time()-3600, '/');
        setcookie("rem", '', time()-3600, '/');
        message("Вы успешно вышли из системы", "", 'catalog', "alert-success");
    }

    public function cabinet($data = '', $dateRet='')
    {
        global $smarty;
		$this->pageTitle = 'Личный кабинет';
        if ($data) {
            $data = $data;
            unset($data['oldpass']);
            unset($data['newpass']);
            unset($data['newpassconfirm']);
            $data['email'] = Security::$userData['email'];
            $data['reg_date'] = Security::$userData['reg_date'];

            foreach ($data as $key => $value) {
                $data[$key] = @stripslashes($value);
            }
           // $data['data'] = $dateRet;
            $data['error'] =  $this->error;
        } else {
            $data = Security::$userData;
        }       
		
		
		foreach ($data as $key => $value) {
            $smarty->assign($key, $value);
        }
              #if(!empty($data['data'])){
        #    foreach($data['data'] as $key => $value){
        #        foreach(SecurityModule::$orgFields as $key1 => $value1){
        #            if($key == $value1['name']){
        #                SecurityModule::$orgFields[$key1]['value'] = stripslashes($value);
        #            }
        #        }
        #    }
        #}

        $smarty->assign('fields', SecurityModule::$orgFields);
        $orgForm = $smarty->fetch(api::setTemplate('modules/security/index/cabinet.form.org.tpl'));


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
        $fizForm = $smarty->fetch(api::setTemplate('modules/security/index/cabinet.form.fiz.tpl'));		

        /*
		if($data['org'] == '0' || $data['org'] == '1'){
			$smarty->assign('fizForm', $fizForm);
		}elseif($data['org'] == '2'){
			$smarty->assign('orgForm', $orgForm);
        }
         */
		  $smarty->assign('data',$data['data']);


        $template = $smarty->fetch(api::setTemplate('modules/security/index/cabinet.form.tpl'));
        $this->content = $template;
		$this->pageTitle = 'Персональная информация';
    }

    public function savedata($id)
    {
        global $sql;
        $dataRet=array();
            
        $fio = explode(' ',$this->postArray['name']);
        $this->postArray['surname']=$fio[0];
        $this->postArray['name']=$fio[1];
        $this->postArray['patronymic']=$fio[2];




        if ($this->postArray['passchange'] == 1) {
            $changePasswordResult = $this->passChange($id, $this->postArray['oldpass'], $this->postArray['newpass'], $this->postArray['newpassconfirm']);
            if (!empty($changePasswordResult)) {
                $this->error = array_merge($this->error, $changePasswordResult);
            }
        }

        $changeBaseDataResult = $this->changeBaseData($this->postArray['name'], $this->postArray['surname'], $this->postArray['patronymic']);
        if(!empty($changeBaseDataResult)){
            $this->error = array_merge($this->error, $changeBaseDataResult);
        }

        /*
        if ($this->postArray['org'] == 1) {
            $changeOrgResult = $this->changeFizData($this->postArray);
            foreach(SecurityModule::$fizFields as $key => $value){
                $dataRet[$value['name']] = $this->postArray[$value['name']];
            }


            if(!empty($changeOrgResult)){
                $this->error = array_merge($this->error, $changeOrgResult);
            }else{
                $data = array();
                foreach(SecurityModule::$fizFields as $key => $value){
                    $arr = array($value['name'] => $this->postArray[$value['name']]);
                    $data = array_merge($data, $arr);
                }
                $data = addslashes(json_encode($data));
            }
        }

        if ($this->postArray['org'] == 2) {
            $changeOrgResult = $this->changeOrgData($this->postArray);
            foreach(SecurityModule::$orgFields as $key => $value){
                $dataRet[$value['name']] = $this->postArray[$value['name']];
            }

            if (!empty($changeOrgResult)) {
                $this->error = array_merge($this->error, $changeOrgResult);
            }else{
                $data = array();
                foreach(SecurityModule::$orgFields as $key => $value){
                    $arr = array($value['name'] => $this->postArray[$value['name']]);
                    $data = array_merge($data, $arr);
                }
                $data = addslashes(json_encode($data));
            }
        }
         */

        if(!empty($this->error)){
			
            return $this->cabinet($this->postArray, $dataRet);
        }else{
				
				
			
            @$sql->query("UPDATE `#__#shop_users` SET `name` = '" . $this->postArray['name'] . "', `surname` = '" . $this->postArray['surname'] . "', `patronymic` = '" . $this->postArray['patronymic'] . "', `phone` = '" . $this->postArray['phone'] . "', `email` = '" . $this->postArray['email'] . "' , `addr` = '".$this->postArray['addr']."', `discount` = '".$this->postArray['discount']."' WHERE `id` = '" . $id . "'");

            if ($this->postArray['passchange'] == 1){
                $sql->query("UPDATE `#__#shop_users` SET `password` = '".md5($this->postArray['newpass'])."'");
            }

            /*
            if ($this->postArray['org'] == 2){
                $sql->query("UPDATE `#__#shop_users` SET `org` = '".$this->postArray['org']."', `data` = '" . $data . "' WHERE `id` = '" . $id . "'");
                $sql->query("SELECT `id` FROM `#__#shop_org` WHERE `inn` = '".$this->postArray['inn_org']."'",true);
                if($sql->num_rows() == 1){
                    $org_id = $sql->result['id'];
                    $sql->query("UPDATE `#__#shop_users` SET `org_id` = '".$org_id."' WHERE `id` = '" . $id . "'");
                }else{
                    $sql->query("INSERT INTO `#__#shop_org` (`name`, `inn`) VALUES ('".$this->postArray['name_org']."', '".$this->postArray['inn_org']."')");
                    $sql->query("SELECT `id` FROM `#__#shop_org` WHERE `name` = '".$this->postArray['name_org']."' AND `inn` ='".$this->postArray['inn_org']."'",true);
                    $org_id = $sql->result['id'];
                    $sql->query("UPDATE `#__#shop_users` SET `org_id` = '".$org_id."' WHERE `id` = '" . $id . "'");
                }
            }*/
            

            $data = $_POST;

            unset($data['passchange']);
            unset($data['newpass']);
            unset($data['newpassconfirm']);
            $sql->query("UPDATE `#__#shop_users` SET `data` = '".json_encode($data)."'  WHERE `id` = '" . $id . "'");
            message("Данные сохранены", "", "cabinet", "alert-success");
        }

    }

    private function passChange($id, $oldpass, $newpass, $newpassconfirm)
    {
        global $sql;
        $result = array();
        $sql->query("SELECT COUNT(*) as 'count' FROM `#__#shop_users` WHERE `id` = '" . $id . "' && `password` = '" . md5($oldpass) . "'", true);

        if ($sql->result['count'] != 1) {
            $result[] = 'Неверно введен старый пароль<br/>';
        }

        if (strlen($newpass) < SecurityModule::$passLength) {
            $result[] = 'Длинна  нового пароля меньше допустимого количества символов<br/>';
        }

        if (strlen($newpass) == SecurityModule::$passLength && !preg_match(SecurityModule::$passCheck, $newpass)) {
            $result[] = 'Поле Новый пароль содержит недопустимые символы<br/>';
        }

        if ($newpass !== $newpassconfirm) {
            $result[] = 'Не совпадают значения полей  Новый пароль и Подтверждение нового пароля<br/>';
        }

        return $result;
    }

    private function changeBaseData($name, $surname, $patronymic)
    {
        $result = array();
        $post = $_POST;
        if (strlen($name) == 0) {
            $result[] = 'Не заполено поле Имя<br/>';
        }

        if (strlen($name) > 0 && !preg_match('/^[a-zа-я]+$/ui', $name)) {
            $result[] = 'Поле Имя содержит недопустимые символы<br/>';
        }
        
        	if(empty($post['phone']) || !preg_match("/^[0-9]{4,13}+$/", $post['phone']))		
        	#if(empty($post['phone']) || !preg_match("/^[0-9]{4,13}+$/", $post['phone']))		
			$result[] = 'Неверно заполнено поле телефон';

       # if (strlen($surname) == 0) {
       #     $result[] = 'Не заполено поле Фамилия<br/>';
       # }

      #  if (strlen($surname) > 0 && !preg_match('/^[a-zа-я]+$/ui', $surname)) {
      #      $result[] = 'Поле Фамилия содержит недопустимые символы<br/>';
      #  }

        #if (strlen($patronymic) == 0) {
        #    $result[] = 'Не заполено поле Отчество<br/>';
        #}

        #if (strlen($patronymic) > 0 && !preg_match('/^[a-zа-я]+$/ui', $patronymic)) {
        #    $result[T = 'Поле Отчество содержит недопустимые символы<br/>';
        #}

        return $result;
    }

    private function changeFizData($array)
    {
        $result = array();

        foreach (SecurityModule::$fizFields as $key => $value){

            if($value['required'] == 1 && !strlen($array[$value['name']])){
                $result[] = "Не заполнено обязательное поле ".$value['description']."<br/>";
            }

            if(strlen($array[$value['name']]) && $value['length'] > 0 && strlen($array[$value['name']]) != $value['length']){
                $result[] = "Неверная длина значения ".$value['description']."<br/>";
            }

            if((!empty($value['mask']) && strlen($array[$value['name']])) && !preg_match($value['mask'], $array[$value['name']])){
                $result[] = "Поле ".$value['description']." содержит недопустимые символы<br/>";
            }
        }
        return $result;
    }

    private function changeOrgData($array)
    {
        $result = array();

        foreach (SecurityModule::$orgFields as $key => $value){

            if($value['required'] == 1 && !strlen($array[$value['name']])){
                $result[] = "Не заполнено обязательное поле ".$value['description']."<br/>";
            }

            if(strlen($array[$value['name']]) && $value['length'] > 0 && strlen($array[$value['name']]) != $value['length']){
                $result[] = "Неверная длина значения ".$value['description']."<br/>";
            }

            if((!empty($value['mask']) && strlen($array[$value['name']])) && !preg_match($value['mask'], $array[$value['name']])){
                $result[] = "Поле ".$value['description']." содержит недопустимые символы<br/>";
            }
        }

        return $result;
    }

    /**
     * Модуль "Security"
     *
     * @param String $file Путь к файлу шаблона
     */
     
     
    public function adminShowUserList()
	{
		$data= array();		
		$data['data'] = $this->model->getUserList();
		$this->tpl->assign('data', $data['data']);
        $template = $this->tpl->fetch(api::setTemplate('modules/security/admin/users.list.tpl'));
    	$this->content=$template;
		return;
	}
   
	public function adminDeleteUser($id)
	{
		$this->model->deleteUser($id);
		$this->tpl->assign('action', 'delete');
        $this->adminShowUserList();
		return;
	}
   
   
   
    public function adminAddUser()
	{
		if (	(!empty($_POST['submit']) ) && (!empty($_POST['name'])))
		{
		#echo '123';
		$this->model->addUser();
		
		}
		$this->adminShowUserList();
	}
   
	public function adminEditUser($id,$edit=false)
	{	
		if (isset($_POST['submit']))
		{
		$data['data'] = $this->model->updateUser($id);
		$this->tpl->assign('alert', ' Данные обновлены ');
		}
	
	if ($edit===true) 
	$this->tpl->assign('edit', 'true');	
	
	$data['data'] = $this->model->getUserList($id);
	$this->tpl->assign('data', $data['data']);
	
	$template = $this->tpl->fetch(api::setTemplate('modules/security/admin/users.edit.tpl'));
    $this->content=$template;
	}
   
   
    function __construct()
    {
		global $smarty;
		
		$this->model = new SecurityModel();
		$this->tpl = clone $smarty;
		
		
		$this->pageTitle = '';
        
        
        
		
		$cfgValue = api::getConfig("modules", "security", "userType");
        $this->formType = ($cfgValue != "") ? $cfgValue : '';
		
		$cfgValue = api::getConfig("modules", "security", "defTemplate");
        $this->template = ($cfgValue != "") ? $cfgValue : '';
        
        $this->p = $_POST;
        if (isset($_POST) && !empty($_POST)) {
            $this->postArray = api::slashData($_POST);
        }
		
		
    }
}

?>
