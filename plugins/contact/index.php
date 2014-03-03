
<?php
/* need to be setting up logo folder on line 39 */
class plugin_contact {
     protected $pluginParams = array();
     protected $return = "";

     public function start() { 
     	  
		return '
			<div id="phone"> 			
				<img alt="" src="/img/phone.png" /> 				
				<span>678-955</span> 				
			</div>  			
			<div id="mail"> 			
				<img alt="" src="/img/mail.png" /> 				
				<a href="mailto:technodom80@mail.ru"> technodom80@mail.ru </a> 				
			</div>
		';
     }

     function __construct($params) {
     	$this->pluginParams = api::setPluginParams($params);
     }
}
?>
