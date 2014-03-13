<?php
if (!defined("API")) {
	exit("Main include fail");
}
//print_r ("inc_pref = ".$includePrefix);
include_once((isset ($includePrefix) ? $includePrefix : '') . "include/classes/class.tree.php");

class page  {
	public $templateToSetView = "index.html";
    public $data = array();
    public $pagesTree	= array();
    public $breadcrumbsArray	= array();


	private $getArray	= array();
    private $postArray	= array();
    private $error = array();
	
	public static function installModule ($pathPrefix = '') {
		ini_set("display_errors", "on");	        
		page::recacheUriOfPages ($pathPrefix);        
		
		ini_set("display_errors", "on");
        return true;
	}
	
	private static function recacheUriOfPages ($pathPrefix = '') {
		global $sql;
        $sql->query("SELECT `uri` FROM `pages`");
        
        while ($row = $sql->next_row()) {
            $routerCheck = api::routerCheck('page', '', $row['uri'], null, $pathPrefix);
            if (!isset($routerCheck['keyGroup'])) {
                api::routerUpdate('page', 'group', 0, $row['uri'], 'add', false, $pathPrefix);
            }
        }
	}	
	
	public function addPage($assignArray = array(), $text = "", $defautSubPage = 0){
		global $smarty;
		
		if (isset($_GET['setOwnerId'])) {
			$defautSubPage = intval($_GET['setOwnerId']);
		}else{
            $defautSubPage = 0;
        }

        $smarty->assign("error", $this->error);
		foreach ($assignArray as $key=>$value) {
			$smarty->assign($key, $value);
		}
		
		$editorForm = new FCKeditor('text') ;
        $editorForm->Value = $text ;
        $editorForm->Height = 450;
        $textForm=$editorForm->CreateHtml();

 		$smarty->assign("selectOwnerPage",	$this->genSelectOwnerPage($defautSubPage));
 		$smarty->assign("fckFormText",		$textForm);		
		
		$template = $smarty->fetch(api::setTemplate('modules/page/admin/add.page.html'));
        return $template;
	}
    
    function genImage()
    {
        $image = new image();
        $image_name = $image->genFileName();
        $filename = NULL;
        if 
            ($filename = $image->resizeEx(
                                           $_FILES['filename']['tmp_name'],
                                           $image_name,     array('userfiles/',
                                                                  73,
                                                                  85
                                                                 ),
                                           true,
                                           false,
                                           false))
        
        return $filename;


    }

	public function addGo(){
        global $sql;

        if (!($this->checkPagePostData())){
            return $this->addPage($this->postArray, strip($this->postArray['text']));
        }

        $sql->query("SELECT COUNT(*) as 'count' FROM `#__#pages` WHERE `ownerId` = '".$this->postArray['ownerId']."'", true);
        $position = $sql->result['count'];

        $uri = $this->uriCheck($this->postArray['uri']);
        $this->postArray['image']=$this->genImage();
        $sql->query("INSERT INTO #__#pages (
											`ownerId`,
											`title`,
											`uri`,
											`template`,
											`redirect`,
											`text`,
											`md`,
											`mk`,
											`pageTitle`,
											`position`,
                                            `image`,
                                            `onmain`,
                                            `shorttext`
											) values (
														'".$this->postArray['ownerId']."',
														'".$this->postArray['title']."',
														'".$uri."',
														'".$this->postArray['template']."',
														'".$this->postArray['redirect']."',
														'".$this->postArray['text']."',
														'".$this->postArray['md']."',
														'".$this->postArray['mk']."',
														'".$this->postArray['pageTitle']."',
														'".$position."',
														'".$this->postArray["image"]."',
														'".$this->postArray["onmain"]."',
														'".$this->postArray["shorttext"]."'
                                                        )");

        api::routerUpdate('page', 'group', null, $this->postArray['uri'], 'add');
        message('Страница "'.$this->postArray['title'].'" успешно создана', "", "/admin/page/index.php");
    }

	private function checkPagePostData() {
        global $admLng;

        if(empty($this->postArray['title'])){$this->error[] = $admLng['noTitle'];}
        if(empty($this->postArray['uri'])){$this->error[] = $admLng['noUri'];}
    	if (!preg_match("/^[a-z0-9_\.]*$/ui", $this->postArray['template'])){$this->error[] = $admLng['invalidTemplate'];}

        if(!empty($this->error)){
            return false;
        }else{
            return true;
        }
	}
    
