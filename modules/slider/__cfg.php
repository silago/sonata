<?php
if (!defined("API")) {
	exit("Main include fail");
}

class mCfg extends cfg {
	public $cfg = array(

						array(
							"uploadImageDir",
							"Каталог в который будут загружаться изображения",
							"Укажите каталог, в который необходимо загружать изображения. Не изменяйте этот параметр из любопытсова.",
							"text",
							"",
							"yes"),

						array(
							"limitsImage",
							"Размер изображения",
							"До какого размера необходиио уменьшать изображение. Задается в формате XXX YYY (ширина высота), где XXX и YYY целые числа (количество пикселей)",
							"text",
							"",
							"yes"),
							
						array(
							"imagequality",
							"Качество",
							"задается числом от 0 до 100. 0 - минимальное качество, 100 - без компрессии (максимальное качество)",
							"text",
							"",
							"yes"),
				);


	public function check() {
		if (substr($this->postArray['cfgParams']['uploadImageDir'], -1, 1) != "/") {
			$this->postArray['cfgParams']['uploadImageDir'] = $this->postArray['cfgParams']['uploadImageDir']."/";
		}
		
        return true;
	}
}
?>
