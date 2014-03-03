<?php
/* need to be setting up logo folder on line 39 */
include_once("modules/catalog/__classes.php");
class plugin_showBestSell {
     protected $pluginParams = array();
     protected $return = "";

	 private $isAction = false;
	 
     public function start() {
		
     	$catalog = new catalog();
		return $catalog->showHit(6, 1);
     }

     function __construct($params) {
     	$this->pluginParams = api::setPluginParams($params);
     }
}
?>
