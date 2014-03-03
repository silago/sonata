<?php

if (!defined("API")) {
	exit("Main include fail");
}


class catalog extends mysql {
	public $lang 	= array();
	public $curLang = "ru";
	public $data	= array();
	public $uri		= array();
	public $returnPath = "/admin/catalog/";

	private $mDir    = "catalog";
	private $aUrl	 = "/admin/catalog/";
	private $tDir    = "modules/catalog/";
	private $error   = "";
	private $groups  = array();

	private $getArray  		= array();
	private $postArray 		= array();
	private $filesArray		= array();

	private $gMaxH	 = 150;
	private $gMaxW	 = 150;

	private $notSoBigMaxWidth = 640;
	private $notSoBigMaxHegiht   = 480;

	private $bigMaxWidth	= 1024;
	private $bigMaxHegiht	= 768;

	private $addPhotoSmallWidth = 100;
	private $addPhotoSmallHeight = 100;
	private $addPhotoBigWidth = 1024;
	private $addPhotoBigHeight = 768;


	private $waterMark = "";

	public function addGroup() {

		if (isset($this->getArray['ownerId'])) {
			$this->data['ownerId'] = $this->getArray['ownerId'];
		}

		$template = new template(api::setTemplate($this->tDir."admin.add.group.html"));
		$this->data['selectGroup'] = $this->genHtmlSelectOwnerGroup((isset($this->data['ownerId']) ? $this->data['ownerId'] : 0), (@!empty($this->data['id']) ? $this->data['id'] : -1));
		@$this->data['fckSmallTextForm'] = api::genFck("descript", $this->data['descript'], 400);

		if (!isset($this->data['error']) || empty($this->data['error'])) $this->data['error'] = "&nbsp;";

		if (isset($this->data['id']) && !empty($this->data['id'])) {
			$template->assign("action", $this->lang['edit']);
			} else {
				$template->assign("action", $this->lang['add']);
			}

		foreach ($this->data as $key => $value) {
			$template->assign($key, @stripslashes($value));
		}

		$this->data['content'] = $template->get();

		return true;
	}

	public function editGroup() {
		global $sql, $base;
		$sql1 = clone $sql;
		$id = $this->getArray['id'];
		if (empty($id)) page500();

		$sql->query("	SELECT	`ownerId`,
								`title`,
								`pageTitle`,
								`photo`,
                                `descript`,
								`template`,
								`navigationShow`,
								`navigationMainTitle`,
								`md`,
								`mk`,
								`redirect`,
								`title_nav`
								FROM `#__#catalogGroups` WHERE `id` = '".$id."'", true);
		$sql1->query("SELECT * FROM `group_descript`  WHERE `id` = '".$id."'",true);
		if ($sql->num_rows() == 0) {
			page500();
		}

		$this->data = array(
							"id" => $id,
							"ownerId" => $sql->result[0],
							"title" => htmlspecialchars($sql->result[1]),
							"pageTitle" => htmlspecialchars($sql->result[2]),
							"photo" => "",
							"descript" => $sql1->result['description'],
							"template" => $sql->result[5],
							"navigationShow" => $sql->result[6],
							"navigationMainTitle" => htmlspecialchars($sql->result[7]),
							"md" => htmlspecialchars($sql->result[8]),
							"mk" => htmlspecialchars($sql->result[9]),
							"redirect" => $sql->result[10],
							"titlenav" => $sql->result[11],
							);

		$template = new template(api::setTemplate($this->tDir."admin.group.edit.imageForm.html"));
		if (!empty($sql->result[3])) {
			$template->assign("image", "<img border=\"0\" src=\"/".$sql->result[3]."\">");
			$template->assign("deleteLing", "<a href=\"/admin/".$this->mDir."/deleteImageFromGroup.php?id=".$id."\">".$this->lang['delImage']."</a>");

		} else {
			$template->assign("image", $this->lang['noPhoto']);
		}

  		$this->data['photoForm'] = $template->get();
		@$this->data['fckSmallTextForm'] = api::genFck("descript", $this->data['descript'], 250);
  		unset($template);


  		$this->addGroup();

		return false;
	}

	public function addGroupGo() {
		global $sql;
        $sql1 = clone $sql; //******************************
		$this->setGroupData();
		$this->setReturnPath();

		if (empty($this->data['title'])) {$this->data['error'] = $this->lang['emptyTitle']; return $this->addGroup();}
		if (!api::checkTemplate($this->data['template'])) {$this->data['error'] = $this->lang['errorTemplate']; return $this->addGroup();}

		if (empty($this->data['lang'])) page500();


		// resizePhoto
		$image = new image();
		$image->waterMark = $this->waterMark;
		$fName = "";
		if (!empty($this->data['id'])) {
			$sql->query("SELECT `photo` FROM `#__#catalogGroups` WHERE `id` = '".$this->data['id']."'", true);
			@$fName = $toDel = $sql->result[0];
		}

		if (!empty($this->data['photo']) && !($fName = $image->resize($this->data['photo'], "upload/", $this->gMaxW, $this->gMaxH))) {
			$this->data['error'] = $image->error;
			$this->addGroup();
			return false;
		}

		if (!empty($this->data['photo'])) {
			@unlink($toDel);
		}

		if (isset($this->data['id']) && !empty($this->data['id'])) {
			// edit
			$sql->query("UPDATE #__#catalogGroups SET
													`ownerId` = '".$this->data['ownerId']."',
													`title` = '".$this->data['title']."',
													`pageTitle` = '".$this->data['pageTitle']."',
													`photo` = '".$fName."',

													`template` = '".$this->data['template']."',
													`navigationShow` = '".$this->data['navigationShow']."',
													`navigationMainTitle` = '".$this->data['navigationMainTitle']."',
													`mk` = '".$this->data['mk']."',
													`md` = '".$this->data['md']."',
													`redirect` = '".$this->data['redirect']."',
													`title_nav` = '".$this->data['titlenav']."'
													WHERE `id` = '".$this->data['id']."'");

			$sql1->query("SELECT `id` FROM `group_descript` WHERE `id` = '".$this->data['id']."'",true); //*************
			if ($sql1->num_rows() > 0)
				{					$sql1->query("UPDATE group_descript SET `description`='".$this->data['descript']."' WHERE `id` = '".$this->data['id']."'");
				}
			else
				{					$sql1->query("INSERT INTO `group_descript` (`id`, `description`) VALUES ('".$this->data['id']."', '".$this->data['descript']."')");
				}
			message($this->lang['editGroupOk'], "", "admin/".$this->mDir."/groupList.php");
		} else {
			// add
			$sql->query("	INSERT INTO	`#__#catalogGroups`	(	`ownerId`,
																`title`,
																`pageTitle`,
																`photo`,

																`template`,
																`navigationShow`,
																`navigationMainTitle`,
																`md`,
																`mk`,
																`lang`,
																`position`,
																`redirect`,
 																`title_nav` )
							VALUES(	'".$this->data['ownerId']."',
									'".$this->data['title']."',
									'".$this->data['pageTitle']."',
									'".$fName."',

									'".$this->data['template']."',
									'".$this->data['navigationShow']."',
									'".$this->data['navigationMainTitle']."',
									'".$this->data['mk']."',
									'".$this->data['md']."',
									'".$this->curLang."',
									'0',
									'".$this->data['redirect']."',
									'".$this->data['titlenav']."')");
            if ($sql1->num_rows() > 0)
				{
					$sql1->query("UPDATE group_descript SET `description`='".$this->data['descript']."' WHERE `id` = '".$this->data['id']."'");
				}
			else
				{
					$sql1->query("INSERT INTO `group_descript` (`id`, `description`) VALUES ('".$this->data['id']."', '".$this->data['descript']."')");
				}
			$sql->query("UPDATE `#__#catalogGroups` SET `position` = `id` WHERE `position` = '0'");
			message($this->lang['groupAddOk'], "", $this->returnPath);
		}

	}

	public function setGroupData() {
		$this->data['id'] = $this->getArray['id'];
		$this->data['ownerId']=$this->postArray['ownerId'];
		$this->data['title']=$this->postArray['title'];
		$this->data['pageTitle']=$this->postArray['pageTitle'];
		$this->data['photo']=$this->filesArray['photo']['tmp_name'];
		$this->data['descript']=$this->postArray['descript'];
		$this->data['template']=$this->postArray['template'];
		$this->data['navigationShow']=$this->postArray['navigationShow'];
		$this->data['navigationMainTitle']=$this->postArray['navigationMainTitle'];
		$this->data['md']=$this->postArray['md'];
		$this->data['mk']=$this->postArray['mk'];
		$this->data['redirect']=$this->postArray['redirect'];
		$this->data['lang']=$this->curLang;
		$this->data['titlenav']=$this->postArray['titlenav'];


		return true;
	}

	public function genHtmlSelectOwnerGroup($defaultValue = 0, $halt = -1) {
		$return = "<select name=\"ownerId\">";

		if ($defaultValue === 0) {$defaultValue=''; $return.="<option value=\"0\" selected=\"selected\">--- ".$this->lang['no']." ---</option>"; }
		else { $return.="<option value=\"0\">--- ".$this->lang['no']." ---</option>"; }

		$treeArray = template::genTree("catalogGroups", "id", "ownerId", "title", "95faf087-a49d-11dc-ba06-505054503030", $halt);

		foreach ($treeArray as $key => $value) {
			$return.="<option value = \"".$key."\"".($defaultValue == $key ? " selected=\"selected\"" : "").">".str_repeat("- ", ($treeArray[$key]['level'] * 2)).$treeArray[$key]['value']."</option>";
		}
		$return.="</select>";
		return $return;

	}

	public function deleteImageFromGroup($id) {
		global $sql;
		$sql->query("SELECT `photo` FROM `catalogGroups` WHERE `id` = '".$id."'", true);
		if ((int)	$sql->num_rows() !== 1) return false;
		if (!empty($sql->result[0])) {
			unlink($sql->result[0]);
			$sql->query("UPDATE `#__#catalogGroups` SET `photo` = '' WHERE `id` = '".$id."'");
			}
		message($this->lang['imageDelOk'], "", $this->returnPath);
		return true;
	}

	public function groupList() {
		global $sql;
                                                               //  95faf087-a49d-11dc-ba06-505054503030
		$treeArray = template::genTree("catalogGroups", "id", "ownerId", "title", "38f3ce5a-8fd4-11e0-a6f2-bcaec53ee8e1", -1, "position");
		$groupsPositions = array();

		$sql->query("SELECT `id`, `position` FROM `#__#catalogGroups`");
		while ($sql->next_row()) $groupsPosition[$id = $sql->result[0]] = $sql->result[1];

		$body = "";
		$template = new template();
		$template->file(api::setTemplate($this->tDir."admin.show.groups.item.html"));
		foreach ($treeArray as $key=>$value) {
			$template->assign("id", $key);
			$template->assign("padding", $treeArray[$key]['level'] * 30).
			$template->assign("title", $treeArray[$key]['value']);
			$template->assign("position", $groupsPosition[$key]);
			$body .= $template->get();
		}

		if (empty($body)) {
			$template = new template(api::setTemplate($this->tDir."admin.show.groups.empty.html"));
			$body = $template->get();
		}

		$template = new template(api::setTemplate($this->tDir."admin.show.groups.body.html"));
		$template->assign("body", $body);
		$this->data['content']=$template->get();
		return true;
	}

	public function moveGroup() {
		global $sql;
		api::move($this->getArray, $sql, "catalogGroups", "ownerId");
	}

	public function moveItem() {
		global $sql;
		api::move($this->getArray, $sql, "catalog", "ownerId");
	}


	public function addItemShowForm() {
		global $sql;

		$template = new template(api::setTemplate($this->tDir."admin.add.item.html"));

		if (@empty($this->data['error'])) $this->data['error'] = "&nbsp;";

		@$this->data['selectOwnerId']    = $this->genHtmlSelectOwnerGroup((isset($this->data['ownerId'])? $this->data['ownerId'] : -1));
		@$this->data['fckSmallTextForm'] = api::genFck("smallText", $this->data['smallText'], 250);
		@$this->data['fckFullTextForm']  = api::genFck("fullText",  $this->data['fullText']);


		if (!@empty($this->data['id'])) {
			// assign photos
			$sql->query("SELECT `photo`, `addedPhoto` FROM `#__#catalog` WHERE `id` = '".$this->data['id']."'", true);
			if ((int)$sql->num_rows() !== 1) {
				page500();
			}

			if (!empty($sql->result[0])) {
				$subTemplate = new template(api::setTemplate($this->tDir."admin.show.uploaded.photos.html"));
				$subTemplate->assign("images", "<a href=\"deletePhotoFromItem.php?id=".$this->data['id']."&type=main\"><img border=\"0\" src=\"/".$sql->result[0]."\"></a>");
				$this->data['imageForm1']=$subTemplate->get();
			}

			if (!empty($sql->result[1])) {
				$data = explode(":::", $sql->result[1]);
				$subTemplate = new template(api::setTemplate($this->tDir."admin.show.uploaded.photos.html"));

				unset($images);

				foreach ($data as $key=>$value) {
					@$images .= "<a href=\"deletePhotoFromItem.php?id=".$this->data['id']."&type=added&photo=".urlencode($value)."\"><img border=\"0\" style=\"padding: 10 10 10 10;\" src=\"/".$value."\"></a> ";
				}

				$subTemplate->assign("images", $images);
				$this->data['imageForm2']=$subTemplate->get();
			}

		}


		foreach ($this->data as $key=>$value) {
			$template->assign($key, $value);
		}

		$this->data['content'] = $template->get();
		return true;
	}


    //Перемещение брендов
	public function moveItemBrand() {
		global $sql;
		api::move1($this->getArray, $sql, "brandsOptions", "");
	}


	//Бренды
	public function brandList() {
		global $sql;

        $subSql = clone $sql;
        //$subSql2 = clone $sql;

        //$cont = "<h1>Управление брендами</h1>";
        $cont = "<table border='0' cellpadding='4' cellspacing='0' width='100%' class='inputTable'>
			<tr>
				<th colspan='6' align='center'><strong>Управление брендами</strong></th>
			</tr>
			<tr>
				<td align='center'>Опции</td>
				<td>Список брендов</td>

				<td align='center'>Верх</td>
				<td align='center'>Правое меню</td>
				<td align='center'>Низ</td>

				<td align='center'>Позиция</td>
			</tr>";

		$sql->query("SELECT * FROM `#__#brandsOptions` ORDER BY `position`");
		while ($sql->next_row()) {

			//$i++;

            //$subSql2->query("UPDATE #__#brandsOptions SET `position`='$i' WHERE `id_brand`='".$sql->result['id_brand']."'");


			$moveItem = '<a href="moveItemBrand.php?lang=ru&moveType=start&currentPosition='.$sql->result['position'].'" onMouseOver="toolTip(\'Переместить бренд на самую верхнюю позицию\', 200)" onMouseOut="toolTip()">
			<img src="/templates/ru/images/api/moveStart.gif" alt="Переместить в начало" width="13" height="12" border="0" align="absmiddle" title="Переместить в начало" /></a>

			<a href="moveItemBrand.php?lang=ru&moveType=up&currentPosition='.$sql->result['position'].'" onMouseOver="toolTip(\'Переместить бренд на одну позицию вверх\', 200)" onMouseOut="toolTip()">
			<img src="/templates/ru/images/api/moveUp.gif" alt="Переместить на одну позицию вверх" width="12" height="8" border="0" align="absmiddle" title="Переместить на одну позицию вверх" /></a>

			<a href="moveItemBrand.php?lang=ru&moveType=down&currentPosition='.$sql->result['position'].'" onMouseOver="toolTip(\'Переместить бренд на одну позицию вниз\', 200)" onMouseOut="toolTip()">
			<img src="/templates/ru/images/api/moveDown.gif" alt="Переместить на одну позицию вниз" width="12" height="8" border="0" align="absmiddle" title="Переместить на одну позицию вниз" /></a>

			<a href="moveItemBrand.php?lang=ru&moveType=end&currentPosition='.$sql->result['position'].'" onMouseOver="toolTip(\'Переместить бренд в конец списка\', 200)" onMouseOut="toolTip()">
			<img src="/templates/ru/images/api/moveEnd.gif" alt="Переместить в конец" width="12" height="11" border="0" align="absmiddle" title="Переместить в конец" /></a>';


            //(<font color='#04BF0E'><b>Показывается на всех страницах</b></font>)
            if ($sql->result['view'] == 1) $statusBrand = "<font color='#0FBD0F'><b>Да</b></font>"; else $statusBrand = "<font color='#CCCCCC'>Нет</font>";
            if ($sql->result['top_view'] == 1) $statusBrand1 = "<font color='#0FBD0F'><b>Да</b></font>"; else $statusBrand1 = "<font color='#CCCCCC'>Нет</font>";
            if ($sql->result['right_view'] == 1) $statusBrand2 = "<font color='#0FBD0F'><b>Да</b></font>"; else $statusBrand2 = "<font color='#CCCCCC'>Нет</font>";


            //Получаем инфу бренда
            $subSql->query("SELECT `title` FROM `#__#brands` WHERE `id`='".$sql->result['id_brand']."'", true);
            if ($subSql->num_rows() > 0) {

		    	$cont .= "<tr>
		    			<td align='center'><a href='javascript:del(\"".$sql->result['id_brand']."\");'><img src='/templates/ru/images/icons/delete.gif' border='0'></a>
		    			    <a href='editBrand.php?id=".$sql->result['id_brand']."'><img src='/templates/ru/images/icons/edit.gif' border='0'></a>
		    			</td>
		    			<td>".$subSql->result['title']."</td>

		    			<td align='center'>$statusBrand1</td>
		    			<td align='center'>$statusBrand2</td>
		    			<td align='center'>$statusBrand</td>

		    			<td align='center'>$moveItem</td>
		    		  </tr>";

		    	}

			}

        $cont .= "</table>
					<SCRIPT language='javascript'>
					function del(delid) {
						if(confirm('Подтверждаете удаление?')){
						document.location.href='dellBrand.php?id=' + delid ;
						}
					}
					</SCRIPT>";

		$this->data['content'] = $cont;

	}

	//Удаление бренда
	public function dellBrand() {
		global $sql, $_GET;
        //Удаление настроек бренда
        $sql->query("DELETE FROM `#__#brandsOptions` WHERE `id_brand`='".$sql->escape($_GET['id'])."'");
        //Удаление самого бренда
        $sql->query("DELETE FROM `#__#brands` WHERE `id`='".$sql->escape($_GET['id'])."'");
        message("Бренд удален!", "", "admin/".$this->mDir."/brandList.php");
	}


	//Редактирование бренда
	public function editBrand() {
		global $sql, $_GET;

        $sql2 = clone $sql;

        $sql->query("SELECT * FROM `#__#brands` WHERE `id`='".$sql->escape($_GET['id'])."'", true);

        $sql2->query("SELECT * FROM `#__#brandsOptions` WHERE `id_brand`='".$sql->escape($_GET['id'])."'", true);

        if ($sql2->result['right_view'] > 0) $checked0 = "checked"; else $checked0 = "";
        if ($sql2->result['top_view'] > 0) $checked1 = "checked"; else $checked1 = "";
        if ($sql2->result['view'] > 0) $checked = "checked"; else $checked = "";

        if (strlen($sql2->result['image']) > 0) $image="<br /> <img src='/upload/brands/".$sql2->result['image']."' border='0' style='border: 1px solid #CCC;'>";

        $cont = "&raquo; <a href='brandList.php'>Вернуться назад</a>
        <br />
        <h1>Управление брендами</h1>";
        $cont .= "<table class='inputTable'>
        		  <form name='edit_brand' action='editBrandGo.php' method='post' enctype='multipart/form-data'>
        		  <input name='id_brand' type='hidden' value='".$sql->escape($_GET['id'])."'>
        		  <input name='position' type='hidden' value='".$sql2->result['position']."'>
        			<tr>
        				<td align='right' width='200'>Название бренда:</td>
        				<td>".$sql->result['title']." <font color='#B0B0B0'>(id: ".$sql->escape($_GET['id']).")</font></td>
        			</tr>
        			<tr>
        				<td align='right'>Опции:</td>
        				<td>

        				<input name='top_view' type='checkbox' value='1' $checked1> Показывать бренд в верхнем меню <br />

        				<input name='right_view' type='checkbox' value='1' $checked0> Показывать бренд в правом меню  <br />

        				<input name='view' type='checkbox' value='1' $checked> Показывать бренд на всех страницах внизу</td>
        			</tr>
        			<tr>
        				<td align='right'>Картинка:</td>
        				<td><input name='image' type='file' /> $image</td>
        			</tr>
        			<tr>
        				<td align='right'>Ссылка:</td>
        				<td><input name='url' type='text' value='".$sql2->result['url']."' size='50'></td>
        			</tr>
        			<tr>
        				<td align='right'> </td>
        				<td><input type='submit' value='Сохранить'></td>
        			</tr>
        		</form>
        		</table>";

		$this->data['content'] = $cont;

	}


	public function editBrandGo() {
		global $sql, $_POST;

        //Каталог куда будет помещен данный файл
		$uploaddir="upload/brands/";
		//Дополнительные переменные
		$filename=$_FILES['image']['name'];
		$filesize=$_FILES['image']['size'];

        $sql->query("SELECT `image` FROM `#__#brandsOptions` WHERE `id_brand`='".$sql->escape($_POST['id_brand'])."'", true);
        $imageFile = $sql->result['image'];
        if (strlen($imageFile) > 3 && strlen($filename) > 0) unlink("upload/brands/$imageFile");
        //Удалим старые настройки
        $sql->query("DELETE FROM `#__#brandsOptions` WHERE `id_brand`='".$sql->escape($_POST['id_brand'])."'");

		//Название файла
        $imageName = "".$sql->escape($_POST['id_brand']).".".end(explode(".", $filename))."";

        if (strlen($filename) > 3) {
        	//Переместим загруенный файл в директорию
        	move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir . $imageName);
            } else {
            	$imageName = $imageFile;
            	}

        //Вставка новых данных в БД
		$sql->query("INSERT INTO `#__#brandsOptions`(`id_brand`,`view`,`image`,`url`,`position`,`top_view`,`right_view`) VALUES ('".$sql->escape($_POST['id_brand'])."','".$sql->escape($_POST['view'])."','$imageName','".$sql->escape($_POST['url'])."','".$sql->escape($_POST['position'])."','".$sql->escape($_POST['top_view'])."','".$sql->escape($_POST['right_view'])."')");
        message("Данные сохранены!", "", "admin/".$this->mDir."/editBrand.php?id=".$sql->escape($_POST['id_brand'])."&");
	}


    //Регистрация покупателя
	function register() {
		global $_SESSION, $_POST, $sql, $mail;

        $cont = "";

        //Если данные были посланы с формы:
        if (@$_POST['state'] == 1) {

        //Каталог куда будет помещен файл с реквизитами
		$uploaddir="upload/userfiles/";
		//Дополнительные переменные
		$filename=$_FILES['userfile']['name'];
		$filesize=$_FILES['userfile']['size'];

        //Разрешенные форматы файлов
        $approvFile = "|rar|zip|jpg|jpeg|doc|pdf|gif|png|";

		//Тип файла
        $typeFile = end(explode(".", $filename));

        $uploadFile = "";

        $er = array();


        if (strlen($filename) > 0) {

        	if (@substr_count($approvFile, $typeFile) == 1 || $typeFile == "") { $uploadFile="yes"; } else { $er[] = "Формат файла не поддерживается!"; }

        	}

            if ($_POST['type_org'] == 1) {

                if (strlen(htmlspecialchars($_POST['name_company'])) < 1)   $er[] = "Введите название организации!";
                if (strlen(htmlspecialchars($_POST['inn'])) < 1)   $er[] = "Введите ИНН!";

                //Проверка на существующий ИНН
             //   $sql->query("SELECT `id` FROM `#__#userShop` WHERE `type_org`='1' AND `inn`='".$sql->escape($_POST['inn'])."'", true);
             //   if ($sql->num_rows() > 0) $er[] = "Данный ИНН уже есть в БД!";

            	}


            if (strlen($_POST['login']) > 0) {
            	//Проверка логина на занятость
        		$sql->query("SELECT `id` FROM `#__#userShop` WHERE `login`='".htmlspecialchars($_POST['login'])."'", true);
        		if ($sql->result['id'] > 0) $er[] = "Данный E-Mail уже зарегистрирован!";
        	}




            if (htmlspecialchars($_POST['pass']) != htmlspecialchars($_POST['pass2']))  $er[] = "Введенные пароли не совпадают!";
            if (strlen(htmlspecialchars($_POST['pass'])) < 4)   $er[] = "Пароль короткий!";
            if (strlen(htmlspecialchars($_POST['login'])) < 4)   $er[] = "E-Mail короткий!";
            if (!checkEmail(htmlspecialchars($_POST['login']))) $er[] = "E-Mail указан не корректно!"; // *********** добавлено 27,09,12 **************
           // if (strlen(htmlspecialchars($_POST['adres'])) < 2)   $er[] = "Не указан адрес!";
            if (strtolower($_SESSION['imageCheckCode']) != strtolower($_POST['imageCheckCode'])) $er[] = "Код с картинки не соответсвует!";

            //Вывод ошибок
			$cont .= "<br /><center><font color='#FF0006'>ОШИБКА! Вы не зарегистрированны по следующим причинам:</font><br><br></center>
				<div align=center>";
				foreach ($er as $word) $cont .= "$word <br />";
			$cont .= "</div>";
        }

        //$er = array();

        //Если ошибок 0 выполним вставку в БД
        if (@count($er) == 0 && @$_POST['state'] == 1) {

        unset($cont);

        if ($uploadFile == "yes") {
        	$filedName = "".time().".$typeFile";
        	move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $filedName);
        	} else {
        		$filedName = "";
        		}


        if (strlen($_POST['inn']) == 0) $_POST['inn'] = rand(10000000, 99999999);

        $sql->query("INSERT INTO `#__#userShop`(`login`,`pass`,`fio`,`mail`,`adres`,`tel`,`nomer_kart`,`type_org`,`name_company`,`inn`,`file`) VALUES ('".$sql->escape($_POST['login'])."','".$sql->escape($_POST['pass'])."','".$sql->escape($_POST['fio'])."','".$sql->escape($_POST['login'])."','".$sql->escape($_POST['adres'])."','".$sql->escape($_POST['tel'])."','".$sql->escape($_POST['nomer_kart'])."','".$sql->escape($_POST['type_org'])."','".$sql->escape($_POST['name_company'])."','".$sql->escape($_POST['inn'])."','$filedName')");

        //Ид последнего инкримента
        $udLastIn = $sql->lastId();

            if (strlen($_POST['name_company']) > 0) $orgname = $_POST['name_company']; else $orgname = $_POST['fio'];

            $web_price = $this->priceUd(2);

            $random_agents = $this->randomId('30');

							/*					   `orgname`,
												   `fullorgname`,
												   `inn`,*/


			$sql->query("INSERT INTO `#__#agents` (`userid`,
			                                       `agentid`,
					   							   `orgname`,
												   `fullorgname`,
												   `inn`,
												   `kpp`,
												   `okpo`,
												   `idprice`,
												   `default`,
												   `file`)
											VALUES ('".$sql->escape($udLastIn)."',
											        '".$sql->escape($random_agents)."',
													'".$sql->escape($orgname)."',
													'".$sql->escape($orgname)."',
													'".$sql->escape($_POST['inn'])."',
													'".$sql->escape($_POST['kpp'])."',
													'".$sql->escape($_POST['okpo'])."',
													'".$web_price."',
													'1',
													'$filedName')");





        //Выполнить апдейт гостевой корзины
        $sql->query("UPDATE `#__#basket` SET `ud_user`='$udLastIn' WHERE `session`='".$this->sessionGuest()."'");


		// Creating headers
		$header  = "From: zakaz@m3952.ru\n";
		$header .= "MIME-Version: 1.0\n";
		$header .= "Content-Type: text/html; charset=utf-8;\n";
		$messageSubject = "Уведомление о регистрации в Интернет-магазине";
		$messageBody = 'Зарегистрировался новый пользователь: '.$orgname;
		//Получим E-Mail Менеджера, для уведомления о новом заказе
		$ManagerSql = clone $this->sql;
		$ManagerSql->query("SELECT `value` FROM `#__#config` WHERE `name`='mailShopManager'", true);

        //Отправка сообщения админу
        mail($ManagerSql->result['value'], $messageSubject, $messageBody, $header);



        //Отправка сообщения пользователю
        $messageBody = '<img src="ml_head.png">
        				<br /><br />
        				Здравствуйте, '.$_POST['fio'].'<br /><br />
        				Вы успешно зарегистрированы в интернет-магазине, группы компаний «Мир»
        				<br /><br />
        				Вам предоставляются:
        				<br /><br />
        				Статус - Постоянный клиент;
                        <br /><br />
                        Возможность приобретать товары по оптовой цене;
                        <br /><br />
                        В личный кабинет вы можете войти перейдя по ссылке:  <a href="http://www.m3952.ru/catalog/auth.php" target="_blank">http://www.m3952.ru/catalog/auth.php</a>
        				<br /><br />
        				<font color="#DF0000">Ваши данные для авторизации:</font>
        				<br /> E-Mail: '.$_POST['login'].'
        				<br /> Пароль: '.$_POST['pass'].'
        				<br /><br />
        				Пароль вы можете изменить, после авторизации, в разделе «Профиль».
        				<br /><br />
        				С уважением, группа компаний «Мир».
        				<br />тел: (3952) 707-768.
        				<br />web: <a href="http://www.m3952.ru">www.m3952.ru</a>';

 // 		$mail->IsSMTP();
  //  	$mail->Host       = "localhost"; // SMTP server

		$mail->From       = "zakaz@m3952.ru";
		$mail->FromName   = "группа компаний Мир";
  		$mail->Subject    = "Регистрация в интернет-магазине МИР-М2";

        $mail->MsgHTML($messageBody);
        $mail->AddAddress($_POST['login'], "");
        $mail->AddAttachment("/home/mir_m2/data/www/m3952.ru/ml_head.png");
        $mail->CharSet = "UTF-8";
        $mail->Send();
//    mail($_POST['login'], 'Регистрация в интернет-магазине МИР-М2', $messageBody, $header);


        $cont .= "<br /><center>Регистрация успешно завершена!<br />
							Для продолжения работы авторизуйтесь в системе!</center><br /><br />
					<table align=center>
        			<form name='reg' action='auth.php' method='post'>
        			<input name='state' type='hidden' value='1'>
        			<tr>
                    	<td align=right style='padding:4px;'>E-Mail:</td>
                    	<td style='padding:4px;'><input name='login' type='text' value='' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'>Пароль:</td>
                    	<td style='padding:4px;'><input name='pass' type='password' value='' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'>&nbsp;</td>
                    	<td style='padding:4px;'><input type='submit' value='Войти' class='pl_Submit'></td>
       				</tr>
       				</form>
       			</table>

							<br /><br />";

        } else {

            $jur_check = "";

        	if (@$_POST['type_org'] == 1) {
                $jur_check="checked=checked";
                $jur_tbody="";
        		} else {
        			$fiz_check="checked=checked";
        			$jur_tbody="style='display:none;'";
        			}


        $cont .= "<br />



        <table align='center'>
        			<form name='reg' action='?' method='post' enctype='multipart/form-data'>
        			<input name='state' type='hidden' value='1'>

        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Регистрировать как:</td>
                    	<td style='padding:4px;'>
                  			<input name='type_org' type='radio' value='0' onclick=\"$('#jur').hide('normal');\" $fiz_check> Физическое лицо
                  			<br />
                  			<input name='type_org' type='radio' value='1' onclick=\"$('#jur').show('normal');\" $jur_check> Юридическое лицо
                    	</td>
       				</tr>

                    <tbody id='jur' $jur_tbody>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Название компании:</td>
                    	<td style='padding:4px;'><input name='name_company' type='text' value='".@htmlspecialchars($_POST['name_company'])."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> ИНН:</td>
                    	<td style='padding:4px;'><input name='inn' type='text' value='".@htmlspecialchars($_POST['inn'])."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'>Файл с реквизитами:</td>
                    	<td style='padding:4px;'><input type='file' name='userfile' /></td>
       				</tr>
       				</tbody>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Контактное лицо:</td>
                    	<td style='padding:4px;'><input name='fio' type='text' value='".@htmlspecialchars($_POST['fio'])."' size='50' class='pl_Text'></td>
       				</tr>


        			<tr>
                    	<td align=right style='padding:4px;'>Контактный телефон:</td>
                    	<td style='padding:4px;'><input name='tel' type='text' value='".@htmlspecialchars($_POST['tel'])."' size='50' class='pl_Text'></td>
       				</tr>

        			<tr>
                    	<td align=right style='padding:4px;'>Адрес:</td>
                    	<td style='padding:4px;'><textarea name='adres' rows='2' cols='47' class='pl_Text'>".@htmlspecialchars($_POST['adres'])."</textarea></td>
       				</tr>


        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> E-Mail:</td>
                    	<td style='padding:4px;'><input name='login' type='text' value='".@htmlspecialchars($_POST['login'])."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Пароль:</td>
                    	<td style='padding:4px;'><input name='pass' type='password' value='".@htmlspecialchars($_POST['pass'])."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Повторите пароль:</td>
                    	<td style='padding:4px;'><input name='pass2' type='password' value='".@htmlspecialchars($_POST['pass2'])."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Код</td>
                    	<td style='padding:4px;'>
                            <div style='float: left; padding-right: 4px;'>
                    			<input name='imageCheckCode' type='text' value='".@htmlspecialchars($_POST['imageCheckCode'])."' size='10' class='pl_Text'>
                    		</div>
                    		<div style='float: left;'>
                    		  <table><tr>
                    		   <td>
                    			<a href=\"javascript:void(0);\" onclick=\"document.getElementById('imageCheckCode').src='/imageCheckCode.php?rid=' + Math.random();\">
                    				<img src='/imageCheckCode.php' border='0' id='imageCheckCode' />
                    			</a>
                    		   </td>
                    		   <td>
                    		   		&nbsp;<a href=\"javascript:void(0);\" onclick=\"document.getElementById('imageCheckCode').src='/imageCheckCode.php?rid=' + Math.random();\">Обновить код</a>
                    		   </td>
                    		  </tr></table>
                            </div>
                    	</td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'>&nbsp;</td>
                    	<td style='padding:4px;'><input type='submit' value='Зарегистрироваться' class='pl_Submit'></td>
       				</tr>
       				</form>
        		  </table>";

        }

        $this->data['pageTitle'] = "Регистрация";
        $this->data['title'] = "Регистрация";
        $this->data['navigation'] = "<a href='/'>Главная</a> / Регистрация";
        $this->data['content'] = $cont;
	}




