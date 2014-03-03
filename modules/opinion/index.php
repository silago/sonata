<?php
/**
 * Модуль управления отзывами
 * 
 * Основной класс
 * 
 * Основная структура данных:
 * Таблица: opinions
 * Структура:
 * 			id 			int unsigned not null primary key auto_increment	//
 * 			fio 		tinytext not null 									// ФИО 
 * 			org			tinytext 											// организация
 * 			opinionText	text 												// текст отзыва
 * 			postedDate	timestamp											// время публикации
 * 			approved	enum('y', 'n', 'b') default 'n'						// флаг одобрения (разрешения к публикации)
 * 																				y - разрешен
 * 																				n - не разрешен (не просмотрен)
 * 																				b - просмотрен, заблокирован к паказу
 *  
 * @package Plaza Content Managment System
 * @subpackage Clients opinion module
 * @author Sergey A Oskorbin
 * @link http://in-site.ru
 * @copyright 2006-2007 Insite Ltd.
 */


if (!defined("API")) {
	exit("Main include fail");
}

$module = new opinion();
$module->lang 	=	@$lng;
$module->smarty =	&$smarty;
$module->exel 	=	&$exel;

$_POST = stripArray($_POST);

switch ($rFile) {
	// Вывод всех отзывов на странице
	case "index.php":
		$API['content'] = $module->showOpinios(
												isset($_GET['currentOffset']) ? (int)$_GET['currentOffset'] : 0
												);
	break;
	
	
	case "addGo.php":
		if (($error = $module->checkPostDataToAddOrEditOpinion($_POST)) !== false) {
			$API['content'] = $module->showOpinios(
													isset($_GET['currentOffset']) ? (int)$_GET['currentOffset'] : 0,
													$error
													);
		} else {
			$module->__addOpinionSql($_POST);
			message($lng['addOpinion_title_ok'], $lng['addOpinion_title_desc'], "/opinion/index.php");
		}
	break;
	
}

@$API['pageTitle'] = $lng['pageTitle'];
@$API['siteTitle'] = $API['title']." | ".$portfolio->return['pageTitle'];
@$API['navigation'] = $module->return['navigation'];
@$API['template'] = (!empty($module->return['template']) ? api::setTemplate($module->return['template']) : $API['template']) ;
@$API['md'] = (!empty($module->return['md']) ? $module->return['md'] : $API['md']);
@$API['mk'] = (!empty($module->return['mk']) ? $module->return['mk'] : $API['mk']);

?>