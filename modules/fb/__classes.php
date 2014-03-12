<?php
if (!defined("API")) {
	exit("Main include fail");
}

class fb {
	private $error = "";

	public $curLang = "";
	public $lang = array();
	public $data = array();

	private $to   = "pr@in-site.ru";
	private $toArray   = array('silago@inbox.ru');	
	private $fromEmail = "admin@in-site.ru";

	private $mDir = "fb";


	function showFbForm() {
        $this->sendFb();
		# global $smarty;


        #$template = $smarty->fetch(api::setTemplate("/modules/fb/index.form.rows.html"));
        #return $template;

		/*global $sql, $_GET;

		$template = new template(api::setTemplate("modules/fb/index.form.rows.html"));

		$subBody = "";

		if (isset($_GET['id'])) {
			$sql->query("SELECT `title` FROM #__#catalog WHERE `id` = '".(int)$_GET['id']."'", true);
			if ($sql->num_rows() !== 1) {
				page404();
			}
			$this->data['subject'] = $sql->result['title'];
		}


		foreach ($this->lang['rows'] as $key=>$empty) {
			$template->assign("rowName", $this->lang['rows'][$key][1]);
			switch ($this->lang['rows'][$key][2]) {
				case "text":
				case "email":
					$template->assign("inputForm", "<input type=\"text\" name=\"".($nR = $this->lang['rows'][$key][0])."\" maxlength=\"".$this->lang['rows'][$key][3]."\" value=\"".@strip($this->data[$nR])."\" size=\"45\" />");
				break;

				case "textarea":
					$template->assign("inputForm", "<textarea name=\"".($nR = $this->lang['rows'][$key][0])."\" rows=\"6\" cols=\"60\">".@strip($this->data[$nR])."</textarea>");
				break;
			}

			if (isset($this->lang['rows'][$key][4])) {
				$template->assign("star", "*");
			} else {
				$template->assign("star", "");
			}

			$subBody .= $template->get();
		}
		$template = new template(api::setTemplate("modules/fb/index.form.body.html"));
		$template->assign("error", $this->error);

		echo '111111111111111111111111111111111';
		echo $template;
		echo '111111111111111111111111111111111';

        if (isset($_GET['lang']) && $_GET['lang'] == "en") $template->assign("lang", "?lang=en");

        if (isset($_GET['lang']) && $_GET['lang'] == "en") {
        	$template->assign("enterCode", "Code:");
        	$template->assign("send", "Send");
        	} else {
        		$template->assign("enterCode", "Код с картинки");
        		$template->assign("send", "Отправить");
        		}

		$template->assign("body", $subBody);
		#$this->data['content'] = $template->get();
		#return true;
		return '1';
		*/
	}

	function sendFb() {
		global $_POST, $smarty;

		// check post data
		$postArray = slashArray($_POST);
        $error     = false;
        $errorField = false;
		$messageBody = "";
		$checkEmail = "";
						if (empty($postArray))
                        {


                            $template = clone $smarty;
                            $this->data['content'] = $template->fetch(api::setTemplate('modules/fb/index.form.body.html'));		


                        
                        }
        else 
        {

                                                                                     
                        
                           
                           
                           
                            if (empty($postArray['Площадь']))  $error='Площадь';			
                            if (empty($postArray['email']))    $error='email';   			
                            if (empty($postArray['phone']))    $error='phone';                  		                  
                            if (empty($postArray['cname']))    $error='cname';       
                                          
                            $cname = $_POST['cname'];
                            $from = 'admin';

                        #if(empty($cname)) return "поле 'имя' не может быть пустым";
						$fname = @$_POST['fname'];
						$email = $_POST['email'];
						#if(empty($email)) return "поле 'email' не может быть пустым";
						$message = $_POST['message'];
						#if(empty($message)) return "поле 'сообщение' не может быть пустым";
						$theme = @$_POST['theme'];
        
        
        
        
        
                            



        if ($error)
        {
                            $template = clone $smarty;
                            $template->assign('error',$error);
                            $template->assign('post',$_POST);
                            $this->data['content'] = $template->fetch(api::setTemplate('modules/fb/index.form.body.html'));		
                            return false; 
        }

            
        foreach($postArray as $key=>$row):
            $message.="\r\n";
            $message.=$key.': ';
            @$html.=(gettype($row)=='array') ? implode(',',$row) : $row;
        endforeach;

		$header  = "From: ".$from."\n";
		$header .= "MIME-Version: 1.0\n";
		$header .= "Content-Type: text/plain; charset=utf-8;\n";
        
        //$header .= "Content-Transfer-Encoding: base64;\n";
        

    

		//$body = base64_encode($messageBody);
		foreach ($this->toArray as $row)
			mail($row, "Письмо с сайта ".$from, $cname."\n".$message.' '.$email, $header);
        
        $this->data['content'] = "<div class='box-cont'><div style='padding:50px;'><h1>
            Ваша заявка успешно отправлена.
            </h1>
            В ближайшее время с Вами встретится наш менеджер, для уточнения деталей заказа.
            </div></div>";		
			#return "Письмо успешно отправлено";

		#message($this->lang['ok'], $this->lang['okDesc'], "index.php");


		#return true;
	    }
    }


	function __construct() {
		$cfgValue = api::getConfig("modules", $this->mDir, "sendEmailTo");
		if (!empty($cfgValue)) {
			$this->to = $cfgValue;
		};

		$cfgValue = api::getConfig("modules", $this->mDir, "fromEmail");
		if (!empty($cfgValue)) {
			$this->fromEmail = $cfgValue;
		};

	}
}

?>
