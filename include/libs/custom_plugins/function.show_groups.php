<?php

function smarty_function_show_groups($params,&$smarty)
{	global $sql;
	$sql->query("select * from shop_groups where `parent_group_id` = '0' order by position");
	

    return smarty_function_show_groups_html($sql->getList());    
    
    #$class= new smarty_plugin_top_formz($params);
    #return $class->start();
}
function smarty_function_show_groups_html($items)
				{
				$html='';
				foreach ($items as $row):
				if (empty($row['thumb']))
					$row['thumb']='/images/nophoto.png';
				$html.='<div class="serv-block">
							<p>
								<a href="/'.$row['uri'].'"><img width="50" height="49" alt="" src="'.$row['thumb'].'"></a>
							</p>
								<a href="/'.$row['uri'].'">'.$row['name'].'</a>	
							</div>';
				endforeach;
				return $html;
				}

?>
