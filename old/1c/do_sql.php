<?php
If ($_SERVER[PHP_AUTH_USER]==$us_name && $_SERVER[PHP_AUTH_PW]==$us_pwd )
{
 include('../include/__config.php');
 include('xmlparser.php');
 $cnn=@mysql_connect($API['config']['mysql']['server'],$API['config']['mysql']['username'],$API['config']['mysql']['password']);
 $database=@mysql_select_db($API['config']['mysql']['db']);
 mysql_set_charset('utf8');
 if ($_GET['filename']=='import.xml')
	{
     	$xmlfile=$data_dir.$_GET['filename'];
     	$xml=simplexml_load_file($xmlfile);
     	// проверка полная или частичная выгрузка
     	$isupdate=(string)$xml->Каталог->attributes()->СодержитТолькоИзменения;
     	if ($isupdate=='false')
     	{
     		$query=mysql_query("TRUNCATE shop_groups");
     		$query=mysql_query("TRUNCATE shop_itemproperties");
     		$query=mysql_query("TRUNCATE shop_prop_values");
     		$query=mysql_query("TRUNCATE shop_items");
     		$query=mysql_query("TRUNCATE shop_itemimages");
     		$query=mysql_query("TRUNCATE shop_itemfiles");
     		$query=mysql_query("TRUNCATE shop_props_assign");
     		//***************************************************
     	}
     	// импорт сведений о владельце
     	owner($xml);
     	$query=mysql_query("TRUNCATE shop_owner");
     	foreach ($owner as $owner_inf)
     	{
     		$ins_query=mysql_query("INSERT INTO shop_owner (`name`, `reprise`, `inn`, `kpp`, `bank`, `bik`, `rcount`, `korr`)
                     	VALUES ('".mysql_real_escape_string($owner_inf[title])."',
                     			'".mysql_real_escape_string($owner_inf[present])."',
                     			'".mysql_real_escape_string($owner_inf[inn])."',
                     			'".mysql_real_escape_string($owner_inf[kpp])."',
                     			'".mysql_real_escape_string($owner_inf[bank])."',
                     			'".mysql_real_escape_string($owner_inf[bik])."',
                     			'".mysql_real_escape_string($owner_inf[rcount])."',
                     			'".mysql_real_escape_string($owner_inf[korr])."')");
     	}
     	//*******************************************************************************************************************************
     	// импорт групп
     	xmltree($xml->Классификатор->Группы[0],$key);
     	if (count($groups)>0) {
  			foreach ($groups as $catgroup)
			  {
				if ($isupdate=='true')
					{
						$query=mysql_query("SELECT group_id FROM shop_groups WHERE `group_id`='$catgroup[id]'");
						$resdata=mysql_num_rows($query);
						if ($resdata>0)
							{
								$query=mysql_query("UPDATE shop_groups SET
									`group_id`='".mysql_real_escape_string($catgroup[id])."',
									`parent_group_id`='".mysql_real_escape_string($catgroup[ownerId])."',
									`name`='".mysql_real_escape_string($catgroup[title])."',
									`position`='".mysql_real_escape_string($catgroup[position])."' WHERE `group_id`='$catgroup[id]'");
							}
						else
							{
								$query=mysql_query("INSERT INTO shop_groups (`group_id`, `parent_group_id`, `name`, `position`)
							VALUES ('".mysql_real_escape_string($catgroup[id])."',
									'".mysql_real_escape_string($catgroup[ownerId])."',
									'".mysql_real_escape_string($catgroup[title])."',
									'".mysql_real_escape_string($catgroup[position])."')");
							}
					}
				else
					{
                  		$query=mysql_query("INSERT INTO shop_groups (`group_id`, `parent_group_id`, `name`, `position`)
							VALUES ('".mysql_real_escape_string($catgroup[id])."',
									'".mysql_real_escape_string($catgroup[ownerId])."',
									'".mysql_real_escape_string($catgroup[title])."',
									'".mysql_real_escape_string($catgroup[position])."')");
					}
			  }
	 	}
       //**********************************************************************************************************************
        // импорт свойств товаров
        item_prop($xml);
       	if (count($item_prop)>0) {
        	 foreach($item_prop as $iproperty)
         	   {
        		if ($isupdate=='true')
        			{
                     	$query=mysql_query("SELECT prop_id FROM shop_itemproperties WHERE `prop_id`='$iproperty[id]'");
						$resdata=mysql_num_rows($query);
						if ($resdata>0)
							{
								$query=mysql_query("UPDATE shop_itemproperties SET
        			           		`prop_id`='".mysql_real_escape_string($iproperty[id])."',
									`name`='".mysql_real_escape_string($iproperty[name])."' WHERE `prop_id`='$iproperty[id]'");
							}
						else
							{
								$query=mysql_query("INSERT INTO shop_itemproperties (`prop_id`, `name`)
									VALUES ('".mysql_real_escape_string($iproperty[id])."',
											'".mysql_real_escape_string($iproperty[name])."')");
							}
					}
        		else
        			{
                          $query=mysql_query("INSERT INTO shop_itemproperties (`prop_id`, `name`)
									VALUES ('".mysql_real_escape_string($iproperty[id])."',
											'".mysql_real_escape_string($iproperty[name])."')");
        			}
         		}
         	foreach($value_prop as $prop_value)
         	   {
        		if ($isupdate=='true')
        			{
                     	$query=mysql_query("SELECT value_id FROM shop_prop_values WHERE `value_id`='$prop_value[id]'");
						$resdata=mysql_num_rows($query);
						if ($resdata>0)
							{
								$query=mysql_query("UPDATE shop_prop_values SET
        			           		`value_id`='".mysql_real_escape_string($prop_value[id])."',
									`name`='".mysql_real_escape_string($prop_value[name])."' WHERE `value_id`='$prop_value[id]'");
							}
						else
							{
								$query=mysql_query("INSERT INTO shop_prop_values (`value_id`, `name`)
									VALUES ('".mysql_real_escape_string($prop_value[id])."',
											'".mysql_real_escape_string($prop_value[name])."')");
							}
					}
        		else
        			{
                          $query=mysql_query("INSERT INTO shop_prop_values (`value_id`, `name`)
									VALUES ('".mysql_real_escape_string($prop_value[id])."',
											'".mysql_real_escape_string($prop_value[name])."')");
        			}
         		}

         }
       //***************************************************************************************************************
       // импорт товаров
        items($xml);
       	if (count($items)>0) {
        	 foreach($items as $goods)
         	   {
        		if ($isupdate=='true')
        			{
        				$query=mysql_query("SELECT item_id FROM shop_items WHERE `item_id`='$goods[id]'");
						$resdata=mysql_num_rows($query);
						if ($resdata>0)
							{
                               // впилить фунуцию обновления записи товара
							}
						else
							{
                                 $query=mysql_query("INSERT INTO shop_items (`item_id`, `article`, `parent_group_id`, `name`, `description`, `small_desc`) VALUES
        											('".mysql_real_escape_string($goods[id])."',
        											 '".mysql_real_escape_string($goods[articul])."',
        											 '".mysql_real_escape_string($goods[group_id])."',
        											 '".mysql_real_escape_string($goods[title])."',
        											 '".mysql_real_escape_string($goods[descript])."',
        											 '".mysql_real_escape_string($goods[smalltext])."') ");

        						foreach ($goods as $good)
        						{
        								foreach ($good as $user_img)
        									{
        										if (!empty($user_img[ifname][0]))
        											{
        												$query=mysql_query("INSERT INTO shop_itemimages (`item_id` , `filename`, `description`) VALUES (
        						                   	 		'".mysql_real_escape_string($goods[id])."',
        											 		'".mysql_real_escape_string($user_img[ifname][0])."',
        											 		'".mysql_real_escape_string($user_img[idesc][0])."') ");
        											}
        									}
        						foreach ($good as $user_files)
        							{
        								if (!empty($user_files[fname][0]))
        									{
        										$query=mysql_query("INSERT INTO shop_itemfiles (`item_id` , `filename`, `description`) VALUES (
        						                   	 '".mysql_real_escape_string($goods[id])."',
        											 '".mysql_real_escape_string($user_files[fname][0])."',
        											 '".mysql_real_escape_string($user_files[fdesc][0])."') ");
        									}
        							}
        						foreach ($good as $props)
        							{
        								if (!empty($props[prop_id][0]))
        									{
        										$query=mysql_query("INSERT INTO shop_props_assign (`item_id` , `prop_id`, `prop_val_id`) VALUES (
        						                   	 '".mysql_real_escape_string($goods[id])."',
        											 '".mysql_real_escape_string($props[prop_id][0])."',
        											 '".mysql_real_escape_string($props[prop_val_id][0])."') ");
        									}
        							}
                            		// *********************************************************************************************************
        						}
							}

        			}
        		else
        			{
                         $query=mysql_query("INSERT INTO shop_items (`item_id`, `article`, `parent_group_id`, `name`, `description`, `small_desc`) VALUES
        											('".mysql_real_escape_string($goods[id])."',
        											 '".mysql_real_escape_string($goods[articul])."',
        											 '".mysql_real_escape_string($goods[group_id])."',
        											 '".mysql_real_escape_string($goods[title])."',
        											 '".mysql_real_escape_string($goods[descript])."',
        											 '".mysql_real_escape_string($goods[smalltext])."') ");

        				foreach ($goods as $good)
        					{
        						foreach ($good as $user_img)
        							{
        								if (!empty($user_img[ifname][0]))
        									{
        										$query=mysql_query("INSERT INTO shop_itemimages (`item_id` , `filename`, `description`) VALUES (
        						                   	 '".mysql_real_escape_string($goods[id])."',
        											 '".mysql_real_escape_string($user_img[ifname][0])."',
        											 '".mysql_real_escape_string($user_img[idesc][0])."') ");
        									}
        							}
        						foreach ($good as $user_files)
        							{
        								if (!empty($user_files[fname][0]))
        									{
        										$query=mysql_query("INSERT INTO shop_itemfiles (`item_id` , `filename`, `description`) VALUES (
        						                   	 '".mysql_real_escape_string($goods[id])."',
        											 '".mysql_real_escape_string($user_files[fname][0])."',
        											 '".mysql_real_escape_string($user_files[fdesc][0])."') ");
        									}
        							}
        						foreach ($good as $props)
        							{
        								if (!empty($props[prop_id][0]))
        									{
        										$query=mysql_query("INSERT INTO shop_props_assign (`item_id` , `prop_id`, `prop_val_id`) VALUES (
        						                   	 '".mysql_real_escape_string($goods[id])."',
        											 '".mysql_real_escape_string($props[prop_id][0])."',
        											 '".mysql_real_escape_string($props[prop_val_id][0])."') ");
        									}
        							}
                            // *********************************************************************************************************
        					}
        			}
        	   }
        }





     	echo "success";
 	}

 if ($_GET['filename']=='offers.xml')
	{
        $xmlfile=$data_dir.$_GET['filename'];
        $xml=simplexml_load_file($xmlfile);
     	// проверка полная или частичная выгрузка
     	$isupdate=(string)$xml->ПакетПредложений->attributes()->СодержитТолькоИзменения;
     	if ($isupdate=='false')
     	{
     		$query=mysql_query("TRUNCATE shop_pricestypes");
     		$query=mysql_query("TRUNCATE shop_prices");
     	}

        pricetype($xml);
        if (count($types)>0) {
  			foreach ($types as $price_types)
			  {
				if ($isupdate=='true')
					{
						$query=mysql_query("SELECT pricetype_id FROM shop_pricestypes WHERE `pricetype_id`='$price_types[id]'");
						$resdata=mysql_num_rows($query);
						if ($resdata>0)
							{
       							$query=mysql_query("UPDATE shop_pricestypes SET `pricetype_id`='".mysql_real_escape_string($price_types[id])."',
       																			`name`='".mysql_real_escape_string($price_types[title])."' WHERE `pricetype_id`='$price_types[id]'");
							}
						else
							{
								$query=mysql_query("INSERT INTO shop_pricestypes (`pricetype_id`, `name`) VALUES (
																				'".mysql_real_escape_string($price_types[id])."',
																				'".mysql_real_escape_string($price_types[title])."')");
							}
					}

				else
					{
                      	$query=mysql_query("INSERT INTO shop_pricestypes (`pricetype_id`, `name`) VALUES (
                      															'".mysql_real_escape_string($price_types[id])."',
                      															'".mysql_real_escape_string($price_types[title])."')");
					}
			  }
     	}

       itemprice($xml);
       if (count($price)>0) {
     		foreach ($price as $i_price)
     			{
     				$i_price= str_replace(',','.',$i_price);
     				if ($isupdate=='true')
     					{
         					$query=mysql_query("SELECT id_item FROM shop_prices WHERE `id_item`='$i_price[item_id]' and `pricetype_id`='$i_price[price_id]'");
         					$resdata=mysql_num_rows($query);
         					if ($resdata>0)
         						{
		         					$query=mysql_query("UPDATE shop_prices SET `value`='$i_price[price]' WHERE `id_item`='$i_price[item_id]' and `pricetype_id`='$i_price[price_id]'");
		         					$query=mysql_query("UPDATE shop_items SET `remains` = '".mysql_real_escape_string($i_price[remains])."' WHERE `item_id`='$i_price[item_id]'");
                   				}
         					else
         						{
         							$query=mysql_query("INSERT INTO shop_prices (`id_item`, `pricetype_id`, `value`) VALUES (
     																	'".mysql_real_escape_string($i_price[item_id])."',
     																	'".mysql_real_escape_string($i_price[price_id])."',
     																	'".$i_price[price]."')");
     								$query=mysql_query("UPDATE shop_items SET `remains` = '".mysql_real_escape_string($i_price[remains])."' WHERE `item_id`='$i_price[item_id]'");
         						}
     					}
     				else
     					{
     						$query=mysql_query("INSERT INTO shop_prices (`id_item`, `pricetype_id`, `value`) VALUES (
     																	'".mysql_real_escape_string($i_price[item_id])."',
     																	'".mysql_real_escape_string($i_price[price_id])."',
     																	'".$i_price[price]."')");
     						$query=mysql_query("UPDATE shop_items SET `remains` = '".mysql_real_escape_string($i_price[remains])."' WHERE `item_id`='$i_price[item_id]'");
     					}
     			}
     	}




		echo "success";

	}











}





?>