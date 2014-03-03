<?php

if (!defined("API")) {
    exit("Main include fail");
}

include_once("include/classes/class.tree.php");
include_once("modules/page/__classes.php");

class menu extends MySQL
{
    public $lang = array();
    public $curLang = "ru";
    public $data = array();

    public $dbname = '123';
    private $getArray = array();
    private $postArray = array();
    private $tDir = "modules/menu/";


    public function menuList()
    {
        global $smarty, $sql;

        $sql->query("SELECT * FROM `#__#menu` ORDER BY `id` ASC");

        if ($sql->num_rows() > 0) {
            $array = array();
            while ($row = $sql->next_row()) {
                $array[] = $row;
            }
            $smarty->assign('array', $array);
            $template = $smarty->fetch(api::setTemplate($this->tDir . "admin/menu.list.html"));
        } else {
            $template = $smarty->fetch(api::setTemplate($this->tDir . "admin/menu.list.empty.html"));
        }
        return $template;
    }


    public function addMenu($error='', $treeItem='')
    {
        global $smarty, $sql, $rFile;
        
		if($rFile == 'editMenu.php'){
			$sql->query("SELECT * FROM `#__#menu` WHERE `id` = '" . intval($_GET['menuid']) . "'", true);
			if($sql->num_rows() !== 1){page500();}
		}
		
		$sqlMenuItems = clone $sql;
        $sqlCatalogGroups = clone $sql; //для выборки групп каталога

        $errorTemplate = '';
        if (!empty($error)) {
            $smarty->assign('errorText', $error);
            $errorTemplate = $smarty->fetch(api::setTemplate($this->tDir . "admin/error.html"));
        }

        $tablename = array('pages', 'shop_groups', 'shop_items', 'newsgroups', 'news', 'gallery_groups');
        $count = count($tablename);

        for ($i = 0; $i < $count; $i++) {

            switch ($tablename[$i]) {

                case "pages":
                    if ($this->table_check($tablename[$i], $this->dbname)) {
                        $pagesArray = array();
                        $page = new page();
                        $sql->query("SELECT `id` as 'id', `ownerId` as 'parent', `title` as 'title', `position` as 'order', `uri` as 'uri' FROM `pages` ORDER BY `id` asc");
                        while ($row = $sql->next_row_assoc()) {
                            $pagesArray[$row['id']] = $row;
                            $pagesArray[$row['id']]['url'] = '/'.$row['uri'].'/';
                        }
                    }
                    break;
                case 'shop_groups':
                    if ($this->table_check($tablename[$i], $this->dbname)) {
                        $catalogGroupsArray = array();
                        $sql->query("SELECT `group_id` as 'id', `uri` as 'code', `parent_group_id` as 'parent', `position` as 'order', `name` as 'title'  FROM `#__#shop_groups` order by `position` asc");
                        while ($row = $sql->next_row_assoc()) {
                            $catalogGroupsArray[$row['id']] = $row;
                            $catalogGroupsArray[$row['id']]['url'] = '/' . $row['code'];
                        }
                    }
                    break;
                case 'shop_items':
                    if ($this->table_check($tablename[$i], $this->dbname)) {
                        $catalogItemsArray = array();
                        $sql->query("SELECT `item_id` as 'id', `name` as 'title', `id` as 'order', `parent_group_id`, `uri` FROM `#__#shop_items` order by `id` asc");

                        while ($row = $sql->next_row_assoc()) {
                            $sqlCatalogGroups->query("SELECT `uri` as 'uri' FROM `#__#shop_groups` WHERE `group_id`='" . $sql->result['parent_group_id'] . "'");
                            $catalogItemsArray[$row['id']] = $row;
                            while ($row1 = $sqlCatalogGroups->next_row_assoc()) {
                                $catalogItemsArray[$row['id']]['url'] = '/catalog/' . $row1['uri'] . '/' . $row['uri'] . '/';
                            }
                            $catalogItemsArray[$row['id']]['parent'] = 0;
                        }
                    }
                    break;
                case 'newsgroups':
                    if ($this->table_check($tablename[$i], $this->dbname)) {
                        $newsGroupsArray = array();
                        $sql->query("SELECT `id` as 'id', `title` as 'title', `id` as 'order', `ownerId` as 'parent' FROM `#__#newsgroups` order by `id` asc");
                        while ($row = $sql->next_row_assoc()) {
                            $newsGroupsArray[$row['id']] = $row;
                            $newsGroupsArray[$row['id']]['url'] = '/news/showGroup/' . $row['id'] . '.html';
                        }
                    }

                    break;

                case 'news':
                    if ($this->table_check($tablename[$i], $this->dbname)) {
                        $newsArray = array();
                        $sql->query("SELECT `id` as 'id', `title` as 'title', `id` as 'order' FROM `#__#news` order by `id` asc");
                        while ($row = $sql->next_row_assoc()) {
                            $newsArray[$row['id']] = $row;
                            $newsArray[$row['id']]['parent'] = 0;
                            $newsArray[$row['id']]['url'] = '/news/show/' . $row['id'] . '.html';
                        }
                    }
                    break;

                case 'gallery_groups':
                    if ($this->table_check($tablename[$i], $this->dbname)) {
                        $galleryGroupsArray = array();
                        $sql->query("SELECT `id` as 'id', `title` as 'title', `position` as 'order', `owner` as 'parent' FROM `#__#gallery_groups` order by `position` asc");
                        while ($row = $sql->next_row_assoc()) {
                            $galleryGroupsArray[$row['id']] = $row;
                            $galleryGroupsArray[$row['id']]['url'] = '/gallery/' . $row['id'] . '/album.html';
                        }
                    }
                    break;
            }
        }

        if (!empty($pagesArray)) {
            $treePages = new Tree();
            foreach ($pagesArray as $item) {
                $treePages->addItem(
                    $item['id'],
                    $item['parent'],
                    array(
                        'title' => $item['title'],
                        'url' => $item['url']
                    ),
                    $item['order']
                );
            }
            $smarty->assign('pagesTree', $this->createNode($treePages, 0));
        }

        if (!empty($catalogGroupsArray)) {
            $treeCatalogGroups = new Tree();
            foreach ($catalogGroupsArray as $item) {
                $treeCatalogGroups->addItem(
                    $item['id'],
                    $item['parent'],
                    array(
                        'title' => $item['title'],
                        'url' => $item['url']
                    ),
                    $item['order']
                );

            }
            $smarty->assign('catalogGroupsTree', $this->createNode($treeCatalogGroups, 0));
        }

        if (!empty($catalogItemsArray)) {
            $treeCatalogItems = new Tree();
            foreach ($catalogItemsArray as $item) {
                $treeCatalogItems->addItem(
                    $item['id'],
                    $item['parent'],
                    array(
                        'title' => $item['title'],
                        'url' => isset ($item['url']) ? $item['url'] : ''
                    ),
                    $item['order']
                );
            }
            $smarty->assign('catalogItemsTree', $this->createNode($treeCatalogItems, 0));
        }

        if (!empty($newsGroupsArray)) {
            $treeNewsGroups = new Tree();
            foreach ($newsGroupsArray as $item) {
                $treeNewsGroups->addItem(
                    $item['id'],
                    $item['parent'],
                    array(
                        'title' => $item['title'],
                        'url' => $item['url']
                    ),
                    $item['order']
                );
            }
            $smarty->assign('newsGroupsTree', $this->createNode($treeNewsGroups, 0));
        }

        if (!empty($newsArray)) {
            $treeNews = new Tree();
            foreach ($newsArray as $item) {
                $treeNews->addItem(
                    $item['id'],
                    $item['parent'],
                    array(
                        'title' => $item['title'],
                        'url' => $item['url']
                    ),
                    $item['order']
                );
            }
            $smarty->assign('newsTree', $this->createNode($treeNews, 0));
        }

        if (!empty($galleryGroupsArray)) {
            $treeGalleryGroups = new Tree();
            foreach ($galleryGroupsArray as $item) {
                $treeGalleryGroups->addItem(
                    $item['id'],
                    $item['parent'],
                    array(
                        'title' => $item['title'],
                        'url' => $item['url']
                    ),
                    $item['order']
                );
            }
            $smarty->assign('galleryGroupsTree', $this->createNode($treeGalleryGroups, 0));
        }

        if (isset($this->getArray['menuid']) && !empty($this->getArray['menuid'])) {
            $sql->query("SELECT * FROM `#__#menu` WHERE `id` = '" . (int)$this->getArray['menuid'] . "'", true);
            if ($sql->num_rows() > 0) {
                $sqlMenuItems->query("SELECT `item_id` as 'id', `title` as 'title', `parent_id` as 'parent', `uri` as 'url', `order` as 'order' FROM `#__#menu_items` WHERE `menu_id` = '" . (int)$this->getArray['menuid'] . "' && `item_id` > '0' ORDER by `order` asc");
                $itemArray = array();
                while ($row = $sqlMenuItems->next_row()) {
                    $itemArray[$row['id']] = $row;
                }
                $treeItem = new Tree();
                foreach ($itemArray as $item) {
                    $treeItem->addItem(
                        $item['id'],
                        $item['parent'],
                        array(
                            'title' => $item['title'],
                            'url' => $item['url'],
                            'order' => $item['order']
                        ),
                        $item['order']
                    );
                }


                $smarty->assign('menuid', $this->getArray['menuid']);
                $smarty->assign('menuTitle', $sql->result['title']);
            }
        }

        if (!empty($treeItem)) {
            $smarty->assign('itemsTree', $this->createTree($treeItem, 0));
        }
        $smarty->assign('error', $errorTemplate);
        $template = $smarty->fetch(api::setTemplate($this->tDir . "admin/menu.add.form.html"));
        return $template;
    }

