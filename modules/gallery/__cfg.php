<?php
if (!defined("API")) {
	exit("Main include fail");
}

class mCfg extends cfg {
	public $cfg = array(
						array(
							"defaultTemplate",
							"Основной шаблон для модуля",
							"Оставте на заполненым, если необходимо использовать основной шаблон системы",
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
							"uploadImageGroupDir",
							"Каталог в который будут загружаться миниатюры для альбомов",
							"Укажите каталог, в который необходимо загружать изображения. Не изменяйте этот параметр из любопытсова.",
							"text",
							"",
							"yes"),

						array(
							"uploadImageThumbDir",
							"Каталог в который будут загружаться миниатюры",
							"Укажите каталог, в который необходимо загружать изображения. Не изменяйте этот параметр из любопытсва. По умолчанию настроено верно.",
							"text",
							"",
							"yes"),

						array(
							"uploadImageBigDir",
							"Каталог в который будут загружаться изображения большого размера",
							"Укажите каталог, в который необходимо загружать изображения большого размера. Не изменяйте этот параметр из любопытсва.",
							"text",
							"",
							"yes"),

						array(
							"limitsImageGroup",
							"Размер миниатюры для альбома",
							"До какого размера необходиио уменьшать изображение. Задается в формате XXX YYY (ширина высота), где XXX и YYY целые числа (количество пикселей)",
							"text",
							"",
							"yes"),

						array(
							"limitsImageThumb",
							"Размер миниатюр",
							"До какого размера необходиио уменьшать изображение. Задается в формате XXX YYY (ширина высота), где XXX и YYY целые числа (количество пикселей)",
							"text",
							"",
							"yes"),

						array(
							"limitsImageBig",
							"Размер фотографии большого размера",
							"До какого размера необходиио уменьшать изображение большого размера. Задается в формате XXX YYY (ширина высота), где XXX и YYY целые числа (количество пикселей). Если значения равны нулю, то размер изменяться не будет.",
							"text",
							"",
							"yes"),
				);


	public function check() {
		if (substr($this->postArray['cfgParams']['uploadImageGroupDir'], -1, 1) != "/") {
			$this->postArray['cfgParams']['uploadImageGroupDir'] = $this->postArray['cfgParams']['uploadImageGroupDir']."/";
		}

		if (substr($this->postArray['cfgParams']['uploadImageThumbDir'], -1, 1) != "/") {
			$this->postArray['cfgParams']['uploadImageThumbDir'] = $this->postArray['cfgParams']['uploadImageThumbDir']."/";
		}

		if (substr($this->postArray['cfgParams']['uploadImageBigDir'], -1, 1) != "/") {
			$this->postArray['cfgParams']['uploadImageBigDir'] = $this->postArray['cfgParams']['uploadImageBigDir']."/";
		}
		/*
		if (!preg_match("/^[0-9]+\s[0-9]+$/", $this->postArray['cfgParams']['limitsImageGroup'])) {
			$this->errorParam = "limitsImageGroup";
			return $this->show();
		}
		if (!preg_match("/^[0-9]+\s[0-9]+$/", $this->postArray['cfgParams']['limitsImageThumb'])) {
			$this->errorParam = "limitsImageThumb";
			return $this->show();
		}

		if (!preg_match("/^[0-9]+\s[0-9]+$/", $this->postArray['cfgParams']['limitsImageBig'])) {
			$this->errorParam = "limitsImageBig";
			return $this->show();
		}
		*/
        return true;
	}
}
?>
