<?php

if (!defined("API")) {
    exit("Main include fail");
}

class banners {

    public $page_title = '';
    public $lang = "";
    public $assignArray = array();
    public $data = array();
    public $postData = array();
    public $getData = array();
    private $filesArray = array();
    private $error = '';
    private $table_name = 'banners';
    private $mDir = 'banners';
    private $valueText = '';

    public function adminAddOrEditForm() {
        $template = new template(api::setTemplate('modules/' . $this->mDir . '/admin.add.form.html'));

        $this->assignArray['action'] = (isset($this->data['id']) && !empty($this->data['id']) ? $this->lang['edit'] : $this->lang['add']);
        $this->assignArray['error'] = (!empty($this->error) ? '<h4 class="alert_error">' . $this->error . '</h4>' : '');

        $this->assignArray();

        $wwgForm = new FCKEditor("wwgForm");
        $wwgForm->Value = $this->valueText;
        $wwgForm->Height = 300;
        $wwgForm->Width = 800;

        $this->assignArray['wwgForm'] = $wwgForm->createHtml();

        foreach ($this->assignArray as $key => $value) {
            $template->assign($key, strip($value));
        }



        $this->data['content'] = $template->get();
        $this->page_title = $this->lang['edit'];
        
        return true;
    }

    public function adminAddGo() {
        global $_POST, $_GET, $sql;

        $this->data['id'] = @(int) $_GET['id'];
        $this->data['title'] = @$_POST['title'];
        $this->data['text'] = @$_POST['wwgForm'];
        $this->data['place'] = @$_POST['place'];
		$this->data['section'] = @$_POST['section'];
		
        
        if (empty($this->data['title'])) {
            $this->error = $this->lang['emptyTitle'];
            return $this->adminAddOrEditForm();
        }

        if (empty($this->data['id'])) {
            $sql->query("INSERT INTO " . $this->table_name . " (`title`, `text`, `place`, `section`) VALUES ('" . $this->data['title'] . "', '" . $this->data['text'] . "', '" . $this->data['place'] . "','" . $this->data['section']. "' )");

            message($this->lang['addOk'], "", "admin/" . $this->mDir . "/index.php");
        } else {
            $sql->query("UPDATE " . $this->table_name . " SET 
														`title` = '" . $this->data['title'] . "', 
														`text` = '" . str_replace("'",'"',$this->data['text']) . "', 
														`place` =  '" . $this->data['place'] . "',
														`section` =  '" . $this->data['section'] . "' 
														
													   WHERE `id` = '" . $this->data['id'] . "'");
        }

        message($this->lang['editOk'], "", "admin/" . $this->mDir . "/index.php");
        return true;
    }

    public function adminEdit($id) {
        global $sql;

        if ($id < 1) {
            page500();
        }

        $sql->query("SELECT * FROM " . $this->table_name . " WHERE `id` = '" . $id . "'", true);

        if ((int) $sql->num_rows() !== 1) {
            page500();
        }


        $this->data['id'] = $id;
        $this->data['title'] = $sql->result['title'];
        $this->data['text'] = $sql->result['text'];
		$this->data['section'] = $sql->result['section'];
        $this->data['place'] = $sql->result['place'];
		
        $this->assignArray();

        $this->adminAddOrEditForm();
    }

    public function adminList() {
        global $sql;

        $sql->query("SELECT `id`, `title` from " . $this->table_name . " ORDER BY `id` DESC");

        $template = new template(api::setTemplate('modules/' . $this->mDir . '/admin.list.item.html'));

        $body = "";
        while ($sql->next_row()) {
            $template->assign('id', $sql->result[0]);
            $template->assign('title', $sql->result[1]);
            $body .= $template->get();
        }
        $template = new template(api::setTemplate('modules/' . $this->mDir . '/admin.list.body.html'));
        $template->assign('body', $body);
        
        $this->data['content'] = $template->get();
        $this->page_title = $this->lang['list'];
        
        return true;
    }

    public function adminDelete($id) {
        global $sql;

        $sql->query("DELETE FROM " . $this->table_name . " WHERE `id` = '" . $id . "'");

        message($this->lang['deleteOk'], "", "admin/" . $this->mDir . "/index.php");
    }

    private function assignArray() {
        @$this->valueText = $this->data['text'];
        foreach ($this->data as $key => $value) {
            $this->assignArray[$key] = $value;
        }
        return true;
    }

    function __construct() {
        //
    }

}

?>
