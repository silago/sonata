<?php
class SecurityModel
{
	function __construct()
	{
		
	}
	
	
	function addUser()
	{
		global  $sql;	
		 $sql->query("
		 
		 INSERT INTO `#__#shop_users` 
		 (`email`, `password`, `name`, `surname`, `patronymic`, `reg_date`, `org`, `state`, `data`, `phone`)					                                
		 VALUES
		 ('" . $_POST['email'] . "', '" . md5($_POST['pass']) . "', '" . $_POST['name'] . "', '" . $_POST['surname'] . "', '" . $_POST['patronymic'] . "', NOW(), '0', '0', '".''."', '".$_POST['phone']."')");
			
	}
	
	function getUserList($id=false)
	{	global  $sql;		
			
		
		if (!$id)
			$where = '1';
		else 
			$where = " `id` = {$id}  ";
			
		$sql->query("select * from shop_users where {$where} order by reg_date desc");         
		$r  = $sql->getList();   
        foreach ($r as &$row):
            
            $row['data']=json_decode($row['data'],true);
            $row['data']=@$row['data']['data'];

        endforeach;
        return $r;
		# парсить ебическую строку data =\ это лучше к хуям снести
		
		#foreach ($result as &$item) 
		#	{
		#	
		#	$item['data'] = json_decode($item['data'],true);
		#	$item['data'] = explode('&',$item['data']['form']);
		#	foreach ($item['data'] as &$item2)
		#		{
		#		$item2 = explode('=',$item2);
		#		}
		#	
		#	## нахуй нахуй
		#	unset($item['data']);
		#	}
		#
		
		
		return $result;
	}
	
	function deleteUser($id)
	{		global  $sql;	
		
		$sql->query("delete from shop_users where id ='{$id}'");         
 
	}
	
	
	
	function createUserValidate()
	{
	if(empty($_POST['name']) || !preg_match('/^[a-zа-я]+$/ui', $_POST['name']))
		{$error[]='Неверно указано имя пользователя';}
	if(empty($_POST['surname']) || !preg_match('/^[a-zа-я]+$/ui', $_POST['surname']))
		{$error[]='Неверно указана фамилия пользователя';}
	if(empty($_POST['patronymic']) || !preg_match('/^[a-zа-я]+$/ui', $_POST['patronymic']))
		{$error[]='Неверно указано отчество пользователя';}
			
	if(empty($_POST['phone']) || !preg_match("/^[0-9]{4,13}+$/", $_POST['phone'])){
				$err[] = 'Неверно заполнено поле телефон';		
			}
	
			if(empty($_POST['email']) || !preg_match('/^[a-z]{1,}[a-zа-я0-9\.\-\_]+@[a-zа-я0-9\-]{2,}+\.[a-zа-я]{2,5}$/ui', $_POST['email'])){
			$err[] = 'Неверно заполнено поле Ваш E-mail адрес';
			}else{			
			$sql->query("SELECT `id` FROM `#__#shop_users` WHERE `email` ='" . $_POST['email'] . "'", true);
			if($sql->num_rows()>0){				
			$err[] = 'Введеный E-mail адрес уже используется';

			}	

			}
			
	
			if(!preg_match(SecurityModule::$passCheck, $_POST['pass'])){			
			$err[] = 'Поле Пароль содержит недопустимые символы';
			#$err['pass'] = 'Введеный E-mail адрес уже используется';

			}

			if(strlen($_POST['pass']) < SecurityModule::$passLength){		
			$err[] = 'Длинна пароля меньше допустимого количества символов';

			}

			if($_POST['pass'] !== $_POST['pass2']){			
			$err[] = 'Не совпадают значения полей Пароль и Подтверждение пароля';

			}   
			
	return $err;
	
	}
	
	function updateUser($id)
	{		global  $sql;	
		
		
		$sql->query("update shop_users set 
			email = '".$_POST['email']."',
			name = '".$_POST['name']."',
			surname = '".$_POST['surname']."',
			patronymic = '".$_POST['patronymic']."',
			
			phone = '".$_POST['phone']."'
			where id ='{$id}'");         
 
	}


	
}


?>
