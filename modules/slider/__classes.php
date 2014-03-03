<?php
//
// slider Module by KMA
if (!defined("API")) {
	exit("Main include fail");
}


class slider{
	public $lang	= array();
	public $curLang	= 'ru';
	public $return	= array();
	public $mDir		= 'slider';
	public $returnPath	= '/admin/slider/index.php';
	
	private $error = '';
	private $getArray	= array();
	private $postArray	= array();
	private $filesArray = array();
	private $uriArray	= array();
	private $sql		= false;
	private $treeArray	= array();
	private $dataArray	= array();
	private $api		= array();

	private $dbName = 'slider';

	private $uploadImageDir		= "userfiles/image/slider/";

    private $limitsImage			= array(150, 150);

	private $adminListColumns	= 4;

	private $assignGroupsArray	= array("error" => "&nbsp;",);
	private $assignItemsArray	= array("error" => "&nbsp;",);

	private $module				= "";
	private $imagequality = 85;

	/* service functions */
	private function GenTree() {
		$query = "SELECT * FROM ".$this->dbName;
		$this->sql->query($query);
		if ($this->sql->num_rows() > 0) {
			while ($this->sql->next_row()) {
				$this->treeArray[$this->sql->result['id']] = array(	'owner'  => $this->sql->result['owner'],
        										'name' 	=> $this->sql->result['name'],
											'image' 	=> $this->sql->result['image'],
                                                                                        'imageCaption' => $this->sql->result['caption']
																);
			}
		}
		else { 
			return false;
		}
		
		return true;
	}
	
	private function GenSelect($selected = 0) {
		$result = '';
		switch ((int)$selected) {
			case 0:
                            $result = '	<option value="0" selected="selected">Слайдер на главной странице</option>';
				/*$result = '	<option value="0" selected="selected">Отель</option>
									<option value="1">Рестораны</option>
									<option value="2">Русские бани</option>
									<option value="3">О комплексе</option>';*/
			break;
			
			/*case 1:
				$result = '	<option value="0">Отель</option>
									<option value="1" selected="selected">Рестораны</option>
									<option value="2">Русские бани</option>
									<option value="3">О комплексе</option>';
			break;
			
			case 2:
				$result = '	<option value="0">Отель</option>
									<option value="1">Рестораны</option>
									<option value="2" selected="selected">Русские бани</option>
									<option value="3">О комплексе</option>';
			break;
			
			case 3:
				$result = '	<option value="0">Отель</option>
									<option value="1">Рестораны</option>
									<option value="2">Русские бани</option>
									<option value="3" selected="selected">О комплексе</option>';
			break;*/
			
			default:
				$result = false;
			break;
		}
		
		return $result;
	}
	
	private function FillDataArray($id) {
		$query = "SELECT * FROM ".$this->dbName." WHERE id='".$id."'";
		$this->sql->query($query, true);
		if ((int)$this->sql->num_rows() === 1) {
			$this->dataArray = array(	'id' => $id,
															'owner' => $this->sql->result['owner'],
															'imageTitle' => $this->sql->result['name'],
															'filename' => $this->sql->result['image'],
                                                                                                                        'imageCaption' => $this->sql->result['caption']);
		}
		else {
			return false;
		}
		return true;
	}
	
	private function ValidateForm() {
		if (!isset($this->postArray['owner']) || !isset($this->postArray['imageTitle'])) {			
			$this->error = 'ошибка: нет данных';
			return false;
		}
		else {			
			if (!is_numeric($this->postArray['owner'])) {
				$this->error = 'ошибка: неверный id';
				return false;
			}
			
			if (!preg_match('/^[A-Za-zА-Яа-яЁё0-9_ ]{3,20}$/u', $this->postArray['imageTitle'])) {
				$this->error = 'ошибка: имя должно быть от 3 до 15 символов и включать только буквы и цифры';
				return false;
			}
		}
		
		return true;
	}
	
