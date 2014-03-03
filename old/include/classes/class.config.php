<?php

class config {
	
	public static function getConfigFromIni($module){
		global $iniconf;
		
		$getVal = $iniconf->read($module, 'confParams');
		$values = explode("#", $getVal);
		
		foreach($values as $key=>$value){			
			$type = $iniconf->read($module, $value.'_type');
			$description = $iniconf->read($module, $value.'_description');
			
			if($type == 'select'){
				$optMax = $iniconf->read($module, $value.'_options');
				$optArray = '';				
				for($i=0;$i<=$optMax; $i++){					
					$optArray[$i] = $iniconf->read($module, $value.'_option'.$i);
				}
				unset($i);
			}
			
			$array[$value] = !empty($optArray) ? array ('type' => $type, 'description' => $description, 'options' => $optArray) : array ('type' => $type, 'description' => $description);
			unset($optArray);
		}
		return $array;
	}	
	
	public static function getValue ($module, $iniKey, $name='')
	{
		global $iniconf;
			
		$return = '';
			
		$getVal = $iniconf->read($module, $iniKey);
		$getVal = str_replace('#', '"', $getVal);
		$getVal = json_decode($getVal, true);
			
		if(!empty($name)){
			if(is_array($getVal)){
				foreach ($getVal as $k => $v){
					if($v['name'] == $name){
						$return = $v['value'];
					}
				}
			}else{								
				$return = $getVal;				
			}					
		}else{
			$return = $getVal;
		}	
		
		return $return;
	}
	
	public static function setValue($module, $iniKey, $value){
		global $iniconf;									
		$setValue = json_encode($value, JSON_UNESCAPED_UNICODE);
		$setValue = str_replace('"', '#', $setValue);				
		$iniconf->write($module, $iniKey, $setValue);	
	}
	


}

?>