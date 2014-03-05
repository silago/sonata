<?php

function smarty_function_show_banner($params,&$smarty)
{	global $sql;
	$sql->query("select * from banners where section = '".$params['section']."'");

    foreach ($sql->getList() as $row)
		@$html.=$row['text'];

	return @$html;
    
    
    #$class= new smarty_plugin_top_formz($params);
    #return $class->start();
}



class smarty_plugin_top_formz {
function start()

{
	
}

}

?>
