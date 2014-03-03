<?php
if (!defined("API")) {
	exit("Main include fail");
}

$l=array(
		'navigationMainTitle' => "",
		'navigationTitle'     => "Feedback",
		'pageTitle'			  => "Send message",
		'enterCode'	=> 'Enter code',
		'send'	=> 'Send',
		"errorPost" => "Error in field ",
		"wrongCapcha" => "Invalid code ",
		"empty"     => "Не заполнено поле ",
		"subject"	=> "Сообщение с сайта",

		"rows" => array(
						array('fname', 'Name', 'text', 150, 1),
						array('cname', 'Organization', 'text', 150, 1),
						array('email', 'E-mail', 'email', 150, 1),
						array('theme', 'Topic', 'text', 12, 1),
						array('message', 'Message', 'textarea', 12, 1),
						),
		"ok"  => "Message successful send",
		"okDesc" => "Thanks for your message! We will contact you soon",


		);

?>