	/* administration */
	private function addOrEditForm() {
		$template = new template(api::setTemplate("modules/".$this->mDir."/admin.add.or.edit.form.html"));
		//print_r($this->postArray);
		/* for edit action */
		if (isset($this->dataArray)) {
			$image_tag = isset($this->dataArray['filename']) ? '<tr><td><strong>Текущее изображение:</strong></td><td><img src="/'.$this->uploadImageDir.$this->dataArray['filename'].'" alt="'.@$this->dataArray['imageTitle'].'" width="150" /></tr></td>' : '';
			
			if (isset($this->dataArray['id'])) {
				$action_text = $this->lang['edit'];
				$id = $this->dataArray['id'];
			}
			else {
				$action_text = $this->lang['add'];
				$id = '';
			}
			
			$template->assign('id', $id);
			$template->assign('ownerSelect', @$this->GenSelect($this->dataArray['owner']));
			$template->assign('imageTitle', @$this->dataArray['imageTitle']);
			$template->assign('uploadedImage', $image_tag);
			$template->assign('action', $action_text);
                        $template->assign('imageCaption', @$this->dataArray['imageCaption']);
		}		
		else {
			$template->assign('ownerSelect', $this->GenSelect());
			$template->assign('action', $this->lang['add']);
		}
		
		$template->assign('imageSize', $this->limitsImage[0] . 'px х ' . $this->limitsImage[1] . 'px');
		$template->assign('returnPath', $this->returnPath);
		$template->assign('curLang', $this->curLang);
		$template->assign('error', $this->error);
		
		return $template->get();
	}
	
	public function adminListImages() {
		$this->treeArray = array();
		
		if ($this->GenTree()) {
			$bodyCat0 = '';
			$bodyCat1 = '';
			$bodyCat2 = '';
			$bodyCat3 = '';

			$template = new template(api::setTemplate("modules/".$this->mDir."/admin.list.images.item.html"));
			foreach ($this->treeArray as $key=>$value) {
				$template->assign('id', $key);
				$template->assign('name', $this->treeArray[$key]['name']);
                                
                                // Если подпись больше 25 симолов - обрезаем ее
                                $imgCapt = $this->treeArray[$key]['imageCaption'];
                                $imgCaptLen = strlen($imgCapt);//mb_strlen($imgCapt, 'UTF-8');
                                $imgCapt = $imgCaptLen < 25 ? $imgCapt : (mb_substr($imgCapt, 0, 24, 'UTF-8')."...");
                                
                                $template->assign('imagecaption', $imgCapt);
				$template->assign('imageURL', '/'.$this->uploadImageDir.$this->treeArray[$key]['image']);
				switch ((int)$this->treeArray[$key]['owner']) {
					case 0:
						$bodyCat0 .= $template->get();
					break;
					
					case 1:
						$bodyCat1 .= $template->get();
					break;
					
					case 2:
						$bodyCat2 .= $template->get();
					break;
					
					case 3:
						$bodyCat3 .= $template->get();
					break;
					default:
						page403();
					break;
				}
			}

			$template = new template(api::setTemplate("modules/".$this->mDir."/admin.list.images.body.html"));
			$template->assign("bodyCat0", $bodyCat0);
			$template->assign("bodyCat1", $bodyCat1);
			$template->assign("bodyCat2", $bodyCat2);
			$template->assign("bodyCat3", $bodyCat3);
			$this->return['content'] = $template->get();

			return true;
		}
		else {
			$template = new template(api::setTemplate("modules/".$this->mDir."/admin.list.images.body.html"));
			$template->assign("bodyCat0", $this->lang['emptyListPhotos']);
			$template->assign("bodyCat1", $this->lang['emptyListPhotos']);
			$template->assign("bodyCat2", $this->lang['emptyListPhotos']);
			$template->assign("bodyCat3", $this->lang['emptyListPhotos']);
			$this->return['content'] = $template->get();
			
			return false;
		}
	}

	public function adminAddImage() {
		unset($this->dataArray);
		
		$this->return['content'] = $this->addOrEditForm();
		return true;
	}
	



