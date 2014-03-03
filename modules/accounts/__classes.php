<?php
if (!defined("API")) {
	exit("Main include fail");
}

class accounts {
	public $data = array();
	public $lang = '';
	public $curLang = 'ru';
	protected $assignArray = array();

    private $mDir    = "accounts";
    private $tDir    = 'modules/accounts/';

	private $getArray  		= array();
	private $postArray 		= array();
	private $filesArray		= array();

    //Форма регистрации
	public function register() {
		global $sql, $lang, $smarty;

		if (isset($_SESSION['shop_user_id'])) go('/');

        $smarty->assign('check_fiz', 'checked');
		$smarty->assign('display_org', 'style="display:none;"');

		$this->data['content'] = $smarty->fetch(api::setTemplate($this->tDir.'index.register.tpl'));
		$this->data['pageTitle'] = $this->lang['register_title'];
		$this->data['navigation'] = $this->lang['register_title'];

	}


    private function checkCapcha() {    	//global $_SESSION, $_POST;
        $this->captha = '$_POST[submit] not isset';

            /** SESSION CONTROL * */
            if (isset($_SESSION['qaptcha_key']) && !empty($_SESSION['qaptcha_key'])) {
                $QaptChaInput = $_SESSION['qaptcha_key'];

                /** we can control the random input grace to the QapTchaToTest intpu value * */
                if (isset($_POST['' . $QaptChaInput . '']) && empty($_POST['' . $QaptChaInput . ''])) {
                    $this->captha = 'Можно отправлять';
                    return TRUE;
                } else {
                    $this->captha = 'Бот детектед =_=';
                    return FALSE;
                }
            } else {
                $this->captha = 'Время сессии истекло';
                return FALSE;
            }

            /** Unset SESSION in all cases * */
            unset($_SESSION['qaptcha_key']);

            return false;

        return false;
    }


