<?php
/**
 * Класс для работы с приватными данными
 *
 * @author $Id: class.Security.php 98 2013-01-14 06:16:27Z  $
 */
class Security {
    /**
     * Переменная, указывающая, осуществлена ли авторизация
     * @var type Boolean
     */
    public static $auth = false;
    
    /**
     * Информация об авторизированном пользователе
     * @var type array
     */
    public static $userData = array ();
    
    /**
     * Список команд модуля
     * @var type array
     */
    public static $arrCommands = array (    array("uri" => "getstate"), 
                                            array("uri" => "login"),
                                            array("uri" => "logingo"),
                                            array("uri" => "logout"),
                                            array("uri" => "register"),
                                            array("uri" => "registergo"),
                                            array("uri" => "cabinet"),
                                            array("uri" => "savedata"),
                                            array("uri" => "forgotpass")
                                        );
    
    /**
     * Установка в кэш router.txt команд, нужных для функционирования модуля
     */
    public static function installSecurityModule () {
        $router = api::object_from_file("chache/router.txt");
        
        $router['security'] = Security::$arrCommands;
        
        print_r ($router);
        
        api::object2file ($router, 'chache/router.txt');        
        
        return true;
    }
    
    function __construct() {
        // Проверка на наличие в сессии нужного ключа, в зависимости от этого устанавливается ::auth, а так же получаются данные о пользователе
        global $sql;
        
        // Проверяем, а есть ли сессия вообще
        if (strlen(session_id()) && isset($_SESSION['sec_id'])) {
            $sql->query ("select * from `shop_users` where `id`='".intval($_SESSION['sec_id'])."'", true);
                        
            $db_sessid = $sql->result['seed'];
            $sessid = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].$_SESSION['sec_id']);
            
            // Сессия есть, проверяем валидность
            if ($db_sessid == $sessid) {
                Security::$auth = true;
                Security::$userData = array (
                    "id" => $sql->result['id'],
                    "email" => $sql->result['email'],
                    "name" => $sql->result['name'],
                    "surname" => $sql->result['surname'],
                    "patronymic" => $sql->result['patronymic'],
                    "reg_date" => $sql->result['reg_date'],
                    "org" => $sql->result['org'],
                    "state" => $sql->result['state'],
                    "data" => json_decode($sql->result['data'], true)
                );
            } else {
                Security::$auth = false;
                Security::$userData = array ();
            }
        } else {
            Security::$auth = false;
            Security::$userData = array ();
        }
    }  
}

