<?php
if (!defined("API")) {
	exit("Main include fail");
}

class tags {
	public $lang			= "";
	public $curLang 		= "ru";
	public $assignArray		= array();
	public $data			= array();
	public $postData		= array();
	public $getData			= array();
	private $filesArray		= array();
	private $error			= "";
	
	private $dbtName			= 'tags';
	
	private $mDir 			= 'tags';
	private $logoDir		= 'userfiles/tags/';
	private $logoWidth		= 100;
	private $logoHeight		= 100;

 	public function adminAddTag() {
 		$template = new template(api::setTemplate('modules/'.$this->mDir.'/admin.add.form.html'));

		$this->assignArray['action'] = (isset($this->data['id']) && !empty($this->data['id']) ? $this->lang['edit'] : $this->lang['add']);
		$this->assignArray['error']  = $this->error;

		$this->assignArray();

 		foreach ($this->assignArray as $key=>$value) {
 			$template->assign($key, strip($value));
 		}

		$this->data['content'] = $template->get();
		
 		return true;
 	}

	public function adminAddGo() {
		global $_POST, $_GET, $_FILES, $sql;

		$this->data['id'] 		= @(int)$_GET['id'];
		$this->data['name']	= $_POST['name']; 
		
				
		if (empty($this->data['name'])) {
			$this->error = $this->lang['emptyTitle'];
			return $this->adminAddTag();
		}

		if (empty($this->data['id'])) {
			 
			$sql->query("INSERT INTO ".$this->dbtName." SET `name` = '".$this->data['name']."'");
			
			message($this->lang['addOk'], "", "admin/tags/index.php");

		} else {			
			 
				$sql->query("UPDATE ".$this->dbtName." SET 
															`name` = '".$this->data['name']."' 
													   WHERE `id` = '".$this->data['id']."'"); 
			
			message($this->lang['editOk'], "", "admin/tags/index.php");
		}

		return true;
	}

	public function adminEdit($id) {
		global $sql;

		if ($id < 1) {
			page500();
		}
		
		$sql->query("SELECT * FROM ".$this->dbtName." WHERE `id` = '".$id."'", true);
		
		if ((int)$sql->num_rows() !== 1) {
			page500();
		}
		 
		
		$this->data['id'] 		= $id;		
		$this->data['name']	= $sql->result['name']; 

		$this->assignArray();
		
		$this->adminAddTag();

	}

	public function adminList() {
        
		global $sql;

		$sql->query("SELECT `id`, `name` from ".$this->dbtName." ORDER BY `id` DESC");

		$template = new template(api::setTemplate('modules/'.$this->mDir.'/admin.list.item.html'));

		$body = ""; 
		
		while ($sql->next_row()) {
			$template->assign('id', $sql->result[0]);
			$template->assign('name',$sql->result[1]);
			$body .= $template->get();
		}
		
		$template = new template(api::setTemplate('modules/'.$this->mDir.'/admin.list.body.html'));
		$template->assign('body', $body);
		$this->data['content'] = $template->get();
		
		return true;
	}

	public function adminDelete($id) {
		global $sql;
		
		$sql->query("DELETE FROM ".$this->dbtName." WHERE `id` = '".$id."'");

		message($this->lang['deleteOk'], "", "admin/tags/index.php");
	}

	private function assignArray() {
		foreach ($this->data as $key => $value) {
			$this->assignArray[$key] = $value;
		}
		return true;
	}

	function __construct() {
		global $config;
        $cfgValue = $config->getValue('modules', 'brands', 'logoDir'); 
		if (!empty($cfgValue)) {
			$this->logoDir = $cfgValue;
		}
		
		$cfgValue = $config->getValue('modules', 'brands', 'logoWidth');
		if (!empty($cfgValue)) {
			$this->logoWidth = $cfgValue;
		}
		
		$cfgValue = $config->getValue('modules', 'brands', 'logoHeight');
		if (!empty($cfgValue)) {
			$this->logoHeight = $cfgValue;
		}
	}

}


?>