    //Регистрация
	public function regpost() {
		global $sql, $lang, $smarty;

        if (isset($_SESSION['shop_user_id'])) go('/');

        @$this->registerData();

        $er = array();

        if (!checkEmail($this->data['email'])) { $smarty->assign('error_email', $this->lang['error_email']); $er[] = 1; }

        $sql->query("SELECT `email` FROM `#__#shop_users` WHERE `email` = '".$this->data['email']."' AND `status` = '1'", true);
        if ($sql->num_rows() > 0) { $smarty->assign('error_email2', $this->lang['error_email2']); $er[] = 1; }

        if (empty($this->data['password'])) { $smarty->assign('error_password', $this->lang['error_password']); $er[] = 1; }
        if (empty($this->data['tel'])) { $smarty->assign('error_tel', $this->lang['error_tel']); $er[] = 1; }

        if ($this->data['password'] != $this->data['password2']) { $smarty->assign('error_password2', $this->lang['error_password2']); $er[] = 1; }

        if (!$this->checkCapcha()) { $smarty->assign('error_capcha', $this->lang['error_capcha']); $er[] = 1; }

		//Если это физическое лицо
        if ($this->data['type'] == 0) {
            if (empty($this->data['name'])) { $smarty->assign('error_name', $this->lang['error_name']); $er[] = 1; }
        	$smarty->assign('check_fiz', 'checked');
			$smarty->assign('display_org', 'style="display:none;"');

            //Если организация        	} else if ($this->data['type'] == 1) {
                if (empty($this->data['org_name'])) { $smarty->assign('error_org_name', $this->lang['error_org_name']); $er[] = 1; }
                if (empty($this->data['inn'])) { $smarty->assign('error_inn', $this->lang['error_inn']); $er[] = 1; }

                if (empty($this->data['full_name'])) $this->data['full_name'] = $this->data['org_name'];

                //Проверка на существующий ИНН
                $sql->query("SELECT `inn` FROM `#__#shop_users_org` WHERE `inn` = '".$this->data['inn']."'", true);
                if ($sql->num_rows() > 0) { $smarty->assign('error_inn2', $this->lang['error_inn2']); $er[] = 1; }
        		$smarty->assign('check_org', 'checked');
				$smarty->assign('display_fiz', 'style="display:none;"');
        		}

		foreach ($this->data as $key => $value) {
			$smarty->assign($key, @stripslashes($value));
		}

        if (count($er) == 0) {
            $genKey = genKey(30);

			$sql->query("INSERT INTO `#__#shop_users` (`email`,`password`,`reg_date`,`type`,`adress`,`tel`,`index`,`status`,`code`) VALUES ('".dataString($this->data['email'])."', '".md5(md5($this->data['password']))."', NOW(), '".$this->data['type']."', '".dataString($this->data['adress'])."', '".dataString($this->data['tel'])."', '".dataString($this->data['index'])."', '0', '$genKey')");
            $id_user = $sql->lastId();

            //физическое лицо
            if ($this->data['type'] == 0) {            	$sql->query("INSERT INTO `#__#shop_users_fiz` (`id_user`,`name`,`last_name`,`middle_name`,`inn`) VALUES ('$id_user', '".dataString($this->data['name'])."', '".dataString($this->data['last_name'])."', '".dataString($this->data['middle_name'])."', '".rand(1000000000, 9999999999)."')");            	//организация
            	} else if ($this->data['type'] == 1) {            		$sql->query("INSERT INTO `#__#shop_users_org` (`id_user`,`org_name`,`full_name`,`inn`) VALUES ('$id_user', '".dataString($this->data['org_name'])."', '".dataString($this->data['full_name'])."', '".dataString($this->data['inn'])."')");            		}

            $smarty->assign('url', 'http://'.$_SERVER["HTTP_HOST"].'/'.$this->mDir.'/regcode/'.$genKey.'/');
            $smarty->assign('site_name', $_SERVER["HTTP_HOST"]);

            $htmlBody = $smarty->fetch(api::setTemplate($this->tDir.'index.send.mail.reg.tpl'));

        	$this->SendMail($this->data['email'], $this->lang['sub_mail_code'], $htmlBody, $this->lang['from_mail_text'], 'no_reply@'.str_replace('www.', '', $_SERVER["HTTP_HOST"]));

            $smarty->assign('email', $this->data['email']);

            $this->data['content'] = $smarty->fetch(api::setTemplate($this->tDir.'index.register.ok.tpl'));
        	} else {        		$this->data['content'] = $smarty->fetch(api::setTemplate($this->tDir.'index.register.tpl'));        		}

			$this->data['pageTitle'] = $this->lang['register_title'];
			$this->data['navigation'] = $this->lang['register_title'];

	}



	public function regcode() {
		global $sql, $lang, $smarty, $uri;

        $sql->query("SELECT `id` FROM `#__#shop_users` WHERE `code` = '".$sql->escape($uri['3'])."' AND `status`='0'", true);
        if ($sql->num_rows() > 0) {
            $id = $sql->result['id'];

			$sql->query("UPDATE `#__#shop_users` SET `code` = '', `status` = '1' WHERE `id` = '$id'");

            $_SESSION['shop_user_id'] = $id;

            $this->data['content'] = $smarty->fetch(api::setTemplate($this->tDir.'index.regcode.tpl'));
        	} else {
        	    $this->data['content'] = $smarty->fetch(api::setTemplate($this->tDir.'index.regcode.error.tpl'));

        		}

		$this->data['pageTitle'] = $this->lang['register_title'];
		$this->data['navigation'] = $this->lang['register_title'];

	}



	public function SendMail($to, $sub, $htmlBody, $from_text, $from_email) {
		$sub = "=?UTF-8?B?".base64_encode($sub)."?=";

		$headers = "Content-Type: text/html; charset = \"UTF-8\";\n";
		$headers  .= "From:"."=?UTF-8?B?".base64_encode($from_text)."?="."<".$from_email.">\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: text/html; charset = \"UTF-8\";\n";
		$headers .= "\n";

		mail($to, $sub, $htmlBody, $headers);

	}

