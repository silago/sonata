<?php
if (!defined("API")) {
	exit("Main include fail");
}


class mCfg extends cfg {	public $cfg = array(
						array(
							"userType",
							"Выбор метода рагистрации пользователя по умолчанию",
							"Укажите форму регистрация пользователя по умолчанию",
							"select",
							array(
									array('value' => '0', 'text' => 'Физическое лицо'), 							
									array('value' => '1', 'text' => 'Организация'), 							
							
							),							
							"no"

						)
				);


	public function check() {        return true;
	}
}
?>
