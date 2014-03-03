<?php
if (!defined("API")) {
	exit("Main include fail");
}

class mCfg extends cfg {
	public $cfg = array(
						array(
							"defaultTemplate",
							"Основной шаблон для модуля",
							"Оставьте на заполненым, если необходимо использовать основной шаблон системы",
							"text",
							"",
							"no"),

						array(
							"md",
							"Краткое описание (meta)",
							"Краткое описание всех страниц в модуле по умолчанию. Используется для SEO оптимизации.",
							"text",
							"",
							"no"),

						array(
							"mk",
							"Ключевые слова (meta)",
							"Ключевые слова всех страниц в модуле по умолчанию. Используется для SEO оптимизации",
							"text",
							"",
							"no"),

						array(
							"sendEmailTo",
							"Адрес электронной почты, на который необходимо напрявлять письма",
							"",
							"text",
							"",
							"yes"
							),

						array(
							"fromEmail",
							"Адрес электронной почты, который будет указан как обратный",
							"",
							"text",
							"",
							"yes"
							),


				);


	public function check() {
		if (!preg_match("/^[0-9a-z_\.\-]+@[0-9a-z\.\-]+\.[a-z]{2,6}$/i", $this->postArray['cfgParams']['sendEmailTo'])) {
			$this->errorParam = "sendEmailTo";
			return $this->show();
		}

		if (!preg_match("/^[0-9a-z_\.\-]+@[0-9a-z\.\-]+\.[a-z]{2,6}$/i", $this->postArray['cfgParams']['fromEmail'])) {
			$this->errorParam = "fromEmail";
			return $this->show();
		}

        return true;
	}
}
?>
