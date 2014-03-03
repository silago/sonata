<?

/* REDIRECTION
 * 0 - Оставляем логику как есть
 * 1 - Перенаправляем 301 редиректом с страниц вида page.html?lang=ru на page.html
 * 2 - Перенаправляем 301 редиректом с страниц вида page.html на page.html?lang=ru
 */

$redirect = 1;

error_reporting(E_ALL);
ini_set("display_errors", "on");

unset($content, $api, $class, $templateMain, $login, $password, $_SESSION, $subTemplateBody, $subTemplateItem, $admin, $module, $session);

if(isset($_COOKIE['rem']) && $_COOKIE['rem'] == '1' && isset($_COOKIE['sess']) && !empty($_COOKIE['sess'])){
    session_id($_COOKIE['sess']);
}

session_start();

//unset($_SESSION['basket']);

// Include main config file and main functions
include ("include/__config.php");
include ("include/__functions.php");

// Init fckeditor system (mpuck)
include ("include/__wysiwyg.php");

// setingup language;
$lang = (!empty($_GET['lang']) ? sl($_GET['lang']) : $API['config']['defaultlang']);

// Including classes from directory "include/classes/"
if (!file_exists("include/classes/") || !is_readable("include/classes/")) {
    exit("Main API: can't access to include/classes/ directory");
}

$dirID = opendir("include/classes/");
while ($fileName = readdir($dirID)) {
    if (!preg_match("/^[a-z\.]+\.php$/i", $fileName)) {
        continue;
    }
    require("include/classes/" . $fileName);
}

// global config

$iniconf = new INIWork();
$iniconf->loadFromFile('chache/config.ini');






// Creating Classes
$mainTemplate = new template();
$sql = new MySQL();
$project = new projectClass();
$socket = new Socket();
$parcer = new Parcer();
$image = new image();
$main = new api();
$install = new install();
$navigation = new navigation();
$users = new users();
$mail = new mail();
$config = new config();

// Запускаем шаболонизатор Smarty
define('SMARTY_DIR', 'include/libs/');
require(SMARTY_DIR . 'Smarty.class.php');
$smarty = new Smarty();

// checkInstall MainAPI
$defaultLang = $API['config']['defaultlang'];

// check present lang;
$main->checkLang($lang);
/*
  // Setting up system locale
  $locales   = array("ru_RU.CP1251", "ru_RU.cp1251", "ru_RU", "RU", "Russian_Russia.1251", "rus_RUS.1251");
  $localeSet = false;
  foreach ($locales as $localeName) {
  if ((bool)$localeSet === false) {
  // setting up locase
  setlocale(LC_ALL, $localeName);
  }
  // check locale
  if ((bool)$localeSet === false && strtolower("qwertyёЁАБГДЯQWERTYZ") == "qwertyёёабгдяqwertyz") {
  // locale setup correctly
  $localeSet = true;
  }
  }
  if ((bool)$localeSet !== true) {
  // exiting now
  echo "Can't set up server locale to cp1251 character set at ".__FILE__." on ".__LINE__;
  exit();
  }

 */
// Classes Initaliaze
//
// MySQL
$sql->server = $API['config']['mysql']['server'];
$sql->username = $API['config']['mysql']['username'];
$sql->password = $API['config']['mysql']['password'];
$sql->db = $API['config']['mysql']['db'];
$sql->prefix = $API['config']['mysql']['prefix'];

// Инициализация модуля безопасности (зависимость от $sql)
$globalsecurity = new Security ();

// Check for install
//$install->checkMainInstall();
//$install->checkInstallAllModules();
// getAllLang
$dirId = opendir("templates");
$allLang = array();
while ($fName = readdir($dirId)) {
    if (preg_match("/^[a-z]+$/i", $fName) && is_dir("templates/" . $fName)) {
        $allLang[] = $fName;
    }
}

// Main API initaliszation
$sql->query("SELECT `category`, `type`, `name`, `value`, `description`, `lang` FROM #__#config");
while ($sql->next_row()) {
    $category = $sql->result[0];
    $type = $sql->result[1];
    $name = $sql->result[2];
    $value = $sql->result[3];
    $description = $sql->result[4];
    $sLang = $sql->result[5];

    $API[$category][$type][$name][$sLang]['value'] = $value;
    $API[$category][$type][$name][$sLang]['descr'] = $description;
}

