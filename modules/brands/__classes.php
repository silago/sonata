<?php
if (!defined("API")) {
	exit("Main include fail");
}

class brands {
	public $lang			= "";
	public $curLang 		= "ru";
	public $assignArray		= array();
	public $data			= array();
	public $postData		= array();
	public $getData			= array();
	private $filesArray		= array();
	private $error			= "";
	
	private $dbtName			= 'brands';
	
	private $mDir 			= 'brands';
	private $logoDir		= 'userfiles/brands/';
	private $logoWidth		= 100;
	private $logoHeight		= 100;

 	public function adminAddBrand() {
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
		$this->data['title']	= @$_POST['title'];
		$this->data['link'] 	= @$_POST['link'];
		$this->data['logo'] 	= @$_FILES['brendlogo']['tmp_name'];
		$this->data['descript'] = @$_POST['descript'];
		$this->data['showonmain'] = @($_POST['showonmain'] == 'on' ? 1 : 0);
		
				
		if (empty($this->data['title'])) {
			$this->error = $this->lang['emptyTitle'];
			return $this->adminAddBrand();
		}

		if (empty($this->data['id'])) {
						
			//загрузить картинкО
			$image = new image();
			$fName = '';

			if (!empty($this->data['logo']) && !($fName = $image->resizeEx($this->data['logo'], $this->data['title'], array($this->logoDir, $this->logoWidth, $this->logoHeight)))) {
				$this->error = $image->error;
				return $this->adminAddBrand();
			}
			
			$advfName = '';
			//$sql->query("INSERT INTO ".$this->dbtName." (`title`, `link`, `logo`, `descript`, `show_on_main`) VALUES ('".$this->data['title']."', '".$this->data['link']."', '".basename($fName)."', '".$this->data['descript']."', '". $this->data['showonmain'] ."')");
			$sql->query("INSERT INTO ".$this->dbtName." (`title`, `link`, `logo`, `descript`, `show_on_main`) VALUES ('".$this->data['title']."', '".$this->data['link']."', '".basename($fName)."', '".$this->data['descript']."', '0')");
			
			message($this->lang['addOk'], "", "admin/brands/index.php");

		} else {			
			if (!empty($this->data['logo'])) {
				
					$sql->query("SELECT logo FROM ".$this->dbtName." WHERE id='".$this->data['id']."'", true);
					@unlink($this->logoDir.$sql->result[0]);
				
					$image = new image();
					$fName = '';
				
					if (!($fName = $image->resizeEx($this->data['logo'], $this->data['title'], array($this->logoDir, $this->logoWidth, $this->logoHeight)))) {
						$this->error = $image->error;
						return $this->adminAddBrandForm();
					}
				
					$sql->query("UPDATE ".$this->dbtName." SET 
															`title` = '".$this->data['title']."', 
															`link` = '".$this->data['link']."', 
															`logo` = '".basename($fName)."', 
															`descript` = '".$this->data['descript']."', 
															`show_on_main` =  '".$this->data['showonmain']."'
													   WHERE `id` = '".$this->data['id']."'");				
			}
			else {
				$sql->query("UPDATE ".$this->dbtName." SET 
															`title` = '".$this->data['title']."', 
															`link` = '".$this->data['link']."', 
															`descript` = '".$this->data['descript']."', 
															`show_on_main` =  '".$this->data['showonmain']."'
													   WHERE `id` = '".$this->data['id']."'");
			}
			
			message($this->lang['editOk'], "", "admin/brands/index.php");
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
		
		if (!empty($sql->result['logo'])) {
			$logoForm = '<tr><td align="right">Текущее Лого:</td><td> <img src="/'.$this->logoDir.$sql->result['logo'].'" alt="pic" /></td></tr>';
		}
		else {
			$logoForm = '';
		}
		
		$this->data['id'] 		= $id;		
		$this->data['title']	= $sql->result['title'];
		$this->data['link'] 	= $sql->result['link'];
		$this->data['logo'] 	= $sql->result['logo'];
		$this->data['descript'] = $sql->result['descript'];
		$this->data['showonmain'] = ($sql->result['show_on_main'] == 1 ? ' checked="checked"': '');
		$this->data['photoForm'] = $logoForm;

		$this->assignArray();
		
		$this->adminAddBrand();

	}

	public function adminList() {
        
		global $sql;

		$sql->query("SELECT `id`, `title` from ".$this->dbtName." ORDER BY `id` DESC");

		$template = new template(api::setTemplate('modules/'.$this->mDir.'/admin.list.item.html'));

		$body = "";
		
		while ($sql->next_row()) {
			$template->assign('id', $sql->result[0]);
			$template->assign('title',$sql->result[1]);
			$body .= $template->get();
		}
		
		$template = new template(api::setTemplate('modules/'.$this->mDir.'/admin.list.body.html'));
		$template->assign('body', $body);
		$this->data['content'] = $template->get();
		
		return true;
	}

	public function adminDelete($id) {
		global $sql;
		
		$sql->query("SELECT `logo` FROM ".$this->dbtName." WHERE `id`=".(int)$id, true);
		if (!empty($sql->result[0])) unlink($this->logoDir.$sql->result[0]);

		$sql->query("DELETE FROM ".$this->dbtName." WHERE `id` = '".$id."'");

		message($this->lang['deleteOk'], "", "admin/brands/index.php");
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
