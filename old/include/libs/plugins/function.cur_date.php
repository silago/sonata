<?php
function smarty_function_cur_date($params, &$smarty)
{
    return date("d/m/Y H:i:s", time() - (int)date("Z") + (9 * 60 * 60) - ((int)date("Z") * 3600))." (+5 ฬัส)";
}
?>