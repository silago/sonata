<?php
// Search Module
// Search enenginare in modules
//		- page
//		- catalog

// ALTER TABLE `pages` ADD FULLTEXT(`title`, `text`);
// ALTER TABLE `catalog` ADD FULLTEXT(`title`, `smallText`, `fullText`);

if (!defined("API")) {
	exit("Main include fail");
}

@$searchIn 		= api::slashData($_POST['searchIn']);
@$searchString	= str_replace(" ", "* ", api::slashData($_POST['searchString']."*"));

if ($rFile !== "result.php") {
	page404();
}

require_once("modules/page/__classes.php");
$page 		= new page();
$API['content'] = "";

$sql->query("SELECT `id`, `title`, SUBSTRING(`text`, 1, 300), '' FROM `#__#pages` WHERE MATCH (`title`, `text`) AGAINST('".$searchString."'  IN BOOLEAN MODE)");

$body = "";
if ($sql->num_rows() !== 0) {
	while ($sql->next_row()) {
		$template = new template(api::setTemplate("modules/search/index.showResult.item.html"));
		$template->assign("url", $page->getPageUrl($sql->result[0]));
		$template->assign("title", $sql->result[1]);
		$template->assign("smallText", strip_tags($sql->result[2]));
		$body .= $template->get();
	}

	$template = new template(api::setTemplate("modules/search/index.showResult.body.html"));
	$template->assign("body", $body);
	$API['content'] = $template->get();
}


// MaximatoR

$sql->query("SELECT `id`, `title`, SUBSTRING(`descript`, 1, 300), '' FROM `#__#catalogGroups` WHERE MATCH (`title`, `descript`) AGAINST('".$searchString."'  IN BOOLEAN MODE)");

$body = "";
if ($sql->num_rows() !== 0) {
	while ($sql->next_row()) {
		$template = new template(api::setTemplate("modules/search/index.showResult.item.html"));
		$template->assign("url", "/catalog/".$sql->result[0]."/showGroup.php");
		$template->assign("title", $sql->result[1]);
		$template->assign("smallText", strip_tags($sql->result[2]));
		$body .= $template->get();
	}

	$template = new template(api::setTemplate("modules/search/index.showResult.body.html"));
	$template->assign("body", $body);
	$API['content'] = $template->get();
}

// / MaximatoR

$sql->query("SELECT `id`, `title`, SUBSTRING(`fullText`, 1, 300) FROM `#__#catalog` WHERE MATCH (`title`, `smallText`, `fullText`) AGAINST('".$searchString."'  IN BOOLEAN MODE)");

$body = "";
if ($sql->num_rows() !== 0) {
	while ($sql->next_row()) {
		$template = new template(api::setTemplate("modules/search/index.showResult.item.html"));
		$template->assign("url", "/catalog/".$sql->result[0]."/showInfo.php");
		$template->assign("title", $sql->result[1]);
		$template->assign("smallText", strip_tags($sql->result[2]));
		$body .= $template->get();
	}

	$template = new template(api::setTemplate("modules/search/index.showResult.body.html"));
	$template->assign("body", $body);
	@$API['content'] .= $template->get();
}

if (empty($API['content'])) {
	$API['content'] = $lng['emptyResult'];
}


$navigation = new navigation();

$navigation->setMainPage(!empty($lng['navigationMainTitle']) ? $lng['navigationMainTitle'] : api::getConfig("main", "api", "mainPageInNavigation"));
$navigation->add($lng['navigationTitle'], "/index.php");

$API['title'] 		= $API['title']." | ".$lng['pageTitle'];
$API['pageTitle'] 	= $lng['pageTitle'];
$API['navigation']  = $navigation->get();

?>