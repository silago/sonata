<?php
/*
Модуль администрирования
Системы управления содержимым сайта

$Id: index.php 93 2012-12-19 02:17:12Z  $
*/

if (!defined("API")) {
	exit("Main include fail");
}

if (@$uri[2] == "logout") {
	$users->clearAuth();
	go("/");
}

if (empty($uri[2])) {
	go((isset ($base) ? $base : '')."/admin/page/index.php");
}

if (!isset($uri[2]) || !preg_match("/^[a-z0-9_]+$/i", $uri[2], $match) || !file_exists("modules/".$uri[2]) || !is_dir("modules/".$uri[2]) || !file_exists("modules/".$uri[2]."/admin.php") || $uri[2] == "admin") {
	page404();
}
$trace = $users->checkAccessToModule($uri[2], $lang);
if ($users->getSinginUserInfo("accessRight") == 2 && $users->checkAccessToModule($uri[2], $lang) !== true) {
	// if moderation go to the thist accessibility module
	$modulesAccess=$users->getSinginUserInfo("accessModules");
	$toLocate = split(":", 	$modulesAccess[0]);
	//echo "Try to redirect to "."/admin/".$toLocate[0]."/index.php?lang=".$toLocate[1];
	go("/admin/".$toLocate[0]."/index.php?lang=".$toLocate[1]);
	exit(0);
}


if ($users->checkLogin() !== true || $users->checkAccessToModule($uri[2], $lang) !== true) {
	$users->showLoginForm();
	exit();
}

// including admin sub module in module;
$install->checkInstall($uri[2]);
if (file_exists("modules/".$uri[2]."/__classes.php")) {
	include("modules/".$uri[2]."/__classes.php");
}


// Load lang
if (file_exists("modules/".$uri[2]."/__".$lang.".php")) {
	require("modules/".$uri[2]."/__".$lang.".php");
	@$admLng = $l;
} else {
	if (file_exists("modules/".$uri[2]."/__".$defaultLang.".php")) {
		require("modules/".$uri[2]."/__".$defaultLang.".php");
		@$admLng = $l;
	}
}

$API['template']=api::setTemplate("admin.html");
$_template = "bootstrap.html";


require("modules/".$uri[2]."/admin.php");
?>
