<?php
if (!defined("API")) {
	exit("Main include fail");
}

$stat = new stat();
$stat->lang		= $lng;
$stat->curLang	= $lang;

switch ($rFile) {
	case "img.php":
		$stat->showImg();
	break;

	default:
		page404();
	break;
}




?>