	public function adminAddImageGo() {
		$this->dataArray = $this->postArray;
		
		if (!$this->ValidateForm()) {
			$this->return['content'] = $this->addOrEditForm();
			return false;
		}
		
		if (!isset($this->filesArray['filename']['tmp_name']) || empty($this->filesArray['filename']['tmp_name'])) {
			$this->error = $this->lang['noPhoto'];
			$this->return['content'] = $this->addOrEditForm();
			return false;
		}
		
		$image = new image();
                // Кто-то заприватил свойство quality, поэтому больше так не катит
		//$image->quality = $this->imagequality;
                //$image->setQuality ($this->imagequality);
                
                $dest_fname = $image->genFileName();
                
                /* $src - source file name, 
                * $filename - dest file name w/o ext,  
                * $dest_image_size - array[dest dir, width, height], 
                * $crop - bool cut or fullfil area, 
                * #not working yet# $round - bool round image, to setup what coroners round set $coroners[lt, rt, lb, rb] and $coroner_size 
                * $gray - bool b&w image
                */
                if (!$filename = $image->resizeEx($this->filesArray['filename']['tmp_name'], $dest_fname, array($this->uploadImageDir, $this->limitsImage[0], $this->limitsImage[1]), true, false, false))
                {
                    $this->error = $image->error;
                    $this->return['content'] = $this->addOrEditForm();
                    return false;
                }
                
		/*if (!$filename = $image->createGroup($this->filesArray['filename']['tmp_name'], array($this->uploadImageDir, $this->limitsImage[0], $this->limitsImage[1]))) {
			$this->error = $image->error;
			$this->return['content'] = $this->addOrEditForm();
			return false;
		}*/
		
		unset($image);
		
		$query = "INSERT INTO " . $this->dbName . " (name, image, owner, caption) VALUES ('" .  $this->postArray['imageTitle'] . "', '" . $filename . "', '" . $this->postArray['owner'] . "', '" . $this->postArray['imageCaption'] . "')";
		 
		$this->sql->query($query);
		
		message("OK", $this->lang['addPhotoOk'], $this->returnPath);
		
		return true;
	}
	
	public function adminEditImage() {
		$this->FillDataArray($this->getArray['id']);
		
		$this->return['content'] = $this->addOrEditForm();
		return true;
	}
	
	public function adminEditImageGo() {
		$this->FillDataArray($this->getArray['id']);
		$filename = $this->dataArray['filename'];
		                
		if (isset($this->filesArray['filename']['tmp_name']) && !empty($this->filesArray['filename']['tmp_name'])) {
			$image = new image();
			$image->quality = $this->imagequality;
                                                
			if (!$filename = $image->createGroup($this->filesArray['filename']['tmp_name'], array($this->uploadImageDir, $this->limitsImage[0], $this->limitsImage[1]))) {
				$this->error = $image->error;
				$this->return['content'] = $this->addOrEditForm();
				return false;
			}
			unset($image);
			
			unlink($this->uploadImageDir.$this->dataArray['filename']);
		}
		if ($this->ValidateForm()) {		
			$query = "UPDATE "
									. $this->dbName . 
							 " SET 
									name='" . $this->postArray['imageTitle'] . "', 
									owner='" . $this->postArray['owner']."', 
									image='" . $filename . "',
                                                                        caption='".$this->postArray['imageCaption'] ."'
							  WHERE 
									id='" . $this->getArray['id'] . "'";
									
			$this->sql->query($query);
			
			message("OK", $this->lang['editPhotoOk'], $this->returnPath);
		}
		else {
			$this->return['content'] = $this->addOrEditForm();
			return false;
		}
		
		return true;
	}
	
	public function adminDeleteImage() {
		if (!isset($this->getArray['id']) || !is_numeric($this->getArray['id'])) {
			page500();			
		}
		
		$query = "SELECT image FROM " . $this->dbName . " WHERE id='" . $this->getArray['id'] . "'";
		$this->sql->query($query, true);
		
		if ((int)$this->sql->num_rows() !== 1) {
			page500();
		}
		
		$filename = $this->sql->result['image'];
		
		$query = "DELETE FROM " . $this->dbName . " WHERE id='" . $this->getArray['id'] . "'";
		$this->sql->query($query);
		
		unlink($this->uploadImageDir.$filename);
		
		message("OK", $this->lang['deletePhotoOk'], $this->returnPath);
	}

	function __construct() {
		global $_GET, $_POST, $_FILES, $sql, $API, $_SESSION, $uri, $module, $smarty;
		
		$this->getArray		= api::slashData($_GET, true);
		$this->postArray	= api::slashData($_POST);
		$this->filesArray	= $_FILES;

		$this->uriArray		= $uri;
		$this->module		= $module;

    	$this->sql = &$sql;
    	$this->api = &$API;

		$cfgValue = api::getConfig("modules", $this->mDir, "uploadImageDir");
		if (!empty($cfgValue)) $this->uploadImageDir = $cfgValue;

		$cfgValue = api::getConfig("modules", $this->mDir, "limitsImage");
		if (!empty($cfgValue)) $this->limitsImage = explode(" ", $cfgValue);
		
		$cfgValue = api::getConfig("modules", $this->mDir, "imagequality");
		if (!empty($cfgValue)) $this->imagequality = (int)$cfgValue;
	}
}

?>
