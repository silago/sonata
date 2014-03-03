<?php
if (!defined("API")) {
	exit("Main include fail");
}

$testimonials = new testimonials($ret['uriGroup']);

// If need redirect;
if (!empty($testimonials->data['redirect'])) {go($testimonials->data['redirect']);}

// Setting up all API values;
@$API['title']      = $testimonials->data['pageTitle'] ? $testimonials->data['pageTitle'] : $testimonials->data['title'] . " | " . @$API['title'];
@$API['pageTitle']	= $testimonials->data['title'];
@$API['content']    = $testimonials->data['content'];
@$API['md']		    = $testimonials->data['md'] ? $testimonials->data['md'] : $API['md'];
@$API['mk']		    = $testimonials->data['mk'] ? $testimonials->data['mk'] : $API['mk'];
@$API['navigation']   = '';//$page->showBreadcrumbs($page->breadcrumbsArray);
@$API['template']   = $testimonials->data['template'] ? api::setTemplate($testimonials->data['template']) : api::setTemplate($API['modules']['testimonials']['defaultTemplate']['ru']['value']);//$API['template'];

//print_r ($API['modules']['page']['defaultTemplate']['ru']['value']);

?>