$API['template'] = $main->setTemplate("index.html");
$API['title'] = $main->getConfig("main", "api", "projectTitle");
$API['md'] = $main->getConfig("main", "api", "md");
$API['mk'] = $main->getConfig("main", "api", "mk");


// Parcing uri
$uriToParce = getenv('REQUEST_URI');

if (!empty($API['config']['base'])) {
    $uriToParce = substr($uriToParce, strlen($API['config']['base']));
}

$uri = array_filter(explode("/", preg_replace('#/+#', '/', '/' . $uriToParce)));

if (!isset($uri[1]) || $uri[1] != 'admin') {

    if (count($uri) > 2) {
        page500();
    }

    if(!count($uri)){
        $ret['module'] = 'page';
        $ret['uriGroup'] = 'glavnaja';
    }

    $router = api::object_from_file("chache/router.txt");
    //print_r($router);
    $group = isset($uri[1]) ? $uri[1] : '';
    if (isset($uri[2])) $item = $uri[2];

    if (!empty($uri[1])) {

        preg_match('/^[a-z0-9\-]{1,}/', $group, $matches);
        foreach ($router as $key => $value) {
            foreach ($router[$key] as $key1 => $value1) {
                foreach ($router[$key][$key1] as $key2 => $value2) {
                    if ($value2 == $matches[0]) {
                        $ret['module'] = $key; //название модуля в котором используется проверяемый uri группы
                        $ret['id'] = $key1; //ключ группы в массиве $router
                        $ret['uriGroup'] = $value2; //uri
                    }
                }
            }
        }

        if (!isset($ret) || (strlen($ret['uriGroup']) == 0)) {
            page404();
        } else {
            if (!empty($uri[2])) {
                preg_match('/^[a-z0-9\-]{1,}/', $item, $matchItem);
                foreach ($router[$ret['module']][$ret['id']]['items'] as $key => $value) {
                    if ($value == $matchItem[0]) {
                        $ret['uriItem'] = $value;
                    }
                }

                if (strlen($ret['uriItem']) == 0) {
                    page404();
                }
            }
        }
  }

    define("API", 1);

    if (file_exists("modules/" . $ret['module'] . "/__classes.php")) {
        require("modules/" . $ret['module'] . "/__classes.php");
    }
    if (file_exists("modules/" . $ret['module'] . "/index.php")) {
        require "modules/" . $ret['module'] . "/index.php";
    }

} else {
// Seting up Uri params
    $uriParams = array();
    foreach ($uri as $key => $value) {
        if (preg_match("/^([a-z0-9]{1,10})\-([a-z0-9\%\+]{1,50})$/i", $uri[$key], $match)) {
            $uriParams[$match[1]] = slash(urldecode($match[2]));
            unset($uri[$key]);
        }
    }

    if (!preg_match("/^[a-z0-9_]+$/i", @$uri[1])) {
        $module = "none";
        $rFile = "index.php";
    } else {
        $module = $uri[1];
    }


// Gets request filename
    if (count($uri) > 1 && preg_match("/([a-z0-9_]+\.(?:[a-z0-9]{2,4}))[$\/]*/i", getenv('REQUEST_URI'), $match)) {
        $allCount = count($uri);
        unset($uri[$allCount]);
        $rFile = $match[1];
    } else {
        if (count($uri) > 1 && !preg_match("/\/\?/", getenv('REQUEST_URI')) && substr(getenv('REQUEST_URI'), -1, 1) != "/") {
            if ($module != "none")
                go(getenv('REQUEST_URI') . "/");
        }
        $rFile = "index.php";
    }

    if (count($uri) < 1 || $uri[1] === "index.php" || $uri[1] === "index.html" || $uri[1] === "index.php?lang=$lang" || $uri[1] === "index.html?lang=$lang" || (count($uri) === 1 && preg_match("/\/\?/", getenv('REQUEST_URI')))) {
        $module = $uri[1] = "page";
        $uric = count($uri);
    }

    if ($module == "none") {
        // redirect to page module
        //go($base."/page/index.php?lang=".$lang);
    } else {
        define("API", 1);
        $API['template'] = trim(($templateToSet = api::getConfig("modules", $module, "defaultTemplate")) != "" ? api::settemplate($templateToSet) : $API['template']);
        $API['md'] = (trim($main->getConfig("modules", $module, "md")) != "" ? $main->getConfig("modules", $module, "md") : $API['md']);
        $API['mk'] = (trim($main->getConfig("modules", $module, "mk")) != "" ? $main->getConfig("modules", $module, "mk") : $API['mk']);

        if (file_exists("modules/" . $uri[1] . "/__" . $lang . ".php")) {
            require("modules/" . $uri[1] . "/__" . $lang . ".php");
            @$lng = $l;
        } else {
            if (file_exists("modules/" . $uri[1] . "/__" . $defaultLang . ".php")) {
                require("modules/" . $uri[1] . "/__" . $defaultLang . ".php");
                @$lng = $l;
            }
        }

        if (file_exists("modules/" . $module . "/__classes.php")) {
            require("modules/" . $module . "/__classes.php");
        }

        if (file_exists("modules/" . $module . "/index.php")) {
            require "modules/" . $module . "/index.php";
        } else {
            page404();
        }
    }
    $smarty->assign("rFile", $rFile);
}

