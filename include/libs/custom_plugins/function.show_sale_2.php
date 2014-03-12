<?php

function smarty_function_show_sale_2($params,&$smarty)
{	global $sql;
	$sql->query("select shop_items.*, shop_prices.value, shop_itemimages.filename,  CONCAT(shop_groups.uri,'/',shop_items.uri) as uri from shop_items
	left join shop_groups on shop_items.parent_group_id = shop_groups.group_id
	left join shop_itemimages on shop_items.item_id = shop_itemimages.item_id
	left join shop_prices on shop_items.item_id = shop_prices.item_id
	where 1 and is_hit = 1
	group by shop_items.id
	order by rand() limit 2 
	");

    return smarty_function_show_sale_2_html($sql->getList());    
    
    #$class= new smarty_plugin_top_formz($params);
    #return $class->start();
}
function smarty_function_show_sale_2_html($items)
				{
				$html='';
	
				foreach ($items as $row):
				if (empty($row['filename']))
					$row['filename']='/images/nophoto.png';
				else $row['filename']='/userfiles/catalog/1cbitrix/'.$row['filename'];
				$html.='<div class="sale-block">
							<a href="/'.$row['uri'].'"><img width="142" height="" alt="" src="'.$row['filename'].'"></a>

								<a class="title" href="/'.$row['uri'].'">'.$row['name'].'</a>
								<p>'.$row['value'].' руб.</p>
							<a class="button" href="#" onclick="addToChart('.$row['id'].',1); return false;"><span>В корзину</span></a>
						</div>';
				endforeach;
				return $html;
				}

?>
