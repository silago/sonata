<?php
// Плагин "Аккаунт"


class plugin_accounts {
     protected $pluginParams = array();
     protected $return = "";

     public function start() {
     	global $lang, $smarty;

        if (isset($_SESSION['shop_user_id'])) $tpl = 'user'; else $tpl = 'guest';

     	return $smarty->fetch(api::setTemplate('plugins/accounts/index.'.$tpl.'.tpl'));

     }

     function __construct($params) {
     	$this->pluginParams = api::setPluginParams($params);
     }
}
?>
