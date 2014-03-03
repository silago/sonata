<?php
if (!defined("API")) {
	exit("Main include fail");
}

$gallery = new gallery();
$gallery->lang 		= $lng;
$gallery->curLang	= $lang;

switch ($rFile) {
	case "index.php":
	case "index.html":
		$gallery->indexShow(0);
	break;

	case "album.html":
		if (!preg_match("/^[0-9]+$/", $uri[2])) page404();
		$gallery->indexShow((int)@$uri[2]);
	break;

	default:
		page404();

	}

@$API['content'] = $gallery->return['content'];
@$API['pageTitle'] = $gallery->return['pageTitle'];
@$API['siteTitle'] = $API['title']." | ".$gallery->return['pageTitle'];
@$API['navigation'] = $gallery->return['navigation'];
@$API['template'] = (!empty($gallery->return['template']) ? api::setTemplate($gallery->return['template']) : $API['template']) ;
@$API['md'] = (!empty($gallery->return['md']) ? $gallery->return['md'] : $API['md']);
@$API['mk'] = (!empty($gallery->return['mk']) ? $gallery->return['mk'] : $API['mk']);

?>