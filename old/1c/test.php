<?php

include('xmlparser.php');

$xml=simplexml_load_file('_tmp.xml');
items($xml);
print_r($items);

foreach($items as $goods)
         	   {
//			   print_r($goods);

         	   	foreach ($goods as $good)
				{
					foreach ($good as $user_img)
        					{
        						if (!empty($user_img[fname][0])) echo($user_img[fname][0]);
        					}
					}

         	   }

?>