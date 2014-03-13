<?php

function smarty_function_show_serv($params,&$smarty)
{	global $sql;
	$sql->query("select * from pages where onmain = 1");

    return smarty_function_show_serv_html($sql->getList());    
    
    #$class= new smarty_plugin_top_formz($params);
    #return $class->start();
}
function smarty_function_show_serv_html($items)
				{
				$html='';
				foreach ($items as $row):
				if (empty($row['filename']))
					$row['filename']='/images/nophoto.png';
				//else $row['filename']='/userfiles/catalog/1cbitrix/'.$row['filename'];
				$html.='<div class="serv-block">
					
							<p><a href="/'.$row['uri'].'"><img width="62" height="" alt="" src="/userfiles/'.$row['image'].'"></a>
							</p>
								<a href="/'.$row['uri'].'">'.$row['title'].'</a>	
						</div>';
				endforeach;
				return $html;
				}

?>
