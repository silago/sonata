<?php
session_start();
include("include/classes/class.imageCheckCode.php");
$imageCheckCode = new imageCheckCode();
$imageCheckCode->create();
?>
