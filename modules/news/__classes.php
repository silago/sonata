<?php

if (!defined("API")) {
    exit("Main include fail");
}

class news {

    public $api = false;
    public $sql = false;
    public $data = array();
    public $mail = false;
    public $smarty = false;
    public $mDir = "news";
    public $groupsTree = array();
    public $groupsArray = array();
    public $breadcrumbsArray = array();
    private $postArray = array();
    private $getArray = array();
    private $error = array();
    private $valueSmallText = "";
    private $valueFullText = "";

	public static function installModule ($pathPrefix = '') {
		ini_set("display_errors", "off");	        

		self::recacheUriOfGroups ($pathPrefix);  
		self::recacheUriOfNews ($pathPrefix);
		
		ini_set("display_errors", "on");
        return true;		
	}
	
	private static function recacheUriOfGroups ($pathPrefix = '') {
		global $sql;
        $sql->query("SELECT `uri` FROM `newsgroups`");

        while ($row = $sql->next_row()) {
            $routerCheck = api::routerCheck('news', null, $row['uri'], $pathPrefix);
            if (!isset($routerCheck['keyGroup'])) {
                api::routerUpdate('news', 'group', 0, $row['uri'], 'add', false, $pathPrefix);
            }
        }
	}
	
	private static function recacheUriOfNews ($pathPrefix = '') {
		global $sql;
        $sqlGroupUri = clone $sql;
        $sql->query("SELECT `uri`, `ownerId` FROM `news`");

        while ($row = $sql->next_row()) {
            $sqlGroupUri->query("SELECT `uri` FROM `newsgroups` WHERE `id` = '" . $row['ownerId'] . "'", true);
            $routerCheck = api::routerCheck('news', $sqlGroupUri->result['uri'], $row['uri'], $pathPrefix);
            if (!isset($routerCheck['keyItem'])) {
                api::routerUpdate('news', 'item', $routerCheck['keyGroup'], $row['uri'], 'add', $routerCheck['keyItem'], $pathPrefix);
            }
        }
		
	}
	
    // Group functions //
    public function listGroups() {
        global $smarty;
        $smarty->assign('tree', $this->groupsArray);
        $body = $smarty->fetch(api::setTemplate('modules/news/admin/show.groups.item.html'));
        $smarty->assign('body', $body);
        $template = $smarty->fetch(api::setTemplate('modules/news/admin/show.groups.body.html'));
        return $template;
    }

    public function addGroup() {
        global $smarty;
        $smarty->assign("error", $this->error);
        $smarty->assign("selectOwnerId", $this->getSelectGroup(isset ($_GET['ownerId']) ? (int) $_GET['ownerId'] : 0));
        $template = $smarty->fetch(api::setTemplate('modules/news/admin/add.group.html'));
        return $template;
    }

    public function addGroupGo() {
        global $sql;
        $sqlPos = clone $sql;
        $sqlPos->query("SELECT COUNT(*) as `count` FROM `newsgroups` WHERE `ownerId` = '" . $this->postArray['ownerId'] . "'", true);
        $position = $sqlPos->result['count'] + 1;
        $uri = $this->uriCheck($this->postArray['uri']);

        if ($this->checkGroupData($this->postArray['id'], $this->postArray['ownerId'], $this->postArray['title'], $this->postArray['template']) === false) {
            return $this->addGroup();
        } else {
            $sql->query("INSERT INTO #__#newsgroups	(`ownerId`, `title`, `uri`, `template`, `position`) VALUES	('" . (int) $this->postArray['ownerId'] . "', '" . $this->postArray['title'] . "', '" . $uri . "', '" . $this->postArray['template'] . "', '" . $position . "')");
            api::routerUpdate('news', 'group', null, $this->postArray['uri'], 'add');
            message('Группа "' . $this->postArray['title'] . '" успешно создана', "", "admin/news/showGroups.php");
        }
    }

    public function editGroup($id) {
        global $smarty, $sql;
        $sql->query("SELECT `id`, `ownerId`, `title`, `uri`, `template` FROM `newsgroups` WHERE `id` = '" . $id . "'", true);
        foreach ($sql->result as $key => $value) {
            if (!is_int($key)) {
                $smarty->assign($key, $value);
            }
        }
        $smarty->assign("error", $this->error);
        $smarty->assign("selectOwnerId", $this->getSelectGroup($sql->result['ownerId'], $id));
        $template = $smarty->fetch(api::setTemplate('modules/news/admin/edit.group.html'));
        return $template;
    }

    public function editGroupGo() {
        global $sql;
        $sqlPos = clone $sql;
        $sqlPos->query("SELECT COUNT(*) as `count` FROM `newsgroups` WHERE `ownerId` = '" . $this->postArray['ownerId'] . "'", true);
        $position = $sqlPos->result['count'] + 1;

        if ($this->checkGroupData($this->postArray['id'], $this->postArray['ownerId'], $this->postArray['title'], $this->postArray['template']) === false) {
            return $this->editGroup($this->postArray['id'], $this->postArray['ownerId']);
        } else {
            $sql->query("UPDATE #__#newsgroups	SET `ownerId`  = '" . (int) $this->postArray['ownerId'] . "', `title` = '" . $this->postArray['title'] . "', `template` = '" . $this->postArray['template'] . "', `position` = '" . $position . "' WHERE`id` = '" . $this->postArray['id'] . "'");
            $routerCheck = api::routerCheck('news', null, $this->postArray['uri']);
            if (!isset($routerCheck['keyGroup'])) {
                api::routerUpdate('news', 'group', 0, $this->postArray['uri'], 'add');
            }
            message('Группа "' . $this->postArray['title'] . '" успешно изменена', "", "admin/news/showGroups.php");
        }
    }

    public function deleteGroup($id) {
        global $sql;

        if ($id > 0) {

            $sql->query("SELECT `title`, `uri` FROM #__#newsgroups WHERE `id` = '" . $id . "'", true);
            if (intval($sql->num_rows()) !== 1) {
                page500();
            }

            $sql->query("SELECT `id` FROM `#__#news` WHERE `ownerId` = '" . $id . "'");
            while ($row = $sql->next_row()) {
                $this->deleteWG($row['id']);
            }

            $grpUri = $sql->result['uri'];

            $sql->query("DELETE FROM #__#newsgroups WHERE `id` = '" . $id . "'");

            $routerCheck = api::routerCheck('news', null, $grpUri);

            if (isset($routerCheck['keyGroup']) > 0) {
                api::routerUpdate('news', 'group', $routerCheck['keyGroup'], $grpUri, 'delete');
            }

            $sql->query("SELECT `id` FROM `#__#newsgroups` WHERE `ownerId` = '" . $id . "'");
            while ($row = $sql->next_row()) {
                $this->deleteGroup($row['id']);
            }

            message('Группа удалена', "", "/admin/news/showGroups.php");
        } else {
            page500();
        }
    }

    public function delete($id) {
        global $sql;

        $sql->query("SELECT COUNT(*) as 'count', `title` as 'title' FROM #__#news WHERE `id` = '" . $id . "'", true);

        if ($id < 0) {
            page500();
        }

        if (intval($sql->result['count']) !== 1) {
            page500();
        };

        $sql->query("DELETE FROM #__#news WHERE `id` = '" . $id . "'");
        message('Новость "' . $sql->result['title'] . '" удалена', "", "/admin/news/list.php");
    }

    private function deleteWG($id) {
        global $sql;
        $sql->query("DELETE FROM #__#news WHERE `id` = '" . $id . "'");
    }

    private function checkGroupData($id, $ownerId, $title, $template) {

        if (empty($title)) {
            $this->error[] = $this->lang['groupErrorNoTitle'];
        }

        if ($id != 0 && $ownerId != 0) {
            if ($id == $ownerId) {
                $this->error[] = $this->lang['lol'];
            }
        }

        if (!preg_match("/^[a-z0-9_\/\.]*$/i", $template)) {
            $this->error[] = $this->lang['groupErrprNotTemplate'];
        }

        if (!empty($this->error)) {
            return false;
        } else {
            return true;
        }
    }

    private function getGroupsTree() {
        global $sql;
        
        $arr = array ();
        $sql->query("SELECT `id`, `ownerId`, `uri`, `title`, `position` FROM `newsgroups` ORDER by `position` ASC");
        while ($row = $sql->next_row_assoc()) {
            $arr[$sql->result['id']] = $sql->result;
        }

        $tree = new Tree();
        foreach ($arr as $item) {
            $tree->addItem($item['id'], $item['ownerId'], array('title' => $item['title'], 'url' => $item['uri']), $item['position']);
        }

        return $tree;
    }

