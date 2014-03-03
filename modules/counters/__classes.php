<?php
if (!defined("API")) {
	exit("Main include fail");
}

class counters {

  public $data	= array();

  private $mDir    = "counters";
  private $tDir    = "modules/counters/";

  private $getArray  		= array();
  private $postArray 		= array();
  private $filesArray		= array();

  public function showCounter() {
    global $sql;
	
	$sql->query("SELECT * FROM #__#counters WHERE count_id = '1'", true);
	
	$template = new template(api::setTemplate($this->tDir."counter.list.body.html"));
	@$this->data['fckFullTextForm']  = api::genFck("counterText",  $sql->result[0]);
	
	
	$template->assign("counterText", $sql->result[1]);
	$template->assign("fckFullTextForm", @$this->data['fckFullTextForm']);
	
	$this->data['content'] = $template->get();
  }
  
  public function editCounter() {
    global $sql;
    $sql->query("UPDATE #__#counters SET count_text = '".$this->postArray['counterText']."' WHERE count_id = '1'");
	
	message("Код изменен!", "", "admin/".$this->mDir."/count.php");
  }
  
  public function showText() {
    global $sql;
	
	$sql->query("SELECT * FROM #__#counters WHERE count_id > '1' ORDER BY count_id DESC");
	
	$template = new template(api::setTemplate($this->tDir."text.list.item.html"));
	
      while ($sql->next_row()) {
        $template->assign("text", "<a href=\"editTextShow.php?id=".$sql->result[0]."\">".$sql->result[2]."</a>");
        $template->assign("id", $sql->result[0]);
        @$body .= $template->get();
      }
		
	$template = new template(api::setTemplate($this->tDir."text.list.body.html"));
	$template->assign("body", @$body);
	
	$this->data['content'] = $template->get();
  }
  
  public function editTextShow() {
    global $sql;
	
	@$id = $this->getArray['id'];
	$sql->query("SELECT * FROM #__#counters WHERE count_id = '".$id."'", true);
	
	$template = new template(api::setTemplate($this->tDir."text.list.edit.item.html"));
	@$this->data['fckFullTextForm']  = api::genFck("contentText",  $sql->result[1]);
	
	$template->assign("fckFullTextForm", @$this->data['fckFullTextForm']);
	$template->assign("url", $sql->result[2]);
	$template->assign("id", $sql->result[0]);
	$template->assign("host", $_SERVER['HTTP_HOST']);
	
	$this->data['content'] = $template->get();
  }
  
  public function editText() {
    global $sql;
	
	@$id = $this->getArray['id'];
	if($id == true) {
      $sql->query("UPDATE #__#counters SET count_url = '".$this->postArray['url']."', count_pos = '".$this->postArray['pos']."', count_text = '".$this->postArray['contentText']."' WHERE count_id = '".$id."'");
	  message("Текст изменен!", "", "admin/".$this->mDir."/text.php");
	} else {
	  $sql->query("INSERT INTO #__#counters VALUES('', '".$this->postArray['contentText']."', '".$this->postArray['url']."', '".$this->postArray['pos']."')");
	  message("Текст добавлен!", "", "admin/".$this->mDir."/text.php");
	}
  }
  
  public function delText() {
    global $sql;
	
	@$id = $this->getArray['id'];
	$sql->query("DELETE FROM #__#counters WHERE count_id = '".@$id."'");
	message("Текст удален!", "", "admin/".$this->mDir."/text.php");
    
  }
  
  function __construct() {
    global $_GET, $_POST;
	
    $this->getArray		= api::slashData($_GET);
    $this->postArray 	= api::slashData($_POST);
  }

}