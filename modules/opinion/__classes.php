<?php
/**
 * Модуль управления пользователями системы управления
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


class opinion {
	public $mDir		= false;
	public $lang		= array();
	public $exel		= false;
	public $return		= array();
	public $smarty		= false;
	public $curLang		= "ru";
	public $returnPath	= "/admin/opinion/index.php";
	public $templatePath = "modules/opinion/";

	private $sql			= false;
	private $api			= array();
	private $data			= array();
	private $uriArray		= array();
	private $getArray		= array();
	private $postArray		= array();
	private $treeArray		= array();
	private $filesArray 	= array();
	private $serverArray	= array();
	private $sessionArray	= array();
	
	/**
	 * Количество отзывов на странице
	 *
	 * @var int
	 */
	private $showOpinionsPerPage = 10;

	/**
	 * Фукция геренации HTML кода вывода отзывов и формы добавления
	 *
	 * @param int $currentOffset Текущее смещение (номер страницы)
	 * @return string HTML код;
	 */
	public function showOpinios($currentOffset, $error = "&nbsp;") {
		// Создаем клон объекта смарти
		$smarty = clone $this->smarty;
		
		$this->sql->query("
							SELECT
									COUNT(*) as `count`
									
							FROM
									`#__#opinions` 
							", true);
		
		$allCount = $this->sql->result['count'];
		
				
		// Выполняем SQL запрос к базе данных
		$this->sql->query("
							SELECT
									*,
									DATE_FORMAT(`postedDate`, '%d/%m/%Y %H:%i') as `postedDate`
									
							FROM
									`#__#opinions`
							
							WHERE
									`approved` = 'y'
							ORDER BY
									`postedDate`
							LIMIT
									".(int)$currentOffset.", ".$this->showOpinionsPerPage);
		
		$assignArray = array();
		while ($this->sql->next_row()) {
			$assignArray[]=$this->sql->result;
		}
		
		$smarty->assign("opinions", $assignArray);
		$smarty->assign("error", $error);
		
		$smarty->assign("pages", api::genPageList(
													$allCount,
													$this->showOpinionsPerPage,
													$currentOffset,
													"/opinion/index.php?lang=".@$_GET['lang']."&currentOffset=[PAGE]"
													));
	
		return $smarty->fetch(api::setTemplate($this->templatePath."show.tpl"));
	}
	
	/**
	 * Функция проверки данных при добавлении/редактировании отзыва
	 * 
	 * @param array $data - массив, содержащий данные для проверки
	 * @return mixed
	 */
	
	function checkPostDataToAddOrEditOpinion($data) {
		if (!isset($data['fio']) || empty($data['fio'])) return $this->lang['empty_fio'];
		if (!isset($data['opinionText']) || empty($data['opinionText'])) return $this->lang['empty_apinionText'];
		return false;
	}
	
	/**
	 * Функция записи в БД новый отзыв
	 *
	 * @param array $data
	 * @return void
	 */
	
	function __addOpinionSql($data) {
		$this->sql->query("
							INSERT INTO
											`#__#opinions` 
															(
															`fio`,
															`org`,
															`opinionText`,
															`postedDate`,
															`approved`
															)
							VALUES
															(
															'".$this->sql->escape($data['fio'])."',
															'".$this->sql->escape($data['org'])."',
															'".$this->sql->escape($data['opinionText'])."',
															NOW(),
															'n'
															)
								");
	}
	
	/**
	 * Генерация HTML кода управлени отзывами
	 * 
	 * @return string html код
	 *
	 */
	
	public function getManagerOpiniosHtml() {
		$smarty = clone $this->smarty;
		
		$this->sql->query("
							SELECT
									`id`,
									`fio`,
									`org`,
									`postedDate`,
									`approved`
							FROM
									`#__#opinions`
							ORDER BY
									`postedDate`
							");
		
		$assignArray = array();
		while ($this->sql->next_row()) {
			$assignArray[] = $this->sql->result;
		}
		
		$smarty->assign("opinions", $assignArray);
		
		return $smarty->fetch(api::setTemplate($this->templatePath."/admin/manager.tpl"));
	}
	
	
	public function getEditOpinionHtml($getArray, $postArray) {
		$this->sql->query("SELECT * FROM `#__#opinions` WHERE `id` = '".(int)@$_GET['id']."'", true);
		if ($this->sql->num_rows() !== 1) {
			page404();
		}
		
		$smarty = clone $this->smarty;
		$smarty->assign("values", $this->sql->result);
		
		return $smarty->fetch(api::setTemplate($this->templatePath."admin/edit.tpl"));
	}	
	
	function __construct() {
		global $_GET, $_POST, $_FILES, $sql, $API, $_SESSION, $uri, $module, $_SERVER;
		$this->getArray		= &$_GET;
		$this->postArray	= &$_POST;
		$this->filesArray	= &$_FILES;
		$this->serverArray	= &$_SERVER;

		$this->uriArray		= &$uri;
		$this->module		= &$module;

		$this->returnPath	= $this->mDir == $this->module ? "/".$this->mDir."/index.html" : "/".$this->module."/".$this->mDir."/";


		if (isset($_SESSION[(string)($this->mDir)."_sess"]['returnPath'])) {
			$this->returnPath = $_SESSION[(string)($this->mDir)."_sess"]['returnPath'];
		}

		
		$this->sql = &$sql;
    	$this->api = &$API;

	}


}

?>
