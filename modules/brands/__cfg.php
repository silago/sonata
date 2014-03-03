<?php
if (!defined("API")) {
	exit("Main include fail");
}

class mCfg extends cfg {
	public $cfg = array(						
						array(
							"logoDir",
							"Папка для загрузки картинок",
							"",
							"text",
							"",
							"yes"),

						array(
							"logoWidth",
							"Ширина картинки в px",
							"",
							"text",
							"",
							"yes"),
							
						array(
							"logoHeight",
							"Высота картинки в px",
							"",
							"text",
							"",
							"yes"),
				);


	public function check() {
        return true;
	}
}
?>
