<?php

// Плагин "Новости"
//
// Версия 1.0 Beta,
// (C) Oskorbin Sergey, 2006
//
// Зависимисть: модуль "Новости" (3.0 И Выше)
//
// Парметры:
//      LIMIT: (INT);
//      Количество новостей для отображения, по уполнчанию -1;
//
//      ORDER: (название столбца в БД);
//      Сортировать по столбцу, по умолнчанию: `date`
//
//      ORDERBY: (DESC|ASK);
//      Тип сортировки данных в таблцице, по умолчанию DESC
//
//      GROUP: (INT);
//      Группа для отображения

include_once("include/classes/class.tree.php");
include_once("include/classes/class.Security.php");

require_once("modules/basket/__classes.php");

class plugin_topLoginForm {

    protected $pluginParams = array();
    protected $return = "";

    public function start() {
		global $sql, $lang, $smarty;
        
        $authed= ((Security::$auth == true) ?'true' :'false');
			 
			 
		$countOfItems = $this->basket->getCountOfItems();	 
		$total = $this->basket->getTotal();	 
		
		$userName = ((isset(Security::$userData['name'])) ? Security::$userData['name'] : false);
		$smarty->assign('authed', $authed);
		$smarty->assign('total', $total);
		$smarty->assign('countOfItems', $countOfItems);
		$smarty->assign('userName', $userName);
        
        
        
        $template = $smarty->fetch(api::setTemplate("plugins/topLoginForm/index.tpl"));
        return $template;
       
    }

    function __construct($params) {
        $this->pluginParams = api::setPluginParams($params);
        
        $this->basket = new Basket();
    }

}

?>
