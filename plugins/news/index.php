<?php
// Плагин "Новости"
//
// Версия 1.0 Beta,
// (C) Oskorbin Sergey, 2006
//
// Зависимисть: модуль "Новости" (3.0 И Выше)
//
// Парметры:
//      LIMIT: (INT);
//      Количество новостей для отображения, по уполнчанию -1;
//
//      ORDER: (название столбца в БД);
//      Сортировать по столбцу, по умолнчанию: `date`
//
//      ORDERBY: (DESC|ASK);
//      Тип сортировки данных в таблцице, по умолчанию DESC
//
//      GROUP: (INT);
//      Группа для отображения


class plugin_news {
     protected $pluginParams = array();
     protected $return = "";

     public function start() {
     	global $sql, $lang;
     	$limit 		= (isset($this->pluginParams['LIMIT'])&& (int)$this->pluginParams['LIMIT'] != -1 		? " LIMIT 0, ".$this->pluginParams['LIMIT'] : "");
		$order 		= (isset($this->pluginParams['ORDER']) 		? " ORDER BY `".$this->pluginParams['ORDER']."`" : " ORDER BY `date`");
		$orderType	= (isset($this->pluginParams['ORDERBY']) 	? " ".$this->pluginParams['ORDERBY'] : " DESC");
		$where 		= (isset($this->pluginParams['GROUP']) 		? " && `ownerId` = ".$this->pluginParams['GROUP'] : "");

     	$query = "SELECT `id`, `title`, `smallText`, DATE_FORMAT(`date`, '%d.%m.%Y'), `uri` FROM #__#news WHERE 1 ".$where.$order.$orderType.$limit;

     	$sql->query($query);

     	$template = new template(api::setTemplate("plugins/news/index.show.item.html"));
     	$subBody = "";
		$i=0;
     	while ($sql->next_row()) {
			$i++;
     		$template->assign("id", $sql->result[0]);
     		$template->assign("uri", $sql->result[4]);
     		$template->assign("title", $sql->result[1]);
     		$template->assign("smallText", $sql->result[2]);
     		$template->assign("date", $sql->result[3]);
			$template->assign("lang", "?lang=ru");
			$template->assign("podrobnee", "Подробнее");


			if($i!=$sql->num_rows()){
				$template->assign("noLastString", "<div class=\"inner-news-div-cntr\"><div></div></div>");
			}else{
				$template->assign("noLastString", "");
			}
     		$subBody.= $template->get();
     	}

     	return $subBody;
     }

     function __construct($params) {
     	$this->pluginParams = api::setPluginParams($params);
     }
}
?>
