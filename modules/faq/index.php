<?php
if (!defined("API")) {
	exit("Main include fail");
}

$faq = new faq();
$faq->lang = $l;
$faq->curLang = $lang;

switch ($rFile) {	case "index.php":
		$faq->show();
	break;

	case "ask.php":
		$faq->ask();
	break;

	default:
		page404();
	break;
}

// Setting up out data (All modelu support)
$md = api::getConfig("modules", "faq", "md");
$mk = api::getConfig("modules", "faq", "mk");
$navigationMainTitle = $lng['navigationMainTitle'];
@$navigationTitle      = $lng['navigationTitle'];

$nClass = new navigation();
$nClass->setMainPage((!empty($navigationMainTitle) ? $navigationMainTitle : api::getConfig("main", "api", "mainPageInNavigation")), $base."/index.php");
if (!@empty($lng['navigationTitle'])) $nClass->add($lng['navigationTitle'], $base."/faq/index.php");


@$API['content'] 	= $faq->data['content'];
@$API['pageTitle']	= $lng['pageTitle'];
@$API['navigation']  = $nClass->get();

@$API['md'] = (!empty($mk) ? $mk : $API['md']);
@$API['mk'] = (!empty($mk) ? $mk : $API['mk']);



?>