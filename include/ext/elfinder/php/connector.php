<?php

error_reporting(E_ALL);
ini_set("display_errors", "off");

include_once($_SERVER['DOCUMENT_ROOT']."/include/classes/class.image.php");


include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderConnector.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinder.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeLocalFileSystem.class.php';
// Required for MySQL storage connector
// include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeMySQL.class.php';
// Required for FTP connector support
// include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeFTP.class.php';


#Функция преобразование в транслит

function elf_translit($string) {
$letters = array("а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "е" => 
          "e", "ё" => "e",  "ж" => "zh", "з" => "z", "и" => "i", "й" => "j", "к" => "k", 
          "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r", "с" => 
          "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h", "ц" => "ts", "ч" => "ch", 
          "ш" => "sh", "щ" => "shch", "ы" => "y", "э" => "e", "ю" => 
          "yu", "я" => "ya");
$string = preg_replace("/[_ .,?!\[\](){}]+/", "-", $string);
$string = mb_strtolower($string,'utf-8');
$string = preg_replace("#(ь|ъ)([аеёиоуыэюя])#u", "j\2", $string);
$string = preg_replace("#(ь|ъ)#u", "", $string);
$string = strtr($string, $letters);
$string = preg_replace("/j{2,}/", "j", $string);
$string = preg_replace("/[^0-9a-z-]+/", "", $string);
$string = preg_replace("/-+/", "-", $string);
$string = trim($string,'-');
return !$string?'untitled':$string;
}
###



/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 * This method will disable accessing files/folders starting from  '.' (dot)
 *
 * @param  string  $attr  attribute name (read|write|locked|hidden)
 * @param  string  $path  file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function access($attr, $path, $data, $volume) {
	return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
		? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
		:  null;                                    // else elFinder decide it itself
}

session_start();

if(isset($_SESSION['auth']) && (($_SESSION['auth']['accessRight'] == '1') || ($_SESSION['auth']['accessRight'] == '2'))){

global $_REQUEST;


$url = '/upload/';
$path = '../../../../upload/';

if(isset($_REQUEST['module']) && !empty($_REQUEST['module'])){	
	
	if(isset($_REQUEST['area']) && !empty($_REQUEST['area'])){	
		
		if(isset($_REQUEST['type']) && !empty($_REQUEST['type'])){		
			$url = '/upload/'.$_REQUEST['module'].'/'.$_REQUEST['area'].'/'.$_REQUEST['type'].'/';
			$path = '../../../../upload/'.$_REQUEST['module'].'/'.$_REQUEST['area'].'/'.$_REQUEST['type'].'/';
		}else{
			$url = '/upload/'.$_REQUEST['module'].'/'.$_REQUEST['area'].'/';
			$path = '../../../../upload/'.$_REQUEST['module'].'/'.$_REQUEST['area'].'/';
		}		
	}else{
		$url = '/upload/'.$_REQUEST['module'].'/';
		$path = '../../../../upload/'.$_REQUEST['module'].'/';
	}
}

    /**
     * Simple logger function.
     * Demonstrate how to work with elFinder event api.
     *
     * @param  string        $cmd     command name
     * @param  object|array  $volumes  current volumes or source/destination volumes list for command "paste"
     * @param  array         $return  command result
     * @return array
     * @author Dmitry (dio) Levashov
     **/
    function logger($cmd, $result, $volumes, $elfinder) {
        $vol = new elFinderVolumeLocalFileSystem();
        foreach($result['added'] as $key=>$value){

            $dir = $elfinder->realpath($value['phash']);
            $pinfo = pathinfo($value['name']);
            $dirHash =  $vol->encode($dir.'/');
            $dirId = explode('_', $value['phash']);

            if (preg_match("/[^0-9a-z-]/is",$pinfo['filename'])) {
				print_r($pinfo);
                $new_name = elf_translit($pinfo['filename']).(($pinfo['extension'])?'.'.$pinfo['extension']:'');
				
				
				
                if (is_file($dir.'/'.$new_name)) $new_name = $vol->uniqueName($dir,$new_name,'-',false);				
				
				
                $result['added'][$key]['name'] = $new_name;
                
				$filehash = $vol->encode($dir.'/'.$new_name);
                $hash = $dirId[0].'_'.preg_replace('/'.$dirHash.'/', '', $filehash);
                $result['added'][$key]['hash'] = $hash;
                $vol->_move($dir.'/'.$value['name'], $dir, $new_name);

                $image = new image();
                echo($new_name);
				$src = $dir.'/'.$new_name;
                $filename = $hash;
				//echo $filename;
                $dest_image_size = array('../../../../upload/thumbnails/', '220', '220');
                $crop = true;
                $image->resizeEx($src, $filename, $dest_image_size, $crop, false, false, $pinfo['extension']);
            }else{
                $image = new image();
                $src = $dir.'/'.$value['name'];
                $filehash = $vol->encode($dir.'/'.$value['name']);
                $hash = $dirId[0].'_'.preg_replace('/'.$dirHash.'/', '', $filehash);
                $filename = $hash;
                $dest_image_size = array('../../../../upload/thumbnails/', '220', '220');
                $crop = true;
                $image->resizeEx($src, $filename, $dest_image_size, $crop, false, false, $pinfo['extension']);
            }
        }
        return $result;
    }

    $opts = array(
		// 'debug' => true,
		'bind' => array('duplicate upload paste' => 'logger'),
		'roots' => array(
			array(
				'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)				
				'path'          => $path,         // path to files (REQUIRED)								
				'tmbSize' 		=> 150,
				'imgLib' 		=> 'gd',
				'URL'           => $url, // URL to files (REQUIRED)
				'tmbPath'       => '.tmb',
				'accessControl' => 'access',             // disable and hide dot starting files (OPTIONAL)
				'uploadOverwrite' => false,
				'copyOverwrite' => true,
				'copyJoin' => true,
                'uploadDeny' => array('all'),
                'uploadAllow' => array('image'),
                'uploadOrder' => 'deny,allow',
                'disabled' => array('mkdir', 'mkfile', 'rename'),
                //'acceptedName' => '/^[0-9A-Za-z_.-]+$/u',
                //'acceptedName' => 'validName',
                'attributes' => array(
                    array(
                        'pattern' => '/thumbnails/',
                        'read' => true,
                        'write' => true,
                        'hidden' => true,
                        'locked' => false,
                    ),

                    array(
                        'pattern' => '/^catalog$/',
                        'read' => true,
                        'write' => true,
                        'hidden' => false,
                        'locked' => true,
                    ),

                    array(
                        'pattern' => '/^images$/',
                        'read' => true,
                        'write' => true,
                        'hidden' => false,
                        'locked' => true
                    ),

                    array(
                        'pattern' => '/.jpg|.png|.jpeg|.gif/',
                        'read' => true,
                        'write' => true,
                        'hidden' => false,
                        'locked' => false
                    ),

                ),
		    ),
		)
	);

// run elFinder
$connector = new elFinderConnector(new elFinder($opts), true);
$connector->run();
}else{echo 'Че нада?!';}