    //Авторизация
	public function enter() {
		global $sql, $lang, $smarty;

        if (isset($_SESSION['shop_user_id'])) go('/');

        @$this->enterData();

        if (isset($this->data['email'])) {        	$sql->query("SELECT `id`,`status` FROM `#__#shop_users` WHERE `email` = '".dataString($this->data['email'])."' AND `password`='".md5(md5($this->data['password']))."'", true);        	if ($sql->num_rows() > 0) {        		if ($sql->result['status'] == 1) {        			$_SESSION['shop_user_id'] = $sql->result['id'];        			go('/'.$this->mDir.'/profile/');
        			} else {        				$smarty->assign('urlcode', '<a href="/'.$this->mDir.'/rcode/">'.$this->lang['urlcode_title'].'</a>');
        				$smarty->assign('enter_error', $this->lang['enter_error_activate']);        				}        		} else {        			$smarty->assign('enter_error', $this->lang['enter_error']);        			}
        	}

        $smarty->assign('email', $this->data['email']);

        $this->data['content'] = $smarty->fetch(api::setTemplate($this->tDir.'index.enter.tpl'));
		$this->data['pageTitle'] = $this->lang['enter_title'];
		$this->data['navigation'] = $this->lang['enter_title'];

	}


	public function rcode() {		global $sql, $lang, $smarty;
        @$this->rcodeData();

        $er = array();

        if (isset($this->data['email'])) {
        	if (!$this->checkCapcha()) { $smarty->assign('error_capcha', $this->lang['error_capcha']); $er[] = 1; }

            $sql->query("SELECT `id`,`status`,`code` FROM `#__#shop_users` WHERE `email` = '".dataString($this->data['email'])."'", true);
            if ($sql->num_rows() > 0) {
                if ($sql->result['status'] == 1) {                	$smarty->assign('error_mail', $this->lang['rcode_active']);
                	$er[] = 1;                	} else if ($sql->result['status'] == 0) {
            			$smarty->assign('url', 'http://'.$_SERVER["HTTP_HOST"].'/'.$this->mDir.'/regcode/'.$sql->result['code'].'/');
            			$smarty->assign('site_name', $_SERVER["HTTP_HOST"]);
            			$htmlBody = $smarty->fetch(api::setTemplate($this->tDir.'index.send.mail.reg.tpl'));

        				$this->SendMail($this->data['email'], $this->lang['sub_mail_code'], $htmlBody, $this->lang['from_mail_text'], 'no_reply@'.str_replace('www.', '', $_SERVER["HTTP_HOST"]));
            			$smarty->assign('message', $this->lang['message_send_code']);
                        $smarty->assign('inform', 1);
                		}
            	} else {            		$smarty->assign('error_mail', $this->lang['error_recovery_mail']);
            	    $er[] = 1;            		}
        	}

        $smarty->assign('email', $this->data['email']);

        $this->data['content'] = $smarty->fetch(api::setTemplate($this->tDir.'index.rcode.tpl'));
		$this->data['pageTitle'] = $this->lang['rcode_title'];
		$this->data['navigation'] = $this->lang['rcode_title'];

	}



