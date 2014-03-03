<?php
if (!defined("API")) {
	exit("Main include fail");
}

$testimonials = new testimonials();

switch ($rFile) {

    case "installmodule.php":
		if (testimonials::installModule ()) $testimonials->data['content'] = "<p>Модуль установлен</p>";
        else $testimonials->data['content'] = "<p>Возникли проблемы при установке модуля</p>";
	break;

    default:
		page404();
	break;
}

$API['content'] = isset ($testimonials->data['content']) ? $testimonials->data['content'] : '';
$API['template'] = isset ($testimonials->data['template']) ? $testimonials->data['template'] : '';

?>
