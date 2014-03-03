<?php
if (!defined("API")) {
	exit("Main include fail");
}

	class config {
		public $lang = array();
		public $curLang = "ru";
		public $data = array();

		public function show() {
			$this->showMainConfig();
			return true;
		}

		private function showMainConfig() {
			global $sql;

			$sql->query("SELECT `name`, `value`, `description` FROM #__#config WHERE `category` = 'main' && `lang` = '".$this->curLang."'");

			$template = new template(api::setTemplate("modules/config/admin.show.config.item.html"));

			$body = "";

			while ($sql->next_row()) {
				$template->assign("category",		"main");
				$template->assign("type", 			"api");
				$template->assign("name", 			$sql->result[0]);
				$template->assign("value", 			$sql->result[1]);
				$template->assign("description",	$sql->result[2]);

				$body .= $template->get();
			}

			$template = new template(api::setTemplate("modules/config/admin.show.config.body.html"));

			$template->assign("blockTitle", 	$this->lang['mainConfigBlockTitle']);
			$template->assign("category",		"main");
			$template->assign("type", 			"api");

			$template->assign("body", 			$body);

			$this->data['content'] = $template->get();

			return true;
		}

		public function edit() {
			global $_GET, $sql;
			$getArray = slashArray($_GET);

			$category	= $getArray['category'];
			$type 		= $getArray['type'];
			$name 		= $getArray['name'];

			$sql->query("SELECT `value`, `description` FROM #__#config WHERE `category` = '".$category."' && `type` = '".$type."' && name = '".$name."' && `lang` = '".$this->curLang."'", true);

			if ((int)$sql->num_rows() !== 1) {
				page500();
			}

			$template = new template(api::setTemplate("modules/config/admin.edit.value.form.html"));
			$template->assign("category", $category);
			$template->assign("type", $type);
			$template->assign("name", $name);
			$template->assign("value", $sql->result[0]);
			$template->assign("description", $sql->result[1]);

			$this->data['content'] = $template->get();
		}

		public function editGo() {
			global $_POST, $sql;
			$postArray = slashArray($_POST);

			@$category	 = $postArray['category'];
			@$type 		 = $postArray['type'];
			@$name 		 = $postArray['name'];
			@$value 	 = $postArray['value'];
			@$description = $postArray['description'];

			if (empty($category) || empty($type) || empty($name)) {
				message($this->lang['error'], $this->lang['empty'], "admin/config/index.php");
			}

			$sql->query("UPDATE #__#config SET `value` = '".$value."', `description` = '".$description."' WHERE `category` = '".$category."' && `type` = '".$type."' && name = '".$name."' && `lang` = '".$this->curLang."'");
			message($this->lang['editOk'], "", "admin/config/index.php");
		}


		public function add() {
			global $_GET, $_POST, $sql;
			$getArray  = slashArray($_GET);
			$postArray = slashArray($_POST);

			$template = new template(api::setTemplate("modules/config/admin.add.value.html"));
			$template->assign("category", $getArray['category']);
			$template->assign("type", $getArray['type']);
			$this->data['content'] = $template->get();
		}


		public function addGo() {
			global $_GET, $_POST, $sql;
			$getArray  = slashArray($_GET);
			$postArray = slashArray($_POST);

			$category	= $getArray['category'];
			$type 		= $getArray['type'];
			$name 		= $postArray['name'];
			$value 	 = $postArray['value'];
			$description = $postArray['description'];

			$sql->query("SELECT `value`, `description` FROM #__#config WHERE `category` = '".$category."' && `type` = '".$type."' && name = '".$name."' && `lang` = '".$this->curLang."'", true);

			if ((int)$sql->num_rows() !== 0) {
				page500();
			}

			if (empty($category) || empty($type) || empty($name)) {
				message($this->lang['error'], $this->lang['empty'], "admin/config/index.php");
			}

			$sqlQuery = "INSERT INTO #__#config(`category`, `type`, `name`, `value`, `description`, `lang`) VALUES('".$category."', '".$type."', '".$name."', '".$value."', '".$description."', '".$this->curLang."')";
			$sql->query($sqlQuery);
			message($this->lang['addOk'],  '', "admin/config/index.php");
		}

		public function delete() {
			global $_GET, $sql;
			$getArray = slashArray($_GET);

			$category	= $getArray['category'];
			$type 		= $getArray['type'];
			$name 		= $getArray['name'];

			$sql->query("SELECT `value`, `description` FROM #__#config WHERE `category` = '".$category."' && `type` = '".$type."' && name = '".$name."' && `lang` = '".$this->curLang."'", true);

			if ((int)$sql->num_rows() !== 1) {
				page500();
			}

			$sql->query("DELETE FROM #__#config WHERE `category` = '".$category."' && `type` = '".$type."' && name = '".$name."' && `lang` = '".$this->curLang."'");
			message($this->lang['deleteOk'], "", "admin/config/index.php");


		}

	}
?>