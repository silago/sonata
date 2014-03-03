<?php
if (!defined("API")) {
	exit("Main include fail");
}

$accounts = new accounts();
$accounts->lang = $l;
$accounts->curLang = $lang;

switch ($uri[2]) {	case "register":
		$accounts->register();
	break;

	case "regpost":
	    $accounts->regpost();
	break;

	case "regcode":
	    $accounts->regcode();
	break;

	case "rcode":
	    $accounts->rcode();
	break;

	case "enter":
	    $accounts->enter();
	break;

	case "recovery":
	    $accounts->recovery();
	break;

	case "profile":
	    $accounts->profile();
	break;

	case "password":
	    $accounts->password();
	break;

	case "out":
	    $accounts->out();
	break;

	default:
		page404();
	break;
}


@$API['content'] 	 = $accounts->data['content'];
@$API['pageTitle']	 = $accounts->data['pageTitle'];
@$API['navigation']  = $accounts->data['navigation'];
@$API['title']      .= ' | '.$accounts->data['pageTitle'];

@$API['template'] = 'ru/accounts.html';



?>