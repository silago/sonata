<?php
if (!defined("API")) {
	exit("Main include fail");
}

$counters = new counters();
$counters->lang = $l;
$counters->curLang = $lang;


switch ($rFile) {
	case "count.php":
		$counters->showCounter();
	break;
	
	case "editCounter.php":
		$counters->editCounter();
	break;
	
	case "text.php":
		$counters->showText();
	break;
	
	case "editTextShow.php":
		$counters->editTextShow();
	break;
	
	case "editText.php":
		$counters->editText();
	break;
	
	case "delText.php":
		$counters->delText();
	break;

	default:
		page404();
	break;
}

$API['content'] = $counters->data['content'];

?>