$curYear = intval(date("Y"));
$rusMonth = explode(" ", " января февраля марта апреля май июня июля августа сентября октября ноября декабря");
$uric = count($uri);
$base = $API['config']['base'];

$smarty->assign("curLang", $lang);
$smarty->assign("projectTitle", $main->getConfig('main', 'api', 'projectTitle'));

// Запускаем класс работы с почтой PHP Mailer
require("include/phpmailer/class.phpmailer.php");
$mail = new PHPMailer();
$mail->SetLanguage("ru", "include/phpmailer/language/");
$mail->PluginDir = "include/phpmailer/language/";
$mail->CharSet = "utf-8";
$mail->IsMail();

//echo "<pre>".var_export($uriParams, true)."</pre>";
// REDIRECTION
//без www на www
if (stristr($_SERVER['HTTP_HOST'], "www.") == false) {
    $rr = parse_url(getenv('REQUEST_URI'));
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: http://www." . $_SERVER['HTTP_HOST'] . "" . $rr['path']);
    exit();
}
// Если идет запрос с параметром lang=ru то перенаправляем на страницу без параметра
//$e = explode("?", getenv('REQUEST_URI'));
if ($redirect == 1 && !empty($e[1]) and stristr(getenv('REQUEST_URI'), "admin") == false) {
    $rr = parse_url(getenv('REQUEST_URI'));
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: " . $rr['path']);
    exit();
}

// Если идет запрос БЕЗ параметра то перенаправляем на страницу c параметром lang=ru
if ($redirect == 2 && empty($_GET['lang'])) {
    $rr = parse_url(getenv('REQUEST_URI'));
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: " . $rr['path'] . "/?lang=ru");
    exit();
}

// Seting up navigation
$navigation->setMainPage($main->getConfig("main", "api", "mainPageInNavigation"));

// Show main content
$mainTemplate->file($API['template']);
@$mainTemplate->assign("title", (!@empty($API['siteTitle']) ? $API['siteTitle'] : $API['title']));
@$mainTemplate->assign("pageTitle", $API['pageTitle']);
@$mainTemplate->assign("content", $API['content']);
@$mainTemplate->assign("navigation", $API['navigation']);
@$mainTemplate->assign("md", $API['md']);
@$mainTemplate->assign("mk", $API['mk']);


@$mainTemplate->assign("mainPageInNavigation", $main->getConfig("main", "api", "mainPageInNavigation"));

/*
  if ($uri[1] == "auto") {
  @$contentToReplace = $API['content'];
  @$API['content'] = "_TO_REPLACE_";
  @$mainTemplate->assign("content", 	 $API['content']);
  ob_start();
  $mainTemplate->out();

  $utf8_content = mb_convert_encoding(ob_get_contents(), "utf-8", "cp1251");
  $utf8_content = str_replace(array("cp1251", "windows-1251"), "utf-8", $utf8_content);
  $utf8_content = str_replace("_TO_REPLACE_", $contentToReplace, $utf8_content);
  ob_end_clean();
  echo $utf8_content;
  } else { */
$mainTemplate->out();

// Сохраняем потенциально измененные настройки обратно в ini sфайл
$iniconf->updateFile();
//}
?>