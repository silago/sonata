<?php
 
include_once("include/classes/class.tree.php");
include_once("include/classes/class.Security.php");

require_once("modules/basket/__classes.php");

class plugin_topCart {

    protected $pluginParams = array();
    protected $return = "";

    public function start() {
		global $sql, $lang, $smarty;
        
        $authed= ((Security::$auth == true) ?'true' :'false');
			 
			 
		$countOfItems = $this->basket->getCountOfItems();	 
		$total = $this->basket->getTotal();	 
		
		$userName = ((isset(Security::$userData['name'])) ? Security::$userData['name'] : false); 
		$smarty->assign('total', $total);
		$smarty->assign('countOfItems', $countOfItems); 
        
        
        
        $template = $smarty->fetch(api::setTemplate("plugins/topCart/index.tpl"));
        return $template;
       
    }

    function __construct($params) {
        $this->pluginParams = api::setPluginParams($params);
        
        $this->basket = new Basket();
    }

}

?>
