<?php
function smarty_function_api_func($params,&$smarty)
{
	return call_user_func("api::".$params['name']);
}

