<?php
if (true)
//If ($_SERVER[PHP_AUTH_USER]==$us_name && $_SERVER[PHP_AUTH_PW]==$us_pwd )
{
// include('../include/__config.php');
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
     	//	$query=mysql_query("TRUNCATE shop_groups");
     		$query=mysql_query("TRUNCATE shop_itemproperties");
     		$query=mysql_query("TRUNCATE shop_prop_values");
     	//	$query=mysql_query("TRUNCATE shop_item_chars");
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
  			if ($isupdate<>'true')
			 {
  			 	$query = mysql_query("DROP TABLE IF EXISTS shop_groups_temp");
				$query = mysql_query("DROP TABLE IF EXISTS shop_groups2");
  				$crt_table = mysql_query("CREATE TABLE IF NOT EXISTS `shop_groups_temp` (
  										`id` int(10) unsigned NOT NULL AUTO_INCREMENT,	`group_id` tinytext NOT NULL, `parent_group_id` tinytext NOT NULL,
  										`name` tinytext NOT NULL, `image` tinytext NOT NULL, `thumb` tinytext NOT NULL,	`uri` tinytext NOT NULL,
  										`description` text NOT NULL, `hidden` tinyint(1) NOT NULL, `position` int(10) NOT NULL,
  										`md` tinytext NOT NULL,	`mk` tinytext NOT NULL,
 										`title` tinytext NOT NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8");
 				$crt_table = mysql_query("CREATE TABLE IF NOT EXISTS `shop_groups2` (
  										`id` int(10) unsigned NOT NULL AUTO_INCREMENT,	`group_id` tinytext NOT NULL, `parent_group_id` tinytext NOT NULL,
  										`name` tinytext NOT NULL, `image` tinytext NOT NULL, `thumb` tinytext NOT NULL,	`uri` tinytext NOT NULL,
  										`description` text NOT NULL, `hidden` tinyint(1) NOT NULL, `position` int(10) NOT NULL,
  										`md` tinytext NOT NULL,	`mk` tinytext NOT NULL,
 										`title` tinytext NOT NULL, PRIMARY KEY (`group_id`(255)),KEY `id` (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8");
 			 }
 			$gr_array = '';
  			foreach ($groups as $catgroup)
			  {
               	$gr_array .= "('".mysql_real_escape_string($catgroup[id])."','".mysql_real_escape_string($catgroup[ownerId])."','".mysql_real_escape_string($catgroup[title])."','".mysql_real_escape_string($catgroup[position])."'),";
			  }
			  $gr_array = substr($gr_array,0,-1);
			  if ($isupdate<>'true')
			 	{
			  		$query = mysql_query("INSERT INTO shop_groups_temp (`group_id`,`parent_group_id`,`name`,`position`) VALUES ".$gr_array."
     					ON DUPLICATE KEY UPDATE `group_id`= VALUES(group_id),`parent_group_id`= VALUES(parent_group_id), `name`= VALUES(name),`position`= VALUES(position)");
     			} else {
     				$query = mysql_query("INSERT INTO shop_groups (`group_id`,`parent_group_id`,`name`,`position`) VALUES ".$gr_array."
     					ON DUPLICATE KEY UPDATE `group_id`= VALUES(group_id),`parent_group_id`= VALUES(parent_group_id), `name`= VALUES(name),`position`= VALUES(position)");
     			}

			  if ($isupdate<>'true')
			 	{
			  		$query = mysql_query("INSERT INTO shop_groups2 (group_id, parent_group_id, name, image, thumb, description, hidden, position, md, mk, title)
			  					(SELECT shop_groups_temp.group_id, shop_groups_temp.parent_group_id, shop_groups_temp.name, shop_groups.image,
			  					 shop_groups.thumb, shop_groups.description, shop_groups.hidden, shop_groups_temp.position, shop_groups.md, shop_groups.mk, shop_groups.title
			  					 FROM shop_groups_temp LEFT JOIN shop_groups ON shop_groups_temp.group_id = shop_groups.group_id)");
			  		$query = mysql_query("DROP TABLE IF EXISTS shop_groups_temp");
			  		$query = mysql_query("DROP TABLE IF EXISTS shop_groups");
      		  		$query = mysql_query("ALTER TABLE shop_groups2 RENAME shop_groups");
      			}
      		unset($gr_array);

	 	}
       //**********************************************************************************************************************
        // импорт свойств товаров
        item_prop($xml);
       	if (count($item_prop)>0) {
       		 $prop_array = '';
        	 foreach($item_prop as $iproperty)
         	   {
               		$prop_array .= "('".mysql_real_escape_string($iproperty[id])."','".mysql_real_escape_string($iproperty[name])."'),";
         	   }
         	 $prop_array = substr($prop_array,0,-1);
			 $query = mysql_query("INSERT INTO shop_itemproperties (`prop_id`,`name`) VALUES ".$prop_array."ON DUPLICATE KEY UPDATE `prop_id`= VALUES(prop_id),`name`= VALUES(name)");
             unset($prop_array);
          }
        if (count($value_prop)>0) {
            $vals_array = '';
         	foreach($value_prop as $prop_value)
         	   {
					$vals_array .= "('".mysql_real_escape_string($prop_value[id])."','".mysql_real_escape_string($prop_value[name])."'),";
         	   }
         	 $vals_array = substr($vals_array,0,-1);
			 $query = mysql_query("INSERT INTO shop_prop_values (`value_id`,`name`) VALUES ".$vals_array."ON DUPLICATE KEY UPDATE `value_id`= VALUES(value_id),`name`= VALUES(name)");
             unset($vals_array);
          }
       //***************************************************************************************************************
       // импорт товаров
        items($xml);
       	if (count($items)>0) {
            if ($isupdate<>'true')
			 {
            	$query = mysql_query("DROP TABLE IF EXISTS shop_items_temp");
				$query = mysql_query("DROP TABLE IF EXISTS shop_items2");
       	 		$crt_teble = mysql_query("CREATE TABLE IF NOT EXISTS `shop_items_temp` (`id` int(10) unsigned NOT NULL AUTO_INCREMENT, `item_id` tinytext NOT NULL,
  									 `owner_id` tinytext NOT NULL, `article` tinytext NOT NULL, `parent_group_id` tinytext NOT NULL, `name` tinytext NOT NULL,
									 `description` text NOT NULL, `small_desc` text, `price_old` decimal(10,2) NOT NULL, `remains` int(10) NOT NULL DEFAULT '0',
  									 `is_hit` tinyint(1) NOT NULL, `is_new` tinyint(1) NOT NULL, `uri` tinytext NOT NULL, `md` tinytext NOT NULL,
  									 `mk` tinytext NOT NULL, `title` tinytext NOT NULL, `inprice` tinyint(1) NOT NULL, PRIMARY KEY (`id`))
  									  ENGINE=MyISAM  DEFAULT CHARSET=utf8");
  				$crt_teble = mysql_query("CREATE TABLE IF NOT EXISTS `shop_items2` (`id` int(10) unsigned NOT NULL AUTO_INCREMENT, `item_id` tinytext NOT NULL,
  									 `owner_id` tinytext NOT NULL, `article` tinytext NOT NULL, `parent_group_id` tinytext NOT NULL, `name` tinytext NOT NULL,
									 `description` text NOT NULL, `small_desc` text, `price_old` decimal(10,2) NOT NULL, `remains` int(10) NOT NULL DEFAULT '0',
  									 `is_hit` tinyint(1) NOT NULL, `is_new` tinyint(1) NOT NULL, `uri` tinytext NOT NULL, `md` tinytext NOT NULL,
  									 `mk` tinytext NOT NULL, `title` tinytext NOT NULL, `inprice` tinyint(1) NOT NULL, PRIMARY KEY (`item_id`(255)),KEY `id` (`id`))
  									  ENGINE=MyISAM  DEFAULT CHARSET=utf8");
  			 }
  			 // всставка товаров, если полная выгрузка, то в темп таблицу, если частичная, то в  итнмы сразу
  			 $goods_array = '';
        	 foreach($items as $goods)
         	   {
                 if (strlen($goods[id])>0) {
                 	$uitmid = $goods[owner_id];

                 	if ($goods[owner_id]<>'0' && stristr($goods_array,$uitmid)==false)
                 		{

                    	 	$goods_array .= "('".mysql_real_escape_string($goods[owner_id])."','0','".mysql_real_escape_string($goods[articul])."','".mysql_real_escape_string($goods[group_id])."','".
                    	 	mysql_real_escape_string($goods[title])."','".mysql_real_escape_string($goods[descript])."','".mysql_real_escape_string($goods[smalltext])."'),";
                 		}
                 	 $goods_array .= "('".mysql_real_escape_string($goods[id])."','".mysql_real_escape_string($goods[owner_id])."','".mysql_real_escape_string($goods[articul])."','".
                     	mysql_real_escape_string($goods[group_id])."','".mysql_real_escape_string($goods[title])."','".mysql_real_escape_string($goods[descript])."','".mysql_real_escape_string($goods[smalltext])."'),";
                 }
        	   	}
        	 $goods_array = substr($goods_array,0,-1);
        	 if ($isupdate<>'true')
			 {
			 	$query = mysql_query("INSERT INTO shop_items_temp (`item_id`,`owner_id`,`article`,`parent_group_id`,`name`,`description`,`small_desc`) VALUES ".$goods_array.
			 		"ON DUPLICATE KEY UPDATE `item_id`= VALUES(item_id),`owner_id`= VALUES(owner_id),`article`= VALUES(article),`parent_group_id`= VALUES(parent_group_id),`name`= VALUES(name),`description`= VALUES(description),`small_desc`= VALUES(small_desc)");
			 } else {
			 	$query = mysql_query("INSERT INTO shop_items (`item_id`,`owner_id`,`article`,`parent_group_id`,`name`,`description`,`small_desc`) VALUES ".$goods_array.
			 		"ON DUPLICATE KEY UPDATE `item_id`= VALUES(item_id),`owner_id`= VALUES(owner_id),`article`= VALUES(article),`parent_group_id`= VALUES(parent_group_id),`name`= VALUES(name),`description`= VALUES(description),`small_desc`= VALUES(small_desc)");
			 }
             unset($goods_array);

             // вставка картинок к товарам

        	   if (count($items['images'])>0)
        		  {
        			$img_array ='';
        			foreach($items['images'] as   $item_img)
               			{
            				if (strlen($item_img['ifname'])>0) $img_array .= "('".mysql_real_escape_string($item_img['id'])."','".mysql_real_escape_string($item_img['idesc'])."','".mysql_real_escape_string($item_img['ifname'])."'),";
                		}
                	$img_array = substr($img_array,0,-1);
			 		$query = mysql_query("INSERT INTO shop_itemimages (`item_id`, `description`, `filename`) VALUES ".$img_array."ON DUPLICATE KEY UPDATE `item_id`= VALUES(item_id),`description`= VALUES(description),`filename`= VALUES(filename)");
             		unset($img_array);
        		  }


             // вставка файлов к товарам

        	    if (count($items['files'])>0)
        		  {
        			$files_array ='';
        			foreach($items['files'] as   $item_files)
               			{
            				if (strlen($item_files['fname'])>0) $files_array .= "('".mysql_real_escape_string($item_files['id'])."','".mysql_real_escape_string($item_files['fdesc'])."','".mysql_real_escape_string($item_files['fname'])."'),";
                		}
                	$files_array = substr($files_array,0,-1);
			 		$query = mysql_query("INSERT INTO shop_itemfiles (`item_id`, `description`, `filename`) VALUES ".$files_array."ON DUPLICATE KEY UPDATE `item_id`= VALUES(item_id),`description`= VALUES(description),`filename`= VALUES(filename)");
             		unset($item_files);
        		  }


                // вставка свойств товаров, точнее заполнение таблицы ассигнаций

                if (count($items['props'])>0)
        		  {
        			$propsval = '';
        			foreach($items['props'] as   $item_props_val)
               			{
            				if (strlen($item_props_val['prop_val_id'])>0) $propsval .= "('".mysql_real_escape_string($item_props_val['id'])."','".mysql_real_escape_string($item_props_val['prop_id'])."','".mysql_real_escape_string($item_props_val['prop_val_id'])."'),";
                		}
	                $propsval = substr($propsval,0,-1);
				 	$query = mysql_query("INSERT INTO shop_props_assign (`item_id`, `prop_id`, `prop_val_id`) VALUES ".$propsval."ON DUPLICATE KEY UPDATE `item_id`= VALUES(item_id),`prop_id`= VALUES(prop_id),`prop_val_id`= VALUES(prop_val_id)");
	             	unset($propsval);
        		  }


                // вставка характеристик товаров и подтоваров

            /*    if (count($items['characts'])>0)
        		  {
        			$characts_array = '';
        			foreach($items['characts'] as   $item_characts)
               			{
            				if (strlen($item_characts['value'])>0) $characts_array .= "('".mysql_real_escape_string($item_characts['id'])."','".mysql_real_escape_string($item_characts['name'])."','".mysql_real_escape_string($item_characts['value'])."'),";
                		}
	                $characts_array = substr($characts_array,0,-1);
				 	$query = mysql_query("INSERT INTO shop_item_chars (`item_id`, `name`, `value`) VALUES ".$characts_array."ON DUPLICATE KEY UPDATE `item_id`= VALUES(item_id),`name`= VALUES(name),`value`= VALUES(value)");
	             	unset($characts_array);
        		  }      */



        	   //** ****************** ****************** *************** *************** ****************** ****************** ****************** **************** ***************
        	   if ($isupdate<>'true')
			 	{
        	   		$query = mysql_query("INSERT INTO shop_items2 (`item_id`, `owner_id`, `article`, `parent_group_id`, `name`, `description`, `small_desc`,
        	   								`price_old`, `remains`, `is_hit`, `is_new`,  `md`, `mk`, `title`, `inprice`)
			  							 (SELECT shop_items_temp.item_id, shop_items_temp.owner_id, shop_items_temp.article, shop_items_temp.parent_group_id,
			  							 	shop_items_temp.name, shop_items_temp.description, shop_items_temp.small_desc, shop_items.price_old, shop_items.remains, shop_items.is_hit,
			  							 	shop_items.is_new, shop_items.md, shop_items.mk, shop_items.title, shop_items.inprice FROM shop_items_temp
			  							 	LEFT JOIN shop_items ON shop_items_temp.item_id = shop_items.item_id)");
			   		$query = mysql_query("DROP TABLE IF EXISTS shop_items_temp");
			   		$query = mysql_query("DROP TABLE IF EXISTS shop_items");
      		   		$query = mysql_query("ALTER TABLE shop_items2 RENAME shop_items");

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
        if (count($types)>0)
          {
        	$pt_array = '';
  			foreach ($types as $price_types)
			  {
               		$pt_array .= "('".mysql_real_escape_string($price_types[id])."','".mysql_real_escape_string($price_types[title])."'),";
         	  }
         	 $pt_array = substr($pt_array,0,-1);
			 $query = mysql_query("INSERT INTO shop_pricestypes (`pricetype_id`,`name`) VALUES ".$pt_array."ON DUPLICATE KEY UPDATE `pricetype_id`= VALUES(pricetype_id),`name`= VALUES(name)");
			 unset($pt_array);
     	  }

        // вставка цен и остатков

        itemprice($xml);
       	if (count($price)>0)
       	 {
       	 	$iprice_array = '';

     		foreach ($price as $i_price)
     			{
     				$i_price= str_replace(',','.',$i_price);
                    if (strlen($i_price['price'])>0) $iprice_array .= "('".mysql_real_escape_string($i_price['id'])."','".mysql_real_escape_string($i_price['price_id'])."','".mysql_real_escape_string($i_price['price'])."'),";
                    $query=mysql_query("UPDATE shop_items SET `remains` = '".mysql_real_escape_string($i_price['remains'])."' WHERE `item_id`='".$i_price['id']."'");
     			}
     		$iprice_array = substr($iprice_array,0,-1);
     		$query = mysql_query("INSERT INTO shop_prices (`item_id`,`pricetype_id`,`value`) VALUES ".$iprice_array."ON DUPLICATE KEY UPDATE `item_id`= VALUES(item_id),`pricetype_id`= VALUES(pricetype_id),`value`= VALUES(value)");
			unset($iprice_array);
     	 }

define("API", 1);
include_once("../include/classes/class.API.php");
include_once("../include/classes/class.MySQL.php");
include_once("../modules/catalog/__classes.php");
$includePrefix = '../';
$sql = new MySQL();
$sql->server = $API['config']['mysql']['server'];
$sql->username = $API['config']['mysql']['username'];
$sql->password = $API['config']['mysql']['password'];
$sql->db = $API['config']['mysql']['db'];
$sql->prefix = $API['config']['mysql']['prefix'];
#$sql->query("UPDATE `#__#shop_itemimages` set `description` = 'Основное' WHERE `position` = 0");
$catalog = new catalog();
catalog::installModule('../');




echo "success";

	}







}




?>
