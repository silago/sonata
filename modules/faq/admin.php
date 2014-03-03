<?php
if (!defined("API")) {
	exit("Main include fail");
}

$faq = new faq();
$faq->lang = $l;
$faq->curLang = $lang;


switch ($rFile) {	case "index.php":
		$faq->adminList();
	break;

	case "edit.php":
		if (!isset($_POST['go']) || $_POST['go'] !== "go") $faq->adminEdit(); else $faq->adminEditGo();
	break;

	case "delete.php":
		$faq->adminDelete();
	break;

	default:
		page404();
	break;}

$API['content'] = $faq->data['content'];

?>

