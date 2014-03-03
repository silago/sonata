<?php

if (!defined("API")) {
    exit("Main include fail");
}

$news = new news();
$news->lang = isset ($lng) ? $lng : '';
$news->smarty = &$smarty;
$news->mail = &$mail;
$news->api = &$API;
$news->sql = &$sql;



if (!empty($ret['uriItem'])) {
    $area = 'item';
} else {
    $area = 'group';
}


switch ($area) {
    case 'group':
        $news->showGroup($ret['uriGroup']);
        break;

    case 'item':
        $news->show($ret['uriItem']);
        break;
}


/* switch ($uri[2]) {
  case "show":
  $news->show($reqestUri[1]);
  break;

  case "showGroup":
  $news->showGroup($reqestUri[1]);
  break;

  default:

  page404();
  break;


  } */


@$API['title'] = (empty($news->data['pageTitle']) ? $news->data['title'] : $news->data['pageTitle']) . " | " . @$API['title'];
@$API['pageTitle'] .= $news->data['title'];
@$API['content'] = $news->data['content'];
@$API['navigation'] = $news->showBreadcrumbs($news->breadcrumbsArray);
@$API['template'] = !empty($news->data['template']) ? api::setTemplate($news->data['template']) : api::setTemplate($API['modules']['news']['defaultTemplate']['ru']['value']);//$API['template'];
@$API['md'] = $news->data['md'];
@$API['mk'] = $news->data['mk'];
?>