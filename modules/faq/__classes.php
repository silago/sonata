<?php
if (!defined("API")) {
	exit("Main include fail");
}

class faq {
	public $data = array();
	public $lang = "";
	public $curLang = "ru";
	protected $assignArray = array();

	public function show() {
		global $sql, $lang;

		$sql->query("SELECT `id`, `question`, `answer`, DATE_FORMAT(`date`, '%d/%m/%Y') FROM #__#faq WHERE `lang` = '".$lang."' && `status` = '1' ORDER BY `date` DESC" );
		if ((int)$sql->num_rows() < 1) {
			$template  = new template(api::setTemplate("modules/faq/index.show.noQuestion.html"));
			@$this->data['content'] = $template->get();
		} else {
			$template 		= new template(api::setTemplate("modules/faq/index.show.question.html"));
			
			$question_list = '';
			while ($sql->next_row()) {
				$template->assign("id", 		$sql->result[0]);
				$template->assign("question",	$sql->result[1]);
				$template->assign("answer",		$sql->result[2]);
				$template->assign("date",		$sql->result[3]);
				$question_list .= $template->get();
			}
			
			$template	= new template(api::setTemplate("modules/faq/index.show.questinCont.body.html"));
			$template->assign("body", $question_list);

			$this->data['content'] = $template->get();
		}		
		
		$template = new template(api::setTemplate("modules/faq/index.ask.form.html"));
		@$template->assign("error", $this->data['error']);
		@$template->assign("valueQuestion", strip($this->data['question']));
		$this->data['content'] .= $template->get();
	return true;
	}


	public function ask() {
		global $_POST, $sql, $mail, $API;
		@$this->data['question'] = slash(htmlspecialchars(trim($_POST['question'])));
		if (!isset($_POST['checkCode']) || empty($_POST['checkCode']) || sl($_POST['checkCode']) != sl($_SESSION['imageCheckCode'])) {$this->data['error'] = 'Неверный код'; return $this->show();}
		if (empty($this->data['question'])) {$this->data['error'] = "Вы не ввели вопрос"; return $this->show();}

		$sql->query("INSERT INTO #__#faq(`question`, `answer`, `date`, `status`, `lang`) VALUES('".$this->data['question']."', '', NOW(), '0', '".$this->curLang."');");
		// Отсылка письмо с телом вопроса
		$textBody = $this->lang['body']."\n\n". $this->lang['question']." ".$this->data['question']."\n\nhttp://".getenv("HTTP_HOST")."/admin/";

		$mail->ClearAllRecipients();
		$mail->ClearAttachments();
		$mail->ClearCustomHeaders();
		$mail->ClearReplyTos();

		$mail->isHTML(false);

		$mail->Body = $textBody; // Боди в HTML

		$mail->Subject = $this->lang['subject']; // тема
		$mail->AddReplyTo("No reply", "no.reply@".getenv("HTTP_HOST")); // ответить кому
		$mail->From = "no.reply@".getenv("HTTP_HOST"); // от кого
		$mail->FromName = "Оповещение: модуль вопрос-ответ"; // от кого - текст
		$mail->AddAddress(api::getConfig("modules", 'faq', "supportEmail"), "Администратор сайта"); // Отправить кому
		$mail->Send();
		
		message($this->lang['sendOK'], $this->lang['sendOKDesk'], "faq/index.php");
		exit(0);
	}
	


	public function adminList() {
		global $sql;

		$sql->query("SELECT `id`, `question`, `status` FROM #__#faq WHERE `lang` = '".$this->curLang."' ORDER BY `date`, `status`");
		$template = new template(api::setTemplate("modules/faq/admin.list.item.html"));

		$body = "";

		while ($sql->next_row()) {
			$template->assign("id", $sql->result[0]);
			$template->assign("question", $sql->result[1]);
			$template->assign("ans", ((int)$sql->result[2] === 1 ? $this->lang['answerd'] : ((int)$sql->result[2] === 0 ?  $this->lang['unAnswerd'] : "")));
			$body .= $template->get();
		}

		$template = new template(api::setTemplate("modules/faq/admin.list.body.html"));
		$template->assign("body", $body);
		$this->data['content'] = $template->get();
		return true;
	}

	public function adminEdit() {
		global $_GET, $sql;

		@$id = (int)$_GET['id'];
		if (empty($id)) page500();

		$sql->query("SELECT `question`, `answer` FROM #__#faq WHERE `id` = '".$id."'", true);
		if ((int)$sql->num_rows() !== 1) {
			page500();
		}

		$this->assignArray = array(
									"error" 	=> "",
									"id"		=> $id,
									"question"	=> $sql->result[0],
									"answer"	=> $sql->result[1],
									);
		$this->showEditForm();

	}

	protected function showEditForm() {
		$template =  new template(api::setTemplate("modules/faq/admin.edit.form.html"));

		foreach ($this->assignArray as $key=>$value) {
			$template->assign($key, $value);
		}

		$editorForm = new FCKeditor('answer') ;
        $editorForm->Value  = $this->assignArray['answer'];
        $editorForm->Height = 450;

		$template->assign("answerForm", $editorForm->CreateHtml());
		$this->data['content'] = $template->get();
	}


	public function adminEditGo() {
		global $_POST, $_GET, $sql;

		$this->assignArray = array(
									"error" 	=> "",
									"id"		=> (int)$_GET['id'],
									"question"	=> $_POST['question'],
									"answer"	=> $_POST['answer'],
									);

		if (empty($_POST['answer'])) {
			$this->assignArray['error'] = $this->lang['noAnswer'];
			return $this->showEditForm();
		}

		$sql->query("UPDATE #__#faq SET
										`question` = '".$this->assignArray['question']."',
										`answer`   = '".$this->assignArray['answer']."',
										`status` = '1'
										WHERE `id` = '".(int)$_GET['id']."'");

		message("Информация успешно обновлена", "", "admin/faq/index.php");
		return true;
	}

	public function adminDelete() {
		global $_GET, $sql;

		if (empty($_GET['id'])) page500();

		$sql->query("SELECT COUNT(*) FROM #__#faq WHERE `id` = '".(int)$_GET['id']."'", true);
		if ((int)$sql->result[0] !== 1) {
			page500();
		}

		$sql->query("DELETE FROM #__#faq WHERE `id` = '".(int)$_GET['id']."'");

		message($this->lang['delOk'], "", "admin/faq/index.php");
		return true;

	}

}


?>
