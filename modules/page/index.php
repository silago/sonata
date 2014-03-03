<?php
if (!defined("API")) {
	exit("Main include fail");
}

$page = new page($ret['uriGroup']);

// If need redirect;
if (!empty($page->data['redirect'])) {go($page->data['redirect']);}

// Setting up all API values;
@$API['title']      = $page->data['pageTitle'] ? $page->data['pageTitle'] : $page->data['title'] . " | " . @$API['title'];
@$API['pageTitle']	= $page->data['title'];
@$API['content']    = $page->data['text'];
@$API['md']		    = $page->data['md'] ? $page->data['md'] : $API['md'];
@$API['mk']		    = $page->data['mk'] ? $page->data['mk'] : $API['mk'];
@$API['navigation']   = $page->showBreadcrumbs($page->breadcrumbsArray);
@$API['template']   = $page->data['template'] ? api::setTemplate($page->data['template']) : api::setTemplate($API['modules']['page']['defaultTemplate']['ru']['value']);//$API['template'];


$_template='page.html';
if (!empty($page->data['template'])) $_template = $page->data['template'];

$smarty->assign("content",$page->data['text']);
$smarty->assign("pageTitle",$API['pageTitle']);
$smarty->assign("child",@$page->data['child']);


//print_r ($API['modules']['page']['defaultTemplate']['ru']['value']);

?>
