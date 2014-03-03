<?php
//error_reporting(0);
set_time_limit(0);
foreach ($_GET as $arrkey=>$data ) // отслеживание запросов к скрипту
	{
		$fps = fopen('querys.txt', "a");
		$result = fwrite($fps, $arrkey."   ".$data."\n");
        fclose($fps);
  	}

require('ex_conf.inc');
//echo $upl_dir;
if (true)
//If ($_SERVER[PHP_AUTH_USER]==$us_name && $_SERVER[PHP_AUTH_PW]==$us_pwd)
{

// проверка авторизации
   If ($_GET['mode']=="checkauth")
   	{
		echo "success\n";
   		echo "test\n";
   		echo "value_test";
	}


// запрос параметров импорта
   If ($_GET['mode']=="init")
   	{
   		echo "zip=yes\n";
   		echo "file_limit=".$arc_size;
   	}

// передача файла
	If ($_GET['mode']=="file" and $_GET['type']=="catalog") // получение файла с товарами
   		{
   			//Здесь работаем с содержимым переданного файла.
		    $fcont = file_get_contents("php://input");
			$fp = fopen($upl_dir.$_GET['filename'], "ab");
			$result = fwrite($fp, $fcont);
        	fclose($fp);
    		if ($result == true) // проверка: получен ли файл успешно
				{
					$fpf = fopen('fflag',"w");    // создаём флаговый файл
					$fpfres = fwrite($fpf, $_GET['filename']); // записываем в него имя полученного файла
					fclose($fpf);
					echo "success";
				}
			else {echo "failure"; die (iconv('UTF-8', 'CP1251',"не удалось записать файл каталога"));}
		}

// запрос данных с сайта
	If ($_GET['mode']=="query" and $_GET['type']=="sale")
  		{
  	     	include('do_sql.php');
  		}

// ответ от 1С об успешном получении файла с заказами
  If ($_GET['mode']=="success" and $_GET['type']=="sale")
  		{
  	 		include("do_sql.php");
  		}

// запрос на загрузку данных с товарами в базу сайта
  If ($_GET['mode']=="import")
  	{
		If (file_exists('fflag')) // проверяем существует ли флаговый файл
			{
				$fp = fopen('fflag',"r");
				$fvar = fread($fp, filesize('fflag'));
				fclose($fp);
				unlink('fflag');
			}
		If (isset($fvar) and file_exists($upl_dir.$fvar)) // проверяем есть ли переменная с именем файла и существует ли файл архива
			{
        		if ( unzip_file($upl_dir.$fvar, 'import.xml', $upl_dir.'_tmp.xml')== true)
					{
                       	$isupdate='';
                       	$xml=simplexml_load_file($upl_dir.'_tmp.xml');
                       	$isupdate=(string)$xml->Каталог->attributes()->СодержитТолькоИзменения;
                        unset($xml);
						unlink($upl_dir.'_tmp.xml');
						if ($isupdate=='false') { del_dir($data_dir.'import_files/'); }
					}
				else {echo "failure\n"; die (iconv('UTF-8', 'CP1251',"Ошибка получения параметров импорта каталога"));}
        		if (extractZip($upl_dir.$fvar, "",$data_dir) == true ) // если файл распакован успешно, то стираем архив
        			{
        				unlink($upl_dir.$fvar);
        			}

			}
		If (file_exists('fflag')) // тупая проверка... если флаговый файл всё ещё существует почему-то то по идее архив не распакован и файл не удален
		 {echo "failure\n"; die (iconv('UTF-8', 'CP1251',"не удалось распаковать архив с каталогом товаров"));}

         include("do_sql.php");
  	}


// обмен данными о заказах
   If ($_GET['mode']=="file" and $_GET['type']=="sale") // получение файла заказов
   	{
        $fcont = file_get_contents("php://input");
		$fp = fopen($upl_dir.$_GET['filename'], "ab");
		$result = fwrite($fp, $fcont);
        fclose($fp);
        $fext = end(explode(".", $upl_dir.$_GET['filename']));
		if ($result == true and $fext == "zip") // проверка: получен ли файл успешно
        	{
        		if (extractZip($upl_dir.$_GET['filename'], "", $data_dir) == true) // если файл распакован успешно, то стираем архив и посылаем success
        			{
        				unlink($upl_dir.$_GET['filename']);
			        	include('do_sql.php');
        			}
        		else {echo "failure"; die (iconv('UTF-8', 'CP1251',"не удалось записать файл заказов"));}
  // в связи с тем что 1С сука не посылает запрос на импорт файла с заказами, то придётся сюда фтыкать функцию импорта
        	}
        else {echo "failure";}
  	}
}
else
	{
		die( "failure\n");
	}


// функция распаковки архива выгрузки
function extractZip($zipFile = '', $dirFromZip = '', $zipDir = '') {

    $zip = zip_open($zipFile);

    if ($zip) {
        while ($zip_entry = zip_read($zip)) {
        	set_time_limit(0);
            $completePath = $zipDir . dirname(iconv('CP866', 'UTF-8', zip_entry_name($zip_entry)));
            $completeName = $zipDir . iconv('CP866', 'UTF-8', zip_entry_name($zip_entry));
            if (!file_exists($completePath) && preg_match('#^' . $dirFromZip .'.*#', dirname(zip_entry_name($zip_entry)))) {
                $tmp = '';
                foreach (explode('/', $completePath) as $k) {
                    $tmp .= $k . '/';
                    if (!file_exists($tmp)) {
                        @mkdir($tmp, 0777);
                    }
                }
            }

            if (zip_entry_open($zip, $zip_entry, "r")) {
                if (preg_match( '#^' . $dirFromZip . '.*#', dirname(zip_entry_name($zip_entry)))) {
                    if ($fd = @fopen($completeName, 'w+')) {
                        fwrite($fd, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
                        fclose($fd);
                    } else {
                        @mkdir($completeName, 0777);
                    }

                    zip_entry_close($zip_entry);
                }
            }
        }

        zip_close($zip);
    }

    return true;
}

// функция распаковки одного файла
function unzip_file($arcname='', $extfname='', $tmpfname='')
	{
		$zip = new ZipArchive;
		if ($zip->open($arcname) === true){
			if (@$fd = fopen($tmpfname, 'w+'))
				{
					fwrite ($fd, $zip->getFromName($extfname));
					fclose($fd);
				}
			$zip->close();
			return true;
		}else{
			return false;
		}
	}

function del_dir($dir) {
	if (is_dir($dir)) {
	$files = scandir($dir);
	array_shift($files);
	array_shift($files);

	foreach ($files as $file)
	  {
		$file = $dir . '/' . $file;
		if (is_dir($file))
		  {
			del_dir($file);
			if (is_dir($file))
			rmdir($file);
		  } else
		  		{
					unlink($file);
				}
	  }
rmdir($dir);
	}
}


?>