	public function recovery() {
		global $sql, $lang, $smarty, $uri;

        if (isset($_SESSION['shop_user_id'])) go('/');

        @$this->recoveryData();

        $er = array();

        if (isset($this->data['email'])) {        	if (!$this->checkCapcha()) { $smarty->assign('error_capcha', $this->lang['error_capcha']); $er[] = 1; }

            $sql->query("SELECT `id` FROM `#__#shop_users` WHERE `email` = '".dataString($this->data['email'])."' AND `status`='1'", true);
            if ($sql->num_rows() == 0) { $smarty->assign('error_recovery_mail', $this->lang['error_recovery_mail']); $er[] = 1; }

            if (count($er) == 0) {
                $id_user = $sql->result['id'];

                $new_password = genKey(10);

                $sql->query("UPDATE `#__#shop_users` SET `password`='".md5(md5($new_password))."' WHERE `id`='$id_user'");

            	$smarty->assign('url', 'http://'.$_SERVER["HTTP_HOST"].'/'.$this->mDir.'/enter/');
            	$smarty->assign('site_name', $_SERVER["HTTP_HOST"]);
                $smarty->assign('new_password', $new_password);
                $htmlBody = $smarty->fetch(api::setTemplate($this->tDir.'index.send.mail.recovery.tpl'));

                $this->SendMail($this->data['email'], $this->lang['sub_recovery_mail'], $htmlBody, $this->lang['from_mail_text'], 'no_reply@'.str_replace('www.', '', $_SERVER["HTTP_HOST"]));
            	$smarty->assign('email', $this->data['email']);            	$this->data['content'] = $smarty->fetch(api::setTemplate($this->tDir.'index.recovery.ok.tpl'));
            	} else {
            	    $this->data['content'] = $smarty->fetch(api::setTemplate($this->tDir.'index.recovery.tpl'));            		}        	} else {
        	    $this->data['content'] = $smarty->fetch(api::setTemplate($this->tDir.'index.recovery.tpl'));
        		}

		$this->data['pageTitle'] = $this->lang['recovery_title'];
		$this->data['navigation'] = $this->lang['recovery_title'];

	}




    //Смена пароля
	public function password() {
		global $sql, $lang, $smarty;

		$this->checkEnter();

        @$this->passwordData();

        $er = array();

        if (isset($this->data['old_password'])) {
            $sql->query("SELECT `id` FROM `#__#shop_users` WHERE `id` = '".$sql->escape($_SESSION['shop_user_id'])."' AND `password`='".md5(md5($this->data['old_password']))."'", true);
            if ($sql->num_rows() == 0) { $smarty->assign('error_password4', $this->lang['error_password4']); $er[] = 1; }

            if (strlen(trim($this->data['new_password'])) < 4) { $smarty->assign('error_password3', $this->lang['error_password3']); $er[] = 1; }        	if ($this->data['new_password'] != $this->data['new_password2']) { $smarty->assign('error_password2', $this->lang['error_password2']); $er[] = 1; }

            if (count($er) == 0) {
                $sql->query("UPDATE `#__#shop_users` SET `password`='".md5(md5($this->data['new_password']))."' WHERE `id` = '".$sql->escape($_SESSION['shop_user_id'])."'");            	$smarty->assign('pass_edit_ok', $this->lang['pass_edit_ok']);
            	}

        	}

        $this->data['content'] = $smarty->fetch(api::setTemplate($this->tDir.'index.password.tpl'));
		$this->data['pageTitle'] = $this->lang['password_title'];
		$this->data['navigation'] = $this->lang['password_title'];

	}


	public function passwordData() {

		$this->data['old_password']=$this->postArray['old_password'];
		$this->data['new_password']=$this->postArray['new_password'];
		$this->data['new_password2']=$this->postArray['new_password2'];

        return true;

    }


