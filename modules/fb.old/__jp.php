<?php
if (!defined("API")) {
	exit("Main include fail");
}

$l=array(
		'navigationMainTitle' => "",
		'navigationTitle'     => "Feedback",
		'pageTitle'			  => "フィードバック",
		'enterCode'	=> 'Введите код с картинки',
		'send'	=> 'Отправить',
		"errorPost" => "Неверно заполнено поле ",
		"wrongCapcha" => "Неверный код ",
		"empty"     => "Не заполнено поле ",
		"subject"	=> "Сообщение с сайта",

		"rows" => array(
						array('fname', 'Имя', 'text', 150, 1),
						array('cname', 'Имя организации/компании', 'text', 150, 1),
						array('email', 'E-mail', 'email', 150, 1),
						array('theme', 'Тема сообщения', 'text', 12, 1),
						array('message', 'Cообщение', 'textarea', 12, 1),
						),
		"ok"  => "Сообщение успешно отправлено",
		"okDesc" => "Спасибо за регистрацию! Мы обязательно свяжемся с вами",


		);

?>

