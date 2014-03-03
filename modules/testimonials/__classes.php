<?php
if (!defined("API")) {
	exit("Main include fail");
}

class testimonials {	
    public $data = array();

	private $getArray	= array();
    private $postArray	= array();
    private $error = array();
	
	public static $arrCommands = array(array("uri" => "testimonials"),
        array("uri" => "testimonialsend"),
        array("uri" => "testimonialview"),
    );
	
	/**
	 *	Список отзывов
	 *
	 */
	private function testimonialsList () {
		global $sql, $smarty;		
		
		$result = '<h1>Отзывы</h1>';
		
		// Форма отправки только для авторизированных пользователей
		if (Security::$auth && !empty (Security::$userData)) {
			$template = new template (api::setTemplate ("modules/testimonials/index/index.sendform.html"));
			
			$template->assign ("userID", Security::$userData['id']);
			
			$result .= $template->get ();
		} else {
			$result .= "<p>Чтобы добавить отзыв, вам необходимо авторизироваться</p><br /><br />";
		}
		
		$sql->query ("	select 
							`testimonials`.`name`,
							date_format(`testimonials`.`date`, '%d.%m.%Y - %H:%i') as `date`,
							`testimonials`.`text`,
							`testimonials`.`rating`,
							`shop_users`.`name` as `username`
						from 
										`testimonials`
							inner join 	`shop_users`
							on
								`testimonials`.`user_id` = `shop_users`.`id`
						where
							`testimonials`.`owner_id` = '0'
						order by
							`testimonials`.`date` desc");
				
		if ($sql->num_rows ()) {
			$template = new template (api::setTemplate ("modules/testimonials/index/index.testimonial.item.html"));
				
			while ($sql->next_row ()) {
				$template->assign ('testimonialText', $sql->result['text']);
				$template->assign ('userName', $sql->result['username']);
				$template->assign ('testimonialDate', $sql->result['date']);
				
				$result .= $template->get ();
			}
		} else {
			
		}		
		
		//print_r ($_SESSION);
		
		$this->data['title'] = 'Отзывы';
		$this->data['pageTitle'] = 'Отзывы';
		$this->data['content'] = $result;
		$this->data['md'] = '4';
		$this->data['mk'] = '5';
		$this->data['navigation'] = '6';
		$this->data['template'] = 'inner.html';		
	}
	
	/**
	 *	Отправка отзыва
	 *
	 */
	private function testimonialSend () {
		global $sql;
	
		//print_r ($this->postArray);
		
		$ownerId = isset ($this->postArray['item_id']) ? strip_tags ($this->postArray['item_id']) : '';
		$userId = isset ($this->postArray['user_id']) ? intval ($this->postArray['user_id']) : '';
		$name = isset ($this->postArray['testimonialName']) ? strip_tags ($this->postArray['testimonialName']) : '';
		$text = isset ($this->postArray['testimonialText']) ? strip_tags ($this->postArray['testimonialText']) : '';				
		
		if (($ownerId == 0 || !empty($ownerId)) && !empty($userId) && !empty($text)) {
			$sql->query ("insert into 
								`testimonials` (`owner_id`, `user_id`, `name`, `date`, `text`) 
							values
								('".$ownerId."','".$userId."','".$name."',NOW(),'".$text."')");
			$_SESSION['testimonialSendSuccess'] = '1';
			header ("location: ".$_SERVER['HTTP_REFERER']);
		} else {
			$_SESSION['testimonialSendSuccess'] = '0';
			if (empty($text)) {
				$_SESSION['testimonialSendError'] = "Поле \"Отзыв\" не заполнено";
			} /*elseif (empty($ownerId)) {	
				$_SESSION['testimonialSendError'] = "err = ownerId";
			} elseif (empty($userId)) {	
				$_SESSION['testimonialSendError'] = "err = userId";
			}*/
			header ("location: ".$_SERVER['HTTP_REFERER']);
		}
	
		$this->data['title'] = '11';
		$this->data['pageTitle'] = '22';
		$this->data['content'] = '33';
		$this->data['md'] = '44';
		$this->data['mk'] = '55';
		$this->data['navigation'] = '66';
		$this->data['template'] = 'inner.html';	
	}
	
    function __construct($uri='') {
		global $sql, $admLng;

        if (isset($_GET) && !empty($_GET)) {
            $this->getArray = api::slashData($_GET);
        }

        if (isset($_POST) && !empty($_POST)) {
            $this->postArray = api::slashData($_POST);
        };

        if(!empty($uri)){

			// Работа с модулем
			
			//print_r ($uri);
			switch ($uri) {
				default:
				case "testimonials":
					$this->testimonialsList ();
				break;
				case "testimonialsend":
					$this->testimonialSend ();
				break;
			}            
        }
	}
	
	public static function installModule() {
        $router = api::object_from_file("chache/router.txt");
        $router['testimonials'] = testimonials::$arrCommands;
        print_r($router);
        api::object2file($router, 'chache/router.txt');        		

        return true;
    }
}
?>