    private function getGroupsArray($tree, $parent, $level) {
        $level++;
        $childs = $tree->getChilds($parent);
        $s = array ();
        foreach ($childs as $k => $v) {
            $s[$v['id']]['id'] = $v['id'];
            $s[$v['id']]['title'] = $v['data']['title'];
            $s[$v['id']]['url'] = $v['data']['url'];
            $s[$v['id']]['parent'] = $v['parent'];
            $s[$v['id']]['level'] = $level;

            if ($tree->hasChilds($v['id'])) {
                $s = array_merge($s, $this->getGroupsArray($tree, $v['id'], $level));
            }
        }
        return $s;
    }

    private function getSelectGroup($ownerId, $id = '') {
        global $smarty;
        $tr = $this->getGroupsArray($this->groupsTree, 0, -1);
        $arr = array();


        foreach ($tr as $key => $value) {
            $arr[$value['id']] = $value;
            $arr[$value['id']]['del'] = str_repeat("-", ($arr[$value['id']]['level'] * 2));
        }

        if (!empty($id)) {
            unset($arr[$id]);
            $tr2 = $this->getGroupsArray($this->groupsTree, $id, -1);
            foreach ($tr2 as $key => $value) {
                if (isset($arr[$value['id']]) && $arr[$value['id']]['parent'] != 0) {
                    unset($arr[$value['id']]);
                }
            }
        }

        $smarty->assign('defaultValue', $ownerId);
        $smarty->assign('groups', $arr);
        $template = $smarty->fetch(api::setTemplate('modules/news/admin/groups.tree.for.select.list.html'));
        return $template;
    }

    public function uriCheck($uri) {
        global $sql, $API;
        $uri = $this->postArray['uri'];
        $array = (api::uriCheck($uri));

        if ($this->postArray['action'] == 'newsGroups') {
            $table = 'newsgroups';
        } elseif ($this->postArray['action'] == 'news') {
            $table = 'news';
        }

        if (!empty($array)) {
            $sql->query("SHOW TABLE STATUS FROM `" . $API['config']['mysql']['db'] . "` LIKE '" . $table . "'", true);
            $uri = $uri . '-' . $sql->result['Auto_increment'];

            if ($this->uCheck($uri)) {
                $i = 1;
                $tUri = $uri;
                while ($this->uCheck($tUri . '-' . $i)) {
                    $i++;
                }
                $uri .= '-' . $i;
            }
        } else {
            $uri = $uri;
        }
        return $uri;
    }

    public function uriCheckAjax() {
        global $sql, $API;
        $uri = $this->postArray['uri'];
        $array = (api::uriCheck($uri));

        if ($this->postArray['action'] == 'newsGroups') {
            $table = 'newsgroups';
        } elseif ($this->postArray['action'] == 'news') {
            $table = 'news';
        }

        if (!empty($array)) {
            $sql->query("SHOW TABLE STATUS FROM `" . $API['config']['mysql']['db'] . "` LIKE '" . $table . "'", true);
            $uri = $uri . '-' . $sql->result['Auto_increment'];

            if ($this->uCheck($uri)) {
                $i = 1;
                $tUri = $uri;
                while ($this->uCheck($tUri . '-' . $i)) {
                    $i++;
                }
                $uri .= '-' . $i;
            }
        } else {
            $uri = $uri;
        }
        echo $uri;
    }

    private function uCheck($uri) {
        $ret = false;
        $array = (api::uriCheck($uri));
        if (!empty($array)) {
            $ret = true;
        }
        return $ret;
    }

    // News add anf edit //
    public function addNews() {
        global $smarty;

        $FCKeditorSmall = new FCKEditor("smallText");
        $FCKeditorSmall->Value = $this->valueSmallText;
        $FCKeditorSmall->Height = 300;

        $FCKeditorFull = new FCKEditor("fullText");
        $FCKeditorFull->Value = $this->valueFullText;
        $FCKeditorFull->Height = 450;

        $smarty->assign('error', $this->error);
        $smarty->assign('smallForm', $FCKeditorSmall->createHtml());
        $smarty->assign('fullForm', $FCKeditorFull->createHtml());
        $smarty->assign("selectOwnerId", $this->getSelectGroup(isset ($_GET['ownerId']) ? (int) $_GET['ownerId'] : 0));

        $template = $smarty->fetch(api::setTemplate("modules/news/admin/add.news.html"));
        return $template;
    }

