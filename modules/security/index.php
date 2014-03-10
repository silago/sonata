<?php
if (!defined("API")) {
	exit("Main include fail");
}

include_once 'modules/security/__classes.php';
include_once 'modules/basket/__classes.php';
include_once 'modules/orders/__classes.php';
include_once 'modules/catalog/__classes.php';

$catalog = new catalog();
$basket = new Basket();
$security = new SecurityModule();
$orders = new Orders();

switch ($ret['uriGroup']) {

    case "getstate":
        if (isset($_POST['modCall']) && intval($_POST['modCall']))
            if (Security::$auth) {
                $security->getAjaxCabinet(Security::$userData['id']);
            } else {
                $security->getAjaxAuthForm();
            }      
        else echo "mod include fail";
        die ();
    break;

    case "gettotal":
       
                $security->total();           
        die ();
    break;

    case "login":

        if(Security::$auth == true){ 
            message("Вы уже авторизованы", "", "catalog", "alert-info");
        }else{
            $security->login();            
        }
    break;

    case "logingo":

        if(Security::$auth == true){

            message("Вы уже авторизованы", "", "catalog", "alert-info");
        }else{
        
            if(!isset($_POST['go'])){
                message("Для авторизации необходимо заполнить форму", "", "login", "alert-error");
            }else{
                $security->logingo();				
            }
        }
	$API['template'] = 'ru/page.html';	
    break;

    case "logout":
        if(Security::$auth == true){
            $security->logout();
        }else{
            message("Вы не авторизованы", "", "login", "alert-error");
        }
    break;

    case "register":
        if(Security::$auth == true){
            message("Вы уже авторизованы", "", "catalog", "alert-info");
        }else{
            $security->register();
            $API['template'] = 'ru/page.html';
        }
    break;

    case "registergo":
        if(isset($_POST['value'])){
            $security->registerGo();
            die();
        }else{
            message("Необходимо заполнить форму регистрации", "", "register", "alert-error");
        }
    break;

    case "cabinet":
        if(Security::$auth == true){
            $security->cabinet();
            $API['template'] = 'ru/page.html';
        }else{
            message("Для входа в личный кабинет заполните форму", "", "login", "alert-error");
        }
    break;

    case 'savedata':
        if(Security::$auth == true){
            $security->savedata($_SESSION['sec_id']);
            $API['template'] = 'ru/page.html';
        }else{
            message("Для изменения личных данных необходимо войти в кабинет", "", "login", "alert-error");
        }
    break;

    case "forgotpass":
        $security->restorePass();
        
        break;

    default:
        page404();
}

@$API['template']   = strlen ($security->template) ? api::setTemplate($security->template) : $API['template'];

/*
$md = api::getConfig("modules", "vote", "md");
$mk = api::getConfig("modules", "vote", "mk");

if (!empty($md)) $API['md'] = $md;
if (!empty($mk)) $API['mk'] = $mk;
*/
//if (empty($catalog->data['pageTitle'])) {
//	$catalog->data['pageTitle'] = $catalog->lang['startPageTitle'];
//}
#print_r($security);
@$API['title']	 = $security->pageTitle;
#@$API['navigation']  = $catalog->showBreadcrumbs($catalog->breadcrumbsArray);
#@$API['template'] 	 = $catalog->data['template'] ? api::setTemplate($catalog->data['template']) : $API['template'];
@$API['content'] 	 = strlen ($security->content) ? $security->content : $API['content'];
/*@$API['md'] = (empty($mk) ? $catalog->data['md'] : $API['md']);
@$API['mk'] = (empty($mk) ? $catalog->data['mk'] : $API['mk']);
@$API['pageTitle'] 	= $catalog->data['pageTitle'];*/
