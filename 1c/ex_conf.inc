<?php

// переменные скрипта
$upl_dir='../userfiles/catalog/'.'upl/';      // директория для загрузки
$data_dir='../userfiles/catalog/'.'1cbitrix/'; // директория для данных
$arc_size=eregi_replace("([^0-9])", "", "504800");   // размер частей архива
$us_name = 'test'; // имя пользователя 1С
$us_pwd = 'test'; // пароль 1С

include("../include/__config.php");
?>