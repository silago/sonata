<?php
/* need to be setting up logo folder on line 39 */
class plugin_showBrands {
     protected $pluginParams = array();
     protected $return = "";

     public function start() {
     	global $sql;
     	  
		$query = "SELECT shop_prop_values.*
		
		from shop_prop_values 
		left join shop_props_assign	 on shop_prop_values.value_id = shop_props_assign.prop_val_id
		left join shop_itemproperties on shop_props_assign.prop_id = shop_itemproperties.prop_id
		where shop_itemproperties.name = 'Производитель' group by shop_prop_values.name
		";  

     	$sql->query($query);
		
		$brandsCount = $sql->num_rows();
		
		if ($brandsCount > 0) {
			
			$ret = '<ul>';
			$i = 0;
			while ($sql->next_row()) {
				
				$ret .= '<li><a href="/catalog/?brand='.$sql->result['name'].'">'.$sql->result['name'].'</a></li>';
				if($brandsCount > 3 && $i == 2){
					$ret .= '</ul><ul class="brands_slide">';
				}
				
				
				$i++;
			} 
			$ret .= '</ul>';
			return $ret;
		}
		else {
			return '';
		}
     }

     function __construct($params) {
     	$this->pluginParams = api::setPluginParams($params);
     }
}
?>
