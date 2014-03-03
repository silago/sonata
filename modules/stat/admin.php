<?php
if (!defined("API")) {
	exit("Main include fail");
}

$stat = new stat();
$stat->lang		= $admLng;
$stat->curLang	= $lang;

switch ($rFile) {
	case "index.php":
		$stat->showStat();
	break;

	case "update.php":
		$stat->updateCounryDatabase();
	break;

	default:
		page404();
}


@$API['content'] = $stat->return['content'];


?>
