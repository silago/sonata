<?php

if (!defined("API")) {
    exit("Main include fail");
}

class catalog extends mysql {

    public $lang = array();
    public $curLang = "ru";
    public $data = array();
    public $uri = array();
    public $returnPath = "/admin/catalog/";
    public $breadcrumbsArray = array();
    public $basketArray = array();
    public static $arrCommands = array(array("uri" => "catalog"),
        array("uri" => "new"),
        array("uri" => "hit"),
        array("uri" => "tag"),
		array("uri" => "catalogsearch")
    );
    private $mainTemplate = '';
    private $groupsTemplate = '';
    private $itemsTemplate = '';
    public $mainShow = '';
    private $mDir = "catalog";
    private $aUrl = "/admin/catalog/";
    private $tDir = "modules/catalog/";
    private $error = "";
    private $groups = array();
    private $getArray = array();
    private $postArray = array();
    private $filesArray = array();
    private $siDir = 'userfiles/catalog/notSoBig/';
    private $biDir = 'userfiles/catalog/big/';
    private $giDir = 'userfiles/catalog/group/';
    private $noImage = '/i/noimage.gif';
    private $gMaxH = 150;
    private $gMaxW = 150;
    private $notSoBigMaxWidth = 640;
    private $notSoBigMaxHegiht = 480;
    private $bigMaxWidth = 1024;
    private $bigMaxHegiht = 768;
    private $addPhotoSmallWidth = 100;
    private $addPhotoSmallHeight = 100;
    private $addPhotoBigWidth = 1024;
    private $addPhotoBigHeight = 768;
    private $groupsInLine = 3;
    private $itemsInLine = 5;
    private $waterMark = "";

    public function config() {
        global $smarty, $sql;

        $array = config::getConfigFromIni('catalog');

        foreach ($array as $key => $value) {
            $confValue = api::getConfig("modules", "catalog", $key);
            $array[$key]['value'] = $confValue;
        }

        if (isset($_POST['go']) && $_POST['go'] == 'go') {
            foreach ($_POST as $key => $value) {
                $cfgValue = api::getConfig("modules", "basket", $key);
                if (empty($cfgValue) && $key != 'go') {
                    $sql->query("INSERT INTO `#__#config` (`category`, `type`, `name`, `value`, `lang`) VALUES ('modules', 'catalog', '" . $key . "', '" . htmlspecialchars($value) . "', 'ru')");
                } else {
                    $sql->query("UPDATE `#__#config` SET  `value` = '" . htmlspecialchars($value) . "' WHERE `category` = 'modules' AND `type` = 'catalog' AND `name` = '" . $key . "'");
                }
            }
        }

        $smarty->assign('moduleName', 'Каталог');
        $smarty->assign('module', 'catalog');
        $smarty->assign('confArray', $array);
        $this->data['content'] = $smarty->fetch(api::setTemplate('modules/admin/config.tpl'));
        return true;
    }

    public static function installModule($pathPrefix = '') {
		ini_set("display_errors", "on");
        
        $router = api::object_from_file($pathPrefix."chache/router.txt");
        $router['catalog'] = catalog::$arrCommands; 
        api::object2file($router, $pathPrefix.'chache/router.txt');

        catalog::recacheUriOfGroups($pathPrefix);
        catalog::recacheUriOfItems($pathPrefix);
		ini_set("display_errors", "on");
        return true;
    }

