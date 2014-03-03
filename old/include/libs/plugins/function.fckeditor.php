<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * fckEditor functions
 *
 * Type:     function<br>
 * Name:     fckrditor<br>
 * Date:     Dec 20, 2007<br>
 * Purpose:  insert fckEditorForm to <br>
 * Input:
*/

 function smarty_function_fckeditor($params, &$smarty) {
    static $cycle_vars;
    
    
    // Проверяем наличие параметров
    
    if (!isset($params['name'])) {
    	$smarty->tirrger_error("fckeditor: missing 'name' parametr");
    }
    
    $fckForm = new fckEditor($params['name']);
    
    $value = isset($params['value']) ? $params['value'] : "";
    $width = isset($params['width']) ? $params['width'] : "100%";
    $height = isset($params['height']) ? $params['height'] : "150";
    $type = isset($params['type']) ? $params['type'] : "Default";
    
    $fckForm->Value = $value;
    $fckForm->Width = $width;
    $fckForm->Height = $height;
    $fckForm->ToolbarSet = $type;
    
    
    
	$returnValue = $fckForm->createHtml();
    
	unset($fckForm);
	
    return $returnValue;
}

/* vim: set expandtab: */

?>
