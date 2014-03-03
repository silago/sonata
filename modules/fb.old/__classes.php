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
	private $fromEmail = "admin@in-site.ru";

	private $mDir = "fb";


	function showFbForm() {
		global $sql, $_GET;

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

        if (isset($_GET['lang']) && $_GET['lang'] == "en") $template->assign("lang", "?lang=en");

        if (isset($_GET['lang']) && $_GET['lang'] == "en") {
        	$template->assign("enterCode", "Code:");
        	$template->assign("send", "Send");
        	} else {
        		$template->assign("enterCode", "Код с картинки");
        		$template->assign("send", "Отправить");
        		}

		$template->assign("body", $subBody);
		$this->data['content'] = $template->get();
		return true;
	}

	function sendFb() {
		global $_POST;

		// check post data
		$postArray = slashArray($_POST);
		$error     = false;
		$messageBody = "";
		$checkEmail = "";


		foreach ($this->lang['rows'] as $key=>$empty) {
			$rP = $this->lang['rows'][$key][0];
			$this->data[$rP] = htmlspecialchars($postArray[$rP]);

if (sl($_POST['checkCode']) != sl($_SESSION['imageCheckCode'])) {
	        if ($_GET['lang'] == "en") {
	        	$this->error = "Error: the code from a picture doesn't correspond";
	        	} else {
	        		$this->error = "Ошибка: код с картинки не соответствует";
	        		}
$error = true;}

			if ($this->lang['rows'][$key][2] == "email" && !$error) {
						$email = $_POST['email'];
            if (!checkEmail($email)) {
					$this->error = $this->lang['errorPost']."&laquo;".$this->lang['rows'][$key][1]."&raquo;";
					$error = true;
				}
			}



			if (@(int)$this->lang['rows'][$key][4] === 1) {
				if ((!isset($this->data[$rP]) || empty($this->data[$rP])) && !$error) {
					$this->error = $this->lang['empty']."&laquo;".$this->lang['rows'][$key][1]."&raquo;";
					$error = true;
				}
			}

			$messageBody .= $this->lang['rows'][$key][1].": ".$this->data[$rP]."\n\r";
		}

		if ($error === true) {
			return $this->showFbForm();
		}

		// Creating headers
		$header  = "From: ".$this->fromEmail."\n";
		$header .= "MIME-Version: 1.0\n";
		$header .= "Content-Type: text/plain; charset=utf-8;\n";
		//$header .= "Content-Transfer-Encoding: base64;\n";



		//$body = base64_encode($messageBody);
		mail($this->to, $this->lang['subject'], $messageBody, $header);

		message($this->lang['ok'], $this->lang['okDesc'], "index.php");


		return true;
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