    public function get_pages($id = false,$params = array())
    {
        global $API, $sql, $smarty;
        
        $template = clone $smarty;

        $sql_ = clone $sql;
        $query_params = '';
        foreach ($params as $row=>$value) $query_params.= " `{$row}` = '{$value}' "; 

        $query =  "select * from pages where {$query_params} ";
        $sql_->query($query);
        $data = $sql_->getList();
        
        
        include_once("modules/page/__classes.php"); 
        $template->assign("items",$data);
        return $template->fetch(api::setTemplate("modules/page/items.main.tpl"));

        /* Варианты:
         * 1) одна запись
         * 2) записи по условию
         * 3) все записи
         */

     }




	private function genSelectOwnerPage($defaultValue, $id='') {
		global $smarty;

        $tr = $this->getTree($this->pagesTree, 0, -1);
        $tr2 = $this->getTree($this->pagesTree, $id, -1);

        $arr = array();
        foreach($tr as $key=>$value){
            $arr[$value['id']] = $value;
            $arr[$value['id']]['del'] = str_repeat("-", ($arr[$value['id']]['level'] * 2));
        }

        if(!empty($id)){
            unset($arr[$id]);
            foreach($tr2 as $key=>$value){
                unset($arr[$value['id']]);
            }
        }

        $smarty->assign('defaultValue', $defaultValue);
        $smarty->assign('pages', $arr);
        $template = $smarty->fetch(api::setTemplate('modules/page/admin/pages.tree.for.select.list.html'));
        return $template;
	}

	public function editPage($id, $dataArray=array()){
		global $sql, $smarty;

        $sql->query("SELECT `title`, `uri`, `template`, `redirect`, `md`, `mk`, `ownerId`, `text`, `pageTitle`, `image`, `onmain`, `shorttext` FROM #__#pages WHERE `id` = '".$id."'", true);
        if ($sql->num_Rows() == 0) {
            page404();
        }


        if(!empty($dataArray)){
            foreach ($dataArray as $key => $value){
                if(!is_int($key)){
                    $smarty->assign($key, strip($value));
                }
            }
        }else{
            foreach ($sql->result as $key => $value){
                if(!is_int($key)){
                    $smarty->assign($key, $value);
                }
            }
        }

        $editorForm = new FCKeditor('text') ;
        $editorForm->Value = isset ($dataArray['text']) ? $dataArray['text'] : $sql->result['text'] ;
        $editorForm->Height = 450;
        $textForm=$editorForm->CreateHtml();


        $editorForm2 = new FCKeditor('shorttext') ;
        $editorForm2->Value = isset ($dataArray['shorttext']) ? $dataArray['shorttext'] : $sql->result['shorttext'] ;
        $editorForm2->Height = 450;
        $textForm2=$editorForm2->CreateHtml();



        $smarty->assign("selectOwnerPage",	$this->genSelectOwnerPage($sql->result['ownerId'], $id));
        $smarty->assign("fckFormText",		$textForm);
        $smarty->assign("fckFormText2",		$textForm2);
        $smarty->assign("id", $id);
        $smarty->assign("title", $sql->result['title']);

        $template = $smarty->fetch(api::setTemplate('modules/page/admin/edit.page.html'));
        return $template;

	}

