<?php
if (!defined("API")) {
	exit("Main include fail");
}

$moduleDir = dirname(__FILE__);

$fb = new fb();
$fb->curLang = $lang;
$fb->lang    = $lng;

switch ($rFile) {
	case "index.php":
		$fb->showFbForm();
	break;

	case "send.php":
		$fb->sendFb();
	break;

	default:
		page404();
	break;
}

// Setting up out data (All modelu support)
$md = api::getConfig("modules", "fb", "md");
$mk = api::getConfig("modules", "fb", "mk");
$navigationMainTitle   = $lng['navigationMainTitle'];
@$navigationTitle      = $lng['navigationTitle'];

$nClass = new navigation();
$nClass->setMainPage((!empty($navigationMainTitle) ? $navigationMainTitle : api::getConfig("main", "api", "mainPageInNavigation")), $base."/index.php");
if (!@empty($lng['navigationTitle'])) $nClass->add($lng['navigationTitle'], $base."/fb/index.php");

@$API['navigation']  = $nClass->get();
@$API['pageTitle']	 = $lng['pageTitle'];
@$API['content']     = $fb->data['content'];


@$API['md'] = (!empty($mk) ? $mk : $API['md']);
@$API['mk'] = (!empty($mk) ? $mk : $API['mk']);



?>