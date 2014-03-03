<?php

class plugin_sliderShow {
     protected $pluginParams = array();     

     public function start() {
     	global $sql;     	

		$result = '';
		
		$sql->query ("select `name`, `image`, `caption` from `slider` where `owner` = 0");
		
		if ($sql->num_rows ()) {
			$template = new template (api::setTemplate ('plugins/sliderShow/slidershow.item.html'));
			while ($sql->next_row ()) {
				$template->assign ('image', 'userfiles/image/slider/'.$sql->result['image']);
				$template->assign ('caption', $sql->result['caption']);
				$result .= $template->get ();
			}
		}
		
     	return $result;
     }

     function __construct($params) {
     	$this->pluginParams = api::setPluginParams($params);
     }
}
?>