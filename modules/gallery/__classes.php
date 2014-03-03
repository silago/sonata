<?php
//
// Photo Gallery Module
//
// (C) Oskorbin Sergey, 2006
// E-mail: os@irj.ru
//
// Shareware version
// All rights reserverd
//
// Ver: 3.0.0
//

if (!defined("API")) {
	exit("Main include fail");
}


class gallery{
	public $lang	= array();
	public $curLang	= "ru";
	public $return	= array();
	public $returnPath	= "/admin/gallery/index.php";
	public $mDir		= "gallery";
	public $smarty		= false;

	private $getArray	= array();
	private $postArray	= array();
	private $filesArray = array();
	private $uriArray	= array();
	private $data		= array();
	private $sql		= false;
	private $treeArray	= array();
	private $api		= array();

	private $dbGroupsTable = "gallery_groups";
	private $dbImagesTable = "gallery_images";

	private $uploadImageGroupDir		= "upload/images/gallery/group/";
	private $uploadImageThumbDir		= "upload/images/gallery/thumb/";
	private $uploadImageBigDir			= "upload/images/gallery/";

    private $limitsImageGroup			= array(150, 150);
    private $limitsImageThumb			= array(100, 100);
	private $limitsImagePreview			= array(500, 500);
    private $limitsImageBig				= array(0, 0);

	private $adminListColumns	= 4;

	private $assignGroupsArray	= array("error" => "&nbsp;",);
	private $assignItemsArray	= array("error" => "&nbsp;",);

	private $module				= "";

	/*********************************** ADMIN GROUPS ***************************/
	public function addGroup() {
		if (!isset($this->getArray['go']) || $this->getArray['go'] !== "go") {
			if (isset($this->getArray['ownerId'])) {
				$this->data['ownerId'] = (int)@$this->getArray['ownerId'];
			}
			$this->groupAddOrEditShowForm();
		}
		else {
			$this->groupAddGo();
		}
		return true;
	}

	private function groupAddOrEditShowForm() {
		$this->assignGroupsArray = array_merge($this->assignGroupsArray, $this->data);
		$this->assignGroupsArray = api::quoteReplace($this->assignGroupsArray, array("groupTitle", "navigationMainTitle", "md", "mk"));

		$this->assignGroupsArray['action'] = isset($this->data['id']) && !empty($this->data['id']) ? $this->lang['edit'] : $this->lang['add'];
		$halt = (isset($this->data['id']) && !empty($this->data['id']) ? $this->data['id'] : -1);

		$this->assignGroupsArray['selectOwnerId'] = $this->genOwnerIdSelect($halt);

		if (isset($this->data['id']) && !empty($this->data['id'])) {
			$this->sql->query("SELECT `thumb` FROM `".$this->dbGroupsTable."` WHERE `id` = '".$this->data['id']."'", true);
			if ((int)$this->sql->num_rows() !== 1) {
				page500();
			}

			if (!empty($this->sql->result[0])) {
				$template = new template(api::setTemplate("modules/".$this->mDir."/admin.show.image.html"));
				$template->assign("id", $this->data['id']);
				$template->assign("type", "group");
				$template->assign("imageUri", $this->uploadImageGroupDir.baseName($this->sql->result[0]));
				$this->assignGroupsArray['thumb'] = $template->get();
			}
		}

		$template = new template(api::setTemplate("modules/".$this->mDir."/admin.add.or.edit.group.form.html"));

		$editorForm = new FCKeditor('text') ;
		if (isset($this->data['groupDescription']))
			$editorForm->Value = $this->data['groupDescription'];
		else
			$editorForm->Value = '';

        $editorForm->Height = 450;
        $textForm=$editorForm->CreateHtml();
		$template->assign('wysiwygEditor', $textForm);

		foreach ($this->assignGroupsArray as $key => $value) {
			$template->assign($key, stripslashes($value));
		}
		$this->return['content'] = $template->get();
		return true;
	}

	private function groupAddGo() {
		$this->data	= @array("id" => (int)$this->getArray['id'],
							"groupTitle" => $this->postArray['groupTitle'],
							"ownerId" => (int)$this->postArray['ownerId'],
							"groupThumb"	=> $this->filesArray['groupThumb']['tmp_name'],
							"template" => $this->postArray['template'],
							"navigationShow" => substr(strtolower($this->postArray['navigationShow']), 0, 1),
							"navigationMainTitle" => $this->postArray['navigationMainTitle'],
							"md" => $this->postArray['md'],
							"mk" => $this->postArray['mk'],
							"lang" => $this->curLang,
							"groupDescription" => $this->postArray['text'],
							);

		if (!empty($this->data['id'])) {
			$this->sql->query("SELECT COUNT(*) FROM `".$this->dbGroupsTable."` WHERE `id` = '".$this->data['id']."'", true);
			if ((int)$this->sql->result[0] !== 1) {
				page500();
			}
		}


		if (empty($this->data['groupTitle'])) {
			$this->data['error'] = $this->lang['emptyGroupTitle']; return $this->groupAddOrEditShowForm();
		}

		if ($this->data['ownerId'] !== 0) {
			$this->sql->query("SELECT COUNT(*) FROM `".$this->dbGroupsTable."` WHERE `id` = '".$this->data['ownerId']."'", true);
			if ((int)$this->sql->result[0] !== 1) {
				$this->data['error'] = $this->lang['ownerGroupIdIsNotExists']; return $this->groupAddOrEditShowForm();
			}
		}
/*
		if (!empty($this->data['template']) && !preg_match("/^[0-9a-z\-\._\/\:]+$/i", $this->data['template'])) {
			$this->data['error'] = $this->lang['templateIncorrect']; return $this->groupAddOrEditShowForm();
		}
*/
		if (!empty($this->data['groupThumb']) && !file_exists($this->data['groupThumb'])) {
			$this->data['error'] = $this->lang['errorUploadFile']; return $this->groupAddOrEditShowForm();
		}

		if ($this->data['navigationShow'] !== "y" && $this->data['navigationShow'] !== "n") {
			$this->data['navigationShow'] = "n";
		}

		if (!empty($this->data['id'])) {
			$this->editGroupSql();
		}
		else {
			$this->addGroupSql();
		}

		return true;
	}

	private function addGroupSql() {

		if (!empty($this->data['groupThumb'])) {
			$image = new image();
			
			$groupImageData = array($this->uploadImageGroupDir, $this->limitsImageGroup[0], $this->limitsImageGroup[1]);
			$newImageFileName = $image->createGroup($this->data['groupThumb'], $groupImageData);

			if ($newImageFileName === false) {
				$this->data['error'] = $image->error;
				return $this->groupAddOrEditShowForm();
			}
			else {
				$this->data['groupThumb'] = $newImageFileName;
			}
		}

		$this->sql->query("INSERT INTO `".$this->dbGroupsTable."`(
															`title`,
															`owner`,
															`thumb`,
															`template`,
															`navigation_show`,
															`navigation_title`,
															`mk`,
															`md`,
															`lang`,
															`position`,
															`description`
															) VALUES (
																		'".$this->data['groupTitle']."',
																		'".$this->data['ownerId']."',
																		'".$this->data['groupThumb']."',
																		'".$this->data['template']."',
																		'".$this->data['navigationShow']."',
																		'".$this->data['navigationMainTitle']."',
																		'".$this->data['mk']."',
																		'".$this->data['md']."',
																		'".$this->data['lang']."',
																		'0',
																		'".$this->sql->escape($this->data['groupDescription'])."'
																)");

		$this->sql->query("UPDATE `".$this->dbGroupsTable."` SET `position` = `id` WHERE `position` = '0'");
		message("OK", $this->lang['groupAddOk'], "admin/".$this->mDir."/addGroup.php");


	}

	public function editGroup() {
		if (!isset($this->getArray['go']) || $this->getArray['go'] !== "go") {
			$this->getGroupValues();
			$this->groupAddOrEditShowForm();
		}
		else {
			$this->groupAddGo();
		}
		return true;
	}

