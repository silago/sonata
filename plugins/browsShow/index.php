<?php


class plugin_browsShow {
	protected $pluginParams = array();
	protected $session		= array();
	protected $smarty		= array();
	protected $sql;

	function user_browser($agent) {
		preg_match("/(MSIE|Opera|Firefox|Chrome|Version|Opera Mini|Netscape|Konqueror|SeaMonkey|Camino|Minefield|Iceweasel|K-Meleon|Maxthon)(?:\/| )([0-9.]+)/", $agent, $browser_info); // регулярное выражение, которое позволяет отпределить 90% браузеров
        list(,$browser,$version) = $browser_info; // получаем данные из массива в переменную
        if (preg_match("/Opera ([0-9.]+)/i", $agent, $opera)) return 'Opera '.$opera[1]; // определение _очень_старых_ версий Оперы (до 8.50), при желании можно убрать
        if ($browser == 'MSIE') { // если браузер определён как IE
                preg_match("/(Maxthon|Avant Browser|MyIE2)/i", $agent, $ie); // проверяем, не разработка ли это на основе IE
                if ($ie) return $ie[1].' based on IE '.$version; // если да, то возвращаем сообщение об этом
                return 'IE '.$version; // иначе просто возвращаем IE и номер версии
        }
        if ($browser == 'Firefox') { // если браузер определён как Firefox
                preg_match("/(Flock|Navigator|Epiphany)\/([0-9.]+)/", $agent, $ff); // проверяем, не разработка ли это на основе Firefox
                if ($ff) return $ff[1].' '.$ff[2]; // если да, то выводим номер и версию
        }
        if ($browser == 'Opera' && $version == '9.80') return 'Opera '.substr($agent,-5); // если браузер определён как Opera 9.80, берём версию Оперы из конца строки
        if ($browser == 'Version') return 'Safari '.$version; // определяем Сафари
        if (!$browser && strpos($agent, 'Gecko')) return 'Browser based on Gecko'; // для неопознанных браузеров проверяем, если они на движке Gecko, и возращаем сообщение об этом
        return $browser.' '.$version; // для всех остальных возвращаем браузер и версию
	}

	function start() {

          $Browser = $this->user_browser($_SERVER['HTTP_USER_AGENT']);

          $Info = "<br /><center><font size=2 color=#D90005>Обнаружена старая версия браузера! Сайт будет отображаться не корректно!</font>
          <br /><br />
          <a href=\"http://www.microsoft.com/rus/windows/ie/\" target=\"_blank\"><b>Скачать обновленную версию браузера</b></a></center><br />";


          if ($Browser == "IE 5.0" || $Browser == "IE 6.0") return $Info;

	}






	function __construct($params) {
		global $smarty, $_SESSION, $sql;
		$this->smarty = &$smarty;
		$this->session = &$_SESSION;
		$this->sql = &$sql;
     	$this->pluginParams = api::setPluginParams($params);
	}

}
?>