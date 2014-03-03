<?php

class plugin_testimonialShow {
     protected $pluginParams = array();
     protected $return = "";

     public function start() {
     	global $sql;
     	
		$result = "";
		
		$sql->query ("	select 
							`testimonials`.`name`,
							`testimonials`.`date`,
							`testimonials`.`text`,
							`testimonials`.`rating`,
							concat(`shop_users`.`name`) as `username`
						from 
										`testimonials`
							inner join 	`shop_users`
							on
								`testimonials`.`user_id` = `shop_users`.`id`
						where
							`testimonials`.`owner_id` = '0'
						order by
							RAND()
						limit
							1", true);

		$template = new template (api::setTemplate ("plugins/testimonialShow/index.testimonial.item.html"));
		
		$template->assign ("testimonialName", $sql->result['username']);
		$template->assign ("testimonialText", $sql->result['text']);
		$result = $template->get ();
		
     	return $result;
     }

     function __construct($params) {
     	$this->pluginParams = api::setPluginParams($params);
     }
}
?>