	public function editGo() {
		global $sql, $_POST, $_FILES, $admLng;

        foreach ($this->postArray as $key=>$value){
            $dataArray[$key] = $value;
        }

        if (!($this->checkPagePostData())) {
			 return $this->editPage($dataArray['id'], $dataArray);
		}


		$sql->query("UPDATE #__#pages SET
										`ownerId` = '".$this->postArray['ownerId']."',
										`title` = '".$this->postArray['title']."',
										`template` = '".$this->postArray['template']."',
										`redirect` = '".$this->postArray['redirect']."',
										`text` = '".$this->postArray['text']."',
										`md` = '".$this->postArray['md']."',
										`mk` = '".$this->postArray['mk']."',
										`pageTitle` = '".$this->postArray['pageTitle']."',
										`onmain` = '".$this->postArray['onmain']."',
										`shorttext` = '".$this->postArray['shorttext']."'
                                        
                                        WHERE
										`id` = '".intval($this->postArray['pageId'])."'
										");
         
         $fname = @$this->postArray['image']=$this->genImage();
         if ($fname) 
            $sql->query("UPDATE pages set `image` = '{$fname}' where id = '".intval($this->postArray['pageId'])."'");


	message($admLng['page']." &laquo;".$this->postArray['title']."&raquo; ".$admLng['editOk'], "", "/admin/page/index.php");

	}

	public function posChange(){
        global $sql;
        $sql->query("UPDATE #__#pages SET `position` = '".intval($_POST['value'])."' WHERE id ='".intval($_POST['id'])."'");
        echo $this->listPages();
    }


    private function getTree($tree, $parent, $level){
            $level++;
            $childs = $tree->getChilds($parent);
            $s = array ();
            foreach ($childs as $k => $v) {
                $s[$v['id']]['id'] = $v['id'];
                $s[$v['id']]['title'] = $v['data']['title'];
                $s[$v['id']]['url'] = $v['data']['url'];
                $s[$v['id']]['position'] = $v['data']['position'];
                $s[$v['id']]['parent'] = $v['parent'];
                $s[$v['id']]['level'] = $level;

                if ($tree->hasChilds($v['id'])) {
                    $s = array_merge($s, $this->getTree($tree, $v['id'], $level));

                }
            }
        return $s;
    }

    /**
     * Выводим список страниц
     *
     * 1. выбираем все страницы из page
     * 2. формируем дерево tree
     * 3. передаем в цикле элементы дерева в шаблон item
     * 4. передаем содержимое item в body
     *
     * @return bool|mixed|string
     */
    public function listPages() {
  		global $sql, $smarty;
        $arr = array();
        $tr = $this->getTree($this->pagesTree, 0, -1);
        $arr = array();
        
		foreach($tr as $key=>$value){
            array_push($arr, $value);
        }

		
        $smarty->assign('pages', $arr);
        $body = $smarty->fetch(api::setTemplate('modules/page/admin/list.pages.item.html'));
        $smarty->assign('body', $body);
        $template = $smarty->fetch(api::setTemplate('modules/page/admin/list.pages.body.html'));
        return $template;
	}

    public function uriCheckAjax()
    {
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


    public function uriCheck($uri)
    {
        global $sql, $API;
        $uri = $this->postArray['uri'];
        $array = (api::uriCheck($uri));

        $table = 'pages';

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

    private function uCheck($uri)
    {
        $ret = false;
        $array = (api::uriCheck($uri));
        if (!empty($array)) {
            $ret = true;
        }
        return $ret;
    }

    private function getPagesTree(){
       global $sql;

        $sql->query("SELECT `id`, `ownerId`, `uri`, `position`, `title` FROM `pages` ORDER by `position` ASC");
        while($row = $sql->next_row_assoc()){
            $arr[$sql->result['id']] = $sql->result;
        }
        
        $tree = new Tree();
        if (!empty ($arr)) {
            foreach ($arr as $item) {
                $tree->addItem($item['id'], $item['ownerId'], array('title' => $item['title'], 'url' => $item['uri'], 'position'=>$item['position']), $item['position']);
            }
        }

       return $tree;
    }

    private function createBreadcrumb($tree, $id)
    {
        $item[] = $tree->getItem($id);
        foreach ($item as $key => $value) {
            if ($value['parent'] != '0') {
                $item = array_merge($item, $this->createBreadcrumb($tree, $value['parent']));
            }
        }
        return $item;
    }

    public function showBreadcrumbs($array){
        global $smarty;
        $count = (count($array) - 1);
        $smarty->assign('count', $count);
        $smarty->assign('array', $array);
        return $smarty->fetch(api::setTemplate("modules/page/index/breadcrumbs.tpl"));
    }


    function __construct($uri='') {
		global $_GET, $sql, $admLng;

        if (isset($_GET) && !empty($_GET)) {
            $this->getArray = api::slashData($_GET);
        }

        if (isset($_POST) && !empty($_POST)) {
            $this->postArray = api::slashData($_POST);
        };

        $this->pagesTree = $this->getPagesTree();

        if(!empty($uri)){

            $sql->query("SELECT `title`, `uri`, `template`, `navigationShow`, `navigationTitle`, `redirect`, `text`, `md`, `mk`, `id`, `pageTitle` FROM #__#pages WHERE `uri` = '".$uri."'",true);
            foreach($sql->result as $key=>$value){
                if(!is_int($key)){
                    $this->data[$key] = $value;
                }
            }
            $sql2 = clone $sql;
            $sql2->query('select * from pages where `ownerId` = "'.$sql->result['id'].'"');
            foreach ( $sql2->getList() as $row) $this->data['child'][]=$row;


            $this->pagesTree = $this->getPagesTree();
            $this->breadcrumbsArray = array_reverse($this->createBreadcrumb($this->pagesTree, $this->data['id']));
        }
	}
}
?>