    public function uriCheckAjax() {
        global $sql, $API;

        $uri = $this->postArray['uri'];
        $array = (api::uriCheck($uri));

        if ($this->postArray['action'] == 'addItem') {
            $table = 'shop_items';
        } elseif ($this->postArray['action'] == 'addGroup') {
            $table = 'shop_groups';
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
    
    public function get_group($uri)
    {
    global $API, $sql, $smarty;
    $query =  "select * from shop_groups where ";
    
    
    }



    public function get_items($id)
    {
    global $API, $sql, $smarty;
    $template = clone $smarty;
    
    
    $sql->query("select count(id) as c from shop_items where parent_group_id = '{$id}'",true);    $count = $sql->result['c'];
    
    $page       = ( isset($_GET['page']) ? $_GET['page'] : 1);
    $order_by   = ( isset($_GET['order_by']) ? $_GET['order_by'] : 'value');
    $order_dir   = ( isset($_GET['order_dir']) ? $_GET['order_dir'] : 'ASC');
    
    $per_page   = ( isset($_GET['per_page']) ? $_GET['per_page'] : 10);
    $pagination = array('total'=>$count,'page'=>$page,'per_page'=>$per_page,'order_by'=>$order_by,'order_dir'=>$order_dir);
    

    $query =  "select shop_items.*, shop_itemimages.filename, shop_prices.value,
            concat(shop_groups.uri,'/',shop_items.uri) as uri
    from shop_items
    left join shop_itemimages on shop_items.item_id = shop_itemimages.item_id
    left join shop_groups on shop_items.parent_group_id = shop_groups.group_id
    left join shop_prices on shop_items.item_id = shop_prices.item_id
    where 1 and shop_prices.value <> '' and shop_items.parent_group_id = '{$id}' group by shop_items.id 
    order by {$order_by} {$order_dir} limit ".(($page-1)*$per_page).", {$per_page}
    
    ";
    $sql->query($query);
    $data = $sql->getList();
    


    return array($data,@$pagination);
    }

    # нужно использовать эту функцию и улучшать. в других адъ.
    public function get_groups($uri = false,$params = array(),$tfile='items.main.tpl')
    {
     
    global $API, $sql, $smarty;

    

    $template = clone $smarty;
    if ($uri) 
    {
    $smarty->assign("uri",$uri);
    $sql->query("select * from shop_groups where uri = '".$uri."'", true);
    $group_id  = $sql->result['group_id'];
    $this->data['pageTitle']=$sql->result['name'];

    $params['parent_group_id']=$group_id;
     
     $parent_group_id = $group_id;
     $b_array = array();
     $this->breadcrumbsArray = array();
     while ($parent_group_id != '0'):
        $sql_ = clone $sql;
        $sql_->query('select * from shop_groups where group_id = "'.$parent_group_id.'"',true);
        $b_array[] = array('title'=>$sql_->result['name'],'uri'=>$sql_->result['uri']);
        $parent_group_id = $sql_->result['parent_group_id'];
     endwhile;

     $b_array[]=array('title'=>'Каталог','uri'=>'catalog');
     $smarty->assign('b_array',array_reverse($b_array));


     #$this->breadcrumbsArray = array(
     #       array('id' => 'new', 'parent' => 'new','data' => array('title' => 'Новинки', 'url' => 'new')),
     #   );

    
    }
        $sql_ = clone $sql;
        $query_params = '';
        foreach ($params as $row=>$value) $query_params.= "and  `{$row}` = '{$value}' "; 

        $query =  "select * from shop_groups where 1 {$query_params} ";
        $sql_->query($query);
        #echo $query;
        #die();
        $data = $sql_->getList();
        
        if ($uri):
            $sql_->query("select * from shop_groups where uri = '{$uri}'",true);
            $template->assign("group",$sql_->result);
            $template->assign("uri",$sql_->result['uri']);
        endif;
        if (!$data) 
            {
            $data_tmp = $this->get_items($group_id); 
            #echo "1";
            $data = $data_tmp[0];
            $pagination = $data_tmp[1]; 
            $tfile = "groups.items.tpl";
            $template->assign('p',$pagination);
            }

        $template->assign("pageTitle",@$this->data['pageTitle']);
        $template->assign("items",$data);
        $result = $template->fetch(api::setTemplate($this->tDir . $tfile));
        return $result;
        /* Варианты:
         * 1) одна запись
         * 2) записи по условию
         * 3) все записи
         */
        
   }
    
    public function get_pages()
    {
    }

    public function uriCheck($uri) {
        global $sql, $API;

        $array = (api::uriCheck($uri));

        $this->postArray['action'] = isset($this->postArray['action']) ? $this->postArray['action'] : '';

        if ($this->postArray['action'] == 'addItem') {
            $table = 'shop_items';
        } elseif ($this->postArray['action'] == 'addGroup') {
            $table = 'shop_groups';
        } else {
			$table = '';
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

    private function uCheck($uri) {
        $ret = false;
        $array = (api::uriCheck($uri));
        if (!empty($array)) {
            $ret = true;
        }
        return $ret;
    }

    function randomId($number) {
        $arr = array('a', 'b', 'c', 'd', 'e', 'f',
            'g', 'h', 'i', 'j', 'k', 'l',
            'm', 'n', 'o', 'p', 'r', 's',
            't', 'u', 'v', 'x', 'y', 'z',
            'A', 'B', 'C', 'D', 'E', 'F',
            'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P', 'R', 'S',
            'T', 'U', 'V', 'X', 'Y', 'Z',
            '1', '2', '3', '4', '5', '6',
            '7', '8', '9', '0');
        $pass = "";
        for ($i = 0; $i < $number; $i++) {
            $index = mt_rand(0, sizeof($arr) - 1);
            $pass .= $arr[$index];
        }
        ;
        return strtolower($pass);
    }

    public function setGroupData() {
        $this->data['random_id'] = $this->randomId('8') . '-' . $this->randomId('4') . '-' . $this->randomId('4') . '-' . $this->randomId('4') . '-' . $this->randomId('12');

        if (!empty($this->postArray)) {
            $this->data['parent_group_id'] = $this->postArray['parent_group_id']; // Устанавливаем значение group_id из выпадающегое списка с группами
            $this->data['name'] = strip_tags($this->postArray['name']); // Название группы
            $this->data['uri'] = $this->uriCheck($this->postArray['uri']); // uri для чпу
            $this->data['image'] = isset($this->postArray['photo']) ? $this->postArray['photo'] : ''; // uri для чпу
            $this->data['thumb'] = isset($this->postArray['thumb']) ? $this->postArray['thumb'] : ''; // uri для чпу
            $this->data['description'] = $this->postArray['description']; // Описание группы
            $this->data['status'] = isset($this->postArray['status']) ? $this->postArray['status'] : 0; // Приходит 1 скрываем группу, ничего не приходит ставим 0
            $this->data['title'] = strip_tags($this->postArray['title']); // МетаТег title
            $this->data['md'] = strip_tags($this->postArray['md']); //МетаТег description
            $this->data['mk'] = strip_tags($this->postArray['mk']); //МетаТег keywords
        }

        if (!empty($this->getArray['id'])) {
            $this->data['group_id'] = $this->getArray['id'];
        }

        $this->data['lang'] = $this->curLang; // текущий язык
        return true;
    }

    public function addGroup() {
        global $smarty;

        $this->data['selectGroup'] = $this->genHtmlSelectOwnerGroup((isset($this->data['parent_group_id']) ? $this->data['parent_group_id'] : 0), (!empty($this->data['group_id']) ? $this->data['group_id'] : -1)); // устанавливаем выпадающий список владельцев группы
        $this->data['fckSmallTextForm'] = api::genFck("description", isset($this->data['description']) ? $this->data['description'] : '', 400);

        if (!isset($this->data['error']) || empty($this->data['error'])) {
            $templateError = '';
        } else {
            $smarty->assign('errorText', $this->data['error']);
            $templateError = $smarty->fetch(api::setTemplate($this->tDir . "admin/error.html"));
        }

        $this->data['error'] = $templateError;

        if (!empty($this->data['thumb'])) {
            $smarty->assign('photo', $this->data['image']);
            $smarty->assign('thumb', $this->data['thumb']);
            $photoForm = $smarty->fetch(api::setTemplate($this->tDir . "admin/group.photo.form.html"));
        } else {
            $photoForm = $smarty->fetch(api::setTemplate($this->tDir . "admin/group.photoform.empty.html"));
        }

        $this->data['photoForm'] = $photoForm;


        foreach ($this->data as $key => $value) {
            $smarty->assign($key, stripslashes($value));
        }

        $template = $smarty->fetch(api::setTemplate($this->tDir . "admin/group.add.html"));
        return $template;
    }

    public function addGroupGo() {
        global $sql;
        $sqlPosition = clone $sql;
        $this->setGroupData();

        if (empty($this->data['name'])) {
            $this->data['error'][] = 'Не заполнено поле "Название группы"';
        }

        if (empty($this->data['uri'])) {
            $this->data['error'][] = 'Не заполнено поле "uri"';
        }

        if (!empty($this->data['error'])) {
            return $this->addGroup();
        }


        $sqlPosition->query("SELECT MAX(`position`) as 'position' FROM `#__#shop_groups` WHERE `parent_group_id` = '" . $this->data['parent_group_id'] . "'", true);

        if ($sqlPosition->num_rows() > 0) {
            $this->data['position'] = $sqlPosition->result['position'] + 1;
        } else {
            $this->data['position'] = 0;
        }

        $sql->query("INSERT INTO `#__#shop_groups` 	(	`group_id`,
														`parent_group_id`,
														`name`,																
														`image`,
														`thumb`,
														`uri`,																
														`description`,
														`status`,																
														`md`,
														`mk`,
														`title`,
														`position`)
					VALUES							(	'" . $this->data['random_id'] . "',
														'" . $this->data['parent_group_id'] . "',
														'" . $this->data['name'] . "',
														'" . $this->data['image'] . "',
														'" . $this->data['thumb'] . "',
														'" . $this->data['uri'] . "',
														'" . $this->data['description'] . "',
														'" . $this->data['status'] . "',
														'" . $this->data['md'] . "',
														'" . $this->data['mk'] . "',
														'" . $this->data['title'] . "',
														'" . $this->data['position'] . "')");


        api::routerUpdate('catalog', 'group', null, $this->data['uri'], 'add');
        message("Группа \"" . $this->data['name'] . "\" успешно добавлена", "", "/admin/catalog/groupList.php");
    }

    public function editGroup() {
        global $sql, $smarty;

        if (!isset($this->data['error']) || empty($this->data['error'])) {
            $templateError = '';
        } else {
            $smarty->assign('errorText', $this->data['error']);
            $templateError = $smarty->fetch(api::setTemplate($this->tDir . "admin/error.html"));
        }

        $group_id = $this->getArray['id']; // ид редактируемой группы

        if (empty($group_id))
            page500(); //если пусто ошибка 500
        $sql->query("SELECT * FROM `#__#shop_groups` WHERE `group_id` = '" . $group_id . "'", true); //выбираем все из таблицы групп с этим ид
        if ($sql->num_rows() == 0) {
            page500();
        } //если в таблице ничего нет - ошибка 500

        if ($sql->result['status'] == 1) {
            $select = 'checked';
        } else {
            $select = '';
        } //если группа скрыта передаем checked в чекбокс "Группа скрыта"

        if (!empty($sql->result['thumb'])) {
            $smarty->assign('photo', $sql->result['image']);
            $smarty->assign('thumb', $sql->result['thumb']);
            $photoForm = $smarty->fetch(api::setTemplate($this->tDir . "admin/group.photo.form.html"));
        } else {
            $photoForm = $smarty->fetch(api::setTemplate($this->tDir . "admin/group.photoform.empty.html"));
        }

        $this->data = array(//данные выводимые в шаблон при редактировании
            "group_id" => $group_id, // ид редактируемой группы
            "parent_group_id" => $sql->result[2], // ид родителя редактируемой группы
            "name" => htmlspecialchars($sql->result[3]), // название редактируемой группы
            "photo" => $sql->result[4], // фотография редактируемой группы
            "thumb" => $sql->result[5], // фотография редактируемой группы
            "uri" => htmlspecialchars($sql->result[6]), // uri редактируемой группы
            "description" => ($sql->result[7]), // описание редактируемой группы
            "title" => htmlspecialchars($sql->result[12]), // мета-тэг title редактируемой группы
            "select" => $select, // checked указанный выше
            "md" => htmlspecialchars($sql->result[10]), // мета-тэг description редактируемой группы
            "mk" => htmlspecialchars($sql->result[11]), // мета-тэг keywords редактируемой группы
            "photoForm" => $photoForm,
            "thumbForm" => !empty ($thimbForm) ? $thumbForm : '',
            "error" => $templateError,
        );

        $this->data['selectGroup'] = $this->genHtmlSelectOwnerGroup((isset($this->data['parent_group_id']) ? $this->data['parent_group_id'] : 0), (!empty($this->data['group_id']) ? $this->data['group_id'] : -1)); // устанавливаем выпадающий список владельцев группы
        $this->data['fckSmallTextForm'] = api::genFck("description", $this->data['description'], 400);

        foreach ($this->data as $key => $value) {
            $smarty->assign($key, stripslashes($value));
        }

        $template = $smarty->fetch(api::setTemplate($this->tDir . "admin/group.edit.html"));
        return $template;
    }

    public function editGroupGo() {
        global $sql;

        $this->setGroupData();
        if (empty($this->data['name'])) {
            $this->data['error'][] = 'Не заполнено поле "Название группы"';
        }

        if (!empty($this->data['error'])) {
            return $this->editGroup();
        }

        if (isset($this->data['group_id']) && !empty($this->data['group_id'])) {
            $this->setGroupVisibility($this->data['group_id'], $this->data['status']);
            $sql->query("UPDATE #__#shop_groups SET
													`group_id` = '" . $this->data['group_id'] . "',
													`parent_group_id` = '" . $this->data['parent_group_id'] . "',
													`name` = '" . $this->data['name'] . "',
													`image` = '" . $this->data['image'] . "',
													`thumb` = '" . $this->data['thumb'] . "',
													`description` = '" . $this->data['description'] . "',
													`title` = '" . $this->data['title'] . "',
													`mk` = '" . $this->data['mk'] . "',
													`md` = '" . $this->data['md'] . "',
													`status` = '" . $this->data['status'] . "'
													WHERE `group_id` = '" . $this->data['group_id'] . "'");


            $routerCheck = api::routerCheck('catalog', null, $this->postArray['uri']);
            if (!isset($routerCheck['keyGroup'])) {
                api::routerUpdate('catalog', 'group', 0, $this->postArray['uri'], 'add');
            }

            message("Группа \"" . $this->data['name'] . "\" успешно отредактирована", "", "/admin/catalog/groupList.php");
            return true;
        }
    }

    private function setGroupVisibility($id, $value) {
        global $sql;
        $sql1 = clone $sql;
        $sql2 = clone $sql;
        $sql1->query("SELECT `group_id` FROM `#__#shop_groups` WHERE `parent_group_id` = '" . $id . "'");
        //$sql2->query("UPDATE `#__#shop_groups` SET `status` = '" . $value . "' WHERE `parent_group_id` = '" . $id . "'");
        //if ($sql1->num_rows() > 0) {
        //    while ($sql1->next_row()) {
        //        $this->setGroupVisibility($sql1->result['group_id'], $value);
        //    }
       // }
        return true;
    }

    function createNode($tree, $parent) {
        global $smarty;
        $s = '';

        if (!$tree->hasChilds($parent))
            return '';
        $childs = $tree->getChilds($parent);
        foreach ($childs as $k => $v) {
            $s .= '<li><a href="?parent_group_id=' . $v['id'] . '">' . $v['data']['title'] . '</a>';
            if (count($tree->getChilds($v['id'])) > 0) {
                if ($tree->hasChilds($v['id'])) {
                    $s .= '<ul style="background-color:whitesmoke;">' . $this->createNode($tree, $v['id']) . '</ul></li>';
                }
            }
        }


        return $s;
    }

    function listItems() {
        global $sql, $_GET, $smarty;
        
        $offset = ((isset($_GET['items'])) ? $_GET['items'] : 0);
        #$limit  = 20;
        $limit  = " limit {$offset}, 20 ";
        
        
        $sqltest = clone $sql;
        $sqlprice = clone $sql;
        $sqlphoto = clone $sql;
        $sqlGroups = clone $this->sql;
        $sqlGroupsInTable = clone $this->sql;
        $order = '';

        /*
         * ********* Товары **********
         */

        if (isset($this->getArray['parent_group_id']) && !empty($this->getArray['parent_group_id'])) {
            $sqltest->query("SELECT * FROM `#__#shop_groups` WHERE `group_id` ='" . $this->getArray['parent_group_id'] . "'", true);
            if ($sqltest->num_rows() == 1) {
                $where = 'WHERE `parent_group_id` = "' . $this->getArray['parent_group_id'] . '"';
            } else {
                page500();
            }
        } else {

            $where = '';
        }


        if (isset($this->getArray['sort']) && isset($this->getArray['type'])) {
            if ($this->getArray['sort'] != 'name' && $this->getArray['sort'] != 'price')
                page500();
            if ($this->getArray['type'] != 'asc' && $this->getArray['type'] != 'desc')
                page500();

            if ($this->getArray['sort'] == 'name') {
                $sql->query("SELECT `item_id`, `name`, `parent_group_id`, `price_old`, `small_desc`, `is_hit`, `is_new` FROM `#__#shop_items` " . $where . " ORDER BY name " . $this->getArray['type'] . "".$limit);
            }

            if ($this->getArray['sort'] == 'price') {
                $sql->query("SELECT `item_id`, `name`, `parent_group_id`, `price_old`, `small_desc`, `is_hit`, `is_new` FROM `#__#shop_items`  LEFT JOIN `#__#shop_prices` ON `#__#shop_items`.`item_id` = `#__#shop_prices`.`item_id` " . $where . " ORDER BY `#__#shop_prices`.`value` " . $this->getArray['type'] . "".$limit);
            }
        } else {
            $sql->query("SELECT `item_id`, `name`, `parent_group_id`, `price_old`, `small_desc`, `is_hit`, `is_new` FROM `#__#shop_items` " . $where . " ORDER BY name ASC ".$limit);
        }

        $itemArray = array();

        while ($row = $sql->next_row_assoc()) {
            $sqlprice->query("SELECT `value` FROM `#__#shop_prices` WHERE `item_id` = '" . $row['item_id'] . "'", true);
            $itemArray[$row['item_id']] = $row;
            $itemArray[$row['item_id']]['price'] = $sqlprice->result['value'];
            $sqlphoto->query("SELECT * FROM `#__#shop_itemimages` WHERE `item_id` = '" . $row['item_id'] . "' && `description` = 'Основное' ", true);

            if ($sqlphoto->num_rows() < 1) {
                $sqlphoto->query("SELECT * FROM `#__#shop_itemimages` WHERE `item_id` = '" . $row['item_id'] . "'", true);
            }

            $itemArray[$row['item_id']]['photo'] = $sqlphoto->result['thumb'];
        }


        if ($sql->num_rows() > 0) {
            $smarty->assign('item', $itemArray);
            $templateItem = $smarty->fetch(api::setTemplate($this->tDir . "admin/item.list.item.html"));
        } else {
            $grpArr = array();
            if (isset($this->getArray['parent_group_id'])) {
                $sqlGroupsInTable->query("SELECT `name`, `group_id`  FROM `#__#shop_groups` WHERE `parent_group_id` = '" . $this->getArray['parent_group_id'] . "' ORDER BY name ASC");
            
                while ($row = $sqlGroupsInTable->next_row()) {
                    $grpArr[] = $row;
                }
            }
            $smarty->assign('grpArr', $grpArr);
            $templateItem = $smarty->fetch(api::setTemplate($this->tDir . "admin/item.list.item.empty.html"));
        }

        /*
         * ********* Товары **********
         */

        /*
         * ********* Группы **********
         */

        $sqlGroups->query("SELECT `group_id` as 'id', `uri` as 'code', `parent_group_id` as 'parent', `position` as 'order', `name` as 'title'  FROM `#__#shop_groups` order by `position` asc");
        $arrGroups = array();
        while ($row = $sqlGroups->next_row_assoc()) {
            $arrGroups[] = $row;
        }
        $tree = new Tree();

        foreach ($arrGroups as $item) {
            $tree->addItem(
                    $item['id'], $item['parent'], array(
                'title' => $item['title'],
                'code' => $item['code'],
                'position' => $item['order']
                    ), $item['order']
            );
        }

        //print_r($this->createNode($tree, 0));

        $smarty->assign('groupsTree', $this->createNode($tree, 0));
        $smarty->assign('groups', $arrGroups);

        /*
         * ********* Группы **********
         */

		#print_r($itemArray);
        $smarty->assign('content', $templateItem);
        if (isset($this->getArray['parent_group_id']))
        $smarty->assign('parent_group_id', $this->getArray['parent_group_id']);
        $smarty->assign('offset', $offset);
        $smarty->assign('items', $itemArray);
        $templateBody = $smarty->fetch(api::setTemplate($this->tDir . "admin/item.list.body.html"));
        $pagination = $smarty->fetch(api::setTemplate($this->tDir . "admin/pags.html"));
        $this->data['content'] = $templateBody;
        $this->data['content'].= $pagination;

        return true;
    }
	
	private function brandsTree( $id = null){
		global $sql;
		$sql2 = clone $sql;
		 
		if($id != null){
			$sql2->query("SELECT * FROM `tag_item` WHERE `id_item` = '{$id}'");
			$it = $sql2->next_row();
		}
		$sql->query("SELECT * FROM `tags`");
			
		$brands = $sql->getListAssoc();
		
		$ret = '<select name="brands">';
		$ret .= '<option value="0">Выберите бренд</option>';
		foreach($brands as $item){
			$ret .= '<option '.(isset($it) && $it['id_tag'] == $item['id'] ? 'selected' : '').' value="'.$item['id'].'">'.$item['name'].'</option>';
		}
		$ret .= '</select>';
		
		return $ret;
	}
	
    public function addItemShowForm() {
        global $smarty;
		
        if (empty($this->data['error'])) {
            $this->data['error'] = '';
        } else {
            $smarty->assign('errorText', $this->data['error']);
            $templateError = $smarty->fetch(api::setTemplate($this->tDir . "admin/error.html"));
            $this->data['error'] = $templateError;
        }

		$brands = $this->brandsTree();
		
        $this->data['brands'] = $brands;
        $this->data['selectOwnerId'] = $this->genHtmlSelectOwnerGroup1((isset($_GET['parent_group_id']) ? $_GET['parent_group_id'] : -1));
        $this->data['fckFullTextForm'] = api::genFck("description", isset($this->data['description']) ? $this->data['description'] : '');

		$smarty->assign('brands', $this->data['brands']);
		
        if (isset($this->data['image']) && !empty($this->data['image'])) {
            $smarty->assign('item', $this->data['image']);
            $smarty->assign('primary_photo', $this->data['primary_photo']);
            $photoTemplate = $smarty->fetch(api::setTemplate($this->tDir . "admin/item.photoform.html"));
        } else {
            $photoTemplate = $smarty->fetch(api::setTemplate($this->tDir . "admin/item.photoform.empty.html"));
        }

        $this->data['photoForm'] = $photoTemplate;
        foreach ($this->data as $key => $value) {
            $smarty->assign($key, $value);
        }

        $template = $smarty->fetch(api::setTemplate($this->tDir . "admin/item.add.html"));
        return $template;
    }

    public function addItemGo() {
        global $sql;
                    
        $sqlGroupUri = clone $sql;
        $item_id = $this->randomId('8') . '-' . $this->randomId('4') . '-' . $this->randomId('4') . '-' . $this->randomId('4') . '-' . $this->randomId('12');
        $hit = (isset($this->postArray['hit']) ? $this->postArray['hit'] : 0);
        $new = (isset($this->postArray['new']) ? $this->postArray['new'] : 0);

        $this->data = array(
            "item_id" => $item_id, 
            "article" => strip_tags($this->postArray['article']),
            "parent_group_id" => $this->postArray['parent_group_id'],
            "name" => strip_tags($this->postArray['name']),
            "uri" => $this->uriCheck($this->postArray['uri']),
            "price" => $this->postArray['price'],
            "price_old" => isset($this->postArray['price_old']) && !empty($this->postArray['price_old']) ? $this->postArray['price_old'] : 0,
            "is_hit" => $hit,
            "is_new" => $new,
            "description" => $this->postArray['description'],
            "title" => strip_tags($this->postArray['title']),
            "mk" => strip_tags($this->postArray['mk']),
            "md" => strip_tags($this->postArray['md']),
            "image" => array("photo" => isset($this->postArray['photo']) ? $this->postArray['photo'] : '',
                "thumb" => isset($this->postArray['thumb']) ? $this->postArray['thumb'] : '',
                "position" => isset($this->postArray['position']) ? $this->postArray['position'] : ''),
            "primary_photo" => isset($this->postArray['primary']) ? $this->postArray['primary'] : '',
            "brands" => $this->postArray['brands'],
        );

		
        if (($this->data['parent_group_id']) == '0') {
            $this->data['error'][] = 'Не указан группа для товара';
        }

        if (empty($this->data['name'])) {
            $this->data['error'][] = 'Не заполнено поле "Название товара"';
        }


        if (empty($this->data['uri'])) {
            $this->data['error'][] = 'Не заполнено поле "uri"';
        }

        /* Проверка цен */
        if (!empty($this->data['price_old']) && !preg_match("/^[0-9]/", $this->data['price_old'], $match)) {
            $this->data['error'][] = 'Неверно указана старая цена';
        } else {
            if (strstr($this->data['price_old'], ',')) {
                $this->data['price_old'] = str_replace(',', '.', $this->data['price_old']);
            }
        }

        if (!empty($this->data['price']) && !preg_match("/^[0-9]/", $this->data['price'], $match)) {
            $this->data['error'][] = 'Неверно указана цена';
        } else {
            if (strstr($this->data['price'], ',')) {
                $this->data['price'] = str_replace(',', '.', $this->data['price']);
            }
        }

        /* Проверка цен */

        if (!empty($this->data['error'])) {
            return $this->addItemShowForm();
        } else {

            $sql->query("INSERT INTO `#__#shop_items`(
													`item_id`,
													`article`,
													`parent_group_id`,
													`name`,
													`description`,
													`price_old`,
													`is_hit`,
													`is_new`,
													`uri`,
													`title`,
													`md`,
													`mk`
													) VALUES (
													  			'" . $this->data['item_id'] . "',
													  			'" . $this->data['article'] . "',
													  			'" . $this->data['parent_group_id'] . "',
													  			'" . $this->data['name'] . "',
													  			'" . $this->data['description'] . "',
																'" . $this->data['price_old'] . "',
																'" . $this->data['is_hit'] . "',
																'" . $this->data['is_new'] . "',
																'" . $this->data['uri'] . "',
																'" . $this->data['title'] . "',
																'" . $this->data['md'] . "',
																'" . $this->data['mk'] . "'
															)");


            $sql->query("INSERT INTO `#__#shop_prices` (`item_id`, `value`) VALUES ('" . $this->data['item_id'] . "', '" . (isset($this->data['price']) && !empty($this->data['price']) ? $this->data['price'] : 0) . "')");

            if (!empty($this->data['image']['photo'])) {
                $count = count($this->data['image']['photo']);
                for ($i = 0; $i < $count; $i++) {
                    $sql->query("INSERT INTO `#__#shop_itemimages` (`item_id`, `filename`, `thumb`, `description`, `position`) VALUES ('" . $this->data['item_id'] . "', '" . $this->data['image']['photo'][$i] . "', '" . $this->data['image']['thumb'][$i] . "', 'Дополнительное', '" . $this->data['image']['position'][$i] . "')");
                }
                $sql->query("UPDATE `#__#shop_itemimages` set `description` = 'Основное' WHERE `position` = '" . $this->data['primary_photo'] . "' AND `item_id` = '" . $this->data['item_id'] . "'");
            }
			
			$q = "INSERT INTO `#__#tag_item` SET `id_tag` = '{$this->data['brands']}', `id_item` = '{$this->data['item_id']}'";
			$sql->query($q);
			
			
			
            $sqlGroupUri->query("SELECT `uri` FROM `shop_groups` WHERE `group_id` = '" . $this->data['parent_group_id'] . "'", true);
            $routerCheck = api::routerCheck('catalog', $sqlGroupUri->result['uri'], $this->data['uri']);
            if (!isset($routerCheck['keyItem'])) {
                api::routerUpdate('catalog', 'item', $routerCheck['keyGroup'], $this->data['uri'], 'add');
            }
		
            message("Товар \"" . $this->data['name'] . "\" успешно добавлен", "", '/admin/catalog/listItems.php');
        }
    }

    public function editItem() {
        global $sql, $smarty;
        $sqlPhotos = clone $sql;
        $sqlPrimPhoto = clone $sql;

        if (empty($this->data['error'])) {
            $this->data['error'] = '';
        } else {
            $smarty->assign('errorText', $this->data['error']);
            $templateError = $smarty->fetch(api::setTemplate($this->tDir . "admin/error.html"));
        }


        $item_id = $this->getArray['id']; // ид редактируемого товара
        if (empty($item_id))
            page500(); //если пусто ошибка 500
        $sql->query("SELECT * FROM `#__#shop_items` WHERE `item_id` = '" . $item_id . "'", true); //выбираем все из таблицы товаров с этим ид

        if ($sql->num_rows() == 0) {
            page500();
        } //если в таблице ничего нет - ошибка 500

        $sqlPhotos->query("SELECT * FROM `#__#shop_itemimages` WHERE `item_id` = '" . $item_id . "' ORDER BY `position` ASC");

        $photo = array ();
        $thumb = array ();
        $position = array ();
        while ($sqlPhotos->next_row()) {
            $photo[] = $sqlPhotos->result['filename'];
            $thumb[] = $sqlPhotos->result['thumb'];
            $position[] = $sqlPhotos->result['position'];
        }
 
        $sqlPrimPhoto->query("SELECT `position` FROM `#__#shop_itemimages` WHERE `description` = 'Основное' AND `item_id` = '" . $item_id . "'", true); //выбираем все из таблицы групп с этим ид
        // доп. условие в строке выше (с item_id) взято из oriflameirk.ru
        $this->data = array(//данные выводимые в шаблон при редактировании
            "item_id" => $item_id, // ид редактируемой группы
            "article" => $sql->result[3], // артикул товара
            "parent_group_id" => $sql->result[4], // артикул товара
            "name" => htmlspecialchars($sql->result[5]), // название редактируемой группы
            "description" => $sql->result[6], // название редактируемой группы
            "small_desc" => htmlspecialchars($sql->result[7]), // название редактируемой группы
            "price_old" => ($sql->result[8]),
            "remains" => ($sql->result[9]),
            "is_hit" => ($sql->result[10]),
            "is_new" => ($sql->result[11]),
            "uri" => htmlspecialchars($sql->result[12]), // uri редактируемой группы
            "md" => htmlspecialchars($sql->result[13]), // мета-тэг description редактируемой группы
            "mk" => htmlspecialchars($sql->result[14]), // мета-тэг keywords редактируемой группы
            "title" => htmlspecialchars($sql->result[15]), // мета-тэг title редактируемой группы
            "brands" => $this->brandsTree($item_id), // бренды
            "error" => isset ($templateError) ? $templateError : '',
        );
        if(isset($photo)){
            $this->data["image"] = array(   "photo" => $photo, 
                                "thumb" => $thumb, 
                                "position" => $position);
            $this->data["primary_photo"] = $sqlPrimPhoto->result['0'];
            
        }
        if (!empty($this->data['image'])) {
            $smarty->assign('item', $this->data['image']);
            $smarty->assign('primary_photo', $this->data['primary_photo']);
            $photoTemplate = $smarty->fetch(api::setTemplate($this->tDir . "admin/item.photoform.html"));
        } else {
            $photoTemplate = $smarty->fetch(api::setTemplate($this->tDir . "admin/item.photoform.empty.html"));
        }

        $this->data['photoForm'] = $photoTemplate;
        $sql->query("SELECT * FROM `#__#shop_prices` WHERE `item_id` = '" . $item_id . "'", true); //цена товара
        $this->data['fckFullTextForm'] = api::genFck("description", $this->data['description']);
        $this->data['selectOwnerId'] = $this->genHtmlSelectOwnerGroup1((isset($this->data['parent_group_id']) ? $this->data['parent_group_id'] : -1));
        $this->data['price'] = $sql->result['value'];

        foreach ($this->data as $key => $value) {
            $smarty->assign($key, $value);
        }
        $template = $smarty->fetch(api::setTemplate($this->tDir . "admin/item.edit.html"));

        return $template;
    }

    public function editItemGo() {
        global $sql, $_GET, $smarty;
        $item_id = $_GET['id'];
        $sqlGroupUri = clone $sql;
        $sqlOldGroupUir = clone $sql;

        $sql->query("SELECT * FROM `#__#shop_items` WHERE `item_id` = '" . $item_id . "'", true); //выбираем все из таблицы групп с этим ид

        if (!($sql->num_rows())) {
            page500();
        } else {
            $oldGroupId = $sql->result['parent_group_id'];
            $sqlOldGroupUir->query("SELECT `uri` FROM `shop_groups` WHERE `group_id` = '" . $oldGroupId . "'", true);
            $oldGroupUri = $sqlOldGroupUir->result['uri'];

            $hit = (isset($this->postArray['hit']) ? $this->postArray['hit'] : 0);
            $new = (isset($this->postArray['new']) ? $this->postArray['new'] : 0);

            $this->data = array( 
                "item_id" => $item_id,
                "article" => strip_tags($this->postArray['article']),
                "brands" => strip_tags($this->postArray['brands']),
                "parent_group_id" => $this->postArray['parent_group_id'],
                "name" => strip_tags($this->postArray['name']),
                "uri" => $this->postArray['uri'],
                "price" => strip_tags($this->postArray['price']),
                "price_old" => strip_tags($this->postArray['price_old']),
                "is_hit" => $hit,
                "is_new" => $new,
                "description" => $this->postArray['description'],
                "title" => strip_tags($this->postArray['title']),
                "mk" => strip_tags($this->postArray['mk']),
                "md" => strip_tags($this->postArray['md']),
            );
                
            if(isset($this->postArray['photo'])){
                $this->data["image"] = array("photo" => $this->postArray['photo'], "thumb" => $this->postArray['thumb'], "position" => $this->postArray['position']);
                $this->data["primary_photo"] = $this->postArray['primary'];
                
            }

            if (($this->data['parent_group_id']) == '0') {
                $this->data['error'][] = 'Не указан группа для товара';
            }

            if (empty($this->data['name'])) {
                $this->data['error'][] = 'Не заполнено поле "Название товара"';
            }

            /* Проверка цен */
            if (!empty($this->data['price_old']) && !preg_match("/^[0-9]/", $this->data['price_old'], $match)) {
                $this->data['error'][] = 'Неверно указана старая цена';
            } else {
                if (strstr($this->data['price_old'], ',')) {
                    $this->data['price_old'] = str_replace(',', '.', $this->data['price_old']);
                }
            }

            if (!empty($this->data['price']) && !preg_match("/^[0-9]/", $this->data['price'], $match)) {
                $this->data['error'][] = 'Неверно указана старая цена';
            } else {
                if (strstr($this->data['price'], ',')) {
                    $this->data['price'] = str_replace(',', '.', $this->data['price']);
                }
            }

            /* Проверка цен */

            if (!empty($this->data['error'])) {
                return $this->editItem();
            } else {
                $sql->query("UPDATE `#__#shop_items` SET
												`item_id` = '" . $this->data['item_id'] . "',
												`article` = '" . $this->data['article'] . "',
												`parent_group_id` = '" . $this->data['parent_group_id'] . "',
												`name` = '" . $this->data['name'] . "',
												`description` = '" . $this->data['description'] . "',
												`price_old` = '" . $this->data['price_old'] . "',
												`is_hit` = '" . $this->data['is_hit'] . "',
												`is_new` = '" . $this->data['is_new'] . "',
												`title` = '" . $this->data['title'] . "',
												`md` = '" . $this->data['md'] . "',
												`mk` = '" . $this->data['mk'] . "' WHERE `item_id` = '" . $this->data['item_id'] . "'"
                );


                $sql->query("UPDATE `#__#shop_prices` SET `value` = '" . $this->data['price'] . "' WHERE `item_id` = '" . $this->data['item_id'] . "'");

                if (!empty($this->data['image']['photo'])) {
                    $sql->query("DELETE FROM `#__#shop_itemimages` WHERE `item_id` = '" . $this->data['item_id'] . "'");
                    $count = count($this->data['image']['photo']);
                    for ($i = 0; $i < $count; $i++) {
                        $sql->query("INSERT INTO `#__#shop_itemimages` (`item_id`, `filename`, `thumb`, `description`, `position`) VALUES ('" . $this->data['item_id'] . "', '" . $this->data['image']['photo'][$i] . "', '" . $this->data['image']['thumb'][$i] . "', 'Дополнительное', '" . $this->data['image']['position'][$i] . "')");
                    }
                    $sql->query("UPDATE `#__#shop_itemimages` set `description` = 'Основное' WHERE `position` = '" . $this->data['primary_photo'] . "'");
                } else { // блок после else взят из oriflameirk.ru
                    $sql->query("DELETE FROM `#__#shop_itemimages` WHERE `item_id` = '" . $this->data['item_id'] . "'");
                }

				
				$sql->query("SELECT * FROM `#__#tag_item` WHERE `id_item` = '{$this->data['item_id']}'");
				if($sql->num_rows())
					$q = "UPDATE `#__#tag_item` SET `id_tag` = '{$this->data['brands']}' WHERE `id_item` = '{$this->data['item_id']}'";
				else
					$q = "INSERT `#__#tag_item` SET `id_tag` = '{$this->data['brands']}', `id_item` = '{$this->data['item_id']}'";
				
				$sql->query($q);

                $sqlGroupUri->query("SELECT `uri` FROM `shop_groups` WHERE `group_id` = '" . $this->data['parent_group_id'] . "'", true);
                $newGroupUri = $sqlGroupUri->result['uri'];


                if ($this->data['parent_group_id'] != $oldGroupId) {

                    $rCheckOrigGroup = api::routerCheck('catalog', $oldGroupUri, $this->data['uri']);
                    if (isset($rCheckOrigGroup['keyItem'])) {
                        api::routerUpdate('catalog', 'item', $rCheckOrigGroup['keyGroup'], $this->data['uri'], 'delete', $rCheckOrigGroup['keyItem']);
                    }

                    $rCheckNewGroup = api::routerCheck('catalog', $newGroupUri, $this->data['uri']);
                    if (!isset($rCheckNewGroup['keyItem'])) {
                        api::routerUpdate('catalog', 'item', $rCheckNewGroup['keyGroup'], $this->data['uri'], 'add');
                    }
                }

                message("Товар \"" . $this->data['name'] . "\" успешно отредактирован", "", '/admin/catalog/listItems.php');
            }
        }
    }

    public function genHtmlSelectOwnerGroup1($defaultValue = 0, $halt = -1) { //для товаров
        $return = "<select style=\"width:466px\" name=\"parent_group_id\" tabindex=\"1\">";
        //if ($defaultValue == '0' && !isset($_GET['id'])) {$return.="<option value=\"0\" selected=\"selected\">--- ".$this->lang['no']." ---</option>"; } else {$return.="<option value=\"0\">--- ".$this->lang['no']." ---</option>";}
        $treeArray = template::genTree1("shop_groups", "group_id", "parent_group_id", "name", 0, $halt);
        $sel = '';

        foreach ($treeArray as $key => $value) {
            $return .= "<option value = \"" . $key . "\"" . ($defaultValue == $key ? " selected=\"selected\"" : "") . ">" . str_repeat("- ", ($treeArray[$key]['level'] * 2)) . $treeArray[$key]['value'] . "</option>";
        }

        $return .= "</select>";
        return $return;
    }

    public function genHtmlSelectOwnerGroup($defaultValue = '0', $halt = -1) { //для групп
        $return = "<select style=\"width:574px;\" name=\"parent_group_id\" id=\"parent_group_id\">";
        if ($defaultValue == '0' && !isset($_GET['id'])) {
            $return .= "<option value=\"0\" selected=\"selected\">--- " . $this->lang['no'] . " ---</option>";
        } else {
            $return .= "<option value=\"0\">--- " . $this->lang['no'] . " ---</option>";
        }
        $treeArray = template::genTree1("shop_groups", "group_id", "parent_group_id", "name", 0, $halt);
        $sel = '';


        foreach ($treeArray as $key => $value) {

            if (($key === $defaultValue) || (isset($_GET['id']) && ($key == $_GET['id']))) {
                $select = 'selected';
            } else {
                $select = '';
            }

            $return .= "<option value = \"" . $key . "\"" . $select . ">" . str_repeat("- ", ($treeArray[$key]['level'] * 2)) . $treeArray[$key]['value'] . "</option>";
        }

        $return .= "</select>";
        return $return;
    }

    public function groupList() {
        global $sql, $smarty;
        
        $sql->query("SELECT `group_id`, `position` FROM `#__#shop_groups`");
        
        while ($sql->next_row())
            $groupsPosition[$id = $sql->result[0]] = $sql->result[1];
        $treeArray = template::genTree1("shop_groups", "group_id", "parent_group_id", "name", 0, -1, "position");
        //var_dump($treeArray);
        //echo "__";
        $body = "";
        $template = new template();
        $template->file(api::setTemplate($this->tDir . "admin/groups.list.item.html"));

        foreach ($treeArray as $key => $value) {

            if (($treeArray[$key]['status']) == '1') {
                $linkColor = 'style="color:#c2c2c2"';
                $checked = 'checked';
            } else {
                $linkColor = 'style="color:#d3d3d3#08C"';
                $checked = '';
            }

            $template->assign("status", $linkColor);
            $template->assign("checked", $checked);
            $template->assign("id", preg_replace('/-/', '', $key));
            $template->assign("idorig", $key);
            $template->assign("padding", $treeArray[$key]['level'] * 30) .
                    $template->assign("title", $treeArray[$key]['value']);
            $template->assign("parent", preg_replace('/-/', '', $treeArray[$key]['parent']));
            $template->assign("position", $groupsPosition[$key]);
            $body .= $template->get();
        }

        if (empty($body)) {
            $template = new template(api::setTemplate($this->tDir . "admin/groups.list.empty.html"));
            $body = $template->get();
        }
        $template = new template(api::setTemplate($this->tDir . "admin/groups.list.body.html"));
        $template->assign("body", $body);
        $this->data['content'] = $template->get();
    }

    public function grpposchange() {
        global $sql;

        $sql->query("UPDATE `#__#shop_groups` SET `status` = '0'");

        foreach ($_POST['positions'] as $key => $value) {
            $sql->query("UPDATE `#__#shop_groups` SET `position` = '" . $value . "' WHERE `group_id` = '" . $key . "'");
        }

        foreach ($_POST['status'] as $key => $value) {
            $sql->query("UPDATE `#__#shop_groups` SET `status` = '" . $value . "' WHERE `group_id` = '" . $key . "'");
            $this->setGroupVisibility($key, $value);
        }

        message("Изменения сохранены", "", '/admin/catalog/groupList.php');
        return true;
    }

    public function deleteItem($id) {
        global $sql;
        $itemSql = clone $sql;
        $groupSql = clone $sql;

        if (empty($id)) {
            $id = $this->getArray['id'];
        }
        $itemSql->query("SELECT * FROM `#__#shop_items` WHERE `item_id` = '" . $id . "'", true);
        if ($itemSql->num_rows() < 1) {
            page500();
        } else {

            $groupSql->query("SELECT `uri` FROM `shop_groups` WHERE `group_id`='" . $itemSql->result['parent_group_id'] . "'", true);
            $routerCheck = api::routerCheck('catalog', $groupSql->result['uri'], $itemSql->result['uri']);

            $sql->query("SELECT `filename`, `thumb` FROM `#__#shop_itemimages` WHERE `item_id` = '" . $id . "'");
            $sql->query("DELETE FROM `#__#shop_itemimages` WHERE `item_id` = '" . $id . "'");
            $sql->query("DELETE FROM `#__#shop_items` WHERE `item_id` = '" . $id . "'");
            $sql->query("DELETE FROM `#__#shop_prices` WHERE `item_id` = '" . $id . "'");
            $sql->query("DELETE FROM `#__#tag_item` WHERE `id_item` = '" . $id . "'");

            if (isset($routerCheck['keyItem'])) {
                api::routerUpdate('catalog', 'item', $routerCheck['keyGroup'], $itemSql->result['uri'], 'delete', $routerCheck['keyItem']);
            } 

            message("Товар удален", null);
        }
    }

    public function showNew() {
        global $sql, $smarty, $basket;
        $itemsNewOnly = clone $sql;
        $itemsPrice = clone $sql;
        $itemsPhoto = clone $sql;
        $itemsArray = array();

        $itemsNewOnly->query("SELECT `name`, `description`, `price_old`, `is_hit`, `is_new`, `parent_group_id`, `uri`, `item_id`, `id` FROM `shop_items` WHERE is_new = 1");
        while ($row = $itemsNewOnly->next_row_assoc()) {

            $itemsPrice->query("SELECT `value` FROM `shop_prices` WHERE `item_id` = '" . $row['item_id'] . "'", true);
            $row['price'] = $itemsPrice->result['value'];

            $itemsPhoto->query("SELECT `thumb` FROM `shop_itemimages` WHERE `description` = 'Основное' AND `item_id` = '" . $row['item_id'] . "'", true);
            $row['thumb'] = $itemsPhoto->result['thumb'];

            $groupUri = $this->getParentGroupUri($row['parent_group_id']);
            $row['uri'] = '/' . $groupUri . '/' . $row['uri'] . '/';
            array_push($itemsArray, $row);
        }
        $this->breadcrumbsArray = array(
            array('id' => 'new', 'parent' => 'new', 'data' => array('title' => 'Новинки', 'url' => 'new')),
        );
        $page = (int) $_GET['page']; //текущая страница
        $count = count($itemsArray); //всего товаров
        $total = intval(($count - 1) / $this->countOfItems) + 1; //всего страниц
        if (empty($page) or $page < 0)
            $page = 1;
        if ($page > $total)
            $page = $total;
        $start = $page * $this->countOfItems - $this->countOfItems;

        $output = array_slice($itemsArray, $start, $this->countOfItems, true);

        /**
         * Если количество товаров выводимых на странице больше общего количества товаров:
         *      передаем в шаблон общее количество товаров, страницы не задаем
         *
         * Иначе:
         *      передаем в шаблон количество товаров выводимых на странице, задаем страницы
         */
        if ($this->countOfItems > $count) {
            $pages = '';
            $smarty->assign('countOfItems', $count);
        } else {
            $pages = $this->getPagination($page, $total);
            $smarty->assign('countOfItems', $this->countOfItems);
        }

        $smarty->assign('count', $count);
        $smarty->assign('pages', $pages);
        $pagination = ($count > 0) ? $smarty->fetch(api::setTemplate($this->tDir . "index/pagination.tpl")) : '';

        $smarty->assign('pagination', $pagination);

        foreach ($output as $key => $value) {
            if (isset($basket->basketArray[$value['item_id']])) {
                $output[$key]['inBasket'] = true;
            }
        }

        $smarty->assign('items', $output);
        $template = $smarty->fetch(api::setTemplate($this->tDir . "index/show.group.body.html"));
        $this->data['content'] = $template;
        $this->data['template'] = $this->mainTemplate;
        return true;
    }

    public function showHit($limitItems = 0, $isAction = false) {
        global $sql, $smarty, $basket;
        $itemsNewOnly = clone $sql;
        $itemsPrice = clone $sql;
        $itemsPhoto = clone $sql;
        $itemsArray = array();
		
		if ($limitItems != 0) {
			$extendedQuery = "limit 0,".$limitItems;
		} else {
			$extendedQuery = "";
		}
		
		if ($isAction == 1) {
			$whereCondition = " `is_hit` = 1 ";
		} else {
			$whereCondition = " `is_new` = 1 ";
		}

        $itemsNewOnly->query("SELECT `name`, `description`, `price_old`, `is_hit`, `is_new`, `parent_group_id`, `uri`, `item_id`, `id`, `price_old` FROM `shop_items` where ".$whereCondition." ".$extendedQuery);
        while ($row = $itemsNewOnly->next_row_assoc()) {

            $itemsPrice->query ("select `shop_prices`.`value` 
                from `shop_prices` 
                where `shop_prices`.`item_id` = '".$row['item_id']."'
                   " 
                    , true);
            
            //echo $itemsPrice->result['value'] . "|||";
            
            //$itemsPrice->query("SELECT `value` FROM `shop_prices` WHERE `item_id` = '" . $row['item_id'] . "'", true);
            $row['price'] = $itemsPrice->result['value'];
            //echo $itemsPrice->result['value']."||";

            //$itemsPhoto->query("SELECT `thumb` FROM `shop_itemimages` WHERE `description` = 'Основное' AND `item_id` = '" . $row['item_id'] . "'", true);
            $itemsPhoto->query("SELECT `thumb`, `filename` FROM `shop_itemimages` WHERE `item_id` = '" . $row['item_id'] . "'", true);
            $row['thumb'] = (!empty($itemsPhoto->result['filename']) ? 
            '/userfiles/catalog/1cbitrix/'.$itemsPhoto->result['filename'] : 
            "");
            #$row['filename'] = (!empty($itemsPhoto->result['filename']) ? $itemsPhoto['filename'] : "123");

            $groupUri = $this->getParentGroupUri($row['parent_group_id']);
            $row['uri'] = '/' . $groupUri . '/' . $row['uri'] . '/';
            array_push($itemsArray, $row);
        }

        $this->breadcrumbsArray = array(
            array('id' => 'new', 'parent' => 'new', 'data' => array('title' => 'Хиты продаж', 'url' => 'hit')),
        );

		$this->countOfItems = 10;
        if (isset($_GET['page']))
            $page = (int) $_GET['page']; //текущая страница
		else
			$page = 1;
        $count = count($itemsArray); //всего товаров
        $total = intval(($count - 1) / $this->countOfItems) + 1; //всего страниц
        if (empty($page) or $page < 0)
            $page = 1;
        if ($page > $total)
            $page = $total;
        $start = $page * $this->countOfItems - $this->countOfItems;

        $output = array_slice($itemsArray, $start, $this->countOfItems, true);

		//print_r ("output<br>\n");
		//print_r ($output);
		
        /**
         * Если количество товаров выводимых на странице больше общего количества товаров:
         *      передаем в шаблон общее количество товаров, страницы не задаем
         *
         * Иначе:
         *      передаем в шаблон количество товаров выводимых на странице, задаем страницы
         */
        if ($this->countOfItems > $count) {
            $pages = '';
            $smarty->assign('countOfItems', $count);
        } else {
            $pages = $this->getPagination($page, $total);
            $smarty->assign('countOfItems', $this->countOfItems);
        }

        $smarty->assign('count', $count);
        $smarty->assign('pages', $pages);
        $pagination = ($count > 0) ? $smarty->fetch(api::setTemplate($this->tDir . "index/pagination.tpl")) : '';

        $smarty->assign('pagination', $pagination);

        foreach ($output as $key => $value) {
            if (isset($basket->basketArray[$value['item_id']])) {
                $output[$key]['inBasket'] = true;
            }
        }



        $smarty->assign('items', $output);        
        if ($isAction == 1)
            $template = $smarty->fetch(api::setTemplate($this->tDir . "index/show.group.body.best.html"));
        elseif($isAction == 2)
            $template = $smarty->fetch(api::setTemplate($this->tDir . "index/show.group.body.new.html"));
        else
            $template = $smarty->fetch(api::setTemplate($this->tDir . "index/show.group.body.html"));
        $this->data['content'] = $template;
        $this->data['template'] = $this->mainTemplate;
		if ($limitItems == 0) $this->data['sortBox'] = $this->buildSortBox ($count, $pagination);
        return $template;
    }

	/**
	 *	Поиск по каталогу
	 *
	 *
	 */
	public function catalogSearch ($br=false) {		
		$onpage=$this->countOfItems;
		if ($br)
		{
			
		$br = $_GET['brand'];
		$br	= "and shop_itemproperties.name = 'Производитель' group by shop_prop_values.name ";
		}
		else $br='';
		
		
		#if (isset($_GET['onpage']))	$onpage=$_GET['onpage'];
			if (isset ($this->sortby)) {
				switch ($this->sortby) {
					default:						
					case "1":	// по цене
						$sortString = " order by `shop_prices`.`value` asc ";
					break;
					case "2":	// по популярности
						$sortString = " order by `shop_items`.`is_hit` desc, `shop_items`.`is_new` desc ";
					break;					
					case "3":	// по названию
						$sortString = " order by `shop_items`.`name` asc ";
					break;
				}
			} else {
				$sortString = " order by `shop_items`.`is_hit` desc, `shop_items`.`is_new` desc ";
			}
		
		if (isset ($_GET['s'])) 
			$_POST['catalogSearch'] = $_GET['s'];
					
		if (isset ($_POST['catalogSearch'])) 
		
		{
			global $sql, $smarty;
			
			$searchString = addslashes (strip_tags ($_POST['catalogSearch']));
            
			$searchString = preg_replace ("/[\s]{1,}/", "",$searchString);
			$arrSearch = explode (' ', $searchString);
//			foreach ($arrSearch as $key => $value) {
//				$arrSearch[$key] = $arrSearch[$key].'*';
//			}
//			$searchString = implode (' ', $arrSearch);
			
			$queryString = "select 
							COUNT(shop_items.id) as c
						from 
							`shop_items` 
					
						
						left join shop_props_assign	 on shop_items.item_id = shop_props_assign.item_id
						left join shop_prop_values	 on shop_props_assign.prop_val_id = shop_prop_values.value_id
						left join shop_itemproperties on shop_props_assign.prop_id = shop_itemproperties.prop_id
						where 1 and
						".$br." 
                            shop_items.`name` LIKE '%$searchString%' OR  shop_items.`description` LIKE '%$searchString%' "."  
";
			
			$sql->query ($queryString,true);
			
			@$page = (int) $_GET['page']; //текущая страница
            $count = ($sql->result['c']); //всего товаров
            $total = (intval(($count - 1) / $this->countOfItems) + 1); //всего страниц
     #      die($count);
            $queryString = "select 
							`shop_items`.*,
							`shop_prices`.value
						from 
							`shop_items` 
						left join shop_prices on shop_items.item_id =  shop_prices.item_id
						left join shop_props_assign	 on shop_items.item_id = shop_props_assign.item_id
						left join shop_prop_values	 on shop_props_assign.prop_val_id = shop_prop_values.value_id
						left join shop_itemproperties on shop_props_assign.prop_id = shop_itemproperties.prop_id
						where 1 and
						".$br." 
						
                           shop_items.`name` LIKE '%$searchString%' OR shop_items.`description` LIKE '%$searchString%'   group by shop_items.id ".$sortString." limit ".$page*$onpage." , ".($page+1)*$onpage;

			#die($queryString);
			$sql->query ($queryString);
           
           
            
			//print_r ($queryString);
							
			/*while ($sql->next_row ()) {
				
			}*/
			
			$arrResultQuery = $sql->getListAssoc (); 
			
			#print_r($arrResultQuery);
			#die();
			
			//print_r ($arrResultQuery);
			$itemsArray = array ();
			$itemsPrice = clone $sql;
			$itemsPhoto = clone $sql;
			//while ($row = $sql->next_row()) {				
			foreach ($arrResultQuery as $key => $row) {
                $itemsPrice->query("SELECT `value` FROM `shop_prices` WHERE `item_id` = '" . $row['item_id'] . "'", true);
				//print_r ($row);
//                $itemsPrice->query ("select `value` 
//                from `shop_prices` where `item_id` = '".$row['item_id']."'
//                " 
//                    , true);
//                
                $row['price'] = /*$itemsNewAndHit->result['value'];//*/$itemsPrice->result['value'];

                //$itemsPhoto->query("SELECT `thumb`, `filename` FROM `shop_itemimages` WHERE `description` = 'Основное' AND `item_id` = '" . $row['item_id'] . "'", true);
                $itemsPhoto->query("SELECT `thumb`, `filename` FROM `shop_itemimages` WHERE `item_id` = '" . $row['item_id'] . "' limit 1", true);
                $row['thumb'] = $itemsPhoto->result['thumb'];
                $row['photo'] = $itemsPhoto->result['filename'];
                $row['filename'] = $itemsPhoto->result['filename'];

                $groupUri = $this->getParentGroupUri($row['parent_group_id']);
                $row['uri'] = '/' . $groupUri . '/' . $row['uri'] . '/';
                array_push($itemsArray, $row);				
            }            			
			
          
            if (empty($page) or $page < 0)
                $page = 1;
            if ($page > $total)
                $page = $total;
            $start = $page * $this->countOfItems - $this->countOfItems;

            $output = $itemsArray;//array_slice($itemsArray, $start, $this->countOfItems, true);

            /**
             * Если количество товаров выводимых на странице больше общего количества товаров:
             *      передаем в шаблон общее количество товаров, страницы не задаем
             *
             * Иначе:
             *      передаем в шаблон количество товаров выводимых на странице, задаем страницы
             */
			
			// Формируем дополнительные параметры для строки get-запроса (для фильтров), а еще генерируем код для автоматического "зачекивания" в форме фильтра
			$additionalGetString = '';
			$filterItemsChecked = '';
			//print_r ($_GET['fsize']);
			if (isset ($_GET['fsize'])) {
				foreach ($_GET['fsize'] as $key => $value) {
					$additionalGetString .= "fsize[".$key."]"."=".$value."&";
					$filterItemsChecked .= "<span class='autoFilterCheck' style='display:none'>check_".$key."</span>";
				}				
			}
			if (isset ($_GET['fprice'])) {
				foreach ($_GET['fprice'] as $key => $value) {
					$additionalGetString .= "fprice[".$key."]"."=".$value."&";
					$filterItemsChecked .= "<span class='autoFilterCheck' style='display:none'>check2_".$key."</span>";
				}
			}
			 
            if ($this->countOfItems > $count) {
                $pages = '';
                $smarty->assign('countOfItems', $count);
            } else {
                $pages = $this->getPagination($page, $total);
                $smarty->assign('countOfItems', $this->countOfItems);
            }			
			
            $smarty->assign('count', $count);
            $smarty->assign('pages', $pages);
            $smarty->assign('s', (isset($_GET['s']) ? 's='.$_GET['s']:'' ));
			$smarty->assign('currpage', $page);
			$smarty->assign('additfstring', $additionalGetString);			
            $pagination = ($count > 0) ? $smarty->fetch(api::setTemplate($this->tDir . "index/pagination.tpl")) : '';

            //$smarty->assign('pagination', $pagination);


            $i = 1;

            foreach ($output as $key => $value) {

                if (isset($basket->basketArray[$value['item_id']])) {
                    $output[$key]['inBasket'] = true;
                }

                $output[$key]['num'] = $i;
                $i++;
                if ($i == 4)
                    $i = 1;
            }

            $smarty->assign('items', $output);
            

            $template = $smarty->fetch(api::setTemplate($this->tDir . "index/show.group.body.html"));
            $this->data['content'] = $template;
            
            $this->data['template'] = 'catalog.html';//$this->groupsTemplate;			
			$this->data['sortBox'] = $this->buildSortBox ($count, $pagination);
			$this->data['bottomPagination'] = $pagination;
			$this->data['filterItemsChecked'] = $filterItemsChecked;
           
           
            if (0==count($output))
            $this->data['content'] = '<div style="margin-top:-20px; padding:15px;" class="pr-box"><div class="pr-info">По вашему запросу ничего не найдено</div></div>';
            return true;
			
			
			
			
			$this->data['content'] = "catalogSearch";
			$this->data['template'] = "inner.html";
        } else {
            $this->data['content'] = '<div class="pr-box"><div class="pr-info">По вашему запросу ничего не найдено</div></div>';
			$this->indexShowGroup ('group1');
			$this->data['template'] = "catalog.html";
		}
	}

    public function showRootGroups($uri = '') {
        global $sql, $smarty, $basket;

        $groupsTree = $this->getGroupsTree();

        if (empty($uri)) {
            $groupsArray = $this->getGroupsArray($groupsTree, 0, -1);
            $smarty->assign('parent', '0');
        } else {

            $sql->query("SELECT `group_id` FROM `shop_groups` WHERE `uri` = '" . $uri . "'", true);
            $smarty->assign('parent', $sql->result['group_id']);
            $groupsArray = $this->getGroupsArray($groupsTree, $sql->result['group_id'], -1);
        }

        $i = 0;
        foreach ($groupsArray as $key => $value) {
            $groupsArray[$key]['num'] = $i;
            $i++;
            if ($i == 4) {
                $i = 0;
            };
        }

        $smarty->assign('groupsArray', $groupsArray);
        $this->data['content'] = $smarty->fetch(api::setTemplate($this->tDir . "index/show.groups.tpl"));
        $this->data['template'] = $this->mainTemplate;
    }

    private function getGroupsArray($tree, $parent, $level) {
        $level++;
        $childs = $tree->getChilds($parent);

        foreach ($childs as $k => $v) {
            $s[$v['id']]['id'] = $v['id'];
            $s[$v['id']]['title'] = $v['data']['title'];
            $s[$v['id']]['url'] = $v['data']['url'];
            $s[$v['id']]['thumb'] = $v['data']['thumb'];
            $s[$v['id']]['parent'] = $v['parent'];
            $s[$v['id']]['level'] = $level;

            if ($tree->hasChilds($v['id'])) {
                $s = array_merge($s, $this->getGroupsArray($tree, $v['id'], $level));
            }
        }
        return $s;
    }

    function indexShowGroup($uri) {
        global $sql, $smarty, $basket;

        //print_r($basket->basketArray);

        $sqlCurentGroupId = clone $sql;
        $itemsNewAndHit = clone $sql;
        $itemsHitOnly = clone $sql;
        $itemsNewOnly = clone $sql;
        $itemsNotNewNotHit = clone $sql;
        $itemsPrice = clone $sql;
        $itemsPhoto = clone $sql;

        $sqlCurentGroupId->query("SELECT `group_id`, `parent_group_id`, `name`, `image` FROM `shop_groups` WHERE `uri` = '" . $uri . "'", true);
        //print_r($sqlCurentGroupId->result);
        $this->data['pageTitle'] = $sqlCurentGroupId->result['name'];
		$this->data['groupImage'] = !empty ($sqlCurentGroupId->result['image']) ? "<img src='" . $sqlCurentGroupId->result['image'] . "' alt=''/>" : '';

        if ($sqlCurentGroupId->num_rows() < 1) {
            page404();
        } else {

            $groupsTree = $this->getGroupsTree();
            $this->breadcrumbsArray = array_reverse($this->createBreadcrumb($groupsTree, $sqlCurentGroupId->result['group_id'])); //хлебные крошки
            $arrayGroupsIdArray = $this->createTreeOfIds($groupsTree, $sqlCurentGroupId->result['group_id']);
            $arrayGroupsIdArray = array_unique($arrayGroupsIdArray);
            foreach ($arrayGroupsIdArray as $item) {
                $resultArray[] = '\'' . $item . '\'';
            }
            $stringOfIds = implode(',', $resultArray);
			#die(print_r($resultArray));
			// Опции сортировки
			if (isset ($this->sortby)) {
				switch ($this->sortby) {
					default:						
					case "1":	// по цене
						$sortString = " order by `shop_prices`.`value` asc ";
					break;
					case "2":	// по популярности
						$sortString = " order by `shop_items`.`is_hit` desc, `shop_items`.`is_new` desc ";
					break;					
					case "3":	// по названию
						$sortString = " order by `shop_items`.`name` asc ";
					break;
				}
			} else {
				$sortString = " order by `shop_items`.`is_hit` desc, `shop_items`.`is_new` desc ";
			}
			
			//print_r ($_GET['fsize']);
			//print_r ($_GET['fprice']);		 
			
			//print_r ($arrFSize);
			
			
			if (isset ($_GET['fnew'])) {
				$fpriceSearchString .= "and `shop_items`.`is_new` = 1 ";
			}
			
			if (isset ($_GET['fhit'])) {
				$fpriceSearchString .= "and `shop_items`.`is_hit` = 1 ";
			}
			
			
			
			$resultQuery = 			"SELECT 
										`shop_items`.`name`, 
										`shop_items`.`description`, 
										`shop_items`.`price_old`, 
										`shop_items`.`is_hit`, 
										`shop_items`.`is_new`, 
										`shop_items`.`parent_group_id`, 
										`shop_items`.`uri`, 
										`shop_items`.`item_id`, 
										`shop_items`.`id`,
										`shop_prices`.`value`,
										`shop_itemimages`.`filename`,
										`shop_itemimages`.`thumb`									
									FROM 
													`shop_items` 
									left outer join	`shop_prices` 	on	`shop_prices`.`item_id` = `shop_items`.`item_id`
									left outer join	`shop_itemimages`	on	`shop_itemimages`.`item_id` = `shop_items`.`item_id`
																							
									WHERE 
										`parent_group_id` in ($stringOfIds) 
										group by
										`shop_items`.`item_id`
										 ".
										$sortString. " ";
			
			
	
			

			
			#print_r ($resultQuery);
			
            $itemsArray = array();
            $itemsNewAndHit->query($resultQuery);
			
            while ($row = $itemsNewAndHit->next_row_assoc()) {
                $row['price'] = $itemsNewAndHit->result['value'];//$itemsPrice->result['value'];
                $itemsPhoto->query("SELECT `thumb`, `filename` FROM `shop_itemimages` WHERE `item_id` = '" . $row['item_id'] . "' limit 1", true);
                $row['thumb'] = $itemsPhoto->result['thumb'];
                $row['photo'] = $itemsPhoto->result['filename'];
                
                
							

                $groupUri = $this->getParentGroupUri($itemsNewAndHit->result['parent_group_id']);
                $row['uri'] = '/' . $groupUri . '/' . $row['uri'] . '/';
                array_push($itemsArray, $row);
            }            			
			
            @$page = (int) $_GET['page']; //текущая страница
            $count = count($itemsArray); //всего товаров
            $total = (intval(($count - 1) / $this->countOfItems) + 1); //всего страниц
            if (empty($page) or $page < 0)
                $page = 1;
            if ($page > $total)
                $page = $total;
            $start = $page * $this->countOfItems - $this->countOfItems;

            $output = array_slice($itemsArray, $start, $this->countOfItems, true);

            /**
             * Если количество товаров выводимых на странице больше общего количества товаров:
             *      передаем в шаблон общее количество товаров, страницы не задаем
             *
             * Иначе:
             *      передаем в шаблон количество товаров выводимых на странице, задаем страницы
             */
			
			// Формируем дополнительные параметры для строки get-запроса (для фильтров), а еще генерируем код для автоматического "зачекивания" в форме фильтра
			$additionalGetString = '';
			$filterItemsChecked = '';
			//print_r ($_GET['fsize']);
			if (isset ($_GET['fsize'])) {
				foreach ($_GET['fsize'] as $key => $value) {
					$additionalGetString .= "fsize[".$key."]"."=".$value."&";
					$filterItemsChecked .= "<span class='autoFilterCheck' style='display:none'>check_".$key."</span>";
				}				
			}
			if (isset ($_GET['fprice'])) {
				foreach ($_GET['fprice'] as $key => $value) {
					$additionalGetString .= "fprice[".$key."]"."=".$value."&";
					$filterItemsChecked .= "<span class='autoFilterCheck' style='display:none'>check2_".$key."</span>";
				}
			}
			 
            if ($this->countOfItems > $count) {
                $pages = '';
                $smarty->assign('countOfItems', $count);
            } else {
                $pages = $this->getPagination($page, $total);
                $smarty->assign('countOfItems', $this->countOfItems);
            }			
			
            $smarty->assign('count', $count);
            $smarty->assign('pages', $pages);
			$smarty->assign('currpage', $page);
			$smarty->assign('additfstring', $additionalGetString);			
            $pagination = ($count > 0) ? $smarty->fetch(api::setTemplate($this->tDir . "index/pagination.tpl")) : '';

            //$smarty->assign('pagination', $pagination);


            $i = 1;

            foreach ($output as $key => $value) {

                if (isset($basket->basketArray[$value['item_id']])) {
                    $output[$key]['inBasket'] = true;
                }

                $output[$key]['num'] = $i;
                $i++;
                if ($i == 4)
                    $i = 1;
            }

            $smarty->assign('items', $output);
            $template = $smarty->fetch(api::setTemplate($this->tDir . "index/show.group.body.html"));
            $this->data['content'] = $template;
            $this->data['template'] = $this->groupsTemplate;			
			$this->data['sortBox'] = $this->buildSortBox ($count, $pagination);
			$this->data['bottomPagination'] = $pagination;
			$this->data['filterItemsChecked'] = $filterItemsChecked;
            return true;
        }
    }
	
	private function buildSortBox ($itemsCount, $pagination) {
		global $sql;
		
		$result = '';
		
		//print_r ($pagination);
		
		$template = new template (api::setTemplate ($this->tDir . "index/show.sortbox.html"));
		$template->assign ('itemsFound', $itemsCount);
		$template->assign ('sortBoxPagination', $pagination);
		$template->assign ('countryselvalue', isset ($_SESSION['sortby']) && intval ($_SESSION['sortby'] > 0) ? intval ($_SESSION['sortby']) : 1);
		$template->assign ('country2selvalue', isset ($_SESSION['icount']) && intval ($_SESSION['icount'] > 0) ? intval ($_SESSION['icount']) : 20);
		
		$result = $template->get ();
		
		return $result;
	}

    private function getGroupsTree() {
        global $sql;
        $sql->query("SELECT `thumb` as 'thumb', `uri` as 'url', `group_id` as 'id', `name` as 'title', `parent_group_id` as 'parent', `position` as 'order' FROM `shop_groups`");

        while ($row = $sql->next_row_assoc()) {
            $array[] = $row;
        }

        $tree = new Tree();
        foreach ($array as $item) {
            $tree->addItem($item['id'], $item['parent'], array('title' => $item['title'], 'url' => $item['url'], 'thumb' => $item['thumb']), $item['order']);
        }
        return $tree;
    }

    public function getParentGroupUri($parent_group_id) {
        global $sql;
        $sql->query("SELECT `uri` FROM `shop_groups` WHERE `group_id` = '" . $parent_group_id . "'", true);
        $uri = $sql->result['uri'];
        return $uri;
    }

    public function showBreadcrumbs($array) {
        global $smarty;
        $count = (count($array) - 1);
        $smarty->assign('count', $count);
        $smarty->assign('array', $array);
        return $smarty->fetch(api::setTemplate($this->tDir . "index/breadcrumbs.tpl"));
    }

    private function createBreadcrumb($tree, $id) {
        $item[] = $tree->getItem($id);
        foreach ($item as $key => $value) {
            if ($value['parent'] != "0") {
                $item = array_merge($item, $this->createBreadcrumb($tree, $value['parent']));
            }
        }
        return $item;
    }

    /**
     * Формирование страниц для pagination.tpl
     *
     * @param $page
     * @param $total
     * @return mixed
     */
    private function getPagination($page, $total) {
        if ($page - 3 == 1) {
			$array[-2] = 1;
		}
		if ($page - 3 > 1) {
			$array[-1] = 1;
		}		
		if ($page - 2 > 0) {
			$array[] = $page-2;
		}
		if ($page - 1 > 0) {
			$array[] = $page-1;
		}
		$array[] = $page;
		if ($page + 1 <= $total) {
			$array[] = $page + 1;
		}
		if ($page + 2 <= $total) {
			$array[] = $page + 2;
		}
		if ($page + 3 == $total) {
			$array[999] = $total;
		}
		if ($page + 3 < $total) {
			$array[1000] = $total;
		}
		
		
		
		/*if ($page != 1)
            $array['prevpage'] = ($page - 1);
        if ($page - 2 > 0)
            $array['page2left'] = $page - 2;
        if ($page - 1 > 0)
            $array['page1left'] = $page - 1;
        $array['currentpage'] = $page;
        if ($page + 1 <= $total)
            $array['page1right'] = $page + 1;
        if ($page + 2 <= $total)
            $array['page2right'] = $page + 2;
        if ($page != $total)
            $array['nextpage'] = ($page + 1);*/
        return $array;
    }

    private function createTreeOfIds($tree, $parent) {
        if (!$tree->hasChilds($parent)) {
            $s[] = $parent;
        } else {
            $childs = $tree->getChilds($parent);
            $s[] = $parent;
            foreach ($childs as $k => $v) {
                $s[] = $v['id'];
                if (count($tree->getChilds($v['id'])) > 0) {
                    if ($tree->hasChilds($v['id'])) {
                        $s = array_merge($s, $this->createTreeOfIds($tree, $v['id']));
                    }
                }
            }
        }
        return $s;
    }

    public function showItemInfo($uri) {
        global $sql, $smarty, $ret;
        $sqlItemCheck = clone $sql;
        $sqlPrice = clone $sql;
        $sqlImages = clone $sql;
        $sqlMainImage = clone $sql;

        $array = array();
        $photoArray = array();

        $sqlItemCheck->query("SELECT `shop_items`.*, `shop_prices`.value , `price_old` FROM `shop_items`
		left outer join	`shop_prices`
		on
		`shop_prices`.`item_id` = `shop_items`.`item_id`
         WHERE `uri` = '" . $uri . "'", true);	
		
		#print_r($sqlItemCheck->result);
		$price=$sqlItemCheck->result['value'];
		$iid=$sqlItemCheck->result['id'];

		$description=$sqlItemCheck->result['description'];
		$price_old=@$sqlItemCheck->result['price_old'];
		#		DIE($price_old);	
		$this->data['title']=$sqlItemCheck->result['name'];
		$this->data['pageTitle']=$sqlItemCheck->result['name'];
		
        array_push($array, $sqlItemCheck->result);
		
		//print_r ($ret['uriGroup']);
		//print_r ($array);

        $sqlPrice->query("SELECT `value` FROM `shop_prices` WHERE `item_id` = '" . $sqlItemCheck->result['item_id'] . "'", true);
        $array[0]['price'] = $sqlPrice->result['value'];

        $sqlImages->query("SELECT `filename`, `thumb`, `description` FROM `shop_itemimages` WHERE `item_id` = '" . $sqlItemCheck->result['item_id'] . "' order by description desc");

        if ($sqlImages->num_rows() > 0) {
            while ($row = $sqlImages->next_row_assoc()) {
                array_push($photoArray, $sqlImages->result);
            }
        }

        $sqlMainImage->query("SELECT `filename`,`thumb` FROM `shop_itemimages` WHERE `item_id` = '" . $sqlItemCheck->result['item_id'] . "' limit 1", true);
        $photo = $sqlMainImage->result['filename'];
        $parentGroupUri = $this->getParentGroupUri($sqlItemCheck->result['parent_group_id']);
        $groupsTree = $this->getGroupsTree();
       # var_dump($groupsTree);
       # die($groupsTree);
        $this->breadcrumbsArray = array_reverse($this->createBreadcrumb($groupsTree, $sqlItemCheck->result['parent_group_id'])); //хлебные крошки
        #print_r($this->breadcrumbsArray);
        #die();
        $count = count($this->breadcrumbsArray);

        $this->breadcrumbsArray[$count]['id'] = $sqlItemCheck->result['item_id'];
        $this->breadcrumbsArray[$count]['parent'] = $sqlItemCheck->result['parent_group_id'];
        $this->breadcrumbsArray[$count]['data']['title'] = $sqlItemCheck->result['name'];
        $this->breadcrumbsArray[$count]['data']['url'] = $parentGroupUri . '/' . $sqlItemCheck->result['uri'] . '/';
		
        foreach ($sqlItemCheck->result as $key => $value) {
            if (!is_int($key)) {
                $smarty->assign($key, $value);
            }
        }
		$smarty->assign ('c_navigation', $this->showBreadcrumbs($this->breadcrumbsArray));

		$sql->query ("	select 
							`shop_itemproperties`.`name` as `propertyName`,
							`shop_prop_values`.`name` as `propertyValue`
						from 
										`shop_prop_values` 
							inner join 	`shop_itemproperties`
							inner join	`shop_props_assign`
							inner join	`shop_items`
						on 							
							`shop_props_assign`.`item_id` = `shop_items`.`item_id` and
							`shop_props_assign`.`prop_id` = `shop_itemproperties`.`prop_id` and
							`shop_props_assign`.`prop_val_id` = `shop_prop_values`.`value_id`	
						where
							`shop_items`.`uri` = '".$uri."'
							");
							
		$arrItemProps = array ();
		$arrItemProps = $sql->getListAssoc();
		$smarty->assign ("arrItemProps", $arrItemProps);
		//print_r ($arrItemProps);
			#foreach ($arrItemProps as $key => $value) {
			#if ($value['propertyName'] == "Состав ткани") {
			#	$smarty->assign ("itemFabric", $value['propertyValue']);
			#}
		#}
		
		$item_id = $array[0]['item_id'];
		//print_r ($item_id);
		$sql->query ("	select 	
								`shop_items`.`id`,
								`shop_items`.`item_id`, 
								`shop_items`.`name`, 
								`shop_prices`.`value`, 
								`shop_props_assign`.`prop_id`, 
								`shop_props_assign`.`prop_val_id`
						from 
												`shop_items`
									inner join 	`shop_prices` 
									inner join 	`shop_props_assign`
						on  `shop_items`.`item_id` = `shop_prices`.`item_id` and 
							`shop_items`.`item_id` = `shop_props_assign`.`item_id`
						where 	`shop_prices`.`pricetype_id` = (select `pricetype_id` from `shop_pricestypes` where `name` = 'розничный') and 
								`owner_id` = '".$item_id."' and
								`remains` > 0");//*/
						
		$arrItemsDescr = array ();
		//while ($sql->next_row ()) {
			$arrItemsDescr = $sql->getListAssoc ();
			
			
							$sqlProps = clone $sql;			
								$sqlProps->query("select shop_itemproperties.name, shop_prop_values.name
								from shop_props_assign
								left join shop_items 			on shop_props_assign.item_id 			= shop_items.item_id
								left join shop_itemproperties 	on shop_props_assign.prop_id 			= shop_itemproperties.prop_id
								left join shop_prop_values 		on shop_props_assign.prop_val_id 		= shop_prop_values.value_id
								where shop_items.item_id = '".$item_id."'");
				#				$value['props'] = $sqlProps->getList();
			$props = $sqlProps->getList();
		//}	
		
		$arrItems = array ();		
		foreach ($arrItemsDescr as $key => $value) {
			$arrItems[$value['item_id']][$value['prop_id']] = $value['prop_val_id'];
			// Сии строки написаны так ввиду того, что образ выгрузки представлен нам в не слишком удобном свете
			$arrItems[$value['item_id']]['price'] = $value['value'];
			$arrItems[$value['item_id']]['id'] = $value['id'];
			if (isset($arrItems[$value['item_id']]['Производитель'])) {
				$itemDeveloper = $arrItems[$value['item_id']]['Производитель'];
			}
			if (isset($arrItems[$value['item_id']]['Цвет'])) {
				$itemColor = $arrItems[$value['item_id']]['Цвет'];
			}
		
		
		
				#				$sqlProps = clone $sql;			
				#				$sqlProps->query("select shop_itemproperties.name, shop_prop_values.value
				#				from shop_props_assign
				#				left join shop_items on shop_props_assign.item_id = shop_items.itemid
				#				left join shop_itemproperties on shop_props_assign.prop_id = shop_itemproperties.prop_id
				#				left join shop_prop_values on shop_prop_values.prop_val_id = shop_prop_values.value_id
				#				where shop_items.id = '".$value['id']."'");
				#				$value['props'] = $sqlProps->getList();
		
		
		
		}
		
		// Формирование набора размеров
		$priceButtons = array  ();
		foreach ($arrItems as $key => $value) {
			// Два варианта подачи размеров в таблице (1 - рост/размер; 2 - размер (размер EU) размер а-ля XL)
				// Первый вариант подачи
			if (preg_match ("/^[0-9]{1,}\/([0-9]{1,})$/" , $value['Размер'], $matches)) {
				$tempVal = $matches[1];
			} else {
				// Второй вариант подачи
				$tempVal = substr($value['Размер'], 0, 2);
			}
			
			$priceButtons[] = array ($tempVal, $key, $value['price'], $value['id']); // Размер, ид товара (item_id), цена, id
		}
		sort ($priceButtons);
		//print_r ($arrItemsDescr);
		//print_r ($arrItems);
		//print_r ($priceButtons);
		
		if (isset($priceButtons[0])) {
			$startSize = isset ($priceButtons[0][0]) ? $priceButtons[0][0] : '';
			$startCost = isset ($priceButtons[0][2]) ? $priceButtons[0][2] : '';
			$startid = isset ($priceButtons[0][3]) ? $priceButtons[0][3] : '';
		} else {
			$startSize = '';
			$startCost = '';
			$startid = '';
		}
				
		$sql->query ("select 
						`testimonials`.`name`, 
						date_format(`testimonials`.`date`, '%d.%m.%Y - %H:%i') as `date`,
						`testimonials`.`text`, 
						`testimonials`.`rating`,
						`shop_users`.`name` as `username`						
					from 
									`testimonials` 
						inner join	`shop_users`
						on
							`testimonials`.`user_id` = `shop_users`.`id`
					where 
						`owner_id` = '" . $item_id . "' 
					order by
						`date` desc");
		$testimonialsContent = array ();		
		$testimonialsCount = 0;
		if ($sql->num_rows ()) {
			while ($sql->next_row ()) {
				$testimonialsContent[] = array ('name' => $sql->result['name'], 
												'username' => $sql->result['username'],
												'date' => $sql->result['date'], 
												'text' => $sql->result['text'], 
												'rating' => $sql->result['rating']);									
			}
			$testimonialsCount = $sql->num_rows ();
		}
		
		//print_r ($_SESSION);
		
		// Форма отправки отзыва только для зарегистрированных юзеров
		if (Security::$auth && !empty (Security::$userData)) {
			$showTestimonialForm = 1;
			$testimonialUserID = Security::$userData['id'];
			$testimonialItemID = $item_id;
		} else {
			$showTestimonialForm = 0;
			$testimonialUserID = -1;
			$testimonialItemID = '';
		}
		
		if (isset ($_SERVER['HTTP_REFERER']) && !preg_match ('/item/', $_SERVER['HTTP_REFERER'])) {
			//print_r ($_SERVER['HTTP_REFERER']);			
			/*$reffilter = explode ('?', $_SERVER['HTTP_REFERER']);
			if (isset ($reffilter[1])) {
				print_r ($reffilter[1]);
			}*/			
			$backToGroup = preg_replace ('/http:\/\/[a-zA-Z\-\_\.]{1,}/', '', $_SERVER['HTTP_REFERER']);			
		} else {
			$backToGroup = '/'.$ret['uriGroup'];
		}
		if (!isset($_SERVER['HTTP_REFERER']) || getenv('REQUEST_URI') == $backToGroup) {
			$backToGroup = '/'.$ret['uriGroup'];
		} 
		
		#$recommendations = $this->showHit (3, false);
		//$smarty->assign ('description', '123');
		//$smarty->assign ('arrItemsDescr', $arrItemsDescr);
		//print_r ($_SERVER['HTTP_REFERER']);
		//print_r (preg_replace ('/http:\/\/[a-zA-Z\-\_\.]{1,}/', '', $_SERVER['HTTP_REFERER']));
		$smarty->assign ('priceButtons', $priceButtons);		
		$smarty->assign ('backToGroup', $backToGroup);//isset ($_SERVER['HTTP_REFERER']) ? preg_replace ('/http:\/\/[a-zA-Z\-\_\.]{1,}/', '', $_SERVER['HTTP_REFERER']) : '/'.$ret['uriGroup']);
        $smarty->assign ('mainthumb', $sqlMainImage->result['thumb']);
        $smarty->assign ('mainfilename', $sqlMainImage->result['filename']);
        $smarty->assign ('price', $startCost);//$sqlPrice->result['value']);
      
		$smarty->assign ('itemid', $startid);
        $smarty->assign ('photos', $photoArray);
		$smarty->assign ('recommendations', @$recommendations);
		$smarty->assign ('testimonialsContent', $testimonialsContent);
		$smarty->assign ('testimonialsCount', $testimonialsCount);
		$smarty->assign ('showTestimonialForm', $showTestimonialForm);
		$smarty->assign ('userID', $testimonialUserID);
		$smarty->assign ('itemFullID', $testimonialItemID);
		$smarty->assign ('props', $props);
		$smarty->assign ('price', $price);
		$smarty->assign ('photo', $photo);
		$smarty->assign ('iid', $iid);
		$smarty->assign ('description', $description);
		$smarty->assign ('price_old', $price_old);
		
		if (isset ($itemDeveloper) && !empty($itemDeveloper)) {
			$smarty->assign ('itemDeveloper', $itemDeveloper);
		}

		if (isset ($itemColor) && !empty($itemColor)) {
			$smarty->assign ('itemColor', $itemColor);
		}

        $smarty->assign ("arrItemProps", $arrItemProps);
        $template = $smarty->fetch(api::setTemplate($this->tDir . "index/show.item.html"));
        
        $this->data['content'] = $template;
        $this->data['template'] = $this->itemsTemplate;
        return true;
    }

    private function getNavigationAndOtherInfo($ownerId) {
        global $sql;

        $sql->query("SELECT `id`, `ownerId`, `title`, `pageTitle`, `template`, `navigationShow`, `navigationMainTitle`, `md`, `mk`, `title_nav` FROM `#__#catalogGroups` WHERE `lang` = '" . $this->curLang . "'");

        $result = array();
        $treeResult = array();

        while ($sql->next_row())
            $result[$curId = $sql->result[0]] = $sql->result;

        if (!isset($ownerId)) {
            page500();
        }

        $forever = false;

        while ($ownerId != 0 && !$forever) {
            array_unshift($treeResult, $result[$ownerId]);
            $ownerId = $result[$ownerId]['ownerId'];

            $incr++;
            if ($incr > 10000)
                $forever = true;
        }

        $pageTitle = '';
        $template = '';
        $md = '';
        $mk = '';

        $navigation = new navigation();
        $navigation->setMainPage(empty($this->lang['navigationMainTitle']) ? api::getConfig("main", "api", "mainPageInNavigation") : $this->lang['navigationMainTitle']);

        if (!empty($this->lang['navigationTitle']))
            $navigation->add($this->lang['navigationTitle'], "/" . $this->mDir . "/index.php");
        $first = false;
        foreach ($treeResult as $key => $value) {
            if (!empty($treeResult[$key]['template']))
                $template = $treeResult[$key]['template'];
            if (!empty($treeResult[$key]['pageTitle']))
                $pageTitle = $treeResult[$key]['pageTitle']; //else $pageTitle=$treeResult[$key]['title'].' - Каталог';
            if (!empty($treeResult[$key]['md']))
                $md = $treeResult[$key]['md'];
            if (!empty($treeResult[$key]['mk']))
                $mk = $treeResult[$key]['mk'];
            if ($treeResult[$key]['navigationShow'] == 'y') {
                if ($treeResult[$key]['title_nav'] != true)
                    $treeResult[$key]['title_nav'] = $treeResult[$key]['title'];
                $navigation->add($treeResult[$key]['title_nav'], "/" . $this->mDir . "/" . $treeResult[$key][0] . "/showGroup.php");
                if (!$first)
                    $first = $treeResult[$key]['title_nav'];
            }

            if (!empty($treeResult[$key]['navigationMainTitle']))
                $navigationMainTitle = $treeResult[$key]['navigationMainTitle'];
        }


        return array($navigation->get(), $template, $pageTitle, $md, $mk, $first);
    }

    public function deleteGroup($id) {
        global $sql, $result;
        if (empty($id)) {
            $id = $this->getArray['id'];
        }

        $sqlGroup = clone $sql;
        $sqlGroupDelete = clone $sql;
        $sqlItems = clone $sql;
        $sqlSubGroups = clone $sql;


        $sqlGroup->query("SELECT * FROM `#__#shop_groups` WHERE `group_id` = '" . $id . "'", true); //выбираем данные о группе
        //проверяем если ли такая группа если есть то...
        if ($sqlGroup->num_rows() > 0) {
            $sqlGroupDelete->query("DELETE FROM `#__#shop_groups` WHERE `group_id` = '" . $id . "'");

            $routerCheck = api::routerCheck('catalog', null, $sqlGroup->result['uri']);
            if (isset($routerCheck['keyGroup']) > 0) {
                api::routerUpdate('catalog', 'group', $routerCheck['keyGroup'], $sqlGroup->result['uri'], 'delete');
            }


            $sqlItems->query("SELECT * FROM `#__#shop_items` WHERE `parent_group_id` = '" . $id . "'");
            while ($sqlItems->next_row()) {
                $this->deleteItem($sqlItems->result['item_id']);
            }

            $sqlSubGroups->query("SELECT * FROM `#__#shop_groups` WHERE `parent_group_id` = '" . $id . "'");
            if ($sqlSubGroups->num_rows() > 0) {
                while ($sqlSubGroups->next_row()) {
                    $this->deleteGroup($sqlSubGroups->result['group_id']);
                }
            }
        }
        message($this->lang['deleteOk']);
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

    public function photoDelete() {
        if (empty($this->postArray['uploaded'])) {
            if (is_dir('upload/thumbnails/')) {
                $dir = opendir('upload/thumbnails/');
                while ($file = readdir($dir)) {
                    $filenew = explode('.', $file);
                    if ($filenew[0] == $this->postArray['hash']) {
                        $filetodelete = $filenew[0] . '.' . $filenew[1];
                        echo $filetodelete;
                        unlink('upload/thumbnails/' . $filetodelete);
                    }
                }
                closedir($dir);
            } else {
                echo 'error';
            }
        }
    }

    public static function recacheUriOfItems($pathPrefix = '') {
        global $sql;
         $sql->query("update  shop_items set `uri` = CONCAT('item',id) where `uri` = ''");      
        
        $sqlGroupUri = clone $sql;
        $sql->query("SELECT `uri`, `parent_group_id` FROM `shop_items`");

        while ($row = $sql->next_row()) {
            $sqlGroupUri->query("SELECT `uri` FROM `shop_groups` WHERE `group_id` = '" . $row['parent_group_id'] . "'", true);
            $routerCheck = api::routerCheck('catalog', $sqlGroupUri->result['uri'], $row['uri'], $pathPrefix);
            if (!isset($routerCheck['keyItem'])) {
                api::routerUpdate('catalog', 'item', $routerCheck['keyGroup'], $row['uri'], 'add', $row['uri'], $pathPrefix);
            }
        }
    }


    private static function recacheUriOfGroups($pathPrefix = '') {
        global $sql;
        
        
        $sql->query("update  shop_groups set `uri` = CONCAT('group',id) where `uri` = ''");        
        $sql->query("SELECT `uri` FROM `shop_groups`");

        while ($row = $sql->next_row()) {			
            $routerCheck = api::routerCheck('catalog', null, $row['uri'], $pathPrefix);
            if (!isset($routerCheck['keyGroup'])) {				
                api::routerUpdate('catalog', 'group', 0, $row['uri'], 'add', false, $pathPrefix);
            }
        }
    }
    
    public function setItemHit() {
        global $sql;
        $sql->query("UPDATE `#__#shop_items` SET `is_hit` = '" . $this->postArray['value'] . "' WHERE `item_id` = '" . $this->postArray['itemid'] . "'");
        echo "Изменено";
    }

    public function setItemNew() {
        global $sql;
        $sql->query("UPDATE `#__#shop_items` SET `is_new` = '" . $this->postArray['value'] . "' WHERE `item_id` = '" . $this->postArray['itemid'] . "'");
        echo "Изменено";
    }

	
	public function showTag($id){ 
		global $sql, $smarty;
		 
		$sql->query("SELECT * FROM `tag_item` WHERE `id_tag` = '{$id}'");
		$brands = $sql->getListAssoc();
		$arr = array();
		foreach($brands as $item){
			$arr[] = "'".$item['id_item']."'";
		}
		if(empty($arr)){
			$this->data['content'] = 'Пусто';
			return true;
		}
		
		$queryString = "select  *    from  `shop_items`  where  `item_id` IN (".(implode(', ', $arr)).")";
		
		$sql->query ($queryString); 
		
		
		$arrResultQuery = $sql->getListAssoc (); 
		 
		//print_r ($arrResultQuery);
		$itemsArray = array ();
		$itemsPrice = clone $sql;
		$itemsPhoto = clone $sql;
		//while ($row = $sql->next_row()) {				
		foreach ($arrResultQuery as $key => $row) {
			$itemsPrice->query("SELECT `value` FROM `shop_prices` WHERE `item_id` = '" . $row['item_id'] . "'", true);
			//print_r ($row);
//                $itemsPrice->query ("select `value` 
//                from `shop_prices` where `item_id` = '".$row['item_id']."'
//                " 
//                    , true);
//                
			$row['price'] = /*$itemsNewAndHit->result['value'];//*/$itemsPrice->result['value'];

			//$itemsPhoto->query("SELECT `thumb`, `filename` FROM `shop_itemimages` WHERE `description` = 'Основное' AND `item_id` = '" . $row['item_id'] . "'", true);
			$itemsPhoto->query("SELECT `thumb`, `filename` FROM `shop_itemimages` WHERE `item_id` = '" . $row['item_id'] . "' limit 1", true);
			$row['thumb'] = $itemsPhoto->result['thumb'];
			$row['photo'] = $itemsPhoto->result['filename'];

			$groupUri = $this->getParentGroupUri($row['parent_group_id']);
			$row['uri'] = '/' . $groupUri . '/' . $row['uri'] . '/';
			array_push($itemsArray, $row);				
		}            			
		
		@$page = (int) $_GET['page']; //текущая страница
		$count = count($itemsArray); //всего товаров
		$total = (intval(($count - 1) / $this->countOfItems) + 1); //всего страниц
		if (empty($page) or $page < 0)
			$page = 1;
		if ($page > $total)
			$page = $total;
		$start = $page * $this->countOfItems - $this->countOfItems;

		$output = $itemsArray;//array_slice($itemsArray, $start, $this->countOfItems, true);

		/**
		 * Если количество товаров выводимых на странице больше общего количества товаров:
		 *      передаем в шаблон общее количество товаров, страницы не задаем
		 *
		 * Иначе:
		 *      передаем в шаблон количество товаров выводимых на странице, задаем страницы
		 */
		
		// Формируем дополнительные параметры для строки get-запроса (для фильтров), а еще генерируем код для автоматического "зачекивания" в форме фильтра
		$additionalGetString = '';
		$filterItemsChecked = '';
		//print_r ($_GET['fsize']);
		if (isset ($_GET['fsize'])) {
			foreach ($_GET['fsize'] as $key => $value) {
				$additionalGetString .= "fsize[".$key."]"."=".$value."&";
				$filterItemsChecked .= "<span class='autoFilterCheck' style='display:none'>check_".$key."</span>";
			}				
		}
		if (isset ($_GET['fprice'])) {
			foreach ($_GET['fprice'] as $key => $value) {
				$additionalGetString .= "fprice[".$key."]"."=".$value."&";
				$filterItemsChecked .= "<span class='autoFilterCheck' style='display:none'>check2_".$key."</span>";
			}
		}
		 
		if ($this->countOfItems > $count) {
			$pages = '';
			$smarty->assign('countOfItems', $count);
		} else {
			$pages = $this->getPagination($page, $total);
			$smarty->assign('countOfItems', $this->countOfItems);
		}			
		
		$smarty->assign('count', $count);
		$smarty->assign('pages', $pages);
		$smarty->assign('currpage', $page);
		$smarty->assign('additfstring', $additionalGetString);			
		$pagination = ($count > 0) ? $smarty->fetch(api::setTemplate($this->tDir . "index/pagination.tpl")) : '';

		//$smarty->assign('pagination', $pagination);


		$i = 1;

		foreach ($output as $key => $value) {

			if (isset($basket->basketArray[$value['item_id']])) {
				$output[$key]['inBasket'] = true;
			}

			$output[$key]['num'] = $i;
			$i++;
			if ($i == 4)
				$i = 1;
		}

		$smarty->assign('items', $output);
		$template = $smarty->fetch(api::setTemplate($this->tDir . "index/show.group.body.html"));
		$this->data['content'] = $template;
		$this->data['template'] = 'catalog.html';//$this->groupsTemplate;			
		$this->data['sortBox'] = $this->buildSortBox ($count, $pagination);
		$this->data['bottomPagination'] = $pagination;
		$this->data['filterItemsChecked'] = $filterItemsChecked;
		return true;
		
		
		
		
		$this->data['content'] = "catalogSearch";
		$this->data['template'] = "inner.html";
		 
	}
	
    function __construct() {
        global $_GET, $_POST, $_FILES, $sql, $_SESSION;

        if (isset($_SESSION[(string) ($this->mDir) . "_adm"]['returnPath'])) {
            $this->returnPath = &$_SESSION[(string) ($this->mDir) . "_adm"]['returnPath'];
        } else {
            $_SESSION[(string) ($this->mDir) . "_adm"]['returnPath'] = &$this->returnPath;
        }


        if (isset($_GET) && !empty($_GET)) {
            $this->getArray = api::slashData($_GET);
        }

        if (isset($_POST) && !empty($_POST)) {
            $this->postArray = api::slashData($_POST);
        }

        $this->filesArray = api::slashData($_FILES);

        $cfgValue = api::getConfig("modules", $this->mDir, "mainShow");
        {
            $this->mainShow = $cfgValue;
        }

        $cfgValue = api::getConfig("modules", $this->mDir, "itemsTemplate");
        {
            $this->itemsTemplate = $cfgValue;
        }

        $cfgValue = api::getConfig("modules", $this->mDir, "groupsTemplate");
        {
            $this->groupsTemplate = $cfgValue;
        }

        $cfgValue = api::getConfig("modules", $this->mDir, "defTemplate");
        {
            $this->mainTemplate = $cfgValue;
        }

        $cfgValue = api::getConfig("modules", $this->mDir, "countOfItems");
        if (!empty($cfgValue)) {
            $this->countOfItems = $cfgValue;
        }
        ;

        //$this->getTreeOnwerTreeArray();
        $this->sql = &$sql;

        return true;
    }

}

?>