    public function addMenuGo()
    {
        global $_POST, $sql;

        $sqlMenuId = clone $sql;
        $sqlMenuItems = clone $sql;
        $sqlMenuTitle = clone $sql;
        if (!isset($_POST['menuid']) || empty($_POST['menuid'])) {
            $sqlMenuTitle->query("SELECT * FROM `#__#menu` WHERE `title` = '" . $_POST['menuTitle'] . "'", true);
            if ($sqlMenuTitle->num_rows() > 0) {
                $error = 'Меню с заданным название уже существует';
                $treeItem = new Tree();
                foreach ($_POST['itemsArr'] as $item) {
                    $treeItem->addItem($item['item_id'], $item['parent_id'], array('title' => $item['title'], 'url' => $item['uri']), $item['order']);
                }
                return $this->addMenu($error, $treeItem);
            } else {                
                $sql->query("INSERT INTO `#__#menu` (`title`) VALUES ('" . $_POST['menuTitle'] . "')");
                $sqlMenuId->query("SELECT `id` FROM `#__#menu` WHERE `title` ='" . $_POST['menuTitle'] . "'", true);                
				foreach($_POST['itemsArr'] as $key=>$value){
					$sqlMenuItems->query("INSERT INTO `#__#menu_items`
														(
															`menu_id`, 
															`item_id`, 
															`parent_id`, 															
															`title`, 
															`uri`,
															`order`
														)
											VALUES (
															'" . $sqlMenuId->result['id'] . "',
															'" . $value['item_id'] . "',
															'" . $value['parent_id'] . "',
															'" . $value['title'] . "',
															'" . $value['uri'] . "',
															'" . $value['order'] . "'
													)");
				
				}
                message('Меню "' . $_POST['menuTitle'] . '" создано', '', '/admin/menu/index.php');
            }
        } else {			
			$sql->query("UPDATE `#__#menu` SET `title` = '" . $_POST['menuTitle'] . "' WHERE `id` ='" . (int)$_POST['menuid'] . "'");
            $sql->query("DELETE FROM `#__#menu_items` WHERE menu_id='" . (int)$_POST['menuid'] . "'");                        			
			foreach($_POST['itemsArr'] as $key=>$value){
				$sqlMenuItems->query("INSERT INTO `#__#menu_items`
														(
															`menu_id`, 
															`item_id`, 
															`parent_id`,															
															`title`, 
															`uri`,
															`order`
														)
											VALUES (
															'" . (int)$_POST['menuid'] . "',
															'" . $value['item_id'] . "',
															'" . $value['parent_id'] . "',
															'" . $value['title'] . "',
															'" . $value['uri'] . "',
															'" . $value['order'] . "'
													)");
			
			}
            $_SESSION['info'] = array("area" => 'admin', "title" => 'Меню "' . $_POST['menuTitle'] . '" отредактировано ', "desc" => '', "uri" => '');
        }
        message('Меню "' . $_POST['menuTitle'] . '" отредактировано', '', '/admin/menu/index.php');
    }

    public function deleteMenu()
    {

        global $sql;
        $sql->query("SELECT * FROM `#__#menu` WHERE id='" . (int)$this->getArray['menuid'] . "'", true);
        $menuTitle = $sql->result['title'];

        if ($sql->num_rows() > 0) {
            $sql->query("DELETE FROM `#__#menu` WHERE id='" . (int)$this->getArray['menuid'] . "'");
            $sql->query("DELETE FROM `#__#menu_items` WHERE menu_id='" . (int)$this->getArray['menuid'] . "'");
            message("Меню \"$menuTitle\" удалено ", "", '/admin/menu/index.php');
        }

    }

    private function createTree($tree, $parent)
    {
        $s = '';
        if (!$tree->hasChilds($parent)) return '';
        $childs = $tree->getChilds($parent);


        foreach ($childs as $k => $v) {
            $s .= '<li id="list_' . $v['id'] . '">
			<div>
				<span class="blockTitle">' . $v['data']['title'] . '</span>
				<span style="float:right" onclick="return ShowOrHide(' . $v['id'] . ')"><i title="Подробнее" class="icon-chevron-down"></i></span>
			</div>
			<div id="info_' . $v['id'] . '" class="info">
				
					<div class="control-group">
						<label class="control-label" for="title">Заголовок ссылки:</label>
						<div class="controls">
							<input style="width:98%" onblur="return checkTitle(\'' . $v['id'] . '\',\'' . htmlspecialchars($v['data']['title']) . '\',\'' . htmlspecialchars($v['data']['url']) . '\');" type="text" name="title" value=\'' . $v['data']['title'] . '\'>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="url">URL:</label>
						<div class="controls">
							<input style="width:98%" onblur="return checkUrl(\'' . $v['id'] . '\',\'' . htmlspecialchars($v['data']['title']) . '\',\'' . $v['data']['url'] . '\');" type="text" name="url" value=\'' . $v['data']['url'] . '\'>
						</div>
					</div>
				
				<div class="btn-group" style="margin: 5px 0px 5px 0px;">
					<button title="Отменить изменения" data-placement="bottom" class="btn btn-info" onclick="return cancelChange(\'' . $v['id'] . '\', \'' . htmlspecialchars($v['data']['title']) . '\', \'' . htmlspecialchars($v['data']['url']) . '\');"> <i class="icon-refresh"></i></button>
					<button title="Удалить пункт меню" data-placement="bottom" class="btn btn-danger" onclick="if(confirm(\'Удалить пункт меню?\')){return deleteNode(\'' . $v['id'] . '\')}"> <i class="icon-trash"></i></button>
				</div>
			</div>
			<input type="hidden" class="title" name="itemsArr[' . $v['id'] . '][title]" value="' . htmlspecialchars($v['data']['title']) . '">
			<input type="hidden" class="url" name="itemsArr[' . $v['id'] . '][uri]" value="' . htmlspecialchars($v['data']['url']) . '">
			<input type="hidden" class="item_id" name="itemsArr[' . $v['id'] . '][item_id]" value="' . $v['id'] . '">
			<input type="hidden" class="parent_id" name="itemsArr[' . $v['id'] . '][parent_id]" value="' . $v['parent'] . '">
			<input type="hidden" class="order" name="itemsArr[' . $v['id'] . '][order]" value="' . $v['data']['order'] . '">
			';

            if (count($tree->getChilds($v['id'])) > 0) {
                if ($tree->hasChilds($v['id'])) {
                    $s .= '<ol>' . $this->createTree($tree, $v['id']) . '</ol></li>';
                }
            }
        }
        return $s;
    }

    private function createNode($tree, $parent)
    {
        $s = '';
        if (!$tree->hasChilds($parent)) return '';
        $childs = $tree->getChilds($parent);
        foreach ($childs as $k => $v) {
            $s .= '<li style="list-style:none;" id="' . $v['id'] . '"><label class="checkbox"><input type="checkbox" name="adding">' . $v['data']['title'] . '</label><input type="hidden" name="url" value=\'' . $v['data']['url'] . '\'><input type="hidden" name="title" value=\'' . $v['data']['title'] . '\'>';
            if (count($tree->getChilds($v['id'])) > 0) {
                if ($tree->hasChilds($v['id'])) {
                    $s .= '<ul style="list-style:none;" id="' . $v['id'] . '">' . $this->createNode($tree, $v['id']) . '</ul></li>';
                }
            }
        }
        return $s;
    }

    private function table_check($tablename, $dbname)
    {
        global $sql;
        $sql->query("SHOW TABLES FROM `" . $dbname . "`");
        while ($row = $sql->next_row()) {
            if ($tablename == $row[0]) {
                return true;
            }
        }
        return false;
    }


    function __construct()
    {
        global $_GET, $_POST, $_FILES, $sql, $_SESSION, $API;

        if (isset($_GET) && !empty($_GET)) {
            $this->getArray = api::slashData($_GET);
        }

        if (isset($_POST) && !empty($_POST)) {
            $this->postArray = api::slashData($_POST);
        }

        $this->dbname = $API['config']['mysql']['db'];

        return true;
    }

}


?>