    //Функция возваращает ФИО Покупателя и размер скидки
    protected function WelcomUserShop() {
    	global $_SESSION, $sql;
/*        $sql->query("SELECT `fio`,`skidka` FROM `#__#userShop` WHERE `id`='".$_SESSION['ud_user']."'", true);
        return"<div class='WelcomUserShop'>Здравствуйте, <b>".$sql->result['fio']."</b>
        <br /><span class='pink_text' style='padding-right:150px;'>Размер Вашей персональной скидки <b>".$sql->result['skidka']."%</b></span> &raquo; <a href='/page/pro_skidku.html'>Как получить скидку больше?</a></div>";
*/    }



    //Редактирование профиля пользователя
	function editProfile() {
		global $_SESSION, $_POST, $sql;

		$cont = $this->WelcomUserShop();

        //Если данные были посланы с формы:
        if ($_POST['state'] == 1) {
            //Проверка логина на занятость
        	$sql->query("SELECT `id` FROM `#__#userShop` WHERE `login`='".htmlspecialchars($_POST['login'])."' AND `login`!='".htmlspecialchars($_POST['r_log'])."'", true);
        	if ($sql->result['id'] > 0) $er[] = "Данный E-Mail занят! Укажите другой";
            if (htmlspecialchars($_POST['pass']) != htmlspecialchars($_POST['pass2']))  $er[] = "Введенные пароли не совпадают!";
            if (strlen(htmlspecialchars($_POST['pass'])) < 4)   $er[] = "Пароль короткий!";
            if (strlen(htmlspecialchars($_POST['login'])) < 4)   $er[] = "E-Mail короткий!";

            if (count($er) < 1) {
				$sql->query("UPDATE `#__#userShop` SET `login`='".htmlspecialchars($_POST['login'])."',`pass`='".htmlspecialchars($_POST['pass'])."',`fio`='".htmlspecialchars($_POST['fio'])."',`mail`='".htmlspecialchars($_POST['login'])."',`adres`='".htmlspecialchars($_POST['adres'])."',`tel`='".htmlspecialchars($_POST['tel'])."',`nomer_kart`='".htmlspecialchars($_POST['nomer_kart'])."' WHERE `id`='".$_SESSION['ud_user']."'");
				} else {
            		//Вывод ошибок
					$cont .= "<center><font color='#FF0006'>ОШИБКА! Данные не отредактированы по следующим причинам:</font><br><br></center>
					<div align=center><table>";
					foreach ($er as $word) $cont .= "<tr><td><li type=circle>$word<br></li></td></tr>";
					$cont .= "</table></div><br>";
            		}


        }


        $sql->query("SELECT * FROM `#__#userShop` WHERE `id`='".$_SESSION['ud_user']."'", true);

        $cont .= "<br /><table align=center>
        			<form name='reg' action='?' method='post' onSubmit='return ValidateForm(this)'>
        			<input name='state' type='hidden' value='1'>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Ваше ФИО:</td>
                    	<td style='padding:4px;'><input name='fio' type='text' value='".$sql->result['fio']."' size='50' class='pl_Text'></td>
       				</tr>

        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Контактный телефон:</td>
                    	<td style='padding:4px;'><input name='tel' type='text' value='".$sql->result['tel']."' size='50' class='pl_Text'></td>
       				</tr>
       				<input name='r_log' type='hidden' value='".$sql->result['login']."'>
        			<tr>
                    	<td align=right style='padding:4px;'>Адрес:</td>
                    	<td style='padding:4px;'><textarea name='adres' rows='2' cols='47' class='pl_Text'>".$sql->result['adres']."</textarea></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> E-Mail:</td>
                    	<td style='padding:4px;'><input name='login' type='text' value='".$sql->result['login']."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Пароль:</td>
                    	<td style='padding:4px;'><input name='pass' type='password' value='".$sql->result['pass']."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Повторите пароль:</td>
                    	<td style='padding:4px;'><input name='pass2' type='password' value='".$sql->result['pass']."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'>&nbsp;</td>
                    	<td style='padding:4px;'><input type='submit' value='Сохранить изменения' class='pl_Submit'></td>
       				</tr>
       				</form>
        		  </table>
					<script language='JavaScript'>
					function ValidateForm(frm) {
						if (frm.fio.value==\"\") {
							alert(\"Укажите Ваше ФИО!\");
							return false;
						}
						if (frm.mail.value==\"\") {
							alert(\"Укажите ваш E-Mail!\");
							return false;
						}
						if (frm.login.value==\"\") {
							alert(\"Укажите ваш E-Mail!\");
							return false;
						}
						if (frm.pass.value==\"\") {
							alert(\"Укажите ваш Пароль!\");
							return false;
						}
						if (frm.tel.value==\"\") {
							alert(\"Укажите ваш контакный телефон!\");
							return false;
						}
					}
					</script>";


        $this->data['pageTitle'] = "Редактирование профиля";

        $this->data['navigation'] = "<a href='/'>Главная</a> / Профиль пользователя";
        $this->data['content'] = $cont;

    }

    //Авторизация покупателя
	function auth() {
		global $_SESSION, $_POST, $sql;

        $cont = "";

        $er = array();

        //Если данные были посланы с формы:
        if (@$_POST['state'] == 1) {
            //Проверка логина на занятость
        	$sql->query("SELECT `id` FROM `#__#userShop` WHERE `login`='".htmlspecialchars($_POST['login'])."' AND `pass`='".htmlspecialchars($_POST['pass'])."'", true);
        	if ($sql->result['id'] < 1) $er[] = "Неверная комбинация E-Mail или пароля";
        	if (strlen(trim($_POST['login'])) < 3 || strlen(trim($_POST['pass'])) < 3) $er[] = "E-Mail или пароль указаны не корректно!";

            //Вывод ошибок
			$cont .= "<br /><font color='#FF0006'>ОШИБКА! Вы не вошли по следующим причинам:</font><br><br>
				<div align=center><table>";
				foreach ($er as $word) $cont .= "<tr><td>$word<br></td></tr>";
			$cont .= "</table></div>";
        }

        //Если ошибок 0 =>выполним авторизацию
        if (count($er) == 0 && @$_POST['state'] == 1) {

        unset($cont);

        $_SESSION['ud_user'] = $sql->result['id'];

        //Выполнить апдейт гостевой корзины
        $sql->query("UPDATE `#__#basket` SET `ud_user`='".$sql->result['id']."',`session`='null' WHERE `session`='".$this->sessionGuest()."'");

        $cont .= "<br /><center>Авторизация выполнена!</center><br /><br /><br />";

        } else {

        $tr = '';

        if (isset($_SESSION['forgotPassword'])) $tr = '<tr><td> </td><td style="padding:4px;">Пароль выслан на: <b>'.$_SESSION['forgotPassword'].'</b></td></tr>';


        $cont .= "<br /><table class='forms'>
        			<form name='reg' action='?' method='post'>
        			<input name='state' type='hidden' value='1'>
        			$tr
        			<tr>
                    	<td align=right style='padding:4px;'>E-Mail:</td>
                    	<td style='padding:4px;'><input name='login' type='text' value='' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'>Пароль:</td>
                    	<td style='padding:4px;'><input name='pass' type='password' value='' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'>&nbsp;</td>
                    	<td style='padding:4px;'><input type='submit' value='Войти' class='pl_Submit'> &nbsp; <a href='/catalog/forgotPassword.php'>Забыли пароль?</a></td>
       				</tr>
       				</form>
       			</table>";

        unset($_SESSION['forgotPassword']);

        }

        $this->data['title'] = "Вход на сайт";
        $this->data['pageTitle'] = "Вход на сайт | <a href=\"http://www.m3952.ru/catalog/register.php\">Регистрация</a>";
        $this->data['navigation'] = "<a href='/'>Главная</a> / Авторизация покупателя";
        $this->data['content'] = $cont;

	}


    //Восстановить пароль
	function forgotPassword() {
		global $sql;

        $cont = '';

        if (@$_POST['state'] == 1 && @strlen($_POST['login']) > 0) {

        	$sql->query("SELECT `pass` FROM `#__#userShop` WHERE `login`='".$sql->escape($_POST['login'])."'", true);
        	if ($sql->num_rows() > 0) {

				// Creating headers
				$header  = "From: no_reply@mir2M.ru\n";
				$header .= "MIME-Version: 1.0\n";
				$header .= "Content-Type: text/html; charset=utf-8;\n";
				$messageSubject = "Восстановление пароля";
				$messageBody = "Ваш пароль: ".$sql->result['pass'];

        		mail($_POST['login'], $messageSubject, $messageBody, $header);

                $_SESSION['forgotPassword'] = htmlspecialchars($_POST['login']);

                go('/catalog/auth.php');

        		//$cont = '<div style="padding-left:200px; padding-top:20px;">Пароль выслан на: <b>'.$_POST['login'].'</b></div>';
        		} else {
        			$cont = '<div style="padding-left:200px; padding-top:20px;"><font color="#E90101">Ошибка! Данный E-Mail не зарегистрирован!</font></div>';
        			}

        }

        $cont .= "<br /><table class='forms'>
        			<form name='reg' action='?' method='post'>
        			<input name='state' type='hidden' value='1'>
        			<tr>
                    	<td align=right style='padding:4px;'>E-Mail:</td>
                    	<td style='padding:4px;'><input name='login' type='text' value='' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'>&nbsp;</td>
                    	<td style='padding:4px;'><input type='submit' value='Выслать пароль' class='pl_Submit'></td>
       				</tr>
       				</form>
       			</table>";



        $this->data['title'] = "Восстановление пароля";
        $this->data['pageTitle'] = "Восстановление пароля";
        $this->data['navigation'] = "<a href='/'>Главная</a> / <a href='/catalog/auth.php'>Авторизация покупателя</a> / Восстановление пароля";
        $this->data['content'] = $cont;


	}






    //Генерация сессии покупателя
	function sessionGuest() {
		global $_SESSION;
		if (strlen($_SESSION['USER_GUEST']) > 0) {
			return $_SESSION['USER_GUEST'];
			} else {
				$_SESSION['USER_GUEST'] = time().mt_rand(1000, 9000);
				return $_SESSION['USER_GUEST'];
				}
	}






    //Блок корзины товаров
	function basketBlock() {
		global $sql, $API, $_FILES, $_SESSION;
        //ИД товара
		$ud_goods = htmlspecialchars($_GET['ud_goods']);
        //Количество товара
        $CountAdd = htmlspecialchars($_POST['dinamic_post']);
        $CountAdd = str_replace("basket_count|***|", "", $CountAdd);
        $CountAdd = str_replace("|**|", "", $CountAdd);


		if (isset($_SESSION['ud_user'])) {
			$sql->query("SELECT SUM(count) FROM `#__#basket` WHERE `ud_user`='".$_SESSION['ud_user']."' AND `ud_goods`='".$sql->escape($ud_goods)."' AND `status`='0'", true);
			//$CountAdd = $CountAdd+$sql->result['SUM(count)'];

			} else {
				$sql->query("SELECT SUM(count) FROM `#__#basket` WHERE `session`='".$this->sessionGuest()."' AND `ud_goods`='".$sql->escape($ud_goods)."' AND `status`='0'", true);
				//$CountAdd = $CountAdd+$sql->result['SUM(count)'];

				}



        $prize_roz = $this->priceUd(1);
    	$prize_web = $this->priceUd(2);

        //Получаем информацию о товаре
        $sql->query("SELECT `assignParam1`,`assignParam3`,`assignParam4`,`price` FROM `#__#catalog` WHERE `id`='$ud_goods'", true);

        //Если продавать товар только упаковками!
/*        if ($sql->result['assignParam3'] > 1 && $sql->result['assignParam4'] == 0) {
        	$CountAdd = $CountAdd*$sql->result['assignParam3'];
        	}*/


		if (isset($_SESSION['ud_user'])) {
		    $sql->result['price'] = $this->priceIn($ud_goods, $prize_web);
			} else {
			    $sql->result['price'] = $this->priceIn($ud_goods, $prize_roz);
				}


        //Стоимость товара если его количество больше 1
        $total_price = str_replace(",", ".", $sql->result['price']*$CountAdd);

        $BasketSql = clone $this->sql;

        //Если юзер авторизован
        //Исправить..
		if (isset($_SESSION['ud_user'])) {
   			//Удаляем товар из корзины
      		$sql->query("DELETE FROM `#__#basket` WHERE `ud_goods`='$ud_goods' AND `ud_user`='".$_SESSION['ud_user']."'");
        	//Добавляем товар в корзину
        	if ($CountAdd > 0) {
				$sql->query("INSERT INTO `#__#basket`(`ud_goods`,`ud_user`,`count`,`price`,`total_price`) VALUES ('$ud_goods','".$_SESSION['ud_user']."','$CountAdd','".$sql->result['price']."','$total_price')");
                }
   			//Получим информацию о корзине
      		$BasketSql->query("SELECT SUM(total_price), SUM(count) FROM `#__#basket` WHERE `ud_user`='".$_SESSION['ud_user']."' AND `status`='0'", true);
        	//ceil(
        	$Sum_total = $BasketSql->result['SUM(total_price)'];
         	$Sum_goods = $BasketSql->result['SUM(count)'];
			} else {
                //Иначе юзер не авторизован
                //Удаляем товар из корзины
                $sql->query("DELETE FROM `#__#basket` WHERE `ud_goods`='$ud_goods' AND `session`='".$this->sessionGuest()."'");
                //Добавляем товар в корзину
                if ($CountAdd > 0) {
					$sql->query("INSERT INTO `#__#basket`(`ud_goods`,`session`,`count`,`price`,`total_price`) VALUES ('$ud_goods','".$this->sessionGuest()."','$CountAdd','".$sql->result['price']."','$total_price')");
                    }
                //Получим информацию о корзине
                $BasketSql->query("SELECT SUM(total_price), SUM(count) FROM `#__#basket` WHERE `session`='".$this->sessionGuest()."' AND `status`='0'", true);
                //ceil(
                $Sum_total = $BasketSql->result['SUM(total_price)'];
                $Sum_goods = $BasketSql->result['SUM(count)'];
				}

        //Проблемы с кодировкой при подгрузке блока
        #!! header("Content-type: text/html; charset=windows-1251");
        //Установим пустой темлейт для корзины, т.к. она подгружается через AJAX
        @$API['template'] = "ru/basketblock.html";

/*        if ($_SESSION['ud_user'] > 0) {
        	$kabinet_url="<a href=\"/catalog/orderStatus.php\"><b>Личный кабинет</b></a>";
        	unset($paramOforml);
        	} else {
        		$kabinet_url="<a href=\"/catalog/register.php\"><b>Зарегистрироваться</b></a>";
        		$paramOforml="?type=select";
        		}*/

		$this->data['content'] = "<p>У Вас <span>$Sum_goods</span> товара<br />
                					на сумму <span>$Sum_total</span> руб.</p>";

	}



	public function brand() {
		global $sql, $_GET;

        $subSql = clone $sql;
        $subSql1 = clone $sql;

		$sql->query("SELECT * FROM `#__#brands` WHERE `id`='".$sql->escape($_GET['id'])."'", true);

		if (strlen($sql->result['image']) > 0) {
		    $cont = '
			<img alt="1196" src="/image.php?id='.$sql->result['id'].'&type=big&vid=brand" style="float:left; margin-right:5px; margin-bottom:5px;" />
			';
		    }



/*        $subSql->query("SELECT `brandsGroups`.`id_groups` as `id_groups`, `catalogGroups`.`title` as `title` FROM `brandsGroups` LEFT JOIN `catalogGroups` ON `catalogGroups`.`id` = `brandsGroups`.`id_groups` WHERE `brandsGroups`.`id_brands`='".$sql->result['id']."'");
        while ($subSql->next_row()) {
            $subCont .= '&raquo; <a href="/catalog/'.$subSql->result['id_groups'].'/showGroup.php?type=brand&id_brand='.$sql->result['id'].'">'.substr($subSql->result['title'], 4).'</a><br />';
            }
*/

        if (strlen($sql->result['url']) > 0) $url = '&raquo; <a href="'.$sql->result['url'].'">Перейти на сайт бренда</a><br />'; else $url = '';

        $cont .= '<div style="clear:both;  padding-top:10px">'.$url.'<b>Основные товарные группы:</b><br />'.$subCont.'</div>';


        $cont .= '<div style="line-height:22px; padding-top:10px;">';

        $name_group = '';

        //$subSql1->query("SELECT `title`,`id_group`,`ownerId_group` FROM `#__#brandsMeny` WHERE `id_brand`='".$sql->escape($_GET['id'])."' AND `sort`='0' AND `level`>'0' ORDER BY `ownerId_group`");
        $subSql1->query("
			SELECT 
				`title`,`id_group`,`ownerId_group` 
			FROM 
				`#__#brandsMeny` 
			WHERE 
				`id_brand`='".$sql->escape($_GET['id'])."' AND `sort`='0' AND `level`>'0' 
			ORDER BY 
				`title`, `level`
		");//ownerId_group
        
        while ($subSql1->next_row()) 
        {
            $subSql->query("SELECT `title` FROM `#__#catalogGroups` WHERE `id`='".$subSql1->result['ownerId_group']."'", true);

            if ($name_group != $subSql->result['title']) 
            {
            	$name_group = $subSql->result['title'];

            	$cont .= '<span style="background: url(/i/images/folder.gif) 0 0 no-repeat;">&nbsp; &nbsp;&nbsp;</span>'.substr($name_group, 4).'<br />';

           	} 
           	else 
           	{
           	    //$name_group = '';
            }

        	$cont .= '&nbsp; &nbsp;<span style="background: url(/i/images/file.gif) 0 0 no-repeat;">&nbsp; &nbsp;&nbsp;</span><a href="/catalog/' . $subSql1->result['id_group'] . '/showGroup.php?type=brand&id_brand=' . $_GET['id'] . '"> '. substr($subSql1->result['title'], 4) . '</a><br />';
        }

        $cont .= '</div>';





        $this->data['navigation'] = '<a href="/catalog/">Каталог</a> / <a href="/catalog/brands.php">Бренды</a> / '.$sql->result['title'].'';
        $this->data['title'] = $sql->result['title'];
        $this->data['pageTitle'] = $sql->result['title'];
		$this->data['content'] = "<div style='padding:8px; text-align: justify;'>".$sql->result['descript']."$cont</div>";
		
		require_once(dirname(__FILE__) . '/../../plugins/brandMenyCatalog/index.php');
		//echo dirname(__FILE__) . '/../../plugins/brandMenyCatalog/index.php';
		$tmpest = new plugin_brandMenyCatalog();
		
		//$_GET['type'] = 'brand';
		$result = $tmpest->start($_GET['id']);
		//var_dump($result);
		$this->data['content'] = $result;
	}


	public function brands() {
		global $sql;

        $subSql = clone $sql;

		$cont = "";

        $cont = '<table>';

		$sql->query("SELECT * FROM `#__#brands` WHERE `view`='true' ORDER BY `position`");
		while ($sql->next_row()) {

            $subCont = '';

            $subSql->query("SELECT `brandsGroups`.`id_groups` as `id_groups`, `catalogGroups`.`title` as `title` FROM `brandsGroups` LEFT JOIN `catalogGroups` ON `catalogGroups`.`id` = `brandsGroups`.`id_groups` WHERE `brandsGroups`.`id_brands`='".$sql->result['id']."' LIMIT 0,5");
            while ($subSql->next_row()) {
            	$subCont .= '&raquo; <a href="/catalog/'.$subSql->result['id_groups'].'/showGroup.php?type=brand&id_brand='.$sql->result['id'].'">'.substr($subSql->result['title'], 4).'</a><br />';
            	}

            $a++;
            $i++;
            $k++;

            if ($i == 1) $cont .= '<tr>';

            if ($a == $sql->num_rows()) $topBorder = ''; else $topBorder = 'border-bottom: 1px solid #CCC; padding:10px;';

            $cont .= '<td style="'.$topBorder.' '.$border.'" width="50%">';

		    if (strlen($sql->result['image']) > 0) {
		    	$cont .= '<a href="/catalog/brand.php?id='.$sql->result['id'].'&type=brand"><img alt="pic" src="/image.php?id='.$sql->result['id'].'&type=big&vid=brand" style="float:left; margin-right:5px; margin-bottom:5px;" /></a>';
		    	}

		    $cont .= '<a href="/catalog/brand.php?id='.$sql->result['id'].'&type=brand" style="color:#000;"><b>'.$sql->result['title'].'</b></a> - '.$sql->result['descript'].'<div style="clear:both;">'.$subCont.'</div>';


            $cont .= '</td>';

            if ($i == 2) { $cont .= '</tr>'; unset($i); }

			}

        $cont .= '</table>';

        $this->data['navigation'] = '<a href="/catalog/">Каталог</a> / Бренды';
        $this->data['title'] = "Полный перечень брендов";
        $this->data['pageTitle'] = "Полный перечень брендов";
		$this->data['content'] = "<div style='padding:8px;'>$cont</div>";
	}



	public function addItemGo() {
		global $sql;

		$image = new image();
		$image->waterMark = $this->waterMark;

		$this->data=array(
							"id" => $this->getArray['id'],
							"ownerId" => $this->postArray['ownerId'],
							"title" => $this->postArray['title'],
							"titleup" => $this->postArray['titleup'],
							"redirect" => $this->postArray['redirect'],
							"smallText" => $this->postArray['smallText'],
							"mk" => $this->postArray['mk'],
							"md" => $this->postArray['md'],
							"hi" => $this->postArray['hi'],
							"fullText" => $this->postArray['fullText'],
							"addedPhoto" => $this->filesArray['addedPhoto'],
							"assignParam1" => $this->postArray['assignParam1'],
							"assignParam2" => $this->postArray['assignParam2'],
							"assignParam3" => $this->postArray['assignParam3'],
							"assignParam4" => $this->postArray['assignParam4'],
							"price"	=> $this->postArray['price'],
							"lang" => $this->curLang,
							"techInformation" => $this->postArray['techInformation'],
							"photo" => $this->filesArray['photo']['tmp_name'],
							);


		if (empty($this->data['title'])) {$this->data['error'] = $this->lang['itemTitleEmpty']; return $this->addItemShowForm();}

		if (!empty($this->data['id'])) {
			$sql->query("SELECT `photo`, `addedPhoto` FROM `#__#catalog` WHERE `id` = '".$this->data['id']."'", true);
			$fMainPhoto = $fToDel = $sql->result[0];
			$addedPhoto = explode(":::", $sql->result[1]);
			} else {
				$fMainPhoto = "";
				$addedPhoto = array();
			}

		if (!empty($this->data['photo']) && !($fMainPhoto = $image->resize($this->data['photo'], "upload/", $this->gMaxW, $this->gMaxH,0))) {
			$this->data['error'] = $image->error;
			return $this->addItemShowForm();
			return false;
		} elseif(!empty($this->data['photo'])) {
			$saveNotSoBigPhotoFileName = basename($fMainPhoto);
			if (!file_exists("upload/notSoBig") || !is_dir("upload/notSoBig") || !is_writable("upload/notSoBig")) mkdir("upload/notSoBig", 0777) or die("Please, create oe set pemissions dir upload/big/");
			$image->dest = "upload/notSoBig/".$saveNotSoBigPhotoFileName;
			$image->resize($this->data['photo'], "upload/", $this->notSoBigMaxWidth, $this->notSoBigMaxHegiht);


			if (!file_exists("upload/big") || !is_dir("upload/big") || !is_writable("upload/big")) mkdir("upload/big", 0777) or die("Please, create oe set pemissions dir upload/big/");
			$image->dest = "upload/big/".$saveNotSoBigPhotoFileName;
			$image->resize($this->data['photo'], "upload/", $this->bigMaxWidth, $this->bigMaxHegiht);

			$image->dest = "";
		}

		$addedPhoto = array_filter($addedPhoto);

		foreach ($this->data['addedPhoto']['tmp_name'] as $fArrayKey=>$fName) {
   			if (empty($fName)) {
   				continue;
   			}

   			if (!empty($fName) && !($fToSavePhoto = $addedPhoto[] = $image->resize($fName, "upload/", $this->addPhotoSmallWidth, $this->addPhotoSmallHeight,0))) {
			$this->data['error'] = $image->error;
			return $this->addItemShowForm();
   			} elseif (!empty($fName)) {
				if (!file_exists("upload/big") || !is_dir("upload/big") || !is_writable("upload/big")) mkdir("upload/big", 0777) or die("Please, create oe set pemissions dir upload/big/");
				$image->dest = "upload/big/".basename($fToSavePhoto);
				$image->resize($fName, "upload/big/", $this->addPhotoBigWidth, $this->addPhotoBigHeight);
				$image->dest = "";
			}

		}

		if (isset($fToDel) && !empty($fToDel) && !empty($this->data['photo'])) {
			unlink($fToDel);
			@unlink("upload/notSoBig/".basename($fToDel));
			@unlink("upload/big/".basename($fToDel));

		}


		if (empty($this->data['id'])) {
			$sql->query("INSERT INTO `#__#catalog`(
													`ownerId`,
													`title`,
													`photo`,
													`redirect`,
													`smallText`,
													`fullText`,
													`addedPhoto`,
													`assignParam1`,
													`assignParam2`,
													`assignParam3`,
													`assignParam4`,
													`price`,
													`lang`,
													`techInformation`,
													`titleup`
													) VALUES (
													  			'".$this->data['ownerId']."',
													  			'".$this->data['title']."',
													  			'".$fMainPhoto."',
													  			'".$this->data['redirect']."',
													  			'".$this->data['smallText']."',
													  			'".$this->data['fullText']."',
													  			'".implode(":::",$addedPhoto)."',
													  			'".$this->data['assignParam1']."',
													  			'".$this->data['assignParam2']."',
													  			'".$this->data['assignParam3']."',
													  			'".$this->data['assignParam4']."',
													  			'".$this->data['price']."',
													  			'".$this->curLang."',
													  			'".$this->data['techInformation']."',
													  			'".$this->data['titleup']."'
															)");
		 	$sql->query("UPDATE `#__#catalog` SET `position` = `id` WHERE `position` = '0';");
			message($this->lang['addItemOk']);

		} else {
			///VAR_DUMP($fMainPhoto);

			// update data
			$sql->query("UPDATE `#__#catalog` SET
												`ownerId` = '".$this->data['ownerId']."',
												`title` = '".$this->data['title']."',
												`photo` = '".$fMainPhoto."',
												`redirect` = '".$this->data['redirect']."',
												`smallText` = '".$this->data['smallText']."',
												`fullText` = '".$this->data['fullText']."',
												`addedPhoto` = '".implode(":::", $addedPhoto)."',
												`assignParam1` = '".$this->data['assignParam1']."',
												`assignParam2` = '".$this->data['assignParam2']."',
												`assignParam3` = '".$this->data['assignParam3']."',
												`assignParam4` = '".$this->data['assignParam4']."',
												`price` = '".$this->data['price']."',
												`techInformation` = '".$this->data['techInformation']."',
												`titleup` = '".$this->data['titleup']."',
												`md` = '".$this->data['md']."',
												`mk` = '".$this->data['mk']."',
												`hi` = '".$this->data['hi']."'
											WHERE `id` = '".$this->data['id']."'"
											);

			message($this->lang['editItemOk'], "", $this->returnPath);
		}
	}

	public function editItem() {
		global $sql;

		$id = $this->getArray['id'];
		if (empty($id)) page500();
		$sql->query("SELECT `ownerId`, `title`, `photo`, `redirect`, `smallText`, `fullText`, `techInformation`, `addedPhoto`, `assignParam1`, `assignParam2`, `assignParam3`, `assignParam4`, `price`, `titleup`, `md`, `mk`, `hi` FROM `#__#catalog` WHERE `id` = '".$id."'", true);
		if ((int)$sql->num_rows() !== 1) page500();

		$this->data = array(
							"id" => $id,
							"ownerId" => $sql->result['ownerId'],
							"title" => htmlspecialchars($sql->result['title']),
							"photo" => "",
							"redirect" => htmlspecialchars($sql->result['redirect']),
							"smallText" => $sql->result['smallText'],
							"fullText" => $sql->result['fullText'],
							"md" => $sql->result['md'],
							"mk" => $sql->result['mk'],
							"addedPhoto" => "",
							"assignParam1" => $sql->result['assignParam1'],
							"assignParam2" => $sql->result['assignParam2'],
							"assignParam3" => $sql->result['assignParam3'],
							"assignParam4" => $sql->result['assignParam4'],
							"price" => $sql->result['price'],
							"techInformation" => $sql->result['techInformation'],
							"titleup" => $sql->result['titleup'],
							"hi" => $sql->result['hi']
							);

		$this->addItemShowForm();
	}

	function deletePhotoFromItem() {
		global $sql;

		$id = $this->getArray["id"];
		switch ($this->getArray["type"]) {
			case "main":
				$sql->query("SELECT `photo` FROM `#__#catalog` WHERE `id`= '".$id."'", true);
				if ((int)$sql->num_rows() !== 1) {
					page500();
				}

				@unlink($sql->result[0]);
				@unlink("upload/notSoBig/".basename($sql->result[0]));
				@unlink("upload/big/".basename($sql->result[0]));


				$sql->query("UPDATE `#__#catalog` SET `photo` = '' WHERE `id` = '".$id."'");

				message($this->lang['imageDelOk'], "", $this->returnPath);
			break;

			case "added":
				$sql->query("SELECT `addedPhoto` FROM `#__#catalog` WHERE `id`= '".$id."'", true);
				if ((int)$sql->num_rows() !== 1) {
					page500();
				}

				$photo = $this->getArray['photo'];

				$addedPhoto = explode(":::", $sql->result[0]);
				$ok = false;
				foreach ($addedPhoto as $key=>$value) {
					if ((string)$photo === (string)$value) {
						unlink($value);
						@unlink("upload/notSoBig/".basename($value));
						@unlink("upload/big/".basename($value));

						unset($addedPhoto[$key]);
						$ok = true;
					}
				}

				if (!$ok) page500();


				$sql->query("UPDATE `#__#catalog` SET `addedPhoto` = '".implode(":::", $addedPhoto)."' WHERE `id` = '".$id."'");

				message($this->lang['imageDelOk'], "", $this->returnPath);
			break;

		}
	}



	function listItems() {
		global $sql, $_GET;
		$this->setReturnPath();
		$start			= @(int)$this->getArray['start'];
		$perPage		= 100;
		if (isset($this->getArray['onlyGroup']) && !empty($this->getArray['onlyGroup'])) {
			$whereCase = " WHERE `catalog`.`ownerId` = '".$this->getArray['onlyGroup']."' && `catalog`.`lang` = '".$this->curLang."'";
		} else {
			//$whereCase = " WHERE `catalog`.`lang` = '".$this->curLang."'";
		}

		switch (@$_GET['filterType']) {
			case "all": $whereCase2 = " && (`catalog`.`title` LIKE '%".$this->sql->escape($_GET['filterString'])."%' || "."`#__#catalogGroups`.`title` LIKE '%".$this->sql->escape(@$_GET['filterString'])."%')"; break;
			case "groupTitle":	$whereCase2 = " && `#__#catalogGroups`.`title` LIKE '%".$this->sql->escape(@$_GET['filterString'])."%'"; break;
			case "itemTitle":	$whereCase2 = " && `catalog`.`title` LIKE '%".$this->sql->escape($_GET['filterString'])."%'"; break;
			default:
				$whereCase2 = "";

		}




		$sql->query($q="(	SELECT
								COUNT(*) as `id`,
								'' as `title`,
								'' as `groupTitle`,
								'' as `groupId`,
								'' as `position`
						FROM `#__#catalog`
						LEFT JOIN `#__#catalogGroups` ON `#__#catalog`.`ownerId` = `#__#catalogGroups`.`id`
						".$whereCase.$whereCase2."
						)
						UNION
						(SELECT `#__#catalog`.`id`,
								`#__#catalog`.`title` ,
								`#__#catalogGroups`.`title`,
								`#__#catalogGroups`.`id`,
								`#__#catalog`.`position`
						FROM `#__#catalog` LEFT JOIN `#__#catalogGroups` ON `#__#catalog`.`ownerId` = `#__#catalogGroups`.`id` ".$whereCase.$whereCase2." ORDER BY `#__#catalogGroups`.`id`, `#__#catalog`.`position` LIMIT ".$start.", ".$perPage." )", true);   //ORDER BY `#__#catalogGroups`.`id`, `#__#catalog`.`position` LIMIT ".$start.", ".$perPage."


		$allData		= $sql->result[0];
		$template = new template(api::setTemplate($this->tDir."admin.list.items.item.html"));

		while ($sql->next_row()) {
			$template->assign("id", $sql->result[0]);
			$template->assign("title", $sql->result[1]);
			$template->assign("position", $sql->result[4]);
			// genTree
			$arrayToGenTree = $this->getTreeFromItem($sql->result[3]);
			$groups = "";
			foreach($arrayToGenTree as $groupIdToNavigationGen => $groupTitleToNavigationGen) {
				$groups .= "<a style=\"text-decoration: underline; font-weight:normal;\" href=\"listItems.php?lang=".$this->curLang."&onlyGroup=".$arrayToGenTree[$groupIdToNavigationGen]['id']."\">".$arrayToGenTree[$groupIdToNavigationGen]['title']."</a> &gt; ";
			}
			$template->assign("groups", (!empty($groups) ? $groups : "No Group &gt; "));
			@$body .= $template->get();
		}


		$template = new template(api::setTemplate($this->tDir."admin.list.items.body.html"));
		@$template->assign("body", 	$body);
		@$template->assign("filter",  (isset($_GET['filterString']) && !empty($_GET['filterString']) ? "Фильтр: ".$_GET['filterString'] : ""));
		$template->assign("pages", 	$template->genPageList($allData, $perPage, $start, "/admin/".$this->mDir."/listItems.php?lang=".$this->curLang."&start=[PAGE]&onlyGroup=".@$this->getArray['onlyGroup']));

		$this->data['content'] = $template->get();
		unset($template);
		return true;
	}


	public function deleteItem() {
		global $sql;

        $body = "";

		$id = $this->getArray['id'];
		$sql->query("SELECT `photo`, `addedPhoto` FROM `#__#catalog` WHERE `id` = '".$id."'", true);
		if ((int)$sql->num_rows() !== 1) page500();

		if (!empty($sql->result[0])) {
			unlink($sql->result[0]);
			@unlink("upload/notSoBig/".basename($sql->result[0]));
			@unlink("upload/big/".basename($sql->result[0]));

			}
		if (!empty($sql->result[1])) {
			$filesArray = explode(":::", $sql->result[1]);
			foreach ($filesArray as $value) {
				@unlink($value);
				@unlink("upload/notSoBig/".basename($value));
				@unlink("upload/big/".basename($value));
			}
		}

		$sql->query("DELETE FROM `#__#catalog` WHERE `id` = '".$id."'");

		message($this->lang['deleteItemOk'], null, $this->returnPath);
	}




	function priceUd($status) {
		global $sql;
		$sql->query("SELECT `id` FROM `#__#pricesOptions` WHERE `status`='$status'", true);
		return $sql->result['id'];
	}


	function priceIn($catalog_id, $price_id) {
		global $sql;

		$bSql = clone $sql;

		$bSql->query("SELECT `price` FROM `#__#price` WHERE `catalog_id`='".$bSql->escape($catalog_id)."' AND `price_id`='".$bSql->escape($price_id)."'", true);
		return $bSql->result['price'];
	}


	//Генератор кода товара
	function codTovara($code) {		$num = 8;

		$strlen = strlen($code);

		$strlen = $num-$strlen;

		$null = '';

		for ($i=0;$i<$strlen;$i++) {			$null .= 0;			}

		return $null.$code;
		}


	function indexShowGroup($ownerId = 0) {
		global $sql;
        $sql1 = clone $sql;
        //Лимит новинок на странице
        $limitNew = 50;

        if (@strlen($_GET['sort']) == 0) $_GET['sort'] = 'desc';


        if (isset($_GET['b'])) $getBrand = '&b='.$_GET['b']; else $getBrand = '';

        $pageNav = "";

		$body = "";
        //$sqlToPrice  = clone $sql;

/*        $SubSq = clone $sql;
        $SubSq2 = clone $sql;

		$sql->query("SELECT `id` FROM `#__#prices`");
		while ($sql->next_row()) {

            $SubSq->query("SELECT `catalog_id` FROM `#__#price` WHERE `price_id`='".$sql->result['id']."'");
            while ($SubSq->next_row()) {

				$SubSq2->query("UPDATE `#__#price` SET `price`='".rand(10, 9999)."' WHERE `catalog_id`='".$SubSq->result['catalog_id']."' AND `price_id`='".$sql->result['id']."'");

            	}

			}
*/

        //?type=brand&id_brand=984a01fb-4faf-11e1-8e1f-000272185a6d

        if (isset($_GET['id_brand'])) {
        	$subGet = '&type=brand&id_brand='.$_GET['id_brand'];
        	$selectBrand = " && `catalog`.`assignParam1`='".mysql_real_escape_string($_GET['id_brand'])."'";
        	$selectBrand2 = " && `assignParam1`='".mysql_real_escape_string($_GET['id_brand'])."'";
        	} else {
        		$selectBrand = '';
        		$selectBrand2 = '';
        		}

		$sql->query("	SELECT 	COUNT(`id`),
								`redirect`,
								`descript`
						FROM `#__#catalogGroups`
						WHERE `id` = '".$ownerId."'
						GROUP BY `id`
						", true);
        $sql1->query("SELECT * FROM group_descript WHERE `id` = '".$ownerId."'",true); //***********************


		if ((int)$sql->result[0] !== 1 && $ownerId !== 0)  {
			//page404();
		}

		if (!empty($sql->result[1])) {
			exit(go($sql->result[1]));
		}

		$descript = $sql1->result['description']; //****************

		//Новинки
        if ($ownerId == "new") $groupSelect = ''; else $groupSelect = "`#__#catalogGroups`.`ownerId` = '".$ownerId."' &&";

		// Show groups
		$sql->query("	SELECT 	`#__#catalogGroups`.`id`,
								`#__#catalogGroups`.`title`,
								`#__#catalogGroups`.`photo`,
								`#__#catalogGroups`.`descript`,
								COUNT(`#__#catalog`.`id`),
								`#__#catalogGroups`.`lang`
						FROM `#__#catalogGroups`
						LEFT JOIN `#__#catalog` ON `#__#catalogGroups`.`id` = `#__#catalog`.`ownerId`
						WHERE  ".$groupSelect." `#__#catalogGroups`.`lang` =  '".$this->curLang."'
						GROUP BY `#__#catalogGroups`.`id`
						ORDER BY `#__#catalogGroups`.`position`;");

		if (($itemsAll = $sql->num_rows()) > 0) {
			$template = new template(api::setTemplate($this->tDir."index.show.groups.item.html"));

			$curGroupIncrement = 0;

			//$body = "\n\t<tr>\n";

			while ($sql->next_row()) {
				$template->assign("groupId", 	$sql->result[0]);
				$template->assign("groupTitle", $sql->result[1]);
				$template->assign("groupPhoto", (!empty($sql->result[2]) ? "<img border=\"0\" src=\"/".$sql->result[2]."\">" : "&nbsp;"));
				$template->assign("groupDescript", $sql1->result['description']);
				$template->assign("groupCount", $sql->result[4]);
				$template->assign("groupLang", $sql->result[5]);
				@$template->assign("colspan", $colspan);

				if (($curGroupIncrement % 3) == 0) {
					//$body .= "\n\t</tr>\n\t<tr>\n";
				}

				$curGroupIncrement++;
				$body .= $template->get();
			}

			//$body .= "\t</tr>";

			$template = new template(api::setTemplate($this->tDir."index.show.groups.body.html"));
			$template->assign("body", $body);
			$template->assign("descript", $descript);
			//exit(htmlspecialchars(var_export($body, true)));
			$this->data['content'] = $template->get();
		}



        $sel_desc = "";
        $sel_asc = "";

        //Критерии сортировки товара
        if (@$_GET['sort'] == "desc") {
        	$sel_desc="selected";
        	$Csort_sql = "`catalog`.`price` DESC";
        	}
            else
        if (@$_GET['sort'] == "asc") {
        	$sel_asc="selected";
        	$Csort_sql = "`catalog`.`price` ASC";
        	}
            else {
            	$Csort_sql = "`catalog`.`position`";
            	}



						//	<option value=\"?sort=desc&numit=".@$_GET['numit']."\" $sel_desc>по убыванию цены</option>
						//	<option value=\"?sort=asc&numit=".@$_GET['numit']."\" $sel_asc>по возрастанию цены</option>


        $numItems = '<div class="sort">Сортировать: ';

        if ($_GET['sort'] == "desc") {
        	$numItems .= '<a href="?sort=asc&numit='.@$_GET['numit'].''.$getBrand.''.$subGet.'">по убыванию цены</a>';
        	$sorts = 'ASC';
        	} else {
        		$numItems .= '<a href="?sort=desc&numit='.@$_GET['numit'].''.$getBrand.''.$subGet.'" class="up">по возрастанию цены</a>';
        		$sorts = 'DESC';
        		}

		$numItems .= '</div>';


        ##############################################
        # Постраничная навигация итемов каталога

        //Новинки


        //Количество итемов в группе
		$sql->query("SELECT COUNT(*) FROM `catalog`  WHERE `ownerId` = '".$ownerId."' $selectBrand2");
        while ($sql->next_row()) {
        	$iPage = strip($sql->result[0]);
        	}

        if ($ownerId == "new") $iPage = $limitNew;


        //Количество итемов на странице

        if (@$_GET['numit'] > 0) $kl = htmlspecialchars($_GET['numit']); else $kl=10;

        $ls2 = @$_GET['ls2'];

		if($ls2 == 1 || $ls2 == "" || !isset($ls2)){ $fom=0; $ls2=1; } else { $fom=($ls2-1)*$kl; }

        ##############################################


        $basSql = clone $sql;
        //$ssql = clone $sql;

        $brandSql = clone $sql;

        $wherStatus = "";
        //Исправить..
		if (isset($_SESSION['ud_user'])) {
			$wherStatus = "`ud_user`='".$_SESSION['ud_user']."'";
			} else {
				$wherStatus = "`session`='".$this->sessionGuest()."'";
				}

        $prize_roz = $this->priceUd(1);
    	$prize_web = $this->priceUd(2);

		//Новинки
        if ($ownerId == "new") {
        	$selNewTable = ',`catalogNew`.`id` as `idNew`';
        	$groupSelect1 = 'LEFT JOIN `catalogNew` ON `catalogNew`.`catalog_id` = `catalog`.`id` ORDER BY `catalogNew`.`id` DESC, ';
        	} else {
        		 $groupSelect1 = "WHERE `catalog`.`ownerId` = '".$ownerId."' $selectBrand ORDER BY ";
                 }



		// show catalg items
		$sql->query("	SELECT	`catalog`.`id`,
					`catalog`.`title` as `title`,
					`catalog`.`photo` as `photo`,
					`catalog`.`smallText` as `smallText`,
					`catalog`.`assignParam1` as `assignParam1`,
					`catalog`.`assignParam2` as `assignParam2`,
					`catalog`.`assignParam3` as `assignParam3`,
					`catalog`.`assignParam4` as `assignParam4`,
					`catalog`.`price` as `price`,
					`catalogGroups`.`descript` as `groupDescript`,
					`catalog`.`lang` as `lang`,

					`price`.`price` as `price`


					 ".$selNewTable."

							FROM 	`catalog`
							LEFT JOIN
									`catalogGroups` ON `catalogGroups`.`id` = `catalog`.`ownerId`


							LEFT JOIN
									`price` ON `price`.`catalog_id` = `catalog`.`id` AND `price`.`price_id` = '".$prize_roz."'

                            ".$groupSelect1."

							`price`.`price` $sorts LIMIT $fom,$kl");        //  $Csort_sql LIMIT $fom,$kl

                                  //&& `catalog`.`lang` = '".$this->curLang."'
           //echo"<pre>"; print_r($sql);
		if ($sql->num_rows() > 0) {	//	 if ($sql->result['price'] > 0){
			$template = new template(api::setTemplate($this->tDir."index.show.items.item.html"));
			//$body = "\n\t<tr>\n";
			$curItemIncrement = 0;
			$prt_sql = clone $sql;
            $uidex = eregi_replace("([^0-9])", "",$wherStatus);

			$prt_sql->query("SELECT * FROM `agents` WHERE `userid`='".$uidex."' and `default`='1'",true);
           //  echo $uidex;
			while ($sql->next_row()) {
                                                                     //
             if (strip($sql->result[11]) > 0) {             	if (isset($_SESSION['ud_user'])) {
             		$priceIn = $this->priceIn($sql->result[0], $prt_sql->result['idprice']);
             	}
             	else {
             		$priceIn = $this->priceIn($sql->result[0], 'dab614b8-6f16-11dd-968a-00e018e21983');
             	}

			    $basSql->query("SELECT `count` FROM `basket` WHERE $wherStatus AND `ud_goods`='".$sql->result[0]."' AND `status`='0'", true);
                if ($basSql->num_rows() > 0) {
                    $inputClass = "pl_Korz_Button_sel";
                    $valueAdd = "<font color=#1B91B8 size=1><b>Добавлен</b></font>";
                	} else {
                        $inputClass = "pl_Korz_Button";
                        $valueAdd = "";
                		}


                $template->assign("valueAdd",		$valueAdd);
                $template->assign("inputClass",		$inputClass);

				$template->assign("id",				$sql->result[0]);


				$brandSql->query("SELECT `title`,`view` FROM `brands` WHERE `id`='".strip($sql->result[4])."'", true);
				if (isset($_GET['b']) && strlen($brandSql->result['title']) > 0) {
					$titles = strip($sql->result[1]).' ('.$brandSql->result['title'].')';
					} else {
						$titles = strip($sql->result[1]);
						}

                if ($brandSql->result['view'] == 'true') $brandsurl = '<a href="/catalog/brand.php?id='.strip($sql->result[4]).'&type=brand"><b>'.$brandSql->result['title'].'</b></a>'; else $brandsurl = '<b>' . $brandSql->result['title'] . '</b>';

                if ($brandSql->num_rows() > 0) $brandsname = '<div style="padding-top:3px; padding-bottom:3px; font-size:8pt; color:#000;">Производитель или бренд: '.$brandsurl.'</div>'; else $brandsname = '';

				$template->assign("title", $titles);


				if (strlen($sql->result[2]) > 0) {   // image.php?src=".$sql->result[0]."&type=big
					$photo = "<a href='/image.php?src=".$sql->result[0]."&type=big&.jpg' id='example2'><img border=\"0\" vspace=\"5\" hspace=\"5\" src=\"/image.php?src=".$sql->result[0]."\" style='border: 1px solid #CADCE6;'></a>";
					} else {
						$photo = "<img src='/i/no_photo.png' border='0' width='100'>";
						}

                //$ssql->query("SELECT `price` FROM `basket` WHERE $wherStatus AND `ud_goods`='".$sql->result[0]."' AND `status`='0'", true);

                if ($_GET['b'] == strip($sql->result[4]) && isset($_GET['b'])) $activbrand = 'style="color:#D20000;"'; else $activbrand = '';

                $template->assign("activbrand", $activbrand);

                //$prize_roz

				$template->assign("image", 		$photo);
				//$template->assign("image", 			(!empty($sql->result[2]) ? "<a href='/1c/webdata/".$sql->result[2]."' id='example2'><img border=\"0\" vspace=\"5\" hspace=\"5\" src=\"/image.php?src=".$sql->result[2]."\" style='border: 1px solid #CADCE6;'></a>" : ""));
				$template->assign("smallText", 		strip($sql->result[3]).$brandsname);

				$template->assign("assignParam1",	strip($sql->result[4]));
				$template->assign("assignParam2", 	$this->codTovara(strip($sql->result[5])));
				$template->assign("assignParam3",	strip($sql->result[6]));
				$template->assign("assignParam4",	strip($sql->result[7]));



                $priced = '';

        		//Цена WEB отображается если юзер авторизован
        		if (isset($_SESSION['ud_user'])) {

                    //$sql->query("SELECT `price` FROM `#__#price` WHERE `catalog_id`='".$sql->escape($catalog_id)."' AND `price_id`='".$sql->escape($price_id)."'", true);



					//$sqlToPrice->query("SELECT `price` FROM `#__#price` WHERE `catalog_id`='".$sqlToPrice->escape($sql->result[0])."' AND `price_id`='".$sqlToPrice->escape($this->priceUd(2))."'", true);

					if (strip($sql->result[11]) > 0) $priced = '<font color="#000000">Цена: '.strip($sql->result[11]).' руб.</font> &nbsp; &nbsp;<br />'; else $priced='';

					if ($priceIn > 0) $priced .= 'Ваша цена: '.$priceIn.' руб.';

					} else {
					#	if (strip($sql->result[11]) > 0) $priced = 'Цена: ' . strip($sql->result[11]).' руб.'; else $priced = '';
						if (strip($sql->result[11]) > 0) $priced = '<font color="#000000"><s>Розничная цена: '.$priceIn.' руб.</s></font> &nbsp; &nbsp;<br>'; else $priced='';

					if ($priceIn > 0) $priced .= 'Цена при заказе с сайта: '.strip($sql->result[11]).' руб.<br />';
						}



				$template->assign("cost",			$priced); //8
				$template->assign("lang",			strip($sql->result['lang']));
				$template->assign("descript",		strip($sql->result['groupDescript']));

                $docs = '';


                //Файлы
                $docs = $this->SortFiles($sql->result[6]);
                $template->assign("files", str_replace("QWERTY", "", $docs));


/*                $doc = explode("QWERTY", strip($sql->result[6]));
                if (count($doc) == 0) $doc = '';
                if (strlen($doc[0]) > 0 && strlen($doc[1]) > 0) $docs = '<a class="pasport" href="/file.php?src='.str_replace("#", ":", $doc[1]).'">'.$doc[0].'</a>';

                if (strlen($doc[2]) > 0 && strlen($doc[3]) > 0) $docs .= '<a class="pasport" href="/file.php?src='.str_replace("#", ":", $doc[3]).'">'.$doc[2].'</a>';
                if (strlen($doc[4]) > 0 && strlen($doc[5]) > 0) $docs .= '<a class="pasport" href="/file.php?src='.str_replace("#", ":", $doc[5]).'">'.$doc[4].'</a>';
                if (strlen($doc[6]) > 0 && strlen($doc[7]) > 0) $docs .= '<a class="pasport" href="/file.php?src='.str_replace("#", ":", $doc[7]).'">'.$doc[6].'</a>';
*/



				if (($curItemIncrement % 1) == 0) {
					//$body .= "\n\t</tr>\n\t<tr>\n";
				}

                $curItemIncrement++;
				$body .= $template->get();

			 }


			}



				$template = new template(api::setTemplate($this->tDir."index.show.items.body.html"));




        ######################################
        # Постраничная навигация

		if ($iPage > $kl) {

			//Количество страниц
		    $CountPage = ceil($iPage/$kl);
            //Ссылка на предыдущюю страницу
		    //if ($ls2 > 1) $pageNav .= "<a href='?ls2=".($ls2-1)."&sort=".htmlspecialchars($_GET['sort'])."'>Предыдущая</a> &laquo; "; else $pageNav .= "<font color=#B6BEBD>Предыдущая</font> &laquo; ";

			for ($c=1;$c<=$CountPage;$c++) {

				if ($ls2 == $c) {
				$pageNav .= "<a class=\"active\" href=\"\">$c</a>"; } else {
				$pageNav .= "<a href='?ls2=$c&sort=".htmlspecialchars($_GET['sort'])."&numit=".$_GET['numit']."".$getBrand."".$subGet."'>$c</a>";
				}

				if ($c <> $CountPage) {
				$pageNav .= "&nbsp; ";
				}
			}
            //Ссылка на следующую страницу
            //if ($ls2 < $CountPage) $pageNav .= " &raquo; <a href='?ls2=".($ls2+1)."&sort=".htmlspecialchars($_GET['sort'])."'>Следующая</a>"; else $pageNav .= " &raquo; <font color=#B6BEBD>Следующая</font>";

		}
        #####################################



        if (@$_GET['numit'] == 10 || @$_GET['numit'] == "") $numitAc10 = 'class="active"'; else $numitAc10 = "";
        if (@$_GET['numit'] == 20) $numitAc20 = 'class="active"'; else $numitAc20 = "";
        if (@$_GET['numit'] == 30) $numitAc30 = 'class="active"'; else $numitAc30 = "";
        if (@$_GET['numit'] == 50) $numitAc50 = 'class="active"'; else $numitAc50 = "";
        if (@$_GET['numit'] == 99999) $numitALL = 'class="active"'; else $numitALL = "";

		$sorts = '<div class="sort1">
				<p>Кол-во товаров на страницу:</p>
				<a '.$numitAc10.' href="?numit=10&sort='.@$_GET['sort'].''.$getBrand.''.$subGet.'">10</a>
				<a '.$numitAc20.' href="?numit=20&sort='.@$_GET['sort'].''.$getBrand.''.$subGet.'">20</a>
				<a '.$numitAc30.' href="?numit=30&sort='.@$_GET['sort'].''.$getBrand.''.$subGet.'">30</a>
				<a '.$numitAc50.' href="?numit=50&sort='.@$_GET['sort'].''.$getBrand.''.$subGet.'">50</a>
				<a '.$numitALL.' href="?numit=99999&sort='.@$_GET['sort'].''.$getBrand.''.$subGet.'">ВСЕ</a>
			</div>

			<div class="sort2" align="right">'.$pageNav.'</div>


			';


        $template->assign("sorts2", '<div class="sort3" align="center">'.$numItems.'</div>');

        $template->assign("sorts", $sorts);

		$template->assign("body", $body);

		@$this->data['content'] .= $template->get();

		unset($template);
		}

		if (!isset($this->data['content']) || empty($this->data['content'])) {
			$template = new template(api::setTemplate($this->tDir."index.show.empty.html"));
			$this->data['content'] = $template->get();

		}
		if (!empty($descript)) {
			$this->data['content'] ="<div class='group_descript'>"."<p>".$descript."</p>".$this->data['content']."</div>";
		}


		$returnNavigation = $this->getNavigationAndOtherInfo($ownerId); //array($navigation->get(), $template, $pageTitle, $md, $mk);

		$sql->query("SELECT `title`, `template`, `pageTitle`, `md`, `mk`, `title_nav` FROM `#__#catalogGroups` WHERE `id` = '$ownerId'", true);

		$this->data['navigation']	= $returnNavigation[0];
		$this->data['pageTitle']	= substr($sql->result[0], 4);
		$this->data['template']		= (!empty($sql->result[1]) ? $sql->result[1] : $returnNavigation[1]);
		$this->data['title']		= (!empty($sql->result[2]) ? $sql->result[2] : $sql->result[0]);
		$this->data['md']			= (!empty($sql->result[3]) ? $sql->result[3] : $returnNavigation[3]);
		$this->data['mk']			= (!empty($sql->result[4]) ? $sql->result[4] : $returnNavigation[4]);
    //   }
	}






	public function brandsInfo() {
		global $sql;

		$idToCheck = $this->uri[2];



		$this->data['content'] = 1;


	}





    //Функция пересчета цен в корзине
	function updatePrices($id_user, $id_agents) {
		global $sql;
        //Оределение ИД цены для агента
		$sql->query("SELECT `idprice` FROM `#__#agents` WHERE `userid`='".$sql->escape($id_user)."' AND `id`='".$sql->escape($id_agents)."'", true);
        if (strlen($sql->result['idprice']) > 0) {
			$sql->query("SELECT `id` FROM `#__#prices` WHERE `id`='".$sql->result['idprice']."'", true);
			if ($sql->num_rows() != 0) $id_price = $sql->result['id']; else $id_price = $this->priceUd(2);
        	} else {
        		$id_price = $this->priceUd(1);
        		}

        $subSql = clone $sql;
        //Список товаров текущего пользователя отложенных в корзину
		$sql->query("SELECT `id`,`ud_goods`,`count` FROM `#__#basket` WHERE `ud_user`='".$sql->escape($id_user)."' AND `status`='0'");
		while ($sql->next_row()) {
			//Определение цены текущего товара
			$subSql->query("SELECT `price`,`measurement` FROM `#__#price` WHERE `catalog_id`='".$sql->result['ud_goods']."' AND `price_id`='$id_price'", true);
			//Переопределение цены в корзине
			$subSql->query("UPDATE `#__#basket` SET `price`='".$subSql->result['price']."', `total_price`='".($subSql->result['price']*$sql->result['count'])."', `measure`='".$subSql->result['measurement']."'  WHERE `id`='".$sql->result['id']."'");
			}

	}





    //Просмотр корзины товаров
	function showBasket() {
		global $sql, $API, $_FILES, $_SESSION;

        $BasketSql = clone $this->sql;

        $pageTitled = "Корзина товаров";

        $cont = '';

        //Ид розничной цены
        $roz_id = $this->priceUd(1);

        if ($_GET['montaz'] == 1) $montazcheck = 'checked'; else $montazcheck = '';

        //$skid = $this->SkidkaUserShop();
        $cont1 = '';
        //Если юзер авторизован
		if (isset($_SESSION['ud_user'])) {
		    $dop_sql = "`ud_user`='".$_SESSION['ud_user']."' AND `status`='0'";

		    //$CommentOrderForm="Комментарий к заказу: <br /> <textarea name='comment' rows='4' cols='60'>".htmlspecialchars($_POST['comment'])."</textarea> <br /><br />";

            $selectContragent = "<script type='text/javascript'>
									function sortBySelected(element) {
										if(element.options[element.selectedIndex].value!='') {
											window.location = element.options[element.selectedIndex].value;
											}
										}
								</script>";

			//Поиск контрагентов у данного пользователя
		    $sql->query("SELECT `id`,`orgname`,`idprice`,`default` FROM `#__#agents` WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."'");
			if ($sql->num_rows() > 0) {

				$selectContragent .= '<select onChange="sortBySelected(this);">';

                while ($sql->next_row()) {
                	if ($sql->result['id'] == $_GET['id_agents'] || !isset($_GET['id_agents']) && $sql->result['default'] == 1) {$sel = 'selected'; $orgsel=$sql->result['orgname']; }else $sel = '';
                	$selectContragent .= '<option value="?id_agents='.$sql->result['id'].'" '.$sel.'>'.$sql->result['orgname'].'</option>';
                	}

				$selectContragent .= '</select>';

                //ИД выбранного агента
                if (isset($_GET['id_agents'])) {
                	$id_agents = $_GET['id_agents'];
                	} else {
                		$sql->query("SELECT `id` FROM `#__#agents` WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."' AND `default`='1'", true);
                		$id_agents = $sql->result['id'];
                		}


                $_SESSION['ud_agents'] = $id_agents;

                //Апдейт цен корзины
				$this->updatePrices($_SESSION['ud_user'], $id_agents);

    			$send_button = '<p class="inp">
                                    <input type="submit" name="" value="Отправить заказ" onClick="$(\'#checkform\').val(\'1\');$(\'#editbasket\').submit();" />
                                </p>';

				} else {

				    $selectContragent = '<font style="color:#D20005;">Вам необходимо <a href="/catalog/agentsAddForm.php" style="color:#D20005; font-weight:bold;">добавить контрагента</a> для отправки заказа</font>';

                    $send_button = '<p class="inp_grey">
                                    	<input type="submit" name="" value="  " />
                                	</p>';

					}




		    //$sendOrder = "<input type='button' onClick=\"window.location.href='/catalog/'\" value='Отправить заказ' style='padding:2px;'>";
			} else {
                $dop_sql = "`session`='".$this->sessionGuest()."' AND `status`='0'";
                //$sendOrder = "<a href=\"?\">Отправить заказ без регистрации</a>";
				}

                $rozSql = clone $sql;
                $master_prsql = clone $sql;
                $pr_id = clone $sql;
                        $uidex = eregi_replace("([^0-9])", "",$_SESSION['ud_user']);
						$pr_id->query("SELECT * FROM `agents` WHERE `userid`='".$uidex."' and `default`='1'",true);
						$master_prid = $pr_id->result['set_idprice'];

                $i = "";
                $k = "";
				$sql->query("SELECT * FROM `#__#basket` WHERE $dop_sql");
				while ($sql->next_row()) {
				    //Определение розничной цены товара
				    $rozSql->query("SELECT `price` FROM `#__#price` WHERE `catalog_id`='".$sql->result['ud_goods']."' AND `price_id`='$roz_id'", true);
				    $rozPrices[] = $rozSql->result['price']*$sql->result['count'];

					$master_prsql->query("SELECT `price` FROM `#__#price` WHERE `catalog_id`='".$sql->result['ud_goods']."' AND `price_id`='$master_prid'", true);
					$set_price[] = $master_prsql->result['price']*$sql->result['count'];

					$i++;
					//Получим наименование товара из каталога
					$BasketSql->query("SELECT `id`,`title`,`photo`,`assignParam1`,`assignParam2`,`assignParam3`,`assignParam4` FROM `#__#catalog` WHERE `id`='".$sql->result['ud_goods']."'", true);


                    //Проверка упаковки
                    if (@$_GET['up'][$sql->result['ud_goods']] > 0) {
                    	$valued = htmlspecialchars($_GET['r'][$sql->result['ud_goods']]);
                    	$infoErr1 = "<br /><center><font color=#D20005>Число должно быть кратно упаковке: ".$BasketSql->result['assignParam3']."</gont></center>";
                    	} else {
                    		//$valued = $sql->result['count'];
                    		$infoErr1 = '';
                    		}


                    //Проверка количества
                    if (@$_GET['r'][$sql->result['ud_goods']] > 0) {
                    	$valued = htmlspecialchars($_GET['r'][$sql->result['ud_goods']]);
                    	$infoErr = "<br /><center><font color=#D20005>В наличии только: ".htmlspecialchars($_GET['c'][$sql->result['ud_goods']])." шт.</gont></center>";
                    	} else {
                    		$valued = $sql->result['count'];
                    		$infoErr = '';
                    		}

                    //Проверка количества
/*                    if ($_GET['r'][$sql->result['ud_goods']] > 0) {
                    	$valued = htmlspecialchars($_GET['r'][$sql->result['ud_goods']]);
                    	$infoErr = "<br /><center><font color=#D20005>В наличии только: ".$BasketSql->result['assignParam1']." шт.</gont></center>";
                    	} else {
                    		$valued = $sql->result['count'];
                    		unset($infoErr);
                    		}*/


                    if ($BasketSql->result['assignParam3'] > 1) $vUpakovke = $BasketSql->result['assignParam3']; else $vUpakovke = "-";


                    if (strlen($sql->result['comment']) > 0) {
                    	$valueds=htmlspecialchars($sql->result['comment']);
                    	} else {
                    		$valueds="Комментарий к товару (размер, цвет и т.п.)";
                    		}

                    $k++;
                    if ($k == $sql->num_rows()) $style_tr = 'id="noborder-b"'; else $style_tr="";


                    //Фото товара
                    if (strlen($BasketSql->result['photo']) > 0) {
                    	$photoItem = "<a id=\"example2\" href=\"/image.php?src=".$BasketSql->result['id']."&amp;type=big&amp;.jpg\"><img border=\"0\" vspace=\"5\" hspace=\"5\" src=\"/image.php?src=".$BasketSql->result['id']."\" style='border: 1px solid #CADCE6;'></a>";
                    	} else {
                    		$photoItem = '<img src="/i/no_photo.png" border="0" width="100">';
                    		}


                    if (strlen($BasketSql->result['assignParam2']) > 0) $articul = $this->codTovara($BasketSql->result['assignParam2']); else $articul = 'Отсутсвует';

					$cont1 .= "<tr $style_tr>
                                        <td class=\"noborder-l\" align='center'>$articul</td>
                                        <td>$photoItem</td>
                                        <td>
                                            <span>
                                               <a href=\"/catalog/".$BasketSql->result['id']."/showInfo.php\">".$BasketSql->result['title']."</a>
                                            </span>
                                        </td>
                                        <td class=\"red\">
                                            ".$sql->result['price']." руб.
                                        </td>
                                        <td>
                                            <input class=\"input-basket\" type=\"text\" name='count[".$sql->result['ud_goods']."]' value=\"$valued\" style='border: 1px solid #A1CBE6; padding:2px; width: 50px;' />$infoErr $infoErr1
                                        </td>
                                        <td>".($sql->result['price']*$valued)." руб.</td>
                                        <td class=\"noborder-r\">
                                                <a href='delGoodsBasket.php?ud_goods=".$sql->result['ud_goods']."'><img class=\"closejs\" src=\"/i/del.gif\" alt=\"\"/></a>
                                        </td>
                                    </tr>";


					$countGd = @$countGd+$sql->result['count'];
					$countTo = @$countTo+$sql->result['total_price'];

					}
			    //Если корзина не пуста
			    if ($i > 0) {

                    $pageTitled="Корзина заказов / ЗАКАЗ ОТ ".date("d.m.Y")."</h3>";

			        //$so_utton = "<input type='button' onClick=\"$('#checkform').val('1');$('#editbasket').submit();\" value='Отправить заказ' style='padding:2px;'>";

                           // class=\"active\"

					$cont .= "
                        <div class=\"clear\"></div>
                        <div class=\"status\">
                            <table class=\"circle\">
                                <tbody>
                                    <tr>
                                        <td id=\"nobackground\"><div><a href=\"/page/help/orderstatus.html\">Принят в работу</a></div></td>
                                        <td class=\"\"><div><a class=\"midle\" href=\"/page/help/orderstatus.html\">В обработке</a></div></td>
                                        <td class=\"\"><div><a class=\"midle\" href=\"/page/help/orderstatus.html\">Ждет оплаты</a></div></td>
                                        <td class=\"\"><div><a class=\"midle\" href=\"/page/help/orderstatus.html\">Оплачен</a></div></td>
                                        <td class=\"\"><div><a class=\"midle\" href=\"/page/help/orderstatus.html\">Сбор заказа</a></div></td>
                                        <td class=\"\"><div><a class=\"midle\" href=\"/page/help/orderstatus.html\">Отгружен</a></div></td>
                                        <td class=\"\"><div><a class=\"midle\" href=\"/page/help/orderstatus.html\">Завершен</a></div></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class=\"tl\">
                                <a href=\"/page/help/orderstatus.html\">Статус заказа</a>
                                <div style='position:absolute; margin-left:95px; margin-top:-21px; width:200px;'><a href='/page/help/orderstatus.html' style='color:#006AB0;'>Описание статусов</a></div>
                            </div>
                            <div class=\"tr\"></div>
                            <div class=\"bl\"></div>
                            <div class=\"br\"></div>
                        </div>
                        <div class=\"article-wrap\">

						<form id='editbasket' action='/catalog/editBasket.php' method='post'>
					          <input id='checkform' name='checkform' type='hidden' value='0'>
			     <div id='itemprint'>
					            <table>
                                <thead>
                                    <tr>
                                        <th class=\"noborder-l\">Код товара</th>
                                        <th>Изображение</th>
                                        <th>Название товара</th>
                                        <th class=\"pink\">Цена за ед.</th>
                                        <th>Количество</th>
                                        <th>Всего</th>
                                        <th class=\"noborder-r\">Удалить</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	$cont1
                                </tbody>
                                </table>
                   </div>

						<div class=\"tl\"></div>
                            <div class=\"tr\"></div>
                            <div class=\"bl\"></div>
                            <div class=\"br\"></div>
                        </div>


						<div align=\"right\" style='padding-right:30px;'>";
                        $pr_id = clone $sql;
                        $uidex = eregi_replace("([^0-9])", "",$_SESSION['ud_user']);
						$pr_id->query("SELECT * FROM `agents` WHERE `userid`='".$uidex."' and `default`='1'",true);

						if(isset($_SESSION['ud_user'])) {
							$cont .= 'Контрагент: '.$selectContragent;

							//Расчет скидки
							$rozPrices = array_sum($rozPrices);
							$def_price = array_sum ($set_price);
							$skidka = '';
							$vigoda = '';
							if ($rozPrices > $countTo) $skidka = '<br />Ваша скидка на текущий тип цены составила: <b>'.($rozPrices-$countTo).'</b> руб.';
                            if ($pr_id->result['idprice']<>$pr_id->result['set_idprice'] && $pr_id->result['ch_pr_type']=='1' && $pr_id->result['orgname']==$orgsel)
                            	{                            		$vigoda = '<font color="green">Выгода от продажи: <b></font>'.($countTo-$def_price).'</b> руб.<br />';
                            	}
							}

                        $nds = ceil($countTo/100*18);

                        $cont .= "<br /><br />
						Итого: <b>$countGd</b> товаров, на сумму: <b>$countTo</b> руб. НДС: <b>$nds</b> руб. $skidka
                            <br />
                            $vigoda
							<div style='margin-right:370px; padding-top:5px;'><input name='montaz' type='checkbox' value='1' $montazcheck> Необходим монтаж</div>

                        	</div>


                        <div class=\"forma\">
                                <p>
                                    <textarea name='comment' rows='4' cols='20'>".base64_decode($_GET['comment'])."</textarea>
                                </p>
                                <div>Добавить комментарий к заказу:</div>




                                <div class=\"clear\"></div>";

                                if (!isset($_SESSION['ud_user'])) $cont .= '<p class="inp"><input type="submit" name="" value="Отправить заказ" onClick="$(\'#checkform\').val(\'1\');$(\'#editbasket\').submit();" /></p>';

								$cont .= "".$send_button."<p class=\"inp\" style=\"padding-right:5px;\">
                                    <input type=\"submit\" name=\"\" value=\"   Пересчитать\" />
                                </p>



                                <div class=\"clear\"></div>
                            </form>
                        </div>";







                    if (@$skid > 0) {
                    	$cont .= "<br />С учетом скидки: <b>".($countTo-($countTo/100*$skid))."</b> руб.";
                    	}


                    //window.location.href='/catalog/sendOrder.php'


			    	} else {

			    	    $cont .= "<br /><center>Корзина пуста!</center><br /><br /><br />";

			    		}


        if (isset($_SESSION['ud_user'])) {

/*      $contAutorize = $this->WelcomUserShop();

        $contAutorize .= "<div class='kabinet_container'>
        	<div class='kabinet_b1_sel'>Корзина</div>
        	<div class='kabinet_b1'><a href='orderStatus.php'>Заказы</a></div>
        	<div class='kabinet_b2'><a href='editProfile.php'>Личные данные</a></div>
        	<div class='kabinet_b1'><a href='exit.php'>Выход</a></div>
        </div>";*/

        } else {
            $contAutorize = '';
            //unset($contAutorize);

        	}



        $this->data['pageTitle'] = $pageTitled;

        $this->data['navigation'] = "<a href='/'>Главная</a> / <a href='/catalog/'>Каталог</a> / Корзина товаров";

        if (@$_GET['type'] == "select" && isset($_SESSION['ud_user'])) {
        	$cont = "<div style='line-height:22px;'><div style='padding:6px;'>Выбирите вариант для работы с корзиной:</div>
        	&nbsp; &raquo; <a href='auth.php'>Авторизироваться</a>
        	<br />&nbsp; &raquo; <a href='register.php'>Зарегистрироваться</a>
        	<br />&nbsp; &raquo; <a href='showBasket.php'>Продолжить работу без регистрации</a></div>";
        	}

		$this->data['content'] = $contAutorize.$cont;
	}

































    //Просмотр корзины товаров
	function showBasketPrint() {
		global $sql, $API, $_FILES, $_SESSION;

        $BasketSql = clone $this->sql;

        $pageTitled = "Корзина товаров";

        $cont = '';

        //Ид розничной цены
        $roz_id = $this->priceUd(1);

        if ($_GET['montaz'] == 1) $montazcheck = 'checked'; else $montazcheck = '';

        //$skid = $this->SkidkaUserShop();
        $cont1 = '';
        //Если юзер авторизован
		if (isset($_SESSION['ud_user'])) {
		    $dop_sql = "`ud_user`='".$_SESSION['ud_user']."' AND `status`='0'";



			//Поиск контрагентов у данного пользователя
		    $sql->query("SELECT `id`,`orgname`,`idprice`,`default` FROM `#__#agents` WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."'");
			if ($sql->num_rows() > 0) {

				$selectContragent .= '<select onChange="sortBySelected(this);" disabled>';

                while ($sql->next_row()) {
                	if ($sql->result['id'] == $_GET['id_agents'] || !isset($_GET['id_agents']) && $sql->result['default'] == 1) $sel = 'selected'; else $sel = '';
                	$selectContragent .= '<option value="?id_agents='.$sql->result['id'].'" '.$sel.'>'.$sql->result['orgname'].'</option>';
                	}

				$selectContragent .= '</select>';

                //ИД выбранного агента
                if (isset($_GET['id_agents'])) {
                	$id_agents = $_GET['id_agents'];
                	} else {
                		$sql->query("SELECT `id` FROM `#__#agents` WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."' AND `default`='1'", true);
                		$id_agents = $sql->result['id'];
                		}


                $_SESSION['ud_agents'] = $id_agents;

                //Апдейт цен корзины
				$this->updatePrices($_SESSION['ud_user'], $id_agents);



				} else {

				    $selectContragent = '<font style="color:#D20005;">Вам необходимо <a href="/catalog/agentsAddForm.php" style="color:#D20005; font-weight:bold;">добавить контрагента</a> для отправки заказа</font>';

                    $send_button = '<p class="inp_grey">
                                    	<input type="submit" name="" value="  " />
                                	</p>';

					}




		    //$sendOrder = "<input type='button' onClick=\"window.location.href='/catalog/'\" value='Отправить заказ' style='padding:2px;'>";
			} else {
                $dop_sql = "`session`='".$this->sessionGuest()."' AND `status`='0'";
                //$sendOrder = "<a href=\"?\">Отправить заказ без регистрации</a>";
				}

                $rozSql = clone $sql;

                $i = "";
                $k = "";
				$sql->query("SELECT * FROM `#__#basket` WHERE $dop_sql");
				while ($sql->next_row()) {

				    //Определение розничной цены товара
				    $rozSql->query("SELECT `price` FROM `#__#price` WHERE `catalog_id`='".$sql->result['ud_goods']."' AND `price_id`='$roz_id'", true);
				    $rozPrices[] = $rozSql->result['price']*$sql->result['count'];


					$i++;
					//Получим наименование товара из каталога
					$BasketSql->query("SELECT `id`,`title`,`photo`,`assignParam1`,`assignParam2`,`assignParam3`,`assignParam4` FROM `#__#catalog` WHERE `id`='".$sql->result['ud_goods']."'", true);


                    //Проверка упаковки
                    if (@$_GET['up'][$sql->result['ud_goods']] > 0) {
                    	$valued = htmlspecialchars($_GET['r'][$sql->result['ud_goods']]);
                    	$infoErr1 = "<br /><center><font color=#D20005>Число должно быть кратно упаковке: ".$BasketSql->result['assignParam3']."</gont></center>";
                    	} else {
                    		//$valued = $sql->result['count'];
                    		$infoErr1 = '';
                    		}


                    //Проверка количества
                    if (@$_GET['r'][$sql->result['ud_goods']] > 0) {
                    	$valued = htmlspecialchars($_GET['r'][$sql->result['ud_goods']]);
                    	$infoErr = "<br /><center><font color=#D20005>В наличии только: ".htmlspecialchars($_GET['c'][$sql->result['ud_goods']])." шт.</gont></center>";
                    	} else {
                    		$valued = $sql->result['count'];
                    		$infoErr = '';
                    		}


                    if ($BasketSql->result['assignParam3'] > 1) $vUpakovke = $BasketSql->result['assignParam3']; else $vUpakovke = "-";


                    if (strlen($sql->result['comment']) > 0) {
                    	$valueds=htmlspecialchars($sql->result['comment']);
                    	} else {
                    		$valueds="Комментарий к товару (размер, цвет и т.п.)";
                    		}

                    $k++;
                    if ($k == $sql->num_rows()) $style_tr = 'id="noborder-b"'; else $style_tr="";


                    //Фото товара
                    if (strlen($BasketSql->result['photo']) > 0) {
                    	$photoItem = "<a id=\"example2\" href=\"/image.php?src=".$BasketSql->result['id']."&amp;type=big&amp;.jpg\"><img border=\"0\" vspace=\"5\" hspace=\"5\" src=\"/image.php?src=".$BasketSql->result['id']."\" style='border: 1px solid #CADCE6;'></a>";
                    	} else {
                    		$photoItem = '<img src="/i/no_photo.png" border="0" width="100">';
                    		}


                    if (strlen($BasketSql->result['assignParam2']) > 0) $articul = $this->codTovara($BasketSql->result['assignParam2']); else $articul = 'Отсутсвует';

					$cont1 .= "<tr $style_tr>
                                        <td class=\"noborder-l\" align='center'>$articul</td>
                                        <td align='center'>$photoItem</td>
                                        <td>
                                            <b>
                                               ".$BasketSql->result['title']."
                                            </b>
                                        </td>
                                        <td class=\"red\" align='center'>
                                            ".$sql->result['price']." руб.
                                        </td>
                                        <td align='center'>
                                            <b>$valued</b>
                                        </td>
                                        <td>".($sql->result['price']*$valued)." руб.</td>
                                    </tr>";


					$countGd = @$countGd+$sql->result['count'];
					$countTo = @$countTo+$sql->result['total_price'];

					}
			    //Если корзина не пуста
			    if ($i > 0) {

                    $pageTitled="Корзина заказов / ЗАКАЗ ОТ ".date("d.m.Y")."</h3>";

					$cont .= "
                        <div class=\"clear\"></div>

                        <div class=\"article-wrap\">

						<form id='editbasket' action='/catalog/editBasket.php' method='post'>
					          <input id='checkform' name='checkform' type='hidden' value='0'>
			     <div id='itemprint'>
					            <table border='1'>
                                <thead>
                                    <tr>
                                        <th class=\"noborder-l\">Код товара</th>
                                        <th>Изображение</th>
                                        <th>Название товара</th>
                                        <th class=\"pink\">Цена за ед.</th>
                                        <th>Количество</th>
                                        <th>Всего</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	$cont1
                                </tbody>
                                </table>
                   </div>

						<div class=\"tl\"></div>
                            <div class=\"tr\"></div>
                            <div class=\"bl\"></div>
                            <div class=\"br\"></div>
                        </div>


						<div style='padding-right:30px;'>";

						if(isset($_SESSION['ud_user'])) {
							$cont .= 'Контрагент: '.$selectContragent;

							//Расчет скидки
							$rozPrices = array_sum($rozPrices);
							$skidka = '';
							if ($rozPrices > $countTo) $skidka = '<br />Ваша скидка составила: <b>'.($rozPrices-$countTo).'</b> руб.';

							}

                        $nds = ceil($countTo/100*18);

                        $cont .= "<br /><br />
						Итого: <b>$countGd</b> товаров, на сумму: <b>$countTo</b> руб. НДС: <b>$nds</b> руб. $skidka";


                    if (@$skid > 0) {
                    	$cont .= "<br />С учетом скидки: <b>".($countTo-($countTo/100*$skid))."</b> руб.";
                    	}


			    	} else {

			    	    $cont .= "<br /><center>Корзина пуста!</center><br /><br /><br />";

			    		}


		$this->data['content'] = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		                          <body onload="window.print();">
								  '.$contAutorize.$cont;
	}





























    //Удаление товара с корзины
	function delGoodsBasket() {
		global $_SESSION, $_POST, $_GET, $sql;
		//Для авторизованного пользователя
      	$sql->query("DELETE FROM `#__#basket` WHERE `ud_goods`='".htmlspecialchars($_GET['ud_goods'])."' AND `ud_user`='".$_SESSION['ud_user']."'");
      	//Для анонима
      	$sql->query("DELETE FROM `#__#basket` WHERE `ud_goods`='".htmlspecialchars($_GET['ud_goods'])."' AND `session`='".$this->sessionGuest()."'");
		header("HTTP/1.1 301 Moved Permanently");
    	header("Location: /catalog/showBasket.php");
	}






	function truncBascet() {
		global $sql;
        //Если юзер авторизован
		if (isset($_SESSION['ud_user'])) {
		    $dop_sql = "`ud_user`='".$_SESSION['ud_user']."' AND `status`='0'";
			} else {
                $dop_sql = "`session`='".$this->sessionGuest()."' AND `status`='0'";
				}

		$sql->query("DELETE FROM `#__#basket` WHERE $dop_sql");

	}




    //Редактирование количества товаров в корзине
	function editBasket() {
		global $_SESSION, $_POST, $_GET, $sql;
        //Если юзер авторизован
		if (isset($_SESSION['ud_user'])) {
		    $dop_sql = "`ud_user`='".$_SESSION['ud_user']."' AND `status`='0'";
		    $prize_us = $this->priceUd(2);
			} else {
                $dop_sql = "`session`='".$this->sessionGuest()."' AND `status`='0'";
                $prize_us = $this->priceUd(1);
				}




        //Обработка массива посланных данных
	    foreach ($_POST['count'] as $key=>$value) {
	    	//Выполним проверку количества товаров на складе
	    	$sql->query("SELECT `assignParam1`,`assignParam3`,`assignParam4`,`price` FROM `#__#catalog` WHERE `id`='$key'", true);

            $sql->result['price'] = $this->priceIn($key, $prize_us);

            $a++;

	    	//Проверка кратности упaковки если продажа разрешена только упаковками
/*	    	if ($sql->result['assignParam3'] > 1 && $sql->result['assignParam4'] == 0) {
	    		//количество упаковок
	    		$CntUp = $value/$sql->result['assignParam3'];
	    		if (substr_count($CntUp, ",") > 0) {
	    			$er1[$a] = 1;
	    			if (strlen($error_str) == 0) $error_str .= "up[$key]=1&"; else $error_str .= "&up[$key]=1&";
	    			}

	    		}*/

                //$sql->result['assignParam1']

	    	if (9999999 < $value || $er1[$a] == 1) {
	    		$i++;
	    		if ($i == 1) $error_str .= "c[$key]=".$sql->result['assignParam1']."&r[$key]=$value"; else $error_str .= "&c[$key]=".$sql->result['assignParam1']."&r[$key]=$value";
	    		} else {
	    			$error_str .= "";
                    //Если товара в форме НОЛЬ, то удалим его из БД корзины
                    if ($value == 0) {
      					$sql->query("DELETE FROM `#__#basket` WHERE `ud_goods`='$key' AND `ud_user`='".$_SESSION['ud_user']."'");
      					$sql->query("DELETE FROM `#__#basket` WHERE `ud_goods`='$key' AND `session`='".$this->sessionGuest()."'");
                    	} else {
                    		$commn = $_POST['param'][$key];

                    		if ($commn == "Комментарий к товару (размер, цвет и т.п.)") $commn = "";

                    		//Иначе апдейт корзины
                    		$sql->query("UPDATE `#__#basket` SET `count`='$value',`total_price`='".($value*$sql->result['price'])."',`comment`='$commn' WHERE `ud_goods`='$key' AND $dop_sql");
                    		}
	    			}

	    	}

	    	if (strlen($error_str) == 0 && $_POST['checkform'] == 1) {
	    		header("HTTP/1.1 301 Moved Permanently");
	    		header("Location: /catalog/sendOrder.php?type=comment&comment=".base64_encode($_POST['comment'])."&montaz=".$_POST['montaz']."");
	    		} else {
					header("HTTP/1.1 301 Moved Permanently");
    				header("Location: /catalog/showBasket.php?$error_str&montaz=".$_POST['montaz']."&comment=".base64_encode($_POST['comment'])."");
	    			}

	}



	function listGoodsSendToManager($id_order) {
		global $sql, $_SESSION;

		$sql->query("SELECT `userid`,`comments` FROM `#__#documents` WHERE `id`='$id_order'", true);
        if (strlen($sql->result['comments']) > 0) $comment = '<br /><b>Комментарий к заказу:</b> '.$sql->result['comments']; else $comment = '';

        $sql->query("SELECT `fio`,`mail`,`adres`,`tel`,`name_company`,`inn` FROM `#__#userShop` WHERE `id`='".$sql->result['userid']."'", true);

        $email_to_user = $sql->result['mail'];

        if (strlen($sql->result['fio']) > 0) $fio = '<br /><b>ФИО:</b> '.$sql->result['fio']; else $fio = '';
        if (strlen($sql->result['mail']) > 0) $mail = '<br /><b>E-Mail:</b> '.$sql->result['mail']; else $mail = '';
        if (strlen($sql->result['adres']) > 0) $adres = '<br /><b>Адрес:</b> '.$sql->result['adres']; else $adres = '';
        if (strlen($sql->result['tel']) > 0) $tel = '<br /><b>Телефон:</b> '.$sql->result['tel']; else $tel = '';
        if (strlen($sql->result['name_company']) > 0) $name_company = '<br /><b>Компания:</b> '.$sql->result['name_company']; else $name_company = '';
        if (strlen($sql->result['inn']) > 0) $inn = '<br /><b>ИНН:</b> '.$sql->result['inn']; else $inn = '';

        $cont = '<br /><br />
        		 <table border="1">
        			<tr>
        				<th>Наименование товара</th>
        				<th align="center">Количество</th>
        				<th align="center">Цена (итого)</th>
        			</tr>';

        $sql->query("SELECT `title`,`summ`,`pcs` FROM `#__#content` WHERE `docid`='$id_order'");
        while ($sql->next_row()) {

            $count[] = $sql->result['pcs'];
            $total[] = $sql->result['summ'];

            $cont .= '<tr>
            				<td>'.$sql->result['title'].'</td>
            				<td align="center">'.$sql->result['pcs'].'</td>
            				<td align="center">'.$sql->result['summ'].' руб.</td>
            		  </tr>';

        	}

        $cont .= '</table>';

        $cont .= '<br />ИТОГО: <b>'.array_sum($count).'</b> шт, на сумму <b>'.array_sum($total).'</b> руб.';

		// Creating headers
		$header  = "From: zakaz@m3952.ru\n";
		$header .= "MIME-Version: 1.0\n";
		$header .= "Content-Type: text/html; charset=utf-8;\n";
		$messageSubject = "Уведомление о новом заказе в Интернет-магазине";
		$messageBody = "Поступил новый заказ в интернет-магазине. Дата и время заказа: ".date('Y-m-d H:i:s')."<br />".$fio.$mail.$adres.$tel.$name_company.$inn.$comment.$cont;
		//Получим E-Mail Менеджера, для уведомления о новом заказе
		$ManagerSql = clone $this->sql;
		$ManagerSql->query("SELECT `value` FROM `#__#config` WHERE `name`='mailShopManager'", true);

        mail($ManagerSql->result['value'], $messageSubject, $messageBody, $header);

        if (strlen($mail) > 0) mail($email_to_user, "Заказ принят", "Здравствуйте! <br> Ваш заказ принят и находится в стадии обработки: <br> ".$cont, $header);

	}






    //Если заказ не авторизированного пользователя
	function listGoodsSendToManagerGuest($id_order) {
		global $sql, $_SESSION;

        $subSql = clone $sql;

		$sql->query("SELECT `ud_user`,`comment` FROM `#__#orderStatus` WHERE `id`='$id_order'", true);
        if (strlen($sql->result['comment']) > 0) $comment = '<br /><b>Комментарий к заказу:</b> '.$sql->result['comment']; else $comment = '';

        $sql->query("SELECT `fio`,`mail`,`adres`,`tel`,`name_company`,`inn` FROM `#__#userShop` WHERE `id`='".$sql->result['ud_user']."'", true);

        $mail_to_guest = $sql->result['mail'];

        if (strlen($sql->result['fio']) > 0) $fio = '<br /><b>ФИО:</b> '.$sql->result['fio']; else $fio = '';
        if (strlen($sql->result['mail']) > 0) $mail = '<br /><b>E-Mail:</b> '.$sql->result['mail']; else $mail = '';
        if (strlen($sql->result['adres']) > 0) $adres = '<br /><b>Адрес:</b> '.$sql->result['adres']; else $adres = '';
        if (strlen($sql->result['tel']) > 0) $tel = '<br /><b>Телефон:</b> '.$sql->result['tel']; else $tel = '';
        if (strlen($sql->result['name_company']) > 0) $name_company = '<br /><b>Компания:</b> '.$sql->result['name_company']; else $name_company = '';
        if (strlen($sql->result['inn']) > 0) $inn = '<br /><b>ИНН:</b> '.$sql->result['inn']; else $inn = '';

        $cont = '<br /><br />
        		 <table border="1">
        			<tr>
        				<th>Наименование товара</th>
        				<th align="center">Количество</th>
        				<th align="center">Цена (итого)</th>
        			</tr>';


        $sql->query("SELECT `ud_goods`,`count`,`price`,`total_price` FROM `#__#basket` WHERE `session`='".$this->sessionGuest()."' AND `status`='0'");
        while ($sql->next_row()) {

            $subSql->query("SELECT `title` FROM `#__#catalog` WHERE `id`='".$sql->result['ud_goods']."'", true);

            $count[] = $sql->result['count'];
            $total[] = $sql->result['total_price'];

            $cont .= '<tr>
            				<td>'.$subSql->result['title'].'</td>
            				<td align="center">'.$sql->result['count'].'</td>
            				<td align="center">'.$sql->result['total_price'].' руб.</td>
            		  </tr>';

        	}

        $cont .= '</table>';

        $cont .= '<br />ИТОГО: <b>'.array_sum($count).'</b> шт, на сумму <b>'.array_sum($total).'</b> руб.';

		// Creating headers
		$header  = "From: zakaz@m3952.ru\n";
		$header .= "MIME-Version: 1.0\n";
		$header .= "Content-Type: text/html; charset=utf-8;\n";
		$messageSubject = "Уведомление о новом заказе в Интернет-магазине";
		$messageBody = "Поступил новый заказ в интернет-магазине. Дата и время заказа: ".date('Y-m-d H:i:s')."<br />".$fio.$mail.$adres.$tel.$name_company.$inn.$comment.$cont;
		//Получим E-Mail Менеджера, для уведомления о новом заказе
		$ManagerSql = clone $this->sql;
		$ManagerSql->query("SELECT `value` FROM `#__#config` WHERE `name`='mailShopManager'", true);

        mail($ManagerSql->result['value'], $messageSubject, $messageBody, $header);

        if (strlen($mail) > 0) mail($mail_to_guest, "Заказ принят", "Здравствуйте! <br/><br /> Ваш заказ принят и находится в стадии обработки: <br/> ".$cont, $header);

	}
















    function randomId($number) {
       $arr = array('a','b','c','d','e','f',
                     'g','h','i','j','k','l',
                     'm','n','o','p','r','s',
                     't','u','v','x','y','z',
                     'A','B','C','D','E','F',
                     'G','H','I','J','K','L',
                     'M','N','O','P','R','S',
                     'T','U','V','X','Y','Z',
                     '1','2','3','4','5','6',
                     '7','8','9','0');
        $pass = "";
        for($i = 0; $i < $number; $i++)
        {
          $index = mt_rand(0, sizeof($arr) - 1);
          $pass .= $arr[$index];
        };
        return strtolower($pass);
      }



	//Отправка заказа
	function sendOrder() {
		global $_SESSION, $_POST, $_GET, $sql;

		$_POST['comment'] = $_GET['comment'];

		$montaz = '';

		if ($_GET['montaz'] == 1) $montaz = 'Рассчитать стоимость монтажа. ';
        $_POST['comment'] = $montaz.base64_decode($_POST['comment']);

		// Creating headers
		$header  = "From: zakaz@m3952.ru\n";
		$header .= "MIME-Version: 1.0\n";
		$header .= "Content-Type: text/plain; charset=Windows-1251;\n";
		$messageSubject = "Уведомление о новом заказе в Интернет-магазине";
		$messageBody .= "Поступил новый заказ в интернет-магазине. Дата и время заказа: ".date('Y-m-d H:i:s')."";
		//Получим E-Mail Менеджера, для уведомления о новом заказе
		$ManagerSql = clone $this->sql;
		$ManagerSql->query("SELECT `value` FROM `#__#config` WHERE `name`='mailShopManager'", true);
        //Если юзер авторизован
		if ($_SESSION['ud_user'] > 0) {

            $sql->query("SELECT `id` FROM `#__#basket` WHERE `status`='0' AND `ud_user`='".$sql->escape($_SESSION['ud_user'])."'", true);
            if ($sql->num_rows() == 0) go('/catalog/showBasket.php');

		    if ($_GET['type'] == "comment") {
				//Создадим заказ
		    	//- - - $sql->query("INSERT INTO `#__#orderStatus`(`ud_user`,`date`,`status`,`comment`) VALUES ('".$_SESSION['ud_user']."','".date('Y-m-d H:i:s')."','1','".htmlspecialchars($_POST['comment'])."')");
            	//- - - $LastOrd = $sql->lastId();
		    	//Обновим позиции заказа
            	//- - - $sql->query("UPDATE `#__#basket` SET `status`='1',`ud_order`='$LastOrd' WHERE `ud_user`='".$_SESSION['ud_user']."' AND `status`='0'");

                $sql->query("SELECT sum(total_price) FROM `#__#basket` WHERE `status`='0' AND `ud_user`='".$sql->escape($_SESSION['ud_user'])."'", true);

                //Генерация случайного ИД
                $random = $this->randomId('30');

                //Генерация случайного ИД агентса
                $random_agents = $this->randomId('30');

                $agentSql = clone $sql;

                $agentSql->query("SELECT `agentid` FROM `#__#agents` WHERE `id`='".$sql->escape($_SESSION['ud_agents'])."'", true);

                //Создание заказа
		    	$sql->query("INSERT INTO `#__#documents`(`id`,
		    	                                         `userid`,
		    											 `hozoperation`,
		    											 `role`,
		    											 `currency`,
		    											 `rate`,
		    											 `summ`,
		    											 `doctime`,
		    											 `comments`,
		    											 `canceled`,
		    											 `status`,
		    											 `docdate`,
		    											 `agentid`,
		    											 `ud_agents`) VALUES ('$random',
		    											 					'".$sql->escape($_SESSION['ud_user'])."',
		    											 					'Заказ товара',
		    											 					'Продавец',
		    											 					'руб',
		    											 					'1',
		    											 					'".$sql->result['sum(total_price)']."',
		    											 					'".date("H:m:s")."',
		    											 					'".$sql->escape(htmlspecialchars($_POST['comment']))."',
		    											 					'false',
		    											 					'[N] Принят',
		    											 					'".date("Y-m-d")."',
		    											 					'".$agentSql->result['agentid']."',
		    											 					'".$sql->escape($_SESSION['ud_agents'])."')");


                //Получение данных о контрагенте
                $sql->query("SELECT * FROM `#__#agents` WHERE `id`='".$sql->escape($_SESSION['ud_agents'])."'", true);

                //Добавление контрагента для текущего заказа
		    	$sql->query("INSERT INTO `#__#agents_orders`(`id`,
		    	                                         	 `userid`,
		    											 	 `docid`,
		    											 	 `agentid`,
		    											 	 `orgname`,
		    											 	 `fullorgname`,
		    											 	 `inn`,
		    											 	 `kpp`,
		    											 	 `okpo`,
		    											 	 `role`,
		    											 	 `idprice`) VALUES ('".$sql->result['agentid']."',
		    											 						'".$sql->result['userid']."',
		    											 						'".$random."',
		    											 						'".$sql->result['agentid']."',
		    											 						'".$sql->result['orgname']."',
		    											 						'".$sql->result['fullorgname']."',
		    											 						'".$sql->result['inn']."',
		    											 						'".$sql->result['kpp']."',
		    											 						'".$sql->result['okpo']."',
		    											 						'".$sql->result['role']."',
		    											 						'".$sql->result['idprice']."')");

                $inSql = clone $sql;

        		$sql->query("SELECT * FROM `#__#basket` WHERE `status`='0' AND `ud_user`='".$sql->escape($_SESSION['ud_user'])."'");
        		while ($sql->next_row()) {

        		    $inSql->query("SELECT `title`,`assignParam2` FROM `#__#catalog` WHERE `id`='".$sql->result['ud_goods']."'", true);

		    		$inSql->query("INSERT INTO `#__#content` (`docid`,
		    										    	  `itemid`,
		    												  `articul`,
		    												  `title`,
		    												  `baseed`,
		    												  `price`,
		    												  `summ`,
		    												  `measure`,
		    												  `pcs`) VALUES ('$random',
		    											 					 '".$sql->result['ud_goods']."',
		    											 					 '".$inSql->result['assignParam2']."',
		    											 					 '".$inSql->result['title']."',
		    											 					 '".$sql->result['measure']."',
		    											 					 '".$sql->result['price']."',
		    											 					 '".$sql->result['total_price']."',
		    											 					 '".$sql->result['measure']."',
		    											 					 '".$sql->result['count']."')");

		    		//Заполнение для сравнения
		    		$inSql->query("INSERT INTO `#__#content_sravnenie` (`docid`,
		    										    	  `itemid`,
		    												  `articul`,
		    												  `title`,
		    												  `baseed`,
		    												  `price`,
		    												  `summ`,
		    												  `measure`,
		    												  `pcs`) VALUES ('$random',
		    											 					 '".$sql->result['ud_goods']."',
		    											 					 '".$inSql->result['assignParam2']."',
		    											 					 '".$inSql->result['title']."',
		    											 					 '".$sql->result['measure']."',
		    											 					 '".$sql->result['price']."',
		    											 					 '".$sql->result['total_price']."',
		    											 					 '".$sql->result['measure']."',
		    											 					 '".$sql->result['count']."')");


        			}

                //Очистка временной таблицы
                $sql->query("DELETE FROM `#__#basket` WHERE `status`='0' AND `ud_user`='".$sql->escape($_SESSION['ud_user'])."'");



            	$cont .= "<br /><center>Ваш заказ отправлен. В ближайшее время с Вами свяжется менеджер нашей компании.</center><br /><br /><br /><br />";

            	//mail($ManagerSql->result['value'], $messageSubject, $messageBody, $header);

            	$this->listGoodsSendToManager($random);

/*            	$sql->query("SELECT `mail` FROM `#__#userShop` WHERE `id`='".$_SESSION['ud_user']."'", true);
            	mail($sql->result['mail'], "Заказ принят", "Ваш заказ в обработке", $header);*/

            	} else {

		    		$cont .= "<br />
		    		<table align=center>
        			<form name='' action='?type=comment' method='post'>
        			<input name='state' type='hidden' value='1'>
        			<tr>
                    	<td align=right style='padding:4px;'>Комментарий к заказу:</td>
                    	<td style='padding:4px;'><textarea name='comment' rows='6' cols='60' class='pl_Text'>".htmlspecialchars($_POST['comment'])."</textarea></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'> </td>
                    	<td style='padding:4px;'><input type='submit' value='Отправить заказ' class='pl_Submit'></td>
       				</tr>
       				</form>
       				</table>";


            		}

			} else {
				//Если данные были посланы с формы
			    if ($_POST['state'] == 1) {

			    if (strtolower($_SESSION['imageCheckCode']) != strtolower($_POST['imageCheckCode'])) $er[] = "1";

			    if (count($er) > 0) {

			    $cont .= "<br /><center>Ошибка! <br /><br /> Код с картинки не соответсвует!</center>
			    <br /><center>[ <a href='#' onClick='history.back();'>Вернуться</a> ]</center>

			    ";

			    } else {

			    //Создадим пользователя
                $sql->query("INSERT INTO `#__#userShop`(`fio`,`mail`,`adres`,`tel`) VALUES ('".htmlspecialchars($_POST['fio'])."','".htmlspecialchars($_POST['mail'])."','".htmlspecialchars($_POST['adres'])."','".htmlspecialchars($_POST['tel'])."')");
                $BaseUserUd = $sql->lastId();
				//Создадим заказ
		    	$sql->query("INSERT INTO `#__#orderStatus`(`ud_user`,`date`,`status`,`comment`) VALUES ('$BaseUserUd','".date('Y-m-d H:i:s')."','1','".htmlspecialchars($_POST['comment'])."')");
            	$LastOrd = $sql->lastId();

            	$this->listGoodsSendToManagerGuest($LastOrd);

                //Обновим статус заказов в корзине
                $sql->query("UPDATE `#__#basket` SET `ud_user`='$BaseUserUd',`session`='null',`status`='1',`ud_order`='$LastOrd' WHERE `session`='".$this->sessionGuest()."' AND `status`='0'");
                $cont .= "<br /><center>Ваш заказ отправлен. В ближайшее время с Вами свяжется менеджер нашей компании.</center><br /><br /><br /><br />";

                //$this->listGoodsSendToManager($LastOrd);


                }

			    } else {

			    $newcomments = $montaz.base64_decode($_GET['comment']);


                $cont .= "<br />
                <table align=center>
        			<form name='reg' action='?' method='post' onSubmit='return ValidateForm(this)'>
        			<input name='state' type='hidden' value='1'>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Ваше ФИО:</td>
                    	<td style='padding:4px;'><input name='fio' type='text' value='".htmlspecialchars($_POST['fio'])."' size='50' style='padding:2px;' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Ваш E-Mail:</td>
                    	<td style='padding:4px;'><input name='mail' type='text' value='".htmlspecialchars($_POST['mail'])."' size='50' style='padding:2px;' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Контактный телефон:</td>
                    	<td style='padding:4px;'><input name='tel' type='text' value='".htmlspecialchars($_POST['tel'])."' size='50' style='padding:2px;' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Адрес:</td>
                    	<td style='padding:4px;'><textarea name='adres' rows='2' cols='50' class='pl_Text'>".htmlspecialchars($_POST['adres'])."</textarea></td>
       				</tr>


                    <input name='comment' type='hidden' value='$newcomments'>

        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Код</td>
                    	<td style='padding:4px;'>


                    		  <table><tr>
                    		   <td width=1>
                    			<a href=\"javascript:void(0);\" onclick=\"document.getElementById('imageCheckCode').src='/imageCheckCode.php?rid=' + Math.random();\">
                    				<img src='/imageCheckCode.php' border='0' id='imageCheckCode' />
                    			</a>
                    		   </td>
                    		   <td>
                    		   		&nbsp;<a href=\"javascript:void(0);\" onclick=\"document.getElementById('imageCheckCode').src='/imageCheckCode.php?rid=' + Math.random();\">Обновить код</a>
                    		   </td>
                    		  </tr></table>



                    	<br />
                    <input name='imageCheckCode' type='text' value='".htmlspecialchars($_POST['imageCheckCode'])."' size='10' class='pl_Text'>
                    </td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'>&nbsp;</td>
                    	<td style='padding:4px;'><input type='submit' value='Отправить заказ' class='pl_Submit'></td>
       				</tr>
       				</form>
        		  </table>
					<script language='JavaScript'>
					function ValidateForm(frm) {
						if (frm.fio.value==\"\") {
							alert(\"Укажите Ваше ФИО!\");
							return false;
						}
						if (frm.mail.value==\"\") {
							alert(\"Укажите ваш E-Mail!\");
							return false;
						}
						if (frm.tel.value==\"\") {
							alert(\"Укажите ваш контакный телефон!\");
							return false;
						}
						if (frm.imageCheckCode.value==\"\") {
							alert(\"Не указан код!\");
							return false;
						}
					}
					</script>";


				}

				}

        $this->data['pageTitle'] = "Отправка заказа";
        $this->data['navigation'] = "<a href='/'>Главная</a> / <a href='/catalog/'>Каталог</a> / Корзина товаров";
		$this->data['content'] = $cont;

}












	public function typePrices() {
		global $sql;

        $subSql = clone $sql;

        $cont = '<form name="SAVE_TYPE" action="typePricesSave.php" method="post">
        		 <table>
					  <tr>
						  <th>ИД цены</th>
			              <th>Название цены</th>
			              <th>Цена которую видят все</th>
			              <th>Цена для зарегистрированных</th>
					  <tr>';

		$sql->query("SELECT * FROM `#__#prices`");
		while ($sql->next_row()) {

            $subSql->query("SELECT `status` FROM `#__#pricesOptions` WHERE `id`='".$sql->result['id']."'", true);

            if ($subSql->result['status'] == 1) $checkRoz = 'checked'; else $checkRoz = '';
            if ($subSql->result['status'] == 2) $checkWeb = 'checked'; else $checkWeb = '';

			$cont .= '<tr>
						  <td class="tbl_stand">'.$sql->result['id'].'</td>
			              <td class="tbl_stand">'.$sql->result['name_ru'].'</td>
			              <td class="tbl_stand" align="center"><input name="roznica" type="radio" value="'.$sql->result['id'].'" '.$checkRoz.'></td>
			              <td class="tbl_stand" align="center"><input name="web" type="radio" value="'.$sql->result['id'].'" '.$checkWeb.'></td>
					  <tr>';

			}


		$cont .= '</table><br /><input type="submit" value="Сохранить"></form>';

        unset($subSql);

        $this->data['content'] = $cont;

	}


	public function typePricesSave() {
		global $sql, $_POST;

        $sql->query("DELETE FROM `#__#pricesOptions`");

		$sql->query("INSERT INTO `#__#pricesOptions` (`id`,`status`) VALUES ('".$sql->escape($_POST['roznica'])."','1')");
        $sql->query("INSERT INTO `#__#pricesOptions` (`id`,`status`) VALUES ('".$sql->escape($_POST['web'])."','2')");

        message("Данные успешно сохранены!", "", "/admin/catalog/typePrices.php");

	}





        function oformlenie() {
            global $sql;

            $ofSql = clone $sql;

            $ofSql->query("SELECT `id` FROM `#__#basket` WHERE `ud_user`='".$ofSql->escape($_SESSION['ud_user'])."' AND `status`='0'");

            if ($ofSql->num_rows() > 0) {
                return '<div style="padding:15px; font-size:13pt;">&raquo; <a href="/catalog/showBasket.php">Продолжить оформление заказа</a></div>';
            }

        }






	function agents() {
		global $_SESSION, $_POST, $sql;
        $curr_price = clone $sql;
        $cont = "<div class='agents_cat'>Список контрагентов | <a href='/catalog/agentsAddForm.php'>Добавить контрагента</a></div>";

		$sql->query("SELECT * FROM `#__#agents` WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."'");

        if ($sql->num_rows() > 0) {

		$cont .= '<script type="text/javascript">

                  	function SaveButton(id){
                  	    var defaultparam = $("#default_id").html();

                  	    if (defaultparam != id) $("#hiddenButton").show(); else $("#hiddenButton").hide();

                  		}

				  </script>

		<form name="default" action="/catalog/defaultSave.php" method="post">
				  <table class="agents_tbl" style="margin-left:15px;">
					  <tr>
		    			<th align="left">Название организации</th>
		    			<th>ИНН</th>
		    			<th>Тип цены</th>
		    			<th>Опции</th>
		    			<th width="100">По умолчанию</th>
		    		  </tr>';

		while ($sql->next_row()) {

            if ($sql->result['default'] == 1) { $sel = 'checked'; $cont .= '<div style="display:none;" id="default_id">'.$sql->result['id'].'</div>'; } else { $sel = ''; }
            $curr_price->query("SELECT * FROM `prices` WHERE `id`='".$sql->result['idprice']."'",true);
            if ($sql->result['idprice']<>$sql->result['set_idprice'] && $sql->result['set_idprice']!=='') {$price_ag_list="<font color='red'>".$curr_price->result['name_ru']."</font>";} else {$price_ag_list=$curr_price->result['name_ru'];}
		    $cont .= "<tr>
		    			<td>".$sql->result['orgname']."</td>
		    			<td align='center'>".$sql->result['inn']."</td>
		    			<td align='center'>".$price_ag_list."</td>
		    			<td align='center'><a href='/catalog/agentsEditForm.php?id=".$sql->result['id']."'>Править</a> | <a href='/catalog/agentsDell.php?id=".$sql->result['id']."'>Удалить</a></td>
		    		    <td align='center'><input name='default' type='radio' value='".$sql->result['id']."' ".$sel." onChange='SaveButton(".$sql->result['id'].");'></td>
		    		  </tr>";

			}

        $cont .= '</table>
        <div style="display:none;" id="hiddenButton"><input type="submit" value="Сохранить" class="pl_Submit" style="margin-left: 822px; margin-top: 10px;"></div>
        </form>'.$this->oformlenie();

        } else {

            $cont .= " &nbsp; &nbsp; &nbsp; Контрагенты отсутсвуют";

        	}


        $this->data['pageTitle'] = "Список контрагентов";

        $this->data['navigation'] = "<a href='/'>Главная</a> / Контрагенты";
        $this->data['content'] = $cont;

    }



	function defaultSave() {
		global $_SESSION, $_POST, $sql;

		$sql->query("UPDATE `#__#agents` SET `default`='0' WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."'");
        $sql->query("UPDATE `#__#agents` SET `default`='1' WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."' AND `id`='".$sql->escape($_POST['default'])."'");

		message("Данные успешно сохранены!", "", "/catalog/agents.php");

	}




	function agentsAddForm() {
		global $_SESSION, $_POST, $sql;

        $cont = "<div class='agents_cat'><a href='/catalog/agents.php'>Список контрагентов</a> | Добавить контрагента</div>";

        if (isset($_POST['state'])) {

            $er = array();

            $sql->query("SELECT `id` FROM `#__#agents` WHERE `userid`='".$_SESSION['ud_user']."' AND `inn`='".$sql->escape($_POST['inn'])."'", true);
            if ($sql->num_rows() > 0) $er[] = 'Данный ИНН уже есть в базе!';
            if (strlen($_POST['orgname']) == 0) $er[] = 'Введите название организации!';



        //Каталог куда будет помещен файл с реквизитами
		$uploaddir="upload/userfiles/";
		//Дополнительные переменные
		$filename=$_FILES['userfile']['name'];
		$filesize=$_FILES['userfile']['size'];

        //Разрешенные форматы файлов
        $approvFile = "|rar|zip|jpg|jpeg|doc|pdf|gif|png|";

		//Тип файла
        $typeFile = end(explode(".", $filename));

        $uploadFile = "";

            if (strlen($filename) > 0) {

        		if (@substr_count($approvFile, $typeFile) == 1 || $typeFile == "") { $uploadFile="yes"; } else { $er[] = "Формат файла не поддерживается!"; }

        		}



            //Вывод ошибок
			$cont .= "<div style='color:#EC0006; padding-left:150px;'>";
			foreach ($er as $word) $cont .= "$word <br />";
			$cont .= "</div>";

            if (count($er) == 0) {


        if ($uploadFile == "yes") {
        	$filedName = "".time().".$typeFile";
        	move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $filedName);
        	} else {
        		$filedName = "";
        		}



            $web_price = $this->priceUd(2);

            //Проверка наличия контрагентов, если их нет, то созданому контрагенту присваиваем статус по умолчанию = 1
            $sql->query("SELECT `id` FROM `#__#agents` WHERE `userid`='".$_SESSION['ud_user']."'", true);
            if($sql->num_rows() > 0) $default = 0; else $default = 1;


            $random_agents = $this->randomId('30');

			$sql->query("INSERT INTO `#__#agents` (`userid`,
			                                       `agentid`,
												   `orgname`,
												   `fullorgname`,
												   `inn`,
												   `kpp`,
												   `okpo`,
												   `idprice`,
												   `default`,
												   `file`)
											VALUES ('".$sql->escape($_SESSION['ud_user'])."',
											        '".$sql->escape($random_agents)."',
													'".$sql->escape($_POST['orgname'])."',
													'".$sql->escape($_POST['fullorgname'])."',
													'".$sql->escape($_POST['inn'])."',
													'".$sql->escape($_POST['kpp'])."',
													'".$sql->escape($_POST['okpo'])."',
													'".$web_price."',
													'".$default."',
													'".$filedName."')");

				//message("Контрагент успешно добавлен!", "", "/catalog/agents.php");

                $cont .= '<div style="padding-left:15px; padding-top:10px; font-size:12pt;">Контрагент успешно добавлен!</div>';

            	}

        	}


        if (!isset($_POST['state']) || isset($_POST['state']) && count($er) > 0) {

        $cont .= "<br />
        			<form name='reg' action='?' method='post' enctype='multipart/form-data' onSubmit='return ValidateForm(this)'>
        			<input name='state' type='hidden' value='1'>
        			<table style='width: 550px; float:left;'>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Название организации:</td>
                    	<td style='padding:4px;'><input name='orgname' type='text' value='".$_POST['orgname']."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Полное название организации:</td>
                    	<td style='padding:4px;'><input name='fullorgname' type='text' value='".$_POST['fullorgname']."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> ИНН:</td>
                    	<td style='padding:4px;'><input name='inn' type='text' value='".$_POST['inn']."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'>КПП:</td>
                    	<td style='padding:4px;'><input name='kpp' type='text' value='".$_POST['kpp']."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'>ОКПО:</td>
                    	<td style='padding:4px;'><input name='okpo' type='text' value='".$_POST['okpo']."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'>Файл с реквизитами:</td>
                    	<td style='padding:4px;'><input type='file' name='userfile' /></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'>&nbsp;</td>
                    	<td style='padding:4px;'><input type='submit' value='Добавить контрагента' class='pl_Submit'></td>
       				</tr>
        		  </table>";

        }

        $this->data['pageTitle'] = "Добавление контрагента";
        $this->data['navigation'] = "<a href='/'>Главная</a> / Добавление контрагента";
        $this->data['content'] = $cont;

    }



	function orderHistory() {
		global $sql;

        //Статусы
        $status_array = array('ОтправленВ1С' => 'Принят в работу',
  							  'Отклонен'     => 'Отменен',
  							  'ВОбработке'   => 'В обработке',
  							  'ЖдетОплаты'   => 'Ждет оплаты',
  							  'Оплачен'      => 'Оплачен',
  							  'СборЗаказа'   => 'Сбор заказа',
  							  'Отгружен'     => 'Отгружен',
  							  'Завершен'     => 'Завершен',
  							  'НеСогласен'   => 'Не согласен',);



        $agentsForm = '<select class="wrap-inp" onChange="sortBySelected(this);" style="border: 0px;">
             		   <option value="?docstat='.$_GET['docstat'].'&date='.$_GET['date'].'">Все</option>';

        //Контрагенты
		$sql->query("SELECT `id`,`orgname` FROM `#__#agents` WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."'");
		while ($sql->next_row()) {

		    if ($_GET['ud_agents'] == $sql->result['id']) $sel = 'selected'; else $sel = '';

			$agentsForm .= '<option value="?docstat='.$_GET['docstat'].'&ud_agents='.$sql->result['id'].'&date='.$_GET['date'].'" '.$sel.'>'.$sql->result['orgname'].'</option>';

			}

        $agentsForm .= '</select>';



        $kl = 30;

        $page = @$_GET['page'];

		if($page == 1 || $page == "" || !isset($page)) { $str=0; $page=1; } else { $str=($page-1)*$kl; }

        if (@strlen($_GET['docstat']) > 0) $whereSql = "AND `status`='".$sql->escape($_GET['docstat'])."'"; else $whereSql = '';

        if (@strlen($_GET['ud_agents']) > 0) $whereSql2 = "AND `ud_agents`='".$sql->escape($_GET['ud_agents'])."'"; else $whereSql2 = '';

        $sql->query("SELECT `id` FROM `#__#documents` WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."' AND `docdate` LIKE '%".$sql->escape($_GET['date'])."%' $whereSql $whereSql2");
        $count = $sql->num_rows();

        //Количество на странице


		$cont = '<link rel="stylesheet" type="text/css" href="/css/vtip.css" />
				 <script type="text/javascript" src="/js/vtip.js"></script>
				 <script type="text/javascript">
						function sortBySelected(element) {
						if(element.options[element.selectedIndex].value!=\'\') {
						window.location = element.options[element.selectedIndex].value; }
						}
					</script>

				 <form class="look-status" method="get" action="vsd">
     				<div>
         				Посмотреть заказы по статусу:

             			<select class="wrap-inp" onChange="sortBySelected(this);" style="border: 0px;">
             			<option value="?">Все</option>';

                        foreach ($status_array as $key => $data) {

                            if (@$_GET['docstat'] == $key) $sel = 'selected'; else $sel = '';

                            $cont .= '<option value="?docstat='.$key.'&ud_agents='.$_GET['ud_agents'].'" '.$sel.'>'.$data.'</option>';

                        	}

                        if (@strlen($_GET['date']) == 0) $all_class = ''; else $all_class = 'class="nodecoration"';
                        if (@strlen($_GET['date']) > 5) $tod_class = ''; else $tod_class = 'class="nodecoration"';
                        if (@strlen($_GET['date']) == 4) $m_class = ''; else $m_class = 'class="nodecoration"';

			$cont .= '</select>

                            </div>
                        </form>

                        <h6 class="look">Посмотреть заказы за <a href="?docstat='.$_GET['docstat'].'&date='.date("Y-m-d").'&ud_agents='.$_GET['ud_agents'].'" '.$tod_class.'>сегодня,</a> <a href="?docstat='.$_GET['docstat'].'&date=-'.date("m").'-&ud_agents='.$_GET['ud_agents'].'" '.$m_class.'>за месяц,</a> <a href="?docstat='.$_GET['docstat'].'&ud_agents='.$_GET['ud_agents'].'" '.$all_class.'>все заказы</a>

                        &nbsp; &nbsp; &nbsp; &nbsp; Контрагент: '.$agentsForm.'

                        </h6>
                        <div class="clear"></div>



                        <div class="article-wrap">
                            <table width=100%>
                                <thead>
                                    <tr>
                                        <th class="noborder-l">Дата заказа</th>
                                        <th>Сумма</th>
                                        <th>Комментарий</th>
                                        <th>Опции</th>
                                        <th>Статус заказа</th>
                                    </tr>
                                </thead>
                                <tbody>';

                    $i = '';

                    $subSql = clone $sql;

					$sql->query("SELECT `id`,`summ`,`comments`,`status`,`docdate` FROM `#__#documents` WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."' AND `docdate` LIKE '%".$sql->escape($_GET['date'])."%' $whereSql $whereSql2 LIMIT $str,$kl");
					while ($sql->next_row()) {


                        $data1 = '';

                    	$subSql->query("SELECT `itemid`,`pcs` FROM `#__#content` WHERE `docid`='".$sql->result['id']."' ORDER BY `itemid`");
                        while ($subSql->next_row()) {

                            $data1 .= $subSql->result['itemid'].$subSql->result['pcs'];

                        	}


                        $data2 = '';

                        $content_sravnenie = '';

                    	$subSql->query("SELECT `itemid`,`pcs` FROM `#__#content_sravnenie` WHERE `docid`='".$sql->result['id']."' ORDER BY `itemid`");
                        while ($subSql->next_row()) {
                            $content_sravnenie = 1;
                            $data2 .= $subSql->result['itemid'].$subSql->result['pcs'];

                        	}


                        if ($data1 != $data2 && $content_sravnenie == 1 && $sql->result['status'] != 'НеСогласен') $srav = '<br />Требуется согласование'; else $srav = '';


						$i++;

						if ($i == $sql->num_rows()) $noborder = 'id="noborder-b"'; else $noborder = '';

					    if (strlen($sql->result['comments']) > 0) $comments = $sql->result['comments']; else $comments = '-';


                        $s = $sql->result['status'];

/*                      if ($s == 'ВОбработке' || $s == 'Отклонен' || $s == 'Согласован' || $s == 'ЖдетОплаты' || $s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Завершен') $vobrabotke = 'active'; else $vobrabotke = '';
                        if ($s == 'Отклонен' || $s == 'Согласован' || $s == 'ЖдетОплаты' || $s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Завершен') $otklonen = 'active'; else $otklonen = '';
                        if ($s == 'Согласован' || $s == 'ЖдетОплаты' || $s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Завершен') $soglasovan = 'active'; else $soglasovan = '';
                        if ($s == 'ЖдетОплаты' || $s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Завершен') $zdetoplati = 'active'; else $zdetoplati = '';
                        if ($s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Завершен') $oplachen = 'active'; else $oplachen = '';
                        if ($s == 'СборЗаказа' || $s == 'Завершен') $sbor = 'active'; else $sbor = '';
                        if ($s == 'Завершен') $zavershen = 'active'; else $zavershen = '';
*/
                     $pdf = '';
                     $povtor = '';

					 if ($s == 'Отклонен') {
                    	$otpravlenV1C = '<td id="nobackground" class="active"><div class="vtip" title="Отменен"></div></td>';
                    	$vobrabotke = '';
                    	$zdetoplati = '';
                    	$oplachen   = '';
                    	$sborzakaza = '';
                    	$otkgruzen  = '';
                    	$zavershen  = '';
                    	} else {

                        if ($s == 'ОтправленВ1С' || $s == 'ВОбработке' || $s == 'ЖдетОплаты' || $s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Отгружен' || $s == 'Завершен') {
                        	$otpravlenV1C = '<td id="nobackground" class="active"><div class="vtip" title="Принят в работу" onclick="location.href=\'/page/help/orderstatus.html\'"></div></td>';
                        	} else {

                        	    $otpravlenV1C = '<td id="nobackground"><div class="vtip" title="Принят в работу" onclick="location.href=\'/page/help/orderstatus.html\'"></div></td>';

                        		}


                        if ($s == 'ВОбработке' || $s == 'ЖдетОплаты' || $s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Отгружен' || $s == 'Завершен') $vobrabotke = 'active'; else $vobrabotke = '';

                        if ($s == 'ЖдетОплаты' || $s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Отгружен' || $s == 'Завершен') $zdetoplati = 'active'; else $zdetoplati = '';

                        if ($s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Отгружен' || $s == 'Завершен') $oplachen = 'active'; else $oplachen = '';

                        if ($s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Отгружен' || $s == 'Завершен') $sborzakaza = 'active'; else $sborzakaza = '';

                        if ($s == 'Отгружен' || $s == 'Завершен') $otkgruzen = 'active'; else $otkgruzen = '';

                        if ($s == 'Завершен') { $zavershen = 'active'; } else { $zavershen = ''; }


                         if ($s == 'ЖдетОплаты') $pdf = '<br /><a href="/1c/invoice.php?doc='.$sql->result['id'].'" target="_blank">Сформировать&nbsp;счет</a>';


                      }


                       if ($s == 'Завершен' || $s == 'Отклонен') $povtor=' <span>|</span> <a href="/catalog/povtor.php?documents_id='.$sql->result['id'].'"><span>Повторить заказ</span></a>';


					    $cont .= '<tr '.$noborder.'>
                                        <td class="noborder-l">'.$sql->result['docdate'].'</td>
                                        <td>
                                        	'.$sql->result['summ'].' руб.
                                        </td>
                                        <td>
                                            <span>'.$comments.'</span>
                                        </td>

										<td>
											<a href="/catalog/docinfo.php?id='.$sql->result['id'].'"><span>Подробнее</span></a>'.$srav.' '.$pdf.' '.$povtor.'
										</td>

                                        <td>
                                            <table class="circle" >
                                                <tbody>
                                                    <tr >
                                                        '.$otpravlenV1C.'
                                                        <td class="'.$vobrabotke.'"><div class="vtip" title="В обработке" onclick="location.href=\'/page/help/orderstatus.html\'"></div></td>
                                                        <td class="'.$zdetoplati.'"><div class="vtip" title="Ждет оплаты" onclick="location.href=\'/page/help/orderstatus.html\'"></div></td>
                                                        <td class="'.$oplachen.'"><div class="vtip" title="Оплачен" onclick="location.href=\'/page/help/orderstatus.html\'"></div></td>
                                                        <td class="'.$sborzakaza.'"><div class="vtip" title="Сбор заказа" onclick="location.href=\'/page/help/orderstatus.html\'"></div></td>
                                                        <td class="'.$otkgruzen.'"><div class="vtip" title="Отгружен" onclick="location.href=\'/page/help/orderstatus.html\'"></div></td>
                                                        <td class="'.$zavershen.'"><div class="vtip" title="Завершен" onclick="location.href=\'/page/help/orderstatus.html\'"></div></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>';

						}


      			$cont .= '</tbody></table>
                            <div class="tl"></div>
                            <div class="tr"></div>
                            <div class="bl"></div>
                            <div class="br"></div>
                            </div>';





        ######################################
        # Постраничная навигация

		if ($count > $kl) {
			$cont .= '<div style="padding: 15px;">Страницы: ';
			//Количество страниц
		    $CountPage = ceil($count/$kl);

			for ($c=1;$c<=$CountPage;$c++) {

				if ($page == $c) {
				$cont .= '<b>'.$c.'</b>'; } else {
				$cont .= '<a href="?page='.$c.'&docstat='.$_GET['docstat'].'&ud_agents='.$_GET['ud_agents'].'">'.$c.'</a>';
				}

				if ($c <> $CountPage) {
				$cont .= "&nbsp; ";
				}
			}
			$cont .= '</div>';
		}
        #####################################




		$this->data['pageTitle'] = "История заказов";
        $this->data['navigation'] = "&nbsp; &nbsp; <a href='/'>Главная</a> / <a href='/catalog/editProfile.php'>Личный кабинет</a> / История заказов";

		$this->data['content'] = $cont;

	}


	function docinfo() {
		global $sql;

        $povtorzakaza = '';



                    $i = '';

					$sql->query("SELECT `id`,`summ`,`comments`,`status`,`docdate` FROM `#__#documents` WHERE `id`='".$sql->escape($_GET['id'])."'");
					while ($sql->next_row()) {

						$i++;

						if ($i == $sql->num_rows()) $noborder = 'id="noborder-b"'; else $noborder = '';

					    if (strlen($sql->result['comments']) > 0) $comments = $sql->result['comments']; else $comments = '-';


                        $s = $sql->result['status'];

/*                        if ($s == 'ВОбработке' || $s == 'Отклонен' || $s == 'Согласован' || $s == 'ЖдетОплаты' || $s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Завершен' || $s == 'НеСогласен') $vobrabotke = 'active'; else $vobrabotke = '';
                        if ($s == 'Отклонен' || $s == 'Согласован' || $s == 'ЖдетОплаты' || $s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Завершен' || $s == 'НеСогласен') $otklonen = 'active'; else $otklonen = '';
                        if ($s == 'Согласован' || $s == 'ЖдетОплаты' || $s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Завершен' || $s == 'НеСогласен') $soglasovan = 'active'; else $soglasovan = '';
                        if ($s == 'ЖдетОплаты' || $s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Завершен'|| $s == 'НеСогласен') $zdetoplati = 'active'; else $zdetoplati = '';
                        if ($s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Завершен') $oplachen = 'active'; else $oplachen = '';
                        if ($s == 'СборЗаказа' || $s == 'Завершен') $sbor = 'active'; else $sbor = '';
                        if ($s == 'Завершен') $zavershen = 'active'; else $zavershen = '';

                        if ($s == 'НеСогласен') $nesoglasen = 'active'; else $nesoglasen = '';*/


					 if ($s == 'Отклонен') {
                    	$otpravlenV1C = '<td id="nobackground" class="active"><div class="vtip" title="Отменен"></div></td>';

                    	$otpravlenV1C2 = '<td id="nobackground" class="active"><div><a href="/page/help/orderstatus/otmenen.html">Отменен</a></div></td>';

                    	$vobrabotke = '';
                    	$zdetoplati = '';
                    	$oplachen   = '';
                    	$sborzakaza = '';
                    	$otkgruzen  = '';
                    	$zavershen  = '';
                    	} else {

                        if ($s == 'ОтправленВ1С' || $s == 'ВОбработке' || $s == 'ЖдетОплаты' || $s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Отгружен' || $s == 'Завершен') {
                        	$otpravlenV1C = '<td id="nobackground" class="active"><div class="vtip" title="Принят в работу"></div></td>';
                        	$otpravlenV1C2 = '<td id="nobackground" class="active"><div><a href="/page/help/orderstatus.html">Принят в работу</a></div></td>';
                        	} else {
                        	    $otpravlenV1C = '<td id="nobackground"><div class="vtip" title="Принят в работу"></div></td>';
                                $otpravlenV1C2 = '<td id="nobackground"><div><a href="/page/help/orderstatus.html">Принят в работу</a></div></td>';
                        		}


                        if ($s == 'ВОбработке' || $s == 'ЖдетОплаты' || $s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Отгружен' || $s == 'Завершен') $vobrabotke = 'active'; else $vobrabotke = '';

                        if ($s == 'ЖдетОплаты' || $s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Отгружен' || $s == 'Завершен') $zdetoplati = 'active'; else $zdetoplati = '';

                        if ($s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Отгружен' || $s == 'Завершен') $oplachen = 'active'; else $oplachen = '';

                        if ($s == 'Оплачен' || $s == 'СборЗаказа' || $s == 'Отгружен' || $s == 'Завершен') $sborzakaza = 'active'; else $sborzakaza = '';

                        if ($s == 'Отгружен' || $s == 'Завершен') $otkgruzen = 'active'; else $otkgruzen = '';


                        if ($s == 'Завершен') {
                        	$zavershen = 'active';

                        	} else {
                        		$zavershen = '';
                        		}



                        if ($s == 'ЖдетОплаты') $pdf = '<td width="1"><div style="margin-top:22px; margin-right:5px;"><a href="/1c/invoice.php?doc='.$sql->result['id'].'" target="_blank">Сформировать&nbsp;счет</a></div></td>';

                      }




                        if ($s == 'Завершен' || $s == 'Отклонен') {

                        	$povtorzakaza = '<form name="a" action="/catalog/povtor.php?documents_id='.$sql->result['id'].'" method="post">
                        			<div class="forma"><p class="inp" style="padding-right:5px;"><input type="submit" name="" value="  Повтор заказа" /></p></div>
                                  </form>';
                        	}



                           // id="nobackground"


                        $cont .= '<div class="status">
                            <table class="circle">
                                <tbody>
                                    <tr>

                                        '.$otpravlenV1C2.'

                                        <td class="'.$vobrabotke.'"><div><a class="midle" href="/page/help/orderstatus.html">В обработке</a></div></td>
                                        <td class="'.$zdetoplati.'"><div><a class="midle" href="/page/help/orderstatus.html">Ждет оплаты</a></div></td>
                                        <td class="'.$oplachen.'"><div><a class="midle" href="/page/help/orderstatus.html">Оплачен</a></div></td>
                                        <td class="'.$sborzakaza.'"><div><a class="midle" href="/page/help/orderstatus.html">Сбор заказа</a></div></td>
                                        <td class="'.$otkgruzen.'"><div><a class="midle" href="/page/help/orderstatus.html">Отгружен</a></div></td>
                                        <td class="'.$zavershen.'"><div><a class="midle" href="/page/help/orderstatus.html">Завершен</a></div></td>

                                    </tr>
                                </tbody>
                            </table>
                            <div class="tl">
                                <a href="/page/help/orderstatus.html">Статус заказа</a>
                                <div style="position:absolute; margin-left:95px; margin-top:-21px; width:200px;"><a href="/page/help/orderstatus.html" style="color:#006AB0;">Описание статусов</a></div>
                            </div>
                            <div class="tr"></div>
                            <div class="bl"></div>
                            <div class="br"></div>
                        </div><br />';





		$cont .= '<link rel="stylesheet" type="text/css" href="/css/vtip.css" />
				 <script type="text/javascript" src="/js/vtip.js"></script>

				 <div class="clear"></div>

                        <div class="article-wrap">
                            <table width=100%>
                                <thead>
                                    <tr>
                                        <th class="noborder-l">Дата заказа</th>
                                        <th>Сумма</th>
                                        <th>Комментарий</th>
                                        <!--//<th>Статус заказа</th>//-->
                                    </tr>
                                </thead>
                                <tbody>';








          /*                                  <table class="circle">
                                                <tbody>
                                                    <tr>
                                                        <td id="nobackground" class="active"><div class="vtip" title="Не подтвержден"></div></td>
                                                        <td class="'.$vobrabotke.'"><div class="vtip" title="В обработке"></div></td>
                                                        <td class="'.$otklonen.'"><div class="vtip" title="Отклонен"></div></td>
                                                        <td class="'.$soglasovan.'"><div class="vtip" title="Согласован"></div></td>
                                                        <td class="'.$zdetoplati.'"><div class="vtip" title="Ждет оплаты"></div></td>

                                                        <td class="'.$nesoglasen.'"><div class="vtip" title="Не согласен"></div></td>

                                                        <td class="'.$oplachen.'"><div class="vtip" title="Оплачен"></div></td>
                                                        <td class="'.$sbor.'"><div class="vtip" title="Сбор заказа"></div></td>
                                                        <td class="'.$zavershen.'"><div class="vtip" title="Завершен"></div></td>
                                                    </tr>
                                                </tbody>
                                            </table>*/



											/*<td>
                                            <table class="circle">
                                                <tbody>
                                                    <tr>
                                                        '.$otpravlenV1C.'
                                                        <td class="'.$vobrabotke.'"><div class="vtip" title="В обработке"></div></td>
                                                        <td class="'.$zdetoplati.'"><div class="vtip" title="Ждет оплаты"></div></td>
                                                        <td class="'.$oplachen.'"><div class="vtip" title="Оплачен"></div></td>
                                                        <td class="'.$sborzakaza.'"><div class="vtip" title="Сбор заказа"></div></td>
                                                        <td class="'.$otkgruzen.'"><div class="vtip" title="Отгружен"></div></td>
                                                        <td class="'.$zavershen.'"><div class="vtip" title="Завершен"></div></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>*/



					    $cont .= '<tr '.$noborder.'>
                                        <td class="noborder-l">'.$sql->result['docdate'].'</td>
                                        <td>
                                            '.$sql->result['summ'].' руб.
                                        </td>
                                        <td>
                                            <span>'.$comments.'</span>
                                        </td>





                                    </tr>';

						}


      			$cont .= '</tbody></table>';


        //Сравнение
        $data1 = '';

		$sql->query("SELECT `itemid`,`pcs` FROM `#__#content` WHERE `docid`='".$sql->escape($_GET['id'])."' ORDER BY `itemid`");
		while ($sql->next_row()) {

        	$data1 .= $sql->result['itemid'].$sql->result['pcs'];

			}


		$data2 = '';
        $content_sravnenie = '';
        $sql->query("SELECT `itemid`,`pcs` FROM `#__#content_sravnenie` WHERE `docid`='".$sql->escape($_GET['id'])."' ORDER BY `itemid`");
		while ($sql->next_row()) {
            $content_sravnenie = 1;
			$data2 .= $sql->result['itemid'].$sql->result['pcs'];

			}


		if ($data1 != $data2 && $content_sravnenie == 1) {

            $cont .= $this->listContentIn('#__#content_sravnenie', '<div style="margin-top:-10px; padding-left:10px; font-weight:bold; font-size:14px;">Ваш заказ</div>');
            $titleOrder = '<div style="margin-top:-10px; padding-left:10px; font-weight:bold; font-size:14px;">В наличии</div>';

            $buttons = '<table>
                        	<tr>
                        	    <td width="100%">&nbsp;</td>

                        	    '.$pdf.'

                        		<td width="1">
                        		  <form name="a" action="/catalog/ordergo.php?id='.$_GET['id'].'" method="post">
                        			<div class="forma"><p class="inp" style="padding-right:5px;"><input type="submit" name="" value="   Подтвердить" /></p></div>
                        		  </form>
                        		</td>
                        		<td width="1">
                        		  <form name="a" action="/catalog/ordercancel.php?id='.$_GET['id'].'" method="post">
                        			<div class="forma"><p class="inp" style="padding-right:5px;"><input type="submit" name="" value="      Отменить" /></p></div>
                                  </form>
                        		</td>
                        	</tr>
            			</table>';

			} else {

            $buttons = '<div style="padding-right:20px;">
            			<table>
                        	<tr>
                        	    <td width="100%">&nbsp;</td>

                        	    '.$pdf.'
                                </tr>
            			</table>
            			</div>';



				$titleOrder = '';
				//$buttons = '';


				}


      	$cont .= $this->listContentIn('#__#content', $titleOrder);


        $cont .= '</div>'.$buttons;

		$this->data['pageTitle'] = "История заказов";
        $this->data['navigation'] = "&nbsp; &nbsp; <a href='/'>Главная</a> / <a href='/catalog/orderHistory.php'>История заказов</a> / Просмотр заказа";

		$this->data['content'] = $cont.$povtorzakaza;

	}


    //Повтор заказа
	function povtor() {
		global $sql;

        $subSql = clone $sql;

        //Поиск документа с текущем ИД и статусом Завершен
        $sql->query("SELECT `id` FROM `#__#documents` WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."' AND `id`='".$sql->escape($_GET['documents_id'])."'", true);  //AND `status`='Завершен'
        if ($sql->num_rows() > 0) {
        	//Если заказ существует

            //Подготовка корзины
            $sql->query("DELETE FROM `#__#basket` WHERE `ud_user`='".$sql->escape($_SESSION['ud_user'])."'");

            //ИД веб цены
            $prize_web = $this->priceUd(2);

			$subSql->query("SELECT `itemid`,`pcs` FROM `#__#content` WHERE `docid`='".$sql->escape($_GET['documents_id'])."'");
			while ($subSql->next_row()) {

            	//Цена товара за единицу
            	$price = $this->priceIn($sql->result['itemid'], $prize_web);

                //Итого
                $total_price = $price*$sql->result['pcs'];

                $sql->query("INSERT INTO `#__#basket`(`ud_goods`,`ud_user`,`count`,`price`,`total_price`) VALUES ('".$subSql->result['itemid']."','".$_SESSION['ud_user']."','".$subSql->result['pcs']."','$price','$total_price')");

				}

        	}

        go('/catalog/showBasket.php');

	}




	function ordergo() {
		global $sql;

        $sql->query("SELECT `id` FROM `#__#documents` WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."' AND `id`='".$sql->escape($_GET['id'])."'");
        if ($sql->num_rows() > 0) {

			$sql->query("UPDATE `#__#documents` SET `status`='Согласован' WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."' AND `id`='".$sql->escape($_GET['id'])."'");
        	$sql->query("DELETE FROM `#__#content_sravnenie` WHERE `docid`='".$sql->escape($_GET['id'])."'");

        	}

        $cont = '<div style="padding:15px; font-size:15px;">Заказ подтвержден<br /><br />
        В течении 15 минут Вам будет выставлен счет на оплату.
        </div>';

		$this->data['pageTitle'] = "История заказов";
        $this->data['navigation'] = "&nbsp; &nbsp; <a href='/'>Главная</a> / <a href='/catalog/orderHistory.php'>История заказов</a> / Просмотр заказа";

		$this->data['content'] = $cont;

    }







	function ordercancel() {
		global $sql;

        $sql->query("SELECT `id` FROM `#__#documents` WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."' AND `id`='".$sql->escape($_GET['id'])."'");
        if ($sql->num_rows() > 0) {

			$sql->query("UPDATE `#__#documents` SET `status`='НеСогласен' WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."' AND `id`='".$sql->escape($_GET['id'])."'");
        	//$sql->query("DELETE FROM `#__#content_sravnenie` WHERE `docid`='".$sql->escape($_GET['id'])."'");

        	}

        $cont = '<div style="padding:15px; font-size:15px;">Заказ отменен</div>';

		$this->data['pageTitle'] = "История заказов";
        $this->data['navigation'] = "&nbsp; &nbsp; <a href='/'>Главная</a> / <a href='/catalog/orderHistory.php'>История заказов</a> / Просмотр заказа";

		$this->data['content'] = $cont;

    }








	function listContentIn($table, $title) {
		global $sql;

  				   $cont = '<div class="tl"></div>
                            <div class="tr"></div>
                            <div class="bl"></div>
                            <div class="br"></div>
                            </div>
                            '.$title.'
                            <div class="article-wrap">
                            <table width=100%>
                                <thead>
                                    <tr>
                                        <th class="noborder-l">Код товара</th>
                                        <th>Изображение</th>
                                        <th>Название товара</th>
                                        <th class="pink">Цена</th>
                                        <th>Количество</th>
                                        <th class="noborder-r">Всего</th>
                                    </tr>
                                </thead>
                                <tbody>';


                    $i = '';

                    $BasketSql = clone $sql;

					$sql->query("SELECT * FROM `$table` WHERE `docid`='".$sql->escape($_GET['id'])."'");
					while ($sql->next_row()) {

                    $BasketSql->query("SELECT `photo` FROM `#__#catalog` WHERE `id`='".$sql->result['itemid']."'", true);
                    //Фото товара
                    if (strlen($BasketSql->result['photo']) > 0) {
                    	$photoItem = "<a id=\"example2\" href=\"/image.php?src=".$sql->result['itemid']."&amp;type=big&amp;.jpg\"><img border=\"0\" vspace=\"5\" hspace=\"5\" src=\"/image.php?src=".$sql->result['itemid']."\" style='border: 1px solid #CADCE6;'></a>";
                    	} else {
                    		$photoItem = '<img src="/i/no_photo.png" border="0" width="100">';
                    		}

					    $i++;

					    if ($i == $sql->num_rows()) $tr = 'id="noborder-b"'; else $tr = '';

					    $cont .= '<tr '.$tr.'>
                                        <td class="noborder-l">'.$this->codTovara($sql->result['articul']).'</td>
                                        <td>'.$photoItem.'</td>
                                        <td><a href="/catalog/'.$sql->result['itemid'].'/showInfo.php"><span>'.$sql->result['title'].'</span></a></td>
                                        <td class="red">'.$sql->result['price'].' руб.</td>
                                        <td>'.$sql->result['pcs'].'</td>
                                        <td>'.$sql->result['summ'].' руб.</td>
                                    </tr>';


						}


      			$cont .= '</tbody></table>
                            <div class="tl"></div>
                            <div class="tr"></div>
                            <div class="bl"></div>
                            <div class="br"></div>
                        ';


	           return $cont;

		}











	function agentsEditForm() {
		global $_SESSION, $_POST, $sql;
        $subSql = clone $sql;
        $cont = "<div class='agents_cat'><a href='/catalog/agents.php'>Список контрагентов</a> | <a href='/catalog/agentsAddForm.php'>Добавить контрагента</a></div>";

        if (isset($_POST['state'])) {

            $er = array();

            $sql->query("SELECT `id` FROM `#__#agents` WHERE `userid`='".$_SESSION['ud_user']."' AND `inn`='".$sql->escape($_POST['inn'])."' AND `id`!='".$sql->escape($_GET['id'])."'", true);
            if ($sql->num_rows() > 0) $er[] = 'Данный ИНН уже есть в базе!';
            if (strlen($_POST['orgname']) == 0) $er[] = 'Введите название организации!';



        //Каталог куда будет помещен файл с реквизитами
		$uploaddir="upload/userfiles/";
		//Дополнительные переменные
		$filename=$_FILES['userfile']['name'];
		$filesize=$_FILES['userfile']['size'];

        //Разрешенные форматы файлов
        $approvFile = "|rar|zip|jpg|jpeg|doc|pdf|gif|png|";

		//Тип файла
        $typeFile = end(explode(".", $filename));

        $uploadFile = "";

            if (strlen($filename) > 0) {


        		if (@substr_count($approvFile, $typeFile) == 1 || $typeFile == "") {

        		$sql->query("SELECT `file` FROM `#__#agents` WHERE `userid`='".$_SESSION['ud_user']."' AND `id`='".$sql->escape($_GET['id'])."'", true);

        		unlink('upload/userfiles/'.$sql->result['file']);

        		$uploadFile="yes";


        		} else { $er[] = "Формат файла не поддерживается!"; }

        		}





            //Вывод ошибок
			$cont .= "<div style='color:#EC0006; padding-left:150px;'>";
			foreach ($er as $word) $cont .= "$word <br />";
			$cont .= "</div>";

            if (count($er) == 0) {


        if ($uploadFile == "yes") {
        	$filedName = "".time().".$typeFile";
        	move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $filedName);
        	} else {
        		$filedName = "";
        		}


			$sql->query("UPDATE `#__#agents` SET `orgname` = '".$sql->escape($_POST['orgname'])."',
												 `fullorgname` = '".$sql->escape($_POST['fullorgname'])."',
												 `inn` = '".$sql->escape($_POST['inn'])."',
												 `kpp` = '".$sql->escape($_POST['kpp'])."',
												 `okpo` = '".$sql->escape($_POST['okpo'])."',
                                                 `idprice` = '".$sql->escape($_POST['sel_pr'])."',
												 `file` = '".$sql->escape($filedName)."'
												 WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."' AND `id`='".$sql->escape($_GET['id'])."'");



				message("Данные успешно сохранены!", "", "/catalog/agents.php");

            	}

        	}


        $sql->query("SELECT * FROM `#__#agents` WHERE `userid`='".$_SESSION['ud_user']."' AND `id`='".$sql->escape($_GET['id'])."'", true);

        $ifile = '';

        if (strlen($sql->result['file']) > 0) $ifile = '<div style="padding-bottom:7px;">Загруженный ранее файл &raquo; <a href="/upload/userfiles/'.$sql->result['file'].'">Скачать файл</a></div>';
         if ($sql->result['ch_pr_type']==1) {
                      $sel_new_pr .= "<tr>
                    	<td align=right style='padding:4px;'>Текущий тип цены:</td>
                    	<td style='padding:4px;'><select name='sel_pr'>";
                      $subSql->query("SELECT * FROM `prices`");
        					while ($subSql->next_row()) {

								if ($subSql->result['id'] == $sql->result['idprice']) $sel = 'selected'; else $sel = '';

        					    $sel_new_pr .= '<option value="'.$subSql->result['id'].'" '.$sel.'>'.$subSql->result['name_ru'].'</option>';

        						}

			        $sel_new_pr .= '</select>';
                    $sel_new_pr .= "</td></tr>";
                    }


        $cont .= "<br />
        			<form name='reg' action='?id=".$_GET['id']."' method='post' enctype='multipart/form-data' onSubmit='return ValidateForm(this)'>
        			<input name='state' type='hidden' value='1'>
        			<table style='width: 550px; float:left;'>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Название организации:</td>
                    	<td style='padding:4px;'><input name='orgname' type='text' value='".$sql->result['orgname']."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> Полное название организации:</td>
                    	<td style='padding:4px;'><input name='fullorgname' type='text' value='".$sql->result['fullorgname']."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'><font color='#FF2020'>*</font> ИНН:</td>
                    	<td style='padding:4px;'><input name='inn' type='text' value='".$sql->result['inn']."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'>КПП:</td>
                    	<td style='padding:4px;'><input name='kpp' type='text' value='".$sql->result['kpp']."' size='50' class='pl_Text'></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'>ОКПО:</td>
                    	<td style='padding:4px;'><input name='okpo' type='text' value='".$sql->result['okpo']."' size='50' class='pl_Text'></td>
       				</tr>

                    ".
                     $sel_new_pr
                    ."

        			<tr>
                    	<td align=right style='padding:4px;'>Файл с реквизитами:</td>
                    	<td style='padding:4px;'>$ifile<input type='file' name='userfile' /></td>
       				</tr>
        			<tr>
                    	<td align=right style='padding:4px;'>&nbsp;</td>
                    	<td style='padding:4px;'><input type='submit' value='Сохранить изменения' class='pl_Submit'></td>
       				</tr>
        		  </table>";

        $this->data['pageTitle'] = "Добавление контрагента";
        $this->data['navigation'] = "<a href='/'>Главная</a> / Добавление контрагента";
        $this->data['content'] = $cont;

    }



	function agentsDell() {
		global $_SESSION, $sql;

		$sql->query("DELETE FROM `#__#agents` WHERE `id`='".$sql->escape($_GET['id'])."' AND `userid`='".$sql->escape($_SESSION['ud_user'])."'");

		//Контрагент по умолчанию
		$sql->query("SELECT `id` FROM `#__#agents` WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."' AND `default`='1'", true);
		if($sql->num_rows() == 0) {

		    $sql->query("SELECT `id` FROM `#__#agents` WHERE `userid`='".$sql->escape($_SESSION['ud_user'])."' LIMIT 0,1");
		    while ($sql->next_row()) {
		    	$sql->query("UPDATE `#__#agents` SET `default` = '1' WHERE `id`='".$sql->result['id']."'");
		    	}
			}

		message("Контрагент успешно удален!", "", "/catalog/agents.php");

	}



	function SortFiles($string) {
                $docs = '';

                //Файлы
                $doc = explode("QWERTY", $string);

                $qwerty == '';

                foreach ($doc as $data) {

                  $i++;

                  if(strlen($data) > 0) {
                    $qwerty .= $data.':::';

                    if ($i == 2) {
                    	$i = '';
                    	$qwerty .= '|||';
                    	}
                  }
                }

                $doc2 = explode("|||", $qwerty);
                sort($doc2);

                foreach ($doc2 as $data2) {

                    $docstr = explode(":::", $data2);

                    if (strlen($data2) > 0) {

                    	$docs .= '<a class="pasport" href="/file.php?src='.str_replace("#", ":", $docstr[1]).'">'.$docstr[0].'</a>';

                        }

                	}

			return $docs;		}



	public function showItemInfo() {
		global $sql;

		$idToCheck = $this->uri[2];
/*		if (empty($idToCheck) || !preg_match("/^[0-9]+$/", $idToCheck, $match)) {
			page404();
		}*/

		//$id = $match[0];
		$id = $idToCheck;

        $subtSql = clone $sql;

		$sql->query("SELECT `ownerId`, `title`, `photo`, `redirect`, `fullText`, `techInformation`, `addedPhoto`, `assignParam1`, `assignParam2`, `assignParam3`, `assignParam4`, `price`, `techInformation`, `titleup`, `md`, `mk`, `hi`, `smallText`, `videolink` FROM `#__#catalog` WHERE `id` = '".$id."'", true);
		if ((int)$sql->num_rows() !== 1) page404();

		if (!empty($sql->result[3])) go($sql->result[3]);
		$ownerIdItem = $sql->result[0];

		$template = new template(api::setTemplate($this->tDir."index.show.info.html"));

		@$imageInfo   = getImageSize("upload/big/".basename($sql->result[2]));
		$template->assign("id", 				$id);
		$template->assign("ownerId", 			$sql->result[0]);
		$template->assign("title", 				!empty($sql->result[16]) ? $sql->result[16] : $sql->result[1]);

		if (trim($sql->result['videolink'])<>'')
			{
				$links_items = explode(' ',$sql->result['videolink']);
        		$vlinks = "<style>.vidos iframe {float:center; padding: 20px 20px 0 0 }</style> <div style=\"width: 500px; margin: 0 auto;\" class=\"vidos\">";
        		foreach($links_items as $key=>$value)
        			{
           				$vlinks .="<iframe width=\"426\" height=\"320\" src=\"".$value."\" frameborder=\"0\" allowfullscreen></iframe>";
            		}
        		$vlinks .= "</div>";
            }

		if (strlen($sql->result[2]) > 0) {
			$photIt = "<a href='/image.php?src=".$id."&type=big&.jpg' id='example2'><img src='/image.php?src=".$id."&in=info' style='border: 1px solid #CCC;'></a>";
			} else {
				$photIt = "<div align='center'><img src='/i/no_photo.png' border='0' width='100'></div>";
				}


        $sql2 = clone $sql;
        $sql3 = clone $sql;

        if (strlen($sql->result[7]) > 0) {

            $sql2->query("SELECT `id`,`title`,`view` FROM `#__#brands` WHERE `id`='".$sql->result[7]."'", true);

            if ($sql2->result['view'] == 'true') {            	$infoBrand = '<a href="/catalog/brand.php?id='.$sql2->result['id'].'&type=brand"><b>'.$sql2->result['title'].'</b></a>';            	} else {            		$infoBrand = '<b>'.$sql2->result['title'].'</b>';            		}



        	} else {
        		$infoBrand="<font color='#C10000'>Отсутсвует</font>";
        		}

        $exp_desc = explode("\n",$sql->result[4]);   //implode
        $iwh=0;
        while ($iwh < count($exp_desc))
        	{                $exp_desc[$iwh] = preg_replace("/^[\*]/","&nbsp;<img style='vertical-align:middle; height:5px; width:5px;' src='../../../images/dot.jpg'>&nbsp;",trim($exp_desc[$iwh]));
        		$iwh++;
        	}
        $imp_desc = implode("<br>",$exp_desc);





        $template->assign("photo", $photIt);
        ///$sql->result[4]=str_replace('<br>','',nl2br($sql->result[4]));
       // print_r($sql->result[4]);
		$template->assign("fullText", 			$imp_desc);
		$template->assign("addedPhoto", 		$this->genHtmlFromAddedPhoto($sql->result[6]));
		$template->assign("assignParam1",		$infoBrand);
		$template->assign("assignParam2",		$this->codTovara($sql->result[8]));
        $template->assign("videolink",	strip($vlinks));

/*                if (count($doc) == 0) $doc = '';
                if (strlen($doc[0]) > 0 && strlen($doc[1]) > 0) $docs = '<a class="pasport" href="/file.php?src='.str_replace("#", ":", $doc[1]).'">'.$doc[0].'</a>';

                if (strlen($doc[2]) > 0 && strlen($doc[3]) > 0) $docs .= '<a class="pasport" href="/file.php?src='.str_replace("#", ":", $doc[3]).'">'.$doc[2].'</a>';
                if (strlen($doc[4]) > 0 && strlen($doc[5]) > 0) $docs .= '<a class="pasport" href="/file.php?src='.str_replace("#", ":", $doc[5]).'">'.$doc[4].'</a>';
                if (strlen($doc[6]) > 0 && strlen($doc[7]) > 0) $docs .= '<a class="pasport" href="/file.php?src='.str_replace("#", ":", $doc[7]).'">'.$doc[6].'</a>';
*/

		$docs = $this->SortFiles($sql->result[9]);

		$template->assign("files", $docs);

		$template->assign("assignParam3",		$sql->result[9]);
		$template->assign("techInformation", 	$this->genHtmlFromTechInformation($sql->result['techInformation']));
		$template->assign("assignParam4",		$sql->result[10]);
        $sql3->query("SELECT `price` FROM `#__#price` WHERE `catalog_id`='$idToCheck' AND `price_id`='dab614b8-6f16-11dd-968a-00e018e21983'", true);

        $sql2->query("SELECT `price` FROM `#__#price` WHERE `catalog_id`='$idToCheck' AND `price_id`='".$this->priceUd(1)."'", true);
        if (!isset($_SESSION['ud_user'])) {        	$imprice = "<p><span class=\"cena\"><font color=\"#8e1000\">Цена при заказе с сайта:<br />".$sql2->result['price']." руб.</font></span></p>";        	if ($sql3->result['price'] > 0) {
				$template->assign("cost", "<p>Розничная цена:<br /><s><span>".$sql3->result['price']." руб.</s></span></p>".$imprice);  //$sql->result[11]
			}
        }  else { $imprice='';
        	if ($sql2->result['price'] > 0) {
				$template->assign("cost", "<p>Цена:<br /><span>".$sql2->result['price']." руб.</span></p>".$imprice);  //$sql->result[11]
        	}
        }

        //Цена WEB отображается если юзер авторизован


			$sql2->query("SELECT `price` FROM `#__#price` WHERE `catalog_id`='$idToCheck' AND `price_id`='".$this->priceUd(2)."'", true);

			if (isset($_SESSION['ud_user']) && $sql2->result['price'] > 0) {
				$template->assign("webCost", '<p class="retail">Ваша цена:<br /><span>'.$sql2->result['price'].' руб.</span></p>');
				}

		$template->assign("bigImage",			"/upload/big/".basename($sql->result[2]));
		@$template->assign("bigImageWidth",  	$imageInfo[0]);
		@$template->assign("bigImageHeight", 	$imageInfo[1]);



        $wherStatus = "";
        //Исправить..
		if (isset($_SESSION['ud_user'])) {
			$wherStatus = "`ud_user`='".$_SESSION['ud_user']."'";
			} else {
				$wherStatus = "`session`='".$this->sessionGuest()."'";
				}

			    $subtSql->query("SELECT `count` FROM `basket` WHERE $wherStatus AND `ud_goods`='".$id."' AND `status`='0'", true);
                if ($subtSql->num_rows() > 0) {
                    $inputClass = "pl_Korz_Button_sel";
                    $valueAdd = "<font color=#1B91B8 size=1><b>Добавлен</b></font>";
                	} else {
                        $inputClass = "pl_Korz_Button";
                        $valueAdd = "";
                		}

		@$template->assign("classButton",  	$inputClass);
		@$template->assign("valueAddtext", 	$valueAdd);



		$subtSql->query("SELECT `smallText`,`title` FROM `#__#catalog` WHERE `id` = '".$id."'", true);

        $template->assign("smallText", 	nl2br($subtSql->result['smallText']));

		$this->data['pageTitle']	= $subtSql->result['title'];

		unset($subtSql);

		$this->data['assignParam1']	= $sql->result[7];
		$this->data['assignParam2']	= $sql->result[8];
		$md = $sql->result[14];
		$mk = $sql->result[15];

		$returnNavigation = $this->getNavigationAndOtherInfo($ownerIdItem); //array($navigation->get(), $template, $pageTitle, $md, $mk, $first);

		$this->data['template']		= $returnNavigation[1];
		$this->data['title']		= $returnNavigation[2];

		$this->data['md']			= !empty($md) ? $md : $returnNavigation[3];
		$this->data['mk']			= !empty($mk) ? $mk : $returnNavigation[4];
		$this->data['navigation']	= $returnNavigation[0];
		$this->data['content'] 		= $template->get();


	}





















	public function showItemInfoPrint() {
		global $sql;

		$idToCheck = $this->uri[2];

		//$id = $match[0];
		$id = $idToCheck;

        $subtSql = clone $sql;

		$sql->query("SELECT `ownerId`, `title`, `photo`, `redirect`, `fullText`, `techInformation`, `addedPhoto`, `assignParam1`, `assignParam2`, `assignParam3`, `assignParam4`, `price`, `techInformation`, `titleup`, `md`, `mk`, `hi`, `smallText` FROM `#__#catalog` WHERE `id` = '".$id."'", true);
		if ((int)$sql->num_rows() !== 1) page404();

		if (!empty($sql->result[3])) go($sql->result[3]);
		$ownerIdItem = $sql->result[0];

		$template = new template(api::setTemplate($this->tDir."index.show.info.print.html"));

		@$imageInfo   = getImageSize("upload/big/".basename($sql->result[2]));
		$template->assign("id", 				$id);
		$template->assign("ownerId", 			$sql->result[0]);
		$template->assign("title", 				!empty($sql->result[16]) ? $sql->result[16] : $sql->result[1]);

		if (strlen($sql->result[2]) > 0) {
			$photIt = "<a href='/image.php?src=".$id."&type=big&.jpg' id='example2'><img src='/image.php?src=".$id."&in=info' style='border: 1px solid #CCC;'></a>";
			} else {
				$photIt = "<div align='center'><img src='/i/no_photo.png' border='0' width='100'></div>";
				}


        $sql2 = clone $sql;
       // $sql3 = clone $sql;

        if (strlen($sql->result[7]) > 0) {

            $sql2->query("SELECT `id`,`title`,`view` FROM `#__#brands` WHERE `id`='".$sql->result[7]."'", true);

            if ($sql2->result['view'] == 'true') {
            	$infoBrand = '<a href="/catalog/brand.php?id='.$sql2->result['id'].'"><b>'.$sql2->result['title'].'</b></a>';
            	} else {
            		$infoBrand = '<b>'.$sql2->result['title'].'</b>';
            		}



        	} else {
        		$infoBrand="<font color='#C10000'>Отсутсвует</font>";
        		}


        $template->assign("photo", $photIt);

		$template->assign("fullText", 			nl2br($sql->result[4]));
		$template->assign("addedPhoto", 		$this->genHtmlFromAddedPhoto($sql->result[6]));
		$template->assign("assignParam1",		$infoBrand);
		$template->assign("assignParam2",		$this->codTovara($sql->result[8]));

		$docs = $this->SortFiles($sql->result[9]);

		$template->assign("files", $docs);

		$template->assign("assignParam3",		$sql->result[9]);
		$template->assign("techInformation", 	$this->genHtmlFromTechInformation($sql->result['techInformation']));
		$template->assign("assignParam4",		$sql->result[10]);


        $sql2->query("SELECT `price` FROM `#__#price` WHERE `catalog_id`='$idToCheck' AND `price_id`='".$this->priceUd(1)."'", true);

        if ($sql2->result['price'] > 0) {
			$template->assign("cost", "Цена:<br /><span>".$sql2->result['price']." руб.</span>");  //$sql->result[11]
			}

        //Цена WEB отображается если юзер авторизован


			$sql2->query("SELECT `price` FROM `#__#price` WHERE `catalog_id`='$idToCheck' AND `price_id`='".$this->priceUd(2)."'", true);

			if (isset($_SESSION['ud_user']) && $sql2->result['price'] > 0) {
				$template->assign("webCost", 'Ваша цена:<br /><span>'.$sql2->result['price'].' руб.</span>');
				}

		$template->assign("bigImage",			"/upload/big/".basename($sql->result[2]));
		@$template->assign("bigImageWidth",  	$imageInfo[0]);
		@$template->assign("bigImageHeight", 	$imageInfo[1]);



        $wherStatus = "";
        //Исправить..
		if (isset($_SESSION['ud_user'])) {
			$wherStatus = "`ud_user`='".$_SESSION['ud_user']."'";
			} else {
				$wherStatus = "`session`='".$this->sessionGuest()."'";
				}

			    $subtSql->query("SELECT `count` FROM `basket` WHERE $wherStatus AND `ud_goods`='".$id."' AND `status`='0'", true);
                if ($subtSql->num_rows() > 0) {
                    $inputClass = "pl_Korz_Button_sel";
                    $valueAdd = "<font color=#1B91B8 size=1><b>Добавлен</b></font>";
                	} else {
                        $inputClass = "pl_Korz_Button";
                        $valueAdd = "";
                		}

		@$template->assign("classButton",  	$inputClass);
		@$template->assign("valueAddtext", 	$valueAdd);



		$subtSql->query("SELECT `smallText`,`title` FROM `#__#catalog` WHERE `id` = '".$id."'", true);

        $template->assign("smallText", 	nl2br($subtSql->result['smallText']));

		$this->data['pageTitle']	= $subtSql->result['title'];

		unset($subtSql);

		$this->data['assignParam1']	= $sql->result[7];
		$this->data['assignParam2']	= $sql->result[8];
		$md = $sql->result[14];
		$mk = $sql->result[15];

		$returnNavigation = $this->getNavigationAndOtherInfo($ownerIdItem); //array($navigation->get(), $template, $pageTitle, $md, $mk, $first);

		$this->data['template']		= $returnNavigation[1];
		$this->data['title']		= $returnNavigation[2];

		$this->data['md']			= !empty($md) ? $md : $returnNavigation[3];
		$this->data['mk']			= !empty($mk) ? $mk : $returnNavigation[4];
		$this->data['navigation']	= $returnNavigation[0];
		$this->data['content'] 		= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.$template->get();


	}































	private function genHtmlFromTechInformation($string) {
		if (empty($string)) return "";


		$dataToParce = explode("\n", $string);

		$body = "<table cellspacing=0 cellpadding=2 class=\"techInformation\">
		<tr><th colspan=8><b><center>Дополнительные характеристики:</center></b></th></tr>
		";

		foreach ($dataToParce as $key=>$value) {
			$body .= "<tr>";

			$array = explode(";", $value);
			foreach ($array as $key=>$item) {
				if ($key == 0) $body .= "<td width=\"40%\">".$item."</td>"; else $body .= "<td>".$item."</td>";
			}

			$body .= "</tr>";
		}

		$body .= "</table>";

		return $body;
	}

	private function genHtmlFromAddedPhoto($array) {
		if (empty($array)) {
			return "";
		}

		$photos = explode(":::", $array);

		foreach ($photos as $key=>$value) {
			if (empty($value)) {
				continue;
			}
			@$imageInfo  = getimagesize("upload/big/".basename($value));
			@$imageWidth  = $imageInfo[0];
			@$imageHeight = $imageInfo[1];
			@$return .= "<a target=\"_blank\" href=\"/upload/big/".basename($value)."\" onclick=\"wopen('/upload/big/".basename($value)."', '".$imageWidth."', '".$imageHeight."'); return false;\" title=\"View image\"><img border=\"0\" hspace=\"10\" src=\"/".$value."\" style=\"padding-bottom:15px;\"></a>";
		}

		return $return;
	}

	private function getNavigationAndOtherInfo($ownerId) {
		global $sql;
        //WHERE `lang` = '".$this->curLang."'
		$sql->query("SELECT `id`, `ownerId`, `title`, `pageTitle`, `template`, `navigationShow`, `navigationMainTitle`, `md`, `mk`, `title_nav` FROM `#__#catalogGroups` ");

		$result 	= array();
		$treeResult = array();

		while ($sql->next_row()) $result[$curId = $sql->result[0]] = $sql->result;

		if (!isset($ownerId)) {
			page500();
		}

		$forever = false;

		while ($ownerId != '' && !$forever) {
			array_unshift($treeResult, @$result[$ownerId]);
			$ownerId = @$result[$ownerId]['ownerId'];

			@$incr++;
			if ($incr > 10000) $forever = true;
		}

		$pageTitle  = '';
		$template	= '';
		$md       	= '';
		$mk			= '';

		$navigation = new navigation();
		$navigation->setMainPage(empty($this->lang['navigationMainTitle']) ? api::getConfig("main", "api", "mainPageInNavigation") : $this->lang['navigationMainTitle']);

		if (!empty($this->lang['navigationTitle']))	$navigation->add($this->lang['navigationTitle'], "/".$this->mDir."/index.php");
		$first = false;

		$k = "";

		foreach ($treeResult as $key=>$value) {

			if (!empty($treeResult[$key]['template']))	$template=$treeResult[$key]['template'];
			if (!empty($treeResult[$key]['pageTitle'])) $pageTitle=$treeResult[$key]['pageTitle'];
			if (!empty($treeResult[$key]['md'])) 		$md=$treeResult[$key]['md'];
			if (!empty($treeResult[$key]['mk'])) 		$mk=$treeResult[$key]['mk'];

			$k++;

			//Bag import 1c Хлебные крошки
			if ($k != 2 && $k != 1) {
			//if ($treeResult[$key]['navigationShow'] == 'y') {
				if($treeResult[$key]['title_nav'] != true) $treeResult[$key]['title_nav'] = $treeResult[$key]['title'];
					$navigation->add($treeResult[$key]['title_nav'], "/".$this->mDir."/".$treeResult[$key][0]."/showGroup.php");
					if (!$first) $first = $treeResult[$key]['title_nav'];
			}

			if (!empty($treeResult[$key]['navigationMainTitle'])) $navigationMainTitle=$treeResult[$key]['navigationMainTitle'];
		}


		return array($navigation->get(), $template, $pageTitle, $md, $mk, $first);
	}


	private function getTreeGroups($id) {
		global $sql, $result;
		$sql->query("SELECT `id`, `photo`, `title` FROM `#__#catalogGroups` WHERE `id` = '".$id."'", true);
		if ($sql->num_rows() < 1) page500();
		$result[] = array($sql->result[0], $sql->result[1], $sql->result[2]);
		$this->getAllGroupTreeIds_Call($id);
		return $result;
	}

	private function getAllGroupTreeIds_Call($id) {
		global $sql, $result, $API;

		$sqlId = mysql_query("SELECT `id`, `photo`, `title` FROM `".$API['config']['mysql']['prefix']."catalogGroups` WHERE `ownerId` = '".$id."'") or die(mysql_error()) ;
		if (mysql_num_rows($sqlId) !== 0) {
			while ($sqlResult = mysql_fetch_array($sqlId)) {
				$result[] = array($sqlResult[0], $sqlResult[1], $sqlResult[2]);
				$id = $sqlResult[0];
				$this->getAllGroupTreeIds_Call($id);
			}
		}
		return true;
	}


	public function deleteGroup() {
		global $sql, $result;
		$id = $this->getArray['id'];

		if (empty($id)) {
			page500();
		}


		$halt = false;
		$delArray = $this->getTreeGroups($id);

		// delete all data;
		foreach ($delArray as $key=>$empty) {
			$sql->query("SELECT `photo`, `addedPhoto` FROM `catalog` WHERE `ownerID` = '".$delArray[$key][0]."'");
			while ($sql->next_row()) {
				if (!empty($sql->result[0])) {
					@unlink($sql->result[0]);
					@unlink("upload/notSoBig/".basename($sql->result[0]));
					@unlink("upload/big/".basename($sql->result[0]));

					}
				if (!empty($sql->result[1])) {
					$delFile = explode(":::", $sql->result[1]);
					foreach ($delFile as $empty=>$fName) if (!empty($fName)) {
						@unlink($fName);
						@unlink("upload/notSoBig/".basename($fName));
						@unlink("upload/big/".basename($fName));
						} 				}
			} 			$sql->query("DELETE FROM `#__#catalogGroups` WHERE `id` = '".$delArray[$key][0]."'");
			$sql->query("DELETE FROM `#__#catalog` WHERE `ownerId` = '".$delArray[$key][0]."'");
			if (!empty($delArray[$key][1])) {
				unlink($delArray[$key][1]);
			};

		message($this->lang['deleteOk']);
		}
	}

	function getTreeOnwerTreeArray() {
		global $sql;

		$sql->query("select `id`, `ownerId`, `title` FROM `#__#catalogGroups`");
		while ($sql->next_row()) {
			$id = $sql->result[0];
			$this->groups[$id] = array("ownerId" => $sql->result[1], "title" => $sql->result[2]);
		}
		return true;

	}

	private function getTreeFromItem($id) {
		$halt = false;

		$returnArray = array();

		while (!$halt) {
			@$forever++; if ($forever > 10000) $halt = true;
			if (!isset($this->groups[$id])) {
				break;
			}
			array_unshift($returnArray, array("id" => $id, "title" => $this->groups[$id]['title']));
			$id = $this->groups[$id]['ownerId'];
		}

		return $returnArray;
	}

	public function printShow() {
		global $sql;
		global $API;
		$API['template']="ru/printVersion.html";

		$idToCheck = $this->uri[2];
		if (empty($idToCheck) || !preg_match("/^[0-9]+$/", $idToCheck, $match)) {
			page404();
		}

		$id = $match[0];

		$sql->query("SELECT `ownerId`, `title`, `photo`, `redirect`, `fullText`, `techInformation`, `addedPhoto`, `assignParam1`, `assignParam2`, `assignParam3`, `assignParam4`, `price` FROM `#__#catalog` WHERE `id` = '".$id."'", true);
		if ((int)$sql->num_rows() !== 1) page404();

		if (!empty($sql->result[3])) go($sql->result[3]);
		$ownerIdItem = $sql->result[0];

		$template = new template(api::setTemplate($this->tDir."index.show.info.print.html"));

		@$imageInfo   = getImageSize("upload/big/".basename($sql->result[2]));
		$template->assign("id", 				$id);
		$template->assign("title", 				$sql->result[1]);
		$template->assign("photo", 				(!empty($sql->result[2]) ? "<img border=\"0\" src=\"/upload/notSoBig/".basename($sql->result[2])."\">" : ""));
		$template->assign("fullText", 			$sql->result[4]);
		$template->assign("addedPhoto", 		$this->genHtmlFromAddedPhoto($sql->result[6]));
		$template->assign("assignParam1",		$sql->result[7]);
		$template->assign("assignParam2",		$sql->result[8]);
		$template->assign("assignParam3",		$sql->result[9]);
		$template->assign("assignParam4",		$sql->result[10]);
		$template->assign("cost",				$sql->result[11]);
		$template->assign("bigImage",			"/upload/big/".basename($sql->result[2]));
		@$template->assign("bigImageWidth",  	$imageInfo[0]);
		@$template->assign("bigImageHeight", 	$imageInfo[1]);




		$this->data['pageTitle']		= $sql->result[1];

		$returnNavigation = $this->getNavigationAndOtherInfo($ownerIdItem); //array($navigation->get(), $template, $pageTitle, $md, $mk);

		$this->data['template']		= $returnNavigation[1];
		$this->data['title']		= $returnNavigation[2];
		$this->data['md']			= $returnNavigation[3];
		$this->data['mk']			= $returnNavigation[4];
		$this->data['navigation']	= $returnNavigation[0];
		$this->data['content'] 		= $template->get();


	}

	/**
	 * Установка параметра ссылки для возврата
	 *
	 * @return void
	 */
	function setReturnPath() {
		global $_SERVER;
		$this->returnPath = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $this->returnPath;
	}


	function __construct() {
		global $_GET, $_POST, $_FILES, $sql, $_SESSION;

        if (isset($_SESSION[(string)($this->mDir)."_adm"]['returnPath'])) {
        	$this->returnPath = &$_SESSION[(string)($this->mDir)."_adm"]['returnPath'];
		} else {
			$_SESSION[(string)($this->mDir)."_adm"]['returnPath'] = &$this->returnPath;
		}



		$this->getArray		= api::slashData($_GET);
		$this->postArray 	= api::slashData($_POST);
		$this->filesArray	= api::slashData($_FILES);

		$cfgValue = api::getConfig("modules", $this->mDir, "waterMark");
		if ($cfgValue!=="") {
			$this->waterMark = $cfgValue;
		};

		$cfgValue = api::getConfig("modules", $this->mDir, "notSoBigMaxWidth");
		if (!empty($cfgValue)) {
			$this->notSoBigMaxWidth = $cfgValue;
		};

		$cfgValue = api::getConfig("modules", $this->mDir, "notSoBigMaxHegiht");
		if (!empty($cfgValue)) {
			$this->notSoBigMaxHegiht = $cfgValue;
		};


		$cfgValue = api::getConfig("modules", $this->mDir, "bigMaxWidth");
		if (!empty($cfgValue)) {
			$this->bigMaxWidth = $cfgValue;
		};

		$cfgValue = api::getConfig("modules", $this->mDir, "bigMaxHegiht");
		if (!empty($cfgValue)) {
			$this->bigMaxHegiht = $cfgValue;
		};


		$cfgValue = api::getConfig("modules", $this->mDir, "groupImageMaxWidth");
		if (!empty($cfgValue)) {
			$this->gMaxW = $cfgValue;
		};

		$cfgValue = api::getConfig("modules", $this->mDir, "groupImageMaxHeight");
		if (!empty($cfgValue)) {
			$this->gMaxH = $cfgValue;
		};

		$cfgValue = api::getConfig("modules", $this->mDir, "addPhotoSmallWidth");
		if (!empty($cfgValue)) {
			$this->addPhotoSmallWidth = $cfgValue;
		};

		$cfgValue = api::getConfig("modules", $this->mDir, "addPhotoSmallHeight");
		if (!empty($cfgValue)) {
			$this->addPhotoSmallHeight = $cfgValue;
		};

		$cfgValue = api::getConfig("modules", $this->mDir, "addPhotoBigWidth");
		if (!empty($cfgValue)) {
			$this->addPhotoBigWidth = $cfgValue;
		};

		$cfgValue = api::getConfig("modules", $this->mDir, "addPhotoBigHeight");
		if (!empty($cfgValue)) {
			$this->addPhotoBigHeight = $cfgValue;
		};

		$this->getTreeOnwerTreeArray();
		$this->sql = &$sql;

		return true;
	}



}



?>
