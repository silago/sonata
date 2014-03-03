<?php
	include "page.php";
	include "gallery.php";
	include "catalog.php";

	$API['content'] = "";
	
	foreach(get_declared_classes() as $val) {
		if(stristr($val, "_map")) {
			$pageMap = new $val;
			$tree = $pageMap->start();
	
			$template = new template("ru/modules/map/map.item.html");
			$body="";
			foreach($tree['items'] as $key => $val) {
				$template->assign("margin", $tree['items'][$key]['level']*20);
				$template->assign("title", $tree['items'][$key]['title']);
				$template->assign("url", $tree['items'][$key]['url']);
				$body .= $template->get();
			}
	
			$template = new template("ru/modules/map/map.body.html");
			$template->assign("module", $tree['moduleName']);
			$template->assign("body", $body);
	
			$API['content'] .= $template->get();
		}
	}
	
	$template = new template("ru/modules/map/map.item.html");
	
	$body = "";
	if(is_dir("modules/faq/")) {
		$template->assign("margin", "0");
		$template->assign("title", "Вопрос-ответ");
		$template->assign("url", "/faq/");
		$body .= $template->get();
	}
	
	if(is_dir("modules/fb/")) {
		$template->assign("margin", "0");
		$template->assign("title", "Обратная связь");
		$template->assign("url", "/fb/");
		$body .= $template->get();
	}
	
	if(is_dir("modules/news/")) {
		$template->assign("margin", "0");
		$template->assign("title", "Новости");
		$template->assign("url", "/news/");
		$body .= $template->get();
	}	
	
	if(is_dir("modules/portfolio/")) {
		$template->assign("margin", "0");
		$template->assign("title", "Портфолио");
		$template->assign("url", "/portfolio/");
		$body .= $template->get();
	}
	
	if(is_dir("modules/vote/")) {
		$template->assign("margin", "0");
		$template->assign("title", "Голосования");
		$template->assign("url", "/vote/");
		$body .= $template->get();
	}
	
	$template = new template("ru/modules/map/map.body.html");
	$template->assign("module", "Разное");
	$template->assign("body", $body);
	
	$API['content'] .= $template->get();
?>