    public function addNewsGo() {
        global $sql;
        $sqlGroupUri = clone $sql;
        if (!$this->checkNewsData($this->postArray['ownerId'], $this->postArray['title'], $this->postArray['smallText'], $this->postArray['fullText'], (isset ($this->postArray['template']) ? $this->postArray['template'] : ''), intval($this->postArray['status']), $this->postArray['date'])) {
            return $this->addNews();
        } else {
            $uri = $this->uriCheck($this->postArray['uri']);
            $sqlGroupUri->query("SELECT `uri` FROM `newsgroups` WHERE `id` = '" . $this->postArray['ownerId'] . "'", true);
            $date = explode('.', $this->postArray['date']);
            $dateRes = $date[2] . '-' . $date[1] . '-' . $date[0];
            $sql->query("INSERT INTO #__#news(
											`ownerId`,
											`title`,
											`uri`,
											`template`,
											`smallText`,
											`fullText`,
											`md`,
											`mk`,
											`date`,
											`pageTitle`,
											`status`
											) VALUES (
													'" . $this->postArray['ownerId'] . "',
													'" . $this->postArray['title'] . "',
													'" . $uri . "',
													'" . (isset ($this->postArray['template']) ? $this->postArray['template'] : '') . "',
													'" . $this->postArray['smallText'] . "',
													'" . $this->postArray['fullText'] . "',
													'" . $this->postArray['md'] . "',
													'" . $this->postArray['mk'] . "',
													'" . $dateRes . "',
													'" . $this->postArray['pageTitle'] . "',
													'" . $this->postArray['status'] . "'
													)");

            $routerCheck = api::routerCheck('news', $sqlGroupUri->result['uri'], $uri);
            if (!isset($routerCheck['keyItem'])) {
                api::routerUpdate('news', 'item', $routerCheck['keyGroup'], $uri, 'add', @$routerCheck['keyItem']);
            }

            message($this->lang['newsAddOk'], "", "admin/news/index.php");
        }
    }

    public function editNews($id) {
        global $sql, $smarty;

        $id = intval($id);

        $sql->query("SELECT `id`, `ownerId`, `title`, `template`, `smallText`, `fullText`, `md`, `mk`, `date`, `pageTitle`, `uri`, `status` FROM #__#news WHERE `id` = '" . $id . "'", true);

        if ($sql->num_rows() !== 1) {
            page500();
        }

        $FCKeditorSmall = new FCKEditor("smallText");
        $FCKeditorSmall->Value = $sql->result['smallText'];
        $FCKeditorSmall->Height = 300;

        $FCKeditorFull = new FCKEditor("fullText");
        $FCKeditorFull->Value = $sql->result['fullText'];
        $FCKeditorFull->Height = 450;

        $smarty->assign('error', $this->error);
        $smarty->assign('smallForm', $FCKeditorSmall->createHtml());
        $smarty->assign('fullForm', $FCKeditorFull->createHtml());
        $smarty->assign("selectOwnerId", $this->getSelectGroup($sql->result['ownerId']));


        foreach ($sql->result as $key => $value) {
            if (!is_int($key)) {
                $smarty->assign($key, $value);
            }
        }

        $template = $smarty->fetch(api::setTemplate("modules/news/admin/edit.news.html"));
        return $template;
    }

