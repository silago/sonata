<?php
/* need to be setting up logo folder on line 39 */
include_once("modules/catalog/__classes.php");
class plugin_showHits {
     protected $pluginParams = array();
     protected $return = "";

	 private $isAction = false;
	 
     public function start() {
		if (isset ($this->pluginParams['isAction'])) $this->isAction = intval ($this->pluginParams['isAction']);
	 
     	$catalog = new catalog();
		return $catalog->showHit(6, 2);
     }

     function __construct($params) {
     	$this->pluginParams = api::setPluginParams($params);
     }
}
?>