	private function getGroupValues() {
		$id = (int)@$this->getArray['id'];

		if (empty($id)) {
			page500();
		}

		$this->sql->query("SELECT
									`title`,
									`owner`,
									`thumb`,
									`template`,
									`navigation_show`,
									`navigation_title`,
									`md`,
									`mk`,
									`description`
							FROM
									`".$this->dbGroupsTable."`
							WHERE
									`id` = '".$id."'", true);
		if ((int)$this->sql->num_rows() === 0) {
			message($this->lang['error'], $this->lang['editGroupIncorrectId']);
		}

		$this->data	= array(
							"id" => $id,
							"groupTitle" => $this->sql->result[0],
							"ownerId" => $this->sql->result[1],
							"groupThumb" => $this->sql->result[2],
							"template" => $this->sql->result[3],
							"navigationShow" => $this->sql->result[4],
							"navigationMainTitle" => $this->sql->result[5],
							"md" => $this->sql->result[6],
							"mk" => $this->sql->result[7],
							"groupDescription" => $this->sql->result[8],
							);

		return true;
	}

	private function editGroupSql() {
		if (!empty($this->data['groupThumb'])) {
			$image = new image();
			
			$groupImageData = array($this->uploadImageGroupDir, $this->limitsImageGroup[0], $this->limitsImageGroup[1]);
			$newImageFileName = $image->createGroup($this->data['groupThumb'], $groupImageData);
		
			if ($newImageFileName === false) {
				$this->data['error'] = $image->error;
				return $this->groupAddOrEditShowForm();
			}
			else {
				$this->data['groupThumb'] = $newImageFileName;
			}
			
			$this->sql->query("SELECT `thumb` FROM `".$this->dbGroupsTable."` WHERE `id` = '".$this->data['id']."'", true);
			
			if (!empty($this->sql->result[0])) {
				@unlink($this->sql->result[0]);
			}
		}

		$this->sql->query("UPDATE `".$this->dbGroupsTable."` SET
														`title` = '".$this->data['groupTitle']."',
														`owner` = '".$this->data['ownerId']."',
														".(!empty($this->data['groupThumb']) ? "`thumb` = '".$this->data['groupThumb']."'," : "")."
														`template` = '".$this->data['template']."',
														`navigation_show` = '".$this->data['navigationShow']."',
														`navigation_title` = '".$this->data['navigationMainTitle']."',
														`mk` = '".$this->data['mk']."',
														`md` = '".$this->data['md']."',
														`description` = '".$this->data['groupDescription']."'
													WHERE
														`id` = '".$this->data['id']."'");
        message("OK", $this->lang['editGroupOk'], "admin/".$this->mDir."/index.php");
	}

	private function genOwnerIdSelect($halt = -1, $addedTagInfo = "") {

		$this->treeArray = array();
		$this->genOwnerIdSelectRecr(0, $halt, 0);
		$return = "<select name=\"ownerId\"".$addedTagInfo."><option value=\"0\">НЕТ</option>";

		foreach ($this->treeArray as $key => $empty) {
			$return .= "<option value=\"".$key."\"".($key == @$this->data['ownerId'] ? " selected = \"selected\"" : "")." style=\"padding: 0 0 0 ".(30 * $this->treeArray[$key][1]).";\">".$this->treeArray[$key][0]."</option>";
		}
		$return .= "</select>";

		return $return;
	}

	private function genOwnerIdSelectRecr($ownerId, $halt, $level) {
		$queryId = mysql_query("SELECT `id`, `title`, `position` FROM `".$this->dbGroupsTable."` WHERE `lang` = '".$this->curLang."' && `owner` =  '".$ownerId."' ORDER BY `position`") or die(mysql_error());
		while ($result = mysql_fetch_array($queryId)) {
			$id = $result[0];
			$groupTitle = $result[1];
			if ($id != $halt && $ownerId != $halt) {
				$this->treeArray[$id] = array($groupTitle, $level, $result[2]);
				$this->genOwnerIdSelectRecr($id, $halt, $level + 1) ;
			}
		}

		return true;
	}

	public function listGroups() {
		$this->treeArray = array();
		$this->genOwnerIdSelectRecr(0, -1, 0);

		$body = "";

		$template = new template(api::setTemplate("modules/".$this->mDir."/admin.list.groups.item.html"));
		foreach ($this->treeArray as $key=>$value) {
			$template->assign("id", $key);
			$template->assign("groupTitle", $this->treeArray[$key][0]);
			$template->assign("level", ($this->treeArray[$key][1] * 40));
			$template->assign("position", $this->treeArray[$key][2]);
			$template->assign("ggURL", 'http://'.$_SERVER['SERVER_NAME'].'/gallery/'.$key.'/album.html');
			$body .= $template->get();
		}

		if (count($this->treeArray) === 0) {
			$body = $this->lang['emptyGroups'];
		}

		$template = new template(api::setTemplate("modules/".$this->mDir."/admin.list.groups.body.html"));
		$template->assign("body", $body);
		$this->return['content'] = $template->get();

		return true;
	}

	public function moveGroup() {
		api::move($this->getArray, $this->sql, "gallery_groups", "owner");
	}

	public function managerGroup() {
		$this->data['ownerId'] = $ownerId = (int)@$this->getArray['id'];

		$this->sql->query("SELECT `title` FROM `".$this->dbGroupsTable."` WHERE `id` = '".$ownerId."'", true);
		if ((int)$this->sql->num_rows() !== 1) {
			message($this->lang['error'], $this->lang['editGroupIncorrectId']);
		}

		$body = "";

		api::setReturnPath();

		$template = new template(api::setTemplate("modules/".$this->mDir."/admin.manage.group.html"));
		$template->assign("ownerId", $ownerId);
		$template->assign("groupTitle", $this->sql->result[0]);
		$template->assign("images", $this->listImages());
		$this->return['content'] = $template->get();
	}

	/************************************ ADMIN IMAGES *******************************************/
	public function addImage() {
		$this->data['ownerId'] = (int)@$this->getArray['ownerId'];

		$this->sql->query("SELECT COUNT(*) FROM `".$this->dbGroupsTable."` WHERE `id` = '".$this->data['ownerId']."'", true);
		if ((int)$this->sql->result[0] !== 1) {
			message($this->lang['error'], $this->lang['editGroupIncorrectId']);
		}

		if (!isset($this->getArray['go']) || $this->getArray['go'] !== "go") {
			$this->addOrEditImageShowForm();
		}
		else {
				$this->addImageGo();
		}

		return true;
	}

	private function addOrEditImageShowForm() {

		$this->assignItemsArray['action'] = @!empty($this->data['id']) ? $this->lang['edit'] : $this->lang['add'];
		$this->assignItemsArray['selectOwnerId'] = $this->genOwnerIdSelect(-1, " disabled=\"disabled\"");
		$this->assignItemsArray['returnPath'] = $this->returnPath;

		if (isset($this->data['id']) && !empty($this->data['id'])) {
			$this->sql->query("SELECT `filename` FROM ".$this->dbImagesTable." WHERE `id` = '".$this->data['id']."'", true);
			if ((int)$this->sql->num_rows() !== 1) {
				page500();
			}

			$template = new template(api::setTemplate("modules/".$this->mDir."/admin.show.image.html"));
			$template->assign("id", $this->data['id']);
			$template->assign("type", "group");
			$template->assign("imageUri", $this->uploadImageThumbDir.basename($this->sql->result[0]));
			$this->assignItemsArray['uploadedImage'] = $template->get();

		}

		$template = new template(api::setTemplate("modules/".$this->mDir."/admin.add.or.edit.image.form.html"));

		$this->assignItemsArray = array_merge($this->assignItemsArray, $this->data);

		$this->assignItemsArray = api::quoteReplace($this->assignItemsArray, array("imageTitle", "md", "mk"));

		foreach ($this->assignItemsArray as $key=>$value) {
			$template->assign($key, stripslashes($value));
		}
		$this->return['content'] = $template->get();

		return true;
	}

	private function addImageGo() {
        $this->data = array(
        					"id" => (int)@$this->getArray['id'],
        					"ownerId" => (int)@$this->getArray['ownerId'],
        					"imageTitle" => @$this->postArray['imageTitle'],
        					"filename" => @$this->filesArray['filename']['tmp_name'],
        					"description" => @$this->postArray['description'],
        					"mk" => @$this->postArray['mk'],
        					"md" => @$this->postArray['md'],

        					);

  		$this->sql->query("SELECT COUNT(*) FROM `".$this->dbGroupsTable."` WHERE `id` = '".$this->data['ownerId']."'", true);
  		if ((int)$this->sql->result[0] !== 1) {
  			$this->data['error'] = $this->lang['editGroupIncorrectId'];
  			$this->addOrEditImageShowForm();
			return true;
  		}


  		if (empty($this->data['imageTitle'])) {
  			$this->data['error'] = $this->lang['noTitlePhoto'];/*lang file*/
  			$this->addOrEditImageShowForm();
			return true;
  		}

  		if (empty($this->data['filename']) && empty($this->data['id'])) {
  			$this->data['error'] = $this->lang['noPhoto'];/*lang file*/
  			$this->addOrEditImageShowForm();
			return true;
  		}


		if (empty($this->data['id'])) {
			return $this->addImageSql();
		}
		else {
			return $this->editImageSql();
		}

	}

	private function addImageSql() {
		$image = new image();

		$bigImageData = array($this->uploadImageBigDir, $this->limitsImageBig[0], $this->limitsImageBig[1]);
		$thumbImageData = array($this->uploadImageThumbDir, $this->limitsImageThumb[0], $this->limitsImageThumb[1]);
		$newImageFileName = $image->resizeEx($this->data['filename'], $bigImageData, $thumbImageData);
		
		if ($newImageFileName === false) {
			$this->data['error'] = $image->error;
			return $this->addOrEditImageShowForm();
		}
		
		$this->sql->query(
							"INSERT INTO `".$this->dbImagesTable."`(
															`title`,
															`owner`,
															`filename`,
															`description`,
															`md`,
															`mk`,
															`lang`
															)
							VALUES
															(
															'".$this->data['imageTitle']."',
															'".$this->data['ownerId']."',
															'".basename($newImageFileName)."',
															'".$this->data['description']."',
															'".$this->data['md']."',
															'".$this->data['mk']."',
															'".$this->curLang."'
															)

							");

		$this->sql->query("UPDATE `".$this->dbImagesTable."` SET `position` = `id` WHERE `position` = '0'");

		message("OK", $this->lang['addPhotoOk'], $this->returnPath);
	}

	public function editImage() {
		$this->data['id'] = @$this->getArray['id'];
		$this->sql->query("SELECT `title`, `owner`, `filename`, `description`, `md`, `mk` FROM `".$this->dbImagesTable."` WHERE `id` = '".$this->data['id']."'", true);
		if ((int)$this->sql->num_rows() !== 1) {
			page500();
		}

		if (isset($this->getArray['go']) && $this->getArray['go'] === "go") {
			return $this->addImageGo();
		}

		$this->data = array_merge($this->data, array(
													"imageTitle" => $this->sql->result[0],
													"ownerId" => $this->sql->result[1],
													"description" => $this->sql->result[3],
													"md" => $this->sql->result[4],
													"mk" => $this->sql->result[5],
													));
		$this->addOrEditImageShowForm();

	}

	private function editImageSql() {
	
		if (!empty($this->data['filename'])) {
			$image = new image();

			$bigImageData = array($this->uploadImageBigDir, $this->limitsImageBig[0], $this->limitsImageBig[1]);
			$thumbImageData = array($this->uploadImageThumbDir, $this->limitsImageThumb[0], $this->limitsImageThumb[1]);
			$newImageFileName = $image->resizeEx($this->data['filename'], $bigImageData, $thumbImageData);
			
			if ($newImageFileName === false) {
				$this->data['error'] = $image->error;
				return $this->addOrEditImageShowForm();
			}

				$this->sql->query("SELECT `filename` FROM `".$this->dbImagesTable."` WHERE `id` = '".$this->data['id']."'", true);
			
			@unlink($this->uploadImageThumbDir.$this->sql->result[0]);
			@unlink($this->uploadImageBigDir.$this->sql->result[0]);
		}

		$this->sql->query("UPDATE `".$this->dbImagesTable."` SET
														`title` = '".$this->data['imageTitle']."',
														`owner` = '".$this->data['ownerId']."',
														".(!empty($this->data['filename']) ? "`filename` = '".basename($newImageFileName)."'," : "")."
														`description` = '".$this->data['description']."',
														`md` = '".$this->data['md']."',
														`mk` = '".$this->data['mk']."'
														WHERE `id` = '".$this->data['id']."'");

		message("OK", $this->lang['editPhotoOk'], $this->returnPath);

	}

	public function listImages() {
		$this->sql->query("SELECT `id`, `title`, `filename`, `position` FROM `".$this->dbImagesTable."` WHERE `owner` = '".$this->data['ownerId']."' ORDER BY `position`");

		if ((int)$this->sql->num_rows() === 0) {
			return $this->lang['emptyListPhotos'];/*check*/
		}

		$body = "";
		$incr = 0;

		$template = new template(api::setTemplate("modules/".$this->mDir."/admin.list.images.item.html"));

		while($this->sql->next_row()) {
			$template->assign("id",				$this->sql->result[0]);
			$template->assign("imageTitle",		$this->sql->result[1]);
			$template->assign("imageThumbUri", 	"/".$this->uploadImageThumbDir.$this->sql->result[2]);
			$template->assign("position",		$this->sql->result[3]);

            if (($incr % $this->adminListColumns) === 0) {
				$body .= "</tr><tr><td colspan=\"".$this->adminListColumns."\">&nbsp;</td></tr><tr>";
            }
			$incr++;
			$body .= $template->get();

		}

		$template = new template(api::setTemplate("modules/".$this->mDir."/admin.list.images.body.html"));
		$template->assign("body", $body);
		return $template->get();
	}

	public function moveImage() {
		api::move($this->getArray, $this->sql, "gallery_images", "owner");
	}

	public function deleteImage() {
		$id = (int)$this->getArray['id'];
		$this->deleteImageSql($id);
		message("OK", $this->lang['deletePhotoOk'], $this->returnPath);

	}

	private function deleteImageSql($id) {
		$this->sql->query("SELECT ".(@$_GET['type'] == "group" ? "`thumb`" : "`filename`")." FROM ".(@$_GET['type'] == "group" ? "`".$this->dbGroupsTable."`" : "`".$this->dbImagesTable."`")." WHERE `id` = '".$id."'", true);
		if ((int)$this->sql->num_rows() !== 1) {
			return false;
		}

		@unlink($this->uploadImageThumbDir.$this->sql->result[0]);
		@unlink($this->uploadImageBigDir.$this->sql->result[0]);

		if (@$_GET['type'] == "group") {
			$this->sql->query("UPDATE `".$this->dbGroupsTable."` SET `thumb` = '' WHERE `id` = '".$id."'");
		}
		else {
			$this->sql->query("DELETE FROM `".$this->dbImagesTable."` WHERE `id` = '".$id."'");
		}

		return true;
	}

	public function deleteGroup() {
		$id = (int)$this->getArray["ownerId"];

		$this->sql->query("SELECT COUNT(*) FROM `".$this->dbGroupsTable."` WHERE `id` = '".$id."'", true);
		if ((int)$this->sql->result[0] !== 1) {
			page500();
		}
		$this->deleteGroupSql($id);

		message("OK", $this->lang['groupDeleted'], "/admin/".$this->mDir."/listGroups.php");

	}

	private function deleteGroupSql($id) {
		$sql = clone $this->sql;

		$sql->query("SELECT `id` FROM `".$this->dbImagesTable."` WHERE `owner` = '".$id."'");
		if ($sql->num_rows() > 0) {
			while ($sql->next_row()) $this->deleteImageSql($sql->result[0]);
		}

		$sql->query("SELECT `id` FROM `".$this->dbGroupsTable."` WHERE `owner` = '".$id."'");
		if ($sql->num_rows() > 0) {
			while ($sql->next_row()) $this->deleteGroupSql($sql->result[0]);
		}

		$sql->query("SELECT `thumb` FROM `".$this->dbGroupsTable."` WHERE `owner` = '".$id."'", true);
		if (!empty($sql->result[0])) {
			@unlink($sql->result[0]);
		}
		$sql->query("DELETE FROM `".$this->dbGroupsTable."` WHERE `id` = '".$id."'");
		unset($sql);

		return true;
	}



	/************************************************** INDEX *****************************************/
	public function indexShow($ownerId) {
		$groups = $this->indexShowGroups($ownerId);
		$images = $this->indexShowImages($ownerId);

		$body = '';

		$this->sql->query("SELECT `description`, `template`  FROM `".$this->dbGroupsTable."` WHERE `lang` = '".$this->curLang."' && `id` =  '".$ownerId."' ORDER BY `position`", true);

		$isSlider = false;

		if ($this->sql->result[1] == 'slider')
			$isSlider = true;

		if ($isSlider){
		if ($images != false)
			$body = $images;
		if (!empty($groups))
			$body .= "\r\n".$groups;
		}
		else {
		if (!empty($groups))
			$body = $groups;

		if ($images != false)
			$body .= "\r\n".$images;
		}

		if (empty($groups) && ($images == false))
			$body = $this->lang['isEmpty'];

		$template = new template(api::setTemplate("modules/".$this->mDir."/index.show.all.html"));
		$template->assign("body", $body);

		$this->sql->query("SELECT `owner` FROM `".$this->dbGroupsTable."` WHERE `lang` = '".$this->curLang."' && `id` =  '".$ownerId."'", true);

		if ($this->sql->num_rows() > 0) {
			$linkBack = ($this->sql->result[0] != 0) ? '<a class="back-link" href="/gallery/'.$this->sql->result[0].'/album.html?lang='.$this->curLang.'">'.$this->lang['back'].'</a>' : '<a class="back-link" href="/gallery/index.php?lang='.$this->curLang.'">'.$this->lang['back'].'</a>';
		}
		else {
			$linkBack = '';
		}

		$template->assign('back', $linkBack);

		$this->return['content'] = $template->get();
	}

	public function indexShowGroups($ownerId) {
		$this->setNavigationAndOtherInfo($ownerId);

		$this->sql->query("SELECT `id`, `title`, `thumb`, `description` FROM `".$this->dbGroupsTable."` WHERE `lang` = '".$this->curLang."' && `owner` =  '".$ownerId."' ORDER BY `position`");

		$body = '';

		if ($this->sql->num_rows() > 0) {
			$template = new template(api::setTemplate("modules/".$this->mDir."/index.show.groups.item.html"));
			
			while ($this->sql->next_row()) {
				$template->assign("id", $this->sql->result[0]);
				$template->assign("groupTitle", $this->sql->result[1]);
				$template->assign("groupThumb", '/'.$this->uploadImageGroupDir.basename($this->sql->result[2]));
				$template->assign("groupDesc", $this->sql->result[3]);
				$template->assign('groupShortTitle', trimString($this->sql->result[1], 60));
				$template->assign('lang', $this->curLang);

				$body .= $template->get();
			}
		}
		else {
			$body = '';
		}

		$template = new template(api::setTemplate("modules/".$this->mDir."/index.show.groups.body.html"));
		$template->assign("body", $body);

		$this->sql->query("SELECT `owner`, `description` FROM `".$this->dbGroupsTable."` WHERE `lang` = '".$this->curLang."' && `id` =  '".$ownerId."' ORDER BY `position`", true);

		if ($this->sql->num_rows() > 0) {
			$template->assign('parentDesc', $this->sql->result[1]);
		}
		else {
			$template->assign('parentDesc', '');
		}

		return $template->get();
	}

	private function indexShowImages($ownerId, $isSlider = false){
		$this->sql->query("SELECT `id`, `title`, `filename`, `description` FROM `".$this->dbImagesTable."` WHERE `lang` = '".$this->curLang."' && `owner` =  '".$ownerId."' ORDER BY `position`", true);

		$body = '';


		if ($this->sql->num_rows() > 0) {
			$id = $this->sql->result[0];
			
			$this->treeArray[$id] = array(
										 $this->sql->result[1],
										 '/'.$this->uploadImageThumbDir.$this->sql->result[2],
										 '/'.$this->uploadImageBigDir.$this->sql->result[2],
										 $this->sql->result[3],
										);

			while ($this->sql->next_row()) {
				$id = $this->sql->result[0];
				$this->treeArray[$id] = array(
											$this->sql->result[1],
											'/'.$this->uploadImageThumbDir.$this->sql->result[2],
											'/'.$this->uploadImageBigDir.$this->sql->result[2],
											$this->sql->result[3],
										);
			}

			$this->sql->query("SELECT `description`, `template`  FROM `".$this->dbGroupsTable."` WHERE `lang` = '".$this->curLang."' && `id` =  '".$ownerId."' ORDER BY `position`", true);

			if ($this->sql->result[1] == 'slider')
				$isSlider = true;

			if ($isSlider)
				$template = new template(api::setTemplate("modules/".$this->mDir."/index.show.images.item.slider.html"));
			else
				$template = new template(api::setTemplate("modules/".$this->mDir."/index.show.images.item.html"));

			foreach ($this->treeArray as $key=>$value) {
				$template->assign("id", $key);
				$template->assign("title", $this->treeArray[$key][0]);
				//$template->assign("titlejs", str_replace(array("'", "\""), array('\x27', '\x22'), $this->treeArray[$key][0]));
				$template->assign("imageThumb", $this->treeArray[$key][1]);
				$template->assign("imageBig", $this->treeArray[$key][2]);
				$template->assign("desc", $this->treeArray[$key][3]);
				$template->assign("album", $ownerId);

				$body .= $template->get();
			}
		}

		if (!empty($body)) {
			if ($isSlider)
				$template = new template(api::setTemplate("modules/".$this->mDir."/index.show.images.body.slider.html"));
			else
				$template = new template(api::setTemplate("modules/".$this->mDir."/index.show.images.body.html"));

			$template->assign('body', $body);
			
			//= быдлокод детектед =_=
			/*foreach ($this->treeArray as $key=>$value) {
				$template->assign("title", $this->treeArray[$key][0]);
				$template->assign("imagePreview", $this->treeArray[$key][2]);
				$template->assign("imageBig", $this->treeArray[$key][3]);
				break;
			}

			if ($this->sql->num_rows() > 0)
				$template->assign("groupDesc", $this->sql->result[0]);
			else
				$template->assign("groupDesc", '');
			*/
			return $template->get();
		}
		else
			return false;
	}

	private function setNavigationAndOtherInfo($ownerId, $addedNavigationMenuItems = array()) {
		$this->sql->query("SELECT `id`, `owner`, `title`, `template`, `navigation_show`, `navigation_title`, `md`, `mk` FROM `".$this->dbGroupsTable."` WHERE `lang` = '".$this->curLang."'");

		$result 	= array();
		$treeResult = array();

		$curId = $ownerId;

		while ($this->sql->next_row())
			$result[$this->sql->result[0]] = $this->sql->result;

		if (!isset($ownerId)) {
			page500();
		}

		if (count($result) < 1) {
			return false;
		}

		$forever = false;

		while ($ownerId != 0 && !$forever) {
			if (!isset($result[$ownerId]))
				break;
			@$incr++;
			if ($incr > 10000)
				$forever = true;

			array_unshift($treeResult, $result[$ownerId]);
			$ownerId = $result[$ownerId][1];
		}

		$pageTitle  = "";
		$template	= "";
		$md       	= "";
		$mk			= "";

		$navigation = new navigation();
		$navigation->setMainPage(empty($this->lang['navigationMainTitle']) ? api::getConfig("main", "api", "mainPageInNavigation") : $this->lang['navigationMainTitle']);

		if (!empty($this->lang['navigationTitle']))	$navigation->add($this->lang['navigationTitle'], "/".$this->mDir."/index.html");

		foreach ($treeResult as $key=>$value) {
			if ((!empty($treeResult[$key][3])) && ($treeResult[$key][3] != 'slider'))	$template = $treeResult[$key][3];
			if (!empty($treeResult[$key][6])) 	$md = $treeResult[$key][6];
			if (!empty($treeResult[$key][7])) 	$mk = $treeResult[$key][7];

			if ($treeResult[$key][4] == 'n') {
				$navigation->add($this->lang['navigationTitle'], "/".$this->mDir."/index.html");
			}
			/*if ($treeResult[$key][4] == 'y') {*/
				$navigation->add($treeResult[$key][2], "/".$this->mDir."/".$treeResult[$key][0]."/album.html");
			/*}*/

			if (!empty($treeResult[$key][5])) $navigation->setMainPage($treeResult[$key][5]);
		}

		foreach ($addedNavigationMenuItems as $key=>$empty) {
			$navigation->add($addedNavigationMenuItems[$key][0], $addedNavigationMenuItems[$key][1]);
		}

		$this->return['navigation'] = $navigation->get();
		$this->return['template']   = $template;
		$this->return['md']			= $md;
		$this->return['mk']			= $mk;
		$this->return['pageTitle']	= (!@empty($result[$curId][2]) ? $result[$curId][2] : $this->lang['startGalleryPageTitle']);

		return true;
	}

	public function randomImage() {
		$this->sql->query("SELECT `owner`, `filename` FROM `".$this->dbImagesTable."` ORDER BY RAND() LIMIT 1", true);

		if ($this->sql->num_rows() > 0) {
			$outArray = array('/gallery/'.$this->sql->result[0].'/album.html', '/'.$this->uploadImageThumbDir.$this->sql->result[1]);
			return $outArray;
		}
		else {
			return false;
		}
	}

	function __construct() {
		global $_GET, $_POST, $_FILES, $sql, $API, $_SESSION, $uri, $module, $smarty;
		$this->getArray		= api::slashData($_GET, true);
		$this->postArray	= api::slashData($_POST);
		$this->filesArray	= $_FILES;

		$this->uriArray		= $uri;
		$this->module		= $module;

		$this->returnPath	= $this->mDir == $this->module ? "/".$this->mDir."/index.html" : "/".$this->module."/".$this->mDir."/";

		if (isset($_SESSION['returnPath'])) {
			$this->returnPath = $_SESSION['returnPath'];
		}

    	$this->sql = &$sql;
    	$this->api = &$API;

    	$this->smarty = &$smarty;

		$cfgValue = api::getConfig("modules", $this->mDir, "uploadImageGroupDir");
		if (!empty($cfgValue)) $this->uploadImageGroupDir = $cfgValue;

		$cfgValue = api::getConfig("modules", $this->mDir, "uploadImageThumbDir");
		if (!empty($cfgValue)) $this->uploadImageThumbDir = $cfgValue;

		$cfgValue = api::getConfig("modules", $this->mDir, "uploadImagePreviewDir");
		if (!empty($cfgValue)) $this->uploadImagePreviewDir = $cfgValue;

		$cfgValue = api::getConfig("modules", $this->mDir, "uploadImageBigDir");
		if (!empty($cfgValue)) $this->uploadImageBigDir = $cfgValue;

		$cfgValue = api::getConfig("modules", $this->mDir, "limitsImageGroup");
		if (!empty($cfgValue)) $this->limitsImageGroup = explode(" ", $cfgValue);

		$cfgValue = api::getConfig("modules", $this->mDir, "limitsImageThumb");
		if (!empty($cfgValue)) $this->limitsImageThumb = explode(" ", $cfgValue);

		$cfgValue = api::getConfig("modules", $this->mDir, "limitsImagePreview");
		if (!empty($cfgValue)) $this->limitsImagePreview = explode(" ", $cfgValue);

		$cfgValue = api::getConfig("modules", $this->mDir, "limitsImageBig");
		if (!empty($cfgValue)) $this->limitsImageBig = explode(" ", $cfgValue);

		$cfgValue = api::getConfig("modules", $this->mDir, "adminListColumns");
		if (!empty($cfgValue)) $this->adminListColumns = $cfgValue;
	}
}

?>
