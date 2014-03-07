<?php

function smarty_function_show_sale($params,&$smarty)
{	global $sql;
	$sql->query("select shop_items.*, shop_prices.value, shop_itemimages.filename,  CONCAT(shop_groups.uri,'/',shop_items.uri) as uri from shop_items
	left join shop_groups on shop_items.parent_group_id = shop_groups.group_id
	left join shop_itemimages on shop_items.item_id = shop_itemimages.item_id
	left join shop_prices on shop_items.item_id = shop_prices.item_id
	where 1
	group by shop_items.id
	order by rand() limit 2 
	");

    return smarty_function_show_sale_html($sql->getList());    
    
    #$class= new smarty_plugin_top_formz($params);
    #return $class->start();
}
function smarty_function_show_sale_html($items)
				{
				$html='';
				$html.='<div class="sales-box">
						<img width="66" height="66" class="sale-icon" alt="" src="/images/sale-icon.png">
						<span>Распродажа товаров</span>';
				foreach ($items as $row):
				if (empty($row['filename']))
					$row['filename']='/images/nophoto.png';
				else $row['filename']='/userfiles/catalog/1cbitrix/'.$row['filename'];
				$html.='<div class="sales-block">
							<a href="/'.$row['uri'].'"><img width="50" height="49" alt="" src="'.$row['filename'].'"></a>

							<div class="sales-info">
								<a href="/'.$row['uri'].'">'.$row['name'].'</a>
								<p>'.$row['value'].'</p>
							</div>	
						</div>';
				endforeach;
				$html.='</div>';
				return $html;
				}

?>