    //Профиль
	public function profile() {
		global $sql, $lang, $smarty;

		$this->checkEnter();

        $sql->query("SELECT * FROM `#__#shop_users` WHERE `id` = '".$sql->escape($_SESSION['shop_user_id'])."'", true);
        foreach ($sql->result as $key => $data) $smarty->assign($key, $data);
        if ($this->data['type'] == 0) {

            if (isset($_POST['email'])) {            	if ($this->profileEdit($sql->result['type'])) $smarty->assign('profile_edit_ok', $this->lang['profile_edit_ok']);
				foreach ($this->data as $key => $value) $smarty->assign($key, @stripslashes($value));
            	} else {
            		$sql->query("SELECT * FROM `#__#shop_users_fiz` WHERE `id_user` = '".$sql->escape($_SESSION['shop_user_id'])."'", true);
            		foreach ($sql->result as $key => $data) $smarty->assign($key, $data);            		}
        	$this->data['content'] = $smarty->fetch(api::setTemplate($this->tDir.'index.profile.fiz.tpl'));
        	} else if ($this->data['type'] == 1) {
            	if (isset($_POST['email'])) {
            		if ($this->profileEdit($sql->result['type'])) $smarty->assign('profile_edit_ok', $this->lang['profile_edit_ok']);
					foreach ($this->data as $key => $value) $smarty->assign($key, @stripslashes($value));
            		} else {
            			$sql->query("SELECT * FROM `#__#shop_users_org` WHERE `id_user` = '".$sql->escape($_SESSION['shop_user_id'])."'", true);
            			foreach ($sql->result as $key => $data) $smarty->assign($key, $data);
            			}

        	    $this->data['content'] = $smarty->fetch(api::setTemplate($this->tDir.'index.profile.org.tpl'));

        		}
		$this->data['pageTitle'] = $this->lang['profile_title'];
		$this->data['navigation'] = $this->lang['profile_title'];

	}


	public function profileEdit($type) {	    global $sql, $lang;

		@$this->profileEditData();

        $er = array();

        if (!checkEmail($this->data['email'])) { $this->data['error_email'] = $this->lang['error_email']; $er[] = 1; }

        $sql->query("SELECT `email` FROM `#__#shop_users` WHERE `id`!='".$sql->escape($_SESSION['shop_user_id'])."' AND `email` = '".$this->data['email']."' AND `status` = '1'", true);
        if ($sql->num_rows() > 0) { $this->data['error_email2'] = $this->lang['error_email2']; $er[] = 1; }

        if (empty($this->data['tel'])) { $this->data['error_tel'] = $this->lang['error_tel']; $er[] = 1; }

        if ($type == 0) {        	if (empty($this->data['name'])) { $this->data['error_name'] = $this->lang['error_name']; $er[] = 1; }
        	} else if ($type == 1) {
                if (empty($this->data['org_name'])) { $this->data['error_org_name'] = $this->lang['error_org_name']; $er[] = 1; }
                if (empty($this->data['inn'])) { $this->data['error_inn'] = $this->lang['error_inn']; $er[] = 1; }
                if (empty($this->data['full_name'])) $this->data['full_name'] = $this->data['org_name'];

                //Проверка на существующий ИНН
                $sql->query("SELECT `inn` FROM `#__#shop_users_org` WHERE `id_user`!='".$sql->escape($_SESSION['shop_user_id'])."' AND `inn` = '".$this->data['inn']."'", true);
                if ($sql->num_rows() > 0) { $this->data['error_inn2'] = $this->lang['error_inn2']; $er[] = 1; }
        		}

		if (count($er) == 0) {
       		$sql->query("UPDATE `#__#shop_users` SET `email`='".dataString($this->data['email'])."', `adress`='".dataString($this->data['adress'])."', `tel`='".dataString($this->data['tel'])."', `index`='".dataString($this->data['index'])."' WHERE `id`='".$sql->escape($_SESSION['shop_user_id'])."'");

            if ($type == 0) {
                $sql->query("UPDATE `#__#shop_users_fiz` SET `name`='".dataString($this->data['name'])."', `last_name`='".dataString($this->data['last_name'])."', `middle_name`='".dataString($this->data['middle_name'])."' WHERE `id_user`='".$sql->escape($_SESSION['shop_user_id'])."'");
            	} else if ($type == 1) {
                    $sql->query("UPDATE `#__#shop_users_org` SET `org_name`='".dataString($this->data['org_name'])."', `full_name`='".dataString($this->data['full_name'])."', `inn`='".dataString($this->data['inn'])."' WHERE `id_user`='".$sql->escape($_SESSION['shop_user_id'])."'");
            		}

            return true;
			} else {
			    return false;
				}

	}



	public function profileEditData() {
		$this->data['email']=$this->postArray['email'];
		$this->data['name']=$this->postArray['name'];
		$this->data['last_name']=$this->postArray['last_name'];
		$this->data['middle_name']=$this->postArray['middle_name'];
		$this->data['org_name']=$this->postArray['org_name'];
		$this->data['full_name']=$this->postArray['full_name'];
		$this->data['inn']=$this->postArray['inn'];
		$this->data['tel']=$this->postArray['tel'];
		$this->data['index']=$this->postArray['index'];
		$this->data['adress']=$this->postArray['adress'];

        return true;

    }

    //выход
	public function out() {
    	unset($_SESSION['shop_user_id']);
        go('/'.$this->mDir.'/enter/');
	}

    //Проверка авторизации
    private function checkEnter() {    	global $sql;
        if (!isset($_SESSION['shop_user_id'])) {
        	go('/'.$this->mDir.'/enter/');        	} else {        		$sql->query("SELECT `type` FROM `#__#shop_users` WHERE `id` = '".$sql->escape($_SESSION['shop_user_id'])."' AND `status`='1'", true);
        		if ($sql->num_rows() == 1) {        			//тип пользователя 0-физик, 1-юрик
                    $this->data['type'] = $sql->result['type'];        			} else {        				go('/'.$this->mDir.'/enter/');        				}        		}
    }


	public function recoveryData() {
		$this->data['email']=$this->postArray['email'];

	    return true;
	}



	public function enterData() {		$this->data['email']=$this->postArray['email'];
	    $this->data['password']=$this->postArray['password'];

	    return true;
	}


	public function registerData() {
		$this->data['type'] = $this->postArray['type'];
		$this->data['email']=$this->postArray['email'];
		$this->data['name']=$this->postArray['name'];
		$this->data['last_name']=$this->postArray['last_name'];
		$this->data['middle_name']=$this->postArray['middle_name'];
		$this->data['org_name']=$this->postArray['org_name'];
		$this->data['full_name']=$this->postArray['full_name'];
		$this->data['inn']=$this->postArray['inn'];
		$this->data['tel']=$this->postArray['tel'];
		$this->data['index']=$this->postArray['index'];
		$this->data['adress']=$this->postArray['adress'];
		$this->data['password']=$this->postArray['password'];
		$this->data['password2']=$this->postArray['password2'];

		return true;
	}



	public function rcodeData() {
		$this->data['email']=$this->postArray['email'];

	    return true;
	}


	public function users() {
		global $sql, $lang, $smarty;

		$users = array();

        $subSql = clone $sql;

		$sql->query("SELECT * FROM `#__#shop_users`");
		while($sql->next_row()) {
		    if ($sql->result['type'] == 0) {		    	$subSql->query("SELECT `name`, `last_name`, `middle_name` FROM `#__#shop_users_fiz` WHERE `id_user`='".$sql->result['id']."'", true);
		    	$sql->result['name'] = $subSql->result['last_name'].' '.$subSql->result['name'].' '.$subSql->result['middle_name'];
		    	} else if ($sql->result['type'] == 1) {		    		$subSql->query("SELECT `org_name` FROM `#__#shop_users_org` WHERE `id_user`='".$sql->result['id']."'", true);
		    		$sql->result['name'] = $subSql->result['org_name'];
		    		}
			array_push($users, $sql->result);
			}

        $smarty->assign("users", $users);

        unset($subSql);

		$this->data['content'] = $smarty->fetch(api::setTemplate($this->tDir.'admin.users.tpl'));

	}








	function __construct() {
		global $_GET, $_POST, $_FILES, $sql, $_SESSION;

		$this->getArray		= api::slashData($_GET);
		$this->postArray 	= api::slashData($_POST);
		$this->filesArray	= api::slashData($_FILES);

		return true;
	}


}


?>