    public function editNewsGo($id, $ownerId) {
        global $sql;

        if ($id > 0 && $ownerId > 0) {
            if (!$this->checkNewsData($this->postArray['ownerId'], $this->postArray['title'], $this->postArray['smallText'], $this->postArray['fullText'], (isset ($this->postArray['template']) ? $this->postArray['template'] : ''), intval($this->postArray['status']), $this->postArray['date'])) {

                return $this->editNews($id);
            } else {
                $date = explode('.', $this->postArray['date']);
                $dateRes = $date[2] . '-' . $date[1] . '-' . $date[0];

                $sql->query("UPDATE `#__#news`	SET
                                                    `ownerId`  = '" . intval($this->postArray['ownerId']) . "',
                                                    `title` = '" . $this->postArray['title'] . "',
                                                    `date` = '" . $dateRes . "',
                                                    `template` = '" . (isset ($this->postArray['template']) ? $this->postArray['template'] : '') . "',
                                                    `smallText` = '" . $this->postArray['smallText'] . "',
                                                    `fullText` = '" . $this->postArray['fullText'] . "',
                                                    `md` = '" . $this->postArray['md'] . "',
                                                    `mk` = '" . $this->postArray['mk'] . "',
                                                    `pageTitle` = '" . $this->postArray['pageTitle'] . "',
													`status` = '" . $this->postArray['status'] . "'
                                     WHERE `id` = '" . $id . "'");


                $sql->query("SELECT `uri` FROM `newsgroups` WHERE `id` = '" . $ownerId . "'", true);
                $orGroupId = $ownerId;
                $orGroupUri = $sql->result['uri'];

                $sql->query("SELECT `uri` FROM `newsgroups` WHERE `id` = '" . intval($this->postArray['ownerId']) . "'", true);
                $newGroupUri = $sql->result['uri'];

                if ($orGroupId != intval($this->postArray['ownerId'])) {

                    $rCheckOrigGroup = api::routerCheck('news', $orGroupUri, $this->postArray['uri']);
                    if (isset($rCheckOrigGroup['keyItem'])) {
                        api::routerUpdate('news', 'item', $rCheckOrigGroup['keyGroup'], $this->postArray['uri'], 'delete', $rCheckOrigGroup['keyItem']);
                    }

                    $rCheckNewGroup = api::routerCheck('news', $newGroupUri, $this->postArray['uri']);
                    if (!isset($rCheckNewGroup['keyItem'])) {
                        api::routerUpdate('news', 'item', $rCheckNewGroup['keyGroup'], $this->postArray['uri'], 'add', $rCheckNewGroup['keyItem']);
                    }
                }

                message('Новость "' . $this->postArray['title'] . '" успешно изменена', "", "/admin/news/list.php");
            }
        } else {
            page404();
        }
    }

    private function checkNewsData($ownerId, $title, $smallText, $fullText, $template, $status, $date) {
        $this->valueSmallText = $smallText;
        $this->valueFullText = $fullText;

        if (empty($ownerId)) {
            $this->error[] = $this->lang['errorNoOwner'];
        }
        if (empty($title)) {
            $this->error[] = $this->lang['errorNoTitle'];
        }
        if (empty($date)) {
            $this->error[] = 'Не указана дата публикации новости';
        }
        if (empty($fullText)) {
            $this->error[] = $this->lang['errorNoFullNews'];
        }
        if (empty($smallText)) {
            $this->error[] = $this->lang['errorNoSmallNews'];
        }
        if ($status != 1 && $status != 0) {
            $this->error[] = 'Недопустимое значение поля "Статус новости"';
        }

        if (!preg_match("/^[a-z0-9_\.\/]*$/i", $template)) {
            $this->error[] = $this->lang['errorNoTemplate'];
        }

        if (!empty($this->error)) {
            return false;
        } else {
            return true;
        }
    }

    private function createNode($tree, $parent) {
        global $smarty;
        $s = '';

        if (!$tree->hasChilds($parent))
            return '';
        $childs = $tree->getChilds($parent);
        foreach ($childs as $k => $v) {
            $s .= '<li><a href="?groupId=' . $v['id'] . '">' . $v['data']['title'] . '</a>';
            if (count($tree->getChilds($v['id'])) > 0) {
                if ($tree->hasChilds($v['id'])) {
                    $s .= '<ul style="background-color:whitesmoke;">' . $this->createNode($tree, $v['id']) . '</ul></li>';
                }
            }
        }


        return $s;
    }

    // News list //
    public function listNews() {
        global $sql, $smarty;

        $groupId = isset ($_GET['groupId']) ? $_GET['groupId'] : 0;
        
        if ((int) $groupId != 0) {
            $where = "WHERE `ownerId` = '" . (int) $groupId . "'";
        } else {
            $where = "";
        }

        $sql->query("SELECT `id`, `title`, `date`, `ownerId` FROM #__#news $where ORDER BY `date` DESC");
        $array = array();
        while ($row = $sql->next_row_assoc()) {
            array_push($array, $row);
        }

        $smarty->assign('news', $array);
        $body = $smarty->fetch(api::setTemplate('modules/news/admin/show.items.item.html'));
        $smarty->assign('body', $body);
        $smarty->assign('groupsTree', $this->createNode($this->groupsTree, 0));
        $template = $smarty->fetch(api::setTemplate('modules/news/admin/show.items.body.html'));
        return $template;
    }

    public function show($uri) {
        global $sql, $smarty;
        $sql->query("SELECT `title`, `template`, `fullText`, `md`, `mk`, DATE_FORMAT(`date`, '%d.%m.%Y'), `pageTitle`, `ownerId` FROM `#__#news` WHERE `uri` = '" . $uri . "' && status='1'", true);

        if ($sql->num_rows() !== 1) {
            page404();
        }

        /** Хлебные крошки * */
        $this->breadcrumbsArray = array_reverse($this->createBreadcrumb($this->groupsTree, $sql->result['ownerId']));
        $count = count($this->breadcrumbsArray);
        $this->breadcrumbsArray[$count]['data']['title'] = $sql->result[0];
        $this->breadcrumbsArray[$count]['data']['url'] = $uri;
        /** Хлебные крошки * */
        $ownerId = $sql->result['ownerId'];
        $template = $sql->result[1];
        $this->data['title'] = $sql->result[0];
        $this->data['md'] = $sql->result[3];
        $this->data['mk'] = $sql->result[4];
        $this->data['pageTitle'] = $sql->result[6];
        $this->data['template'] = '';
        $this->data['template'] = (isset ($template) && !empty($template) ? $template : $this->data['template']);
        $smarty->assign('title', $sql->result[0]);
        $smarty->assign('date', $sql->result[5]);
        $smarty->assign('fullText', $sql->result[2]);

        $sql->query("SELECT `uri`, `title` FROM `newsgroups` WHERE `id` = '" . $ownerId . "'", true);

        $smarty->assign('grpUri', $sql->result[0]);
        $smarty->assign('grpTitle', mb_strtolower($sql->result['title'], 'UTF-8'));

        $template = $smarty->fetch(api::setTemplate('modules/news/index/show.news.full.html'));
        $this->data['content'] = $template;
    }

    public function showGroup($uri) {
        global $smarty, $sql;
        $itemSql = clone $sql;

        $sql->query("SELECT `title`, `template`, `id` FROM `newsgroups` WHERE `uri` = '" . $uri . "'", true);
        $this->data['title'] = $sql->result['title'];
        $this->data['template'] = $sql->result['template'];

        $this->breadcrumbsArray = array_reverse($this->createBreadcrumb($this->groupsTree, $sql->result['id']));

        $itemSql->query("SELECT `title`, `smallText`, DATE_FORMAT(`date`, '%d.%m.%Y') as 'date', `uri` FROM `news` WHERE `ownerId` = '" . $sql->result['id'] . "' && `status` = '1'");

        if ($itemSql->num_rows() < 1) {
            $smarty->assign('empty', true);
        } else {
            $itemsArray = array();
            while ($row = $itemSql->next_row()) {
                array_push($itemsArray, $row);
            }
            $smarty->assign('news', $itemsArray);
        }
        $smarty->assign('grpUri', $uri);
        $template = $smarty->fetch(api::setTemplate('modules/news/index/show.group.html'));
        $this->data['content'] = $template;
    }

    public function showBreadcrumbs($array) {
        global $smarty;
        $count = (count($array) - 1);
        $smarty->assign('count', $count);
        $smarty->assign('array', $array);
        return $smarty->fetch(api::setTemplate("modules/news/index/breadcrumbs.html"));
    }

    private function createBreadcrumb($tree, $id) {
        $item[] = $tree->getItem($id);
        foreach ($item as $key => $value) {
            if ($value['parent'] != '0') {
                $item = array_merge($item, $this->createBreadcrumb($tree, $value['parent']));
            }
        }
        return $item;
    }

    function __construct() {
        $this->groupsTree = $this->getGroupsTree();
        $this->groupsArray = $this->getGroupsArray($this->groupsTree, 0, -1);


        if (isset($_GET) && !empty($_GET)) {
            $this->getArray = api::slashData($_GET);
        }

        if (isset($_POST) && !empty($_POST)) {
            $this->postArray = api::slashData($_POST);
        }
    }

}

?>
