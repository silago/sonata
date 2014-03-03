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
							"waterMark",
							"Путь к файлу водяного знака",
							"Если Вы хотите налаживать на загружаемые фото водяной знак, то укажите в этом параметре путь к файлу водяного знака",
							"text",
							"",
							"no"),

						array(
							"groupImageMaxWidth",
							"Максимальная ширина прикрепленного изображения к группе (в пикселях)",
							"",
							"text",
							"",
							"yes"),

						array(
							"groupImageMaxHeight",
							"Максимальная высота прикрепленного изображения к группе (в пикселях)",
							"",
							"text",
							"",
							"yes"),

						array(
							"notSoBigMaxWidth",
							"Максимальная ширина изображения среднего размера, прикрепленного товару (в пикселях)",
							"",
							"text",
							"",
							"yes"),

						array(
							"notSoBigMaxHegiht",
							"Максимальная высота изображения среднего размера, прикрепленного товару (в пикселях)",
							"",
							"text",
							"",
							"yes"),


						array(
							"bigMaxHegiht",
							"Максимальная высота изображения большого размера, прикрепленного товару (в пикселях)",
							"",
							"text",
							"",
							"yes"),

						array(
							"bigMaxWidth",
							"Максимальная ширина изображения большого размера, прикрепленного товару (в пикселях)",
							"",
							"text",
							"",
							"yes"),

						array(
							"addPhotoSmallWidth",
							"Максимальная ширина миниатюры дополнительной фотографии",
							"",
							"text",
							"",
							"yes"),

						array(
							"addPhotoSmallHeight",
							"Максимальная высота миниатюры дополнительной фотографии",
							"",
							"text",
							"",
							"yes"),

						array(
							"addPhotoBigWidth",
							"Максимальная ширина дополнительного фото большого размера",
							"",
							"text",
							"",
							"yes"),

						array(
							"addPhotoBigHeight",
							"Максимальная высота дополнительного фото большого размера",
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
