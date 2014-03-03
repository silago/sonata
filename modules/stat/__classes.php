<?php
if (!defined("API")) {
	exit("Main include fail");
}

class stat {
	public $return 	= array();
	public $lang 	= array();
	public $curLang = "ru";

	private $data	= array(
							"ip" => "",
							"ref" => "",
							"br" => "",
							"js" => "",
							"width" => "",
							"height" => "",
							"session" => "",
							"requestUri" => "",
							"countryCode" => "FF",
							"countryString" => "",
							"isNewUser" => false,
							"isNewIpAddr" => false,
							"refDomain" => "",
							"searchWord" => "",
							"resolution" => "",
							);
	private $currentDate	= "1970-01-01 23:59:59";
	private $sql			= false;
	private $onLineTimeout	= 15;
	private $mDir			= "stat";

	private $rusMonths		= array(false, "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентабрь", "Октябрь", "Ноябрь", "Декабрь",);

	//private $countryDbPath	= "cvs.cvs";
	private $countryDbPath	= "http://www.maxmind.com/download/geoip/database/GeoIPCountryCSV.zip";
	private $countryDbTmp	= "chache/countryDb.tmp";

	private $statImage		= "templates/ru/images/api/statImg.jpg";
	private $fontPath		= "templates/ru/images/api/ariblk.ttf";

	protected $getArray 	= array();
	protected $postArray	= array();
	protected $timeZone 	= 8;
	protected $summerTime	= true;

	public function showStat() {
		$type	= (int)@$this->postArray["type"];

		$sd		= (int)@$this->postArray["sinceDay"];
		$sm		= (int)@$this->postArray["sinceMonth"];
		$sy		= (int)@$this->postArray["sinceYear"];

		$fd		= (int)@$this->postArray["forDay"];
		$fm		= (int)@$this->postArray["forMonth"];
		$fy		= (int)@$this->postArray["forYear"];

		if ($sd == 0) $sd = date("d");
		if ($sm == 0) $sm = date("m");
		if ($sy == 0) $sy = date("Y");

		if ($fd == 0) $fd = date("d");
		if ($fm == 0) $fm = date("m");
		if ($fy == 0) $fy = date("Y");

		$incr = 1;		while($incr <= 31) 			{@$sinceDay		.= "<option value=\"".$incr."\"".($incr == $sd ? " selected=\"selected\"" : "").">".$incr."</option>"; $incr++;}
		$incr = 1; 		while($incr <= 12) 			{@$sinceMonth	.= "<option value=\"".$incr."\"".($incr == $sm ? " selected=\"selected\"" : "").">".$this->rusMonths[$incr]."</option>"; $incr++;}
		$incr = 2006;	while($incr <= date("Y"))	{@$sinceYear	.= "<option value=\"".$incr."\"".($incr == $sy ? " selected=\"selected\"" : "").">".$incr."</option>"; $incr++;}

		$incr = 1;		while($incr <= 31) 			{@$forDay	.= "<option value=\"".$incr."\"".($incr == $fd ? " selected=\"selected\"" : "").">".$incr."</option>"; $incr++;}
		$incr = 1; 		while($incr <= 12) 			{@$forMonth	.= "<option value=\"".$incr."\"".($incr == $fm ? " selected=\"selected\"" : "").">".$this->rusMonths[$incr]."</option>"; $incr++;}
		$incr = 2006;	while($incr <= date("Y"))	{@$forYear	.= "<option value=\"".$incr."\"".($incr == $fy ? " selected=\"selected\"" : "").">".$incr."</option>"; $incr++;}


		$template = new template(api::setTemplate("modules/".$this->mDir."/admin.show.head.html"));
		$template->assign("s".(string)$type, " selected=\"selected\"");
		$template->assign("sinceDay",	$sinceDay);
		$template->assign("sinceMonth",	$sinceMonth);
		$template->assign("sinceYear",	$sinceYear);

		$template->assign("forDay",		$forDay);
		$template->assign("forMonth",	$forMonth);
		$template->assign("forYear",	$forYear);

		$this->return['content'] = $template->get();

		$sDate = sprintf("%04d-%02d-%02d", $sy, $sm, $sd);
		$fDate = sprintf("%04d-%02d-%02d", $fy, $fm, $fd);

		if (@$this->getArray['show'] == "show") {
			return (((int)$type === 1 ? $this->showSumStat($sDate, $fDate) : $this->showSimpleStat($type, $sDate, $fDate)));
		}
	}


	private function showSumStat($sDate, $fDate) {
		$this->sql->query("SELECT DATE_FORMAT(`dt`, '%d/%m/%Y'), `hits`, `hosts`, `visitors` FROM `#__#statSum` WHERE `dt` BETWEEN '".$sDate."' AND '".$fDate."' ORDER BY `dt`");
		$template = new template(api::setTemplate("modules/".$this->mDir."/admin.show.sum.item.html"));
		$body = "";
		while ($this->sql->next_row()) {
			$template->assign("td1", $this->sql->result[0]);
			$template->assign("td2", $this->sql->result[1]);
			$template->assign("td3", $this->sql->result[2]);
			$template->assign("td4", $this->sql->result[3]);
			$body .= $template->get();
		}

		$this->sql->query("SELECT SUM(`hits`), SUM(`hosts`), SUM(`visitors`) FROM `#__#statSum` WHERE `dt` BETWEEN '".$sDate."' AND '".$fDate."'", true);

		$template = new template(api::setTemplate("modules/".$this->mDir."/admin.show.sum.head.html"));
		$template->assign("sumHits", 		$this->sql->result[0]);
		$template->assign("sumHosts",		$this->sql->result[1]);
		$template->assign("sumVisitors",	$this->sql->result[2]);
		$template->assign("body", 	$body);
		$this->return['content'] .= $template->get();

	}

	private function showSimpleStat($type, $sDate, $fDate) {
		switch ((int)$type) {
			case 2:		$dbFieldsArray = array("statNowAndPoints", "joinPoint", "quitPoint"); break;
			case 3:		$dbFieldsArray = array("statIpAddr", "ip", "count"); break;
			case 4:		$dbFieldsArray = array("statCountries", "countryString", "count"); break;
			case 5:		$dbFieldsArray = array("statSearchWord", "searchWord", "count"); break;
			case 6:		$dbFieldsArray = array("statRef", "ref", "count", true); break;
			case 7:		$dbFieldsArray = array("statRefDomain", "refDomain", "count", true); break;
			case 8:		$dbFieldsArray = array("statResolution", "resolution", "count"); break;
			case 9:		$dbFieldsArray = array("statBr", "br", "count"); break;
			case 10:	$dbFieldsArray = array("statJs", "js", "count"); break;
            default:	message($this->lang['noChoose'], "", "admin/".$this->mDir."/index.php"); break;
		}


		$this->sql->query("SELECT DATE_FORMAT(`dt`, '%d/%m/%Y'), `".$dbFieldsArray[1]."`, `".$dbFieldsArray[2]."` FROM `#__#".$dbFieldsArray[0]."` WHERE `dt` BETWEEN '".$sDate."' AND '".$fDate."' ORDER BY `dt`");
		if ((int)$this->sql->num_rows() === 0) message($this->lang['statEmpty'], "", "admin/".$this->mDir."/index.php");


		$template = new template(api::setTemplate("modules/".$this->mDir."/admin.show.simple.item.html"));
		$body = "";
		while ($this->sql->next_row()) {
			$template->assign("td1", $this->sql->result[0]);
			$template->assign("td2", (isset($dbFieldsArray[3]) ?  "<a href=\"".$this->sql->result[1]."\">" : "").$this->sql->result[1].(isset($dbFieldsArray[3]) ?  "</a>" : ""));
			$template->assign("td3", $this->sql->result[2]);
			$body .= $template->get();
		}

		$tableHeader = $this->lang['tableSimpleHeader'][$type];

		$template = new template(api::setTemplate("modules/".$this->mDir."/admin.show.simple.head.html"));
		$template->assign("tHead1", $tableHeader[0]);
		$template->assign("tHead2",	$tableHeader[1]);
		$template->assign("body", 	$body);
		$this->return['content'] .= $template->get();

	}


	public function saveStat() {

		// Save now and points stat;
		$this->sql->query("SELECT COUNT(*) FROM `#__#statNowAndPoints` WHERE `dt` = DATE('".$this->currentDate."') && `session` = '".$this->data['session']."'", true);
		if ((int)$this->sql->result[0] !== 1) {
			$this->sql->query("INSERT INTO `#__#statNowAndPoints`(`dt`, `lastActionTime`, `joinPoint`, `quitPoint`, `session`) VALUES('".$this->currentDate."', '".$this->currentDate."', '".$this->data['requestUri']."', '".$this->data['requestUri']."', '".$this->data['session']."')");
		} else {
			$this->sql->query("UPDATE `#__#statNowAndPoints` SET `lastActionTime` = '".$this->currentDate."', `quitPoint` = '".$this->data['requestUri']."' WHERE `dt` = DATE('".$this->currentDate."') && `session` = '".$this->data['session']."'");
		}

		$this->saveSimpleStatToDb("statSearchWord", "searchWord");


		// Simple stat save
		if ($this->data['isNewUser']) {
			$this->saveSimpleStatToDb("statRefDomain", "refDomain");
			$this->saveSimpleStatToDb("statIpAddr", "ip");
			$this->saveSimpleStatToDb("statCountries", "countryString");
			$this->saveSimpleStatToDb("statBr", "br");
			$this->saveSimpleStatToDb("statJs", "js");
			$this->saveSimpleStatToDb("statRef", "ref");
			$this->saveSimpleStatToDb("statResolution", "resolution");
		}

		// Sum stat save
        $this->sql->query("SELECT COUNT(*) FROM `#__#statSum` WHERE `dt` = DATE('".$this->currentDate."')", true);
        if ((int)$this->sql->result[0] === 0) {
        	$this->sql->query("INSERT INTO `#__#statSum`(`dt`, `hits`, `hosts`, `visitors`) VALUES('".$this->currentDate."', '1', '1', '1')");
        } else {
        	$this->sql->query("UPDATE `#__#statSum` SET `hits` = `hits`+1".($this->data['isNewIpAddr'] ? ", `hosts` = `hosts`+1" : "").($this->data['isNewUser'] ? ", `visitors` = `visitors`+1" : "")." WHERE `dt` = DATE('".$this->currentDate."')");
        }

	}

	private function saveSimpleStatToDb($db, $dataKey) {

		if (empty($this->data[$dataKey])) return true;

		$this->sql->query("SELECT COUNT(*) FROM `#__#".$db."` WHERE `".$dataKey."` = '".$this->data[$dataKey]."' && `dt` = DATE('".$this->currentDate."')", true);
		if ((int)$this->sql->result[0] === 0) {
			$this->sql->query("INSERT INTO `#__#".$db."`(`dt`, `".$dataKey."`, `count`) VALUES ('".$this->currentDate."', '".$this->data[$dataKey]."', '1')");
		} else {
			$this->sql->query("UPDATE `#__#".$db."` SET `count` = `count` + 1 WHERE `".$dataKey."` = '".$this->data[$dataKey]."' && `dt` = DATE('".$this->currentDate."')");
		}

	}

	public function showImg() {
		$this->saveStat();

		$this->sql->query("(SELECT `visitors` FROM `#__#statSum` WHERE `dt` = DATE('".$this->currentDate."')) UNION (SELECT SUM(`visitors`) FROM `#__#statSum`)");
		$this->sql->next_row(); $hits = $this->sql->result[0];
		$this->sql->next_row(); $allHits = $this->sql->result[0];

		$offsetX = 6*strlen($hits) + 2;

		$im=imagecreatefromjpeg($this->statImage);
		imagettftext($im, 7, 0, 88 - $offsetX, 10,  imagecolorallocate($im, 255, 255, 255), $this->fontPath, $hits);
		imagettftext($im, 7, 0, 5, 27,  imagecolorallocate($im, 255, 180, 180), $this->fontPath, $allHits);
		header("Content-type: image/jpeg");
		imagejpeg($im,"", 100);
		imagedestroy($im);

//		var_dump($this->data);
//		echo "SELECT COUNT(*) FROM `#__#statNowAndPoints` WHERE `dt` = DATE('".$this->currentDate."') && `session` = '".$this->data['session']."'";		
		exit();

	}

 	public function updateCounryDatabase() {
	
	message("OK", $this->lang['updateOk']);
/*  	  @set_time_limit(0);
	  
	  $loadFile = file_get_contents($this->countryDbPath);
	  file_put_contents("GeoIPCountryCSV.zip", $loadFile);
	  
	  if(file_exists("GeoIPCountryCSV.zip")) {
	    $zip = zip_open(getcwd()."/GeoIPCountryCSV.zip");
		while($zip_entry = zip_read($zip)) {
		  if(zip_entry_open($zip, $zip_entry, "r")) {
		    $zipFileContent = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
            zip_entry_close($zip_entry);
       	  }
		}
   		zip_close($zip);
   		unlink("GeoIPCountryCSV.zip");
   		file_put_contents("GeoIPCountryCSV.tmp", $zipFileContent);
   		unset($zipFileContent);
		
        $this->sql->query("DROP TABLE IF EXISTS `#__#countryTmp`");
		$this->sql->query("CREATE TABLE `#__#countryTmp` (
														`startIp` CHAR(15) NOT NULL,
														`endIp` CHAR(15) NOT NULL,
														`start` INT UNSIGNED NOT NULL,
														`end` INT UNSIGNED NOT NULL,
														`cc` CHAR(2) NOT NULL,
														`cn` VARCHAR(50) NOT NULL
														)
														");
														
		$fileHandle = file(getcwd()."/GeoIPCountryCSV.tmp");
		foreach($fileHandle as $value) {
		    $value = str_replace("\"", "", $value);
		    $value = addslashes($value);
			$cvsArray = explode(",", $value);
			$this->sql->query("INSERT INTO `#__#countryTmp` VALUES('".$cvsArray[0]."', '".$cvsArray[1]."', '".$cvsArray[2]."', '".$cvsArray[3]."', '".$cvsArray[4]."', '".$cvsArray[5]."')");
		}

		@unlink("GeoIPCountryCSV.tmp");

		$this->sql->query("DROP TABLE IF EXISTS `#__#countriesCcTable`");
		$this->sql->query("DROP TABLE IF EXISTS `#__#countriesLongIpTable`");
		$this->sql->query("CREATE TABLE `#__#countriesCcTable` (`ci` TINYINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, `cc` CHAR(2) NOT NULL, `cn` VARCHAR(50) NOT NULL)");
		$this->sql->query("CREATE TABLE `#__#countriesLongIpTable` (`start` INT UNSIGNED NOT NULL, `end` INT UNSIGNED NOT NULL, `ci` TINYINT UNSIGNED NOT NULL)");

		$this->sql->query("INSERT INTO `#__#countriesCcTable` SELECT DISTINCT NULL, `cc`, `cn` FROM `#__#countryTmp`");
		$this->sql->query("INSERT INTO `#__#countriesLongIpTable` SELECT `start`, `end`, `ci` FROM `#__#countryTmp` NATURAL JOIN `#__#countriesCcTable`");

		$this->sql->query("DROP TABLE IF EXISTS `#__#countryTmp`");
		
		message("OK", $this->lang['updateOk']);
	  } else {
	    message($this->lang['error'], $this->lang['remoteDownloadError']);
	  } */
	}
/*  	public function updateCounryDatabase() {
		@set_time_limit(60*60*3);

		if (preg_match("/^http\:\/\//i", $this->countryDbPath)) {
			$curlSessionId = curl_init($this->countryDbPath);
			curl_setopt($curlSessionId, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curlSessionId, CURLOPT_HEADER, 0);
			curl_setopt($curlSessionId, CURLOPT_COOKIE, 0);
			$resposeData = curl_exec($curlSessionId);
			if ((bool)$resposeData === false) {
				message($this->lang['error'], $this->lang['remoteDownloadError']);
			}
			file_put_contents($this->countryDbTmp, $resposeData);
			unset($resposeData);
		} else {
			$copyResult = copy($this->countryDbPath, $this->countryDbTmp);
			if ($copyResult === false) message($this->lang['error'], $this->lang['localDownloadError']);
		}

		if (preg_match("/\.zip$/i", $this->countryDbPath)) {
			$zip = zip_open($this->countryDbTmp);
			if ($zip === ZIPARCHIVE::ER_NOZIP) message($this->lang['error'], $this->lang['unzipError']);

		 	while ($zip_entry = zip_read($zip)) {
		 		if (zip_entry_open($zip, $zip_entry, "r")) {
		 			$zipFileContent = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
          			zip_entry_close($zip_entry);
       			}
			}
   			zip_close($zip);
   			unlink($this->countryDbTmp);
   			file_put_contents($this->countryDbTmp, $zipFileContent);
   			unset($zipFileContent);
		}


		$this->sql->query("DROP TABLE IF EXISTS `#__#countryTmp`");
		$this->sql->query("CREATE TABLE `#__#countryTmp` (
														`startIp` CHAR(15) NOT NULL,
														`endIp` CHAR(15) NOT NULL,
														`start` INT UNSIGNED NOT NULL,
														`end` INT UNSIGNED NOT NULL,
														`cc` CHAR(2) NOT NULL,
														`cn` VARCHAR(50) NOT NULL
														)
														");

		$fileHandle = fopen($this->countryDbTmp, "r");
		$query = "";
		$incr = 0;
		while (!feof($fileHandle)) {
			$incr++;

			$cvsArray =explode(",", addslashes(str_replace("\"", "", fgets($fileHandle))));
			if (count($cvsArray) < 5)  {
				continue;
			}
			$this->sql->queryUnbuf("INSERT INTO `#__#countryTmp`	(`startIp`, `endIp`, `start`, `end`, `cc`, `cn`)
			 									VALUES
													('".$cvsArray[0]."', '".$cvsArray[1]."', '".$cvsArray[2]."', '".$cvsArray[3]."', '".$cvsArray[4]."', '".$cvsArray[5]."');
									");
		}

		fclose($fileHandle);
		@unlink($this->countryDbTmp);

		$this->sql->query("DROP TABLE IF EXISTS `#__#countriesCcTable`");
		$this->sql->query("DROP TABLE IF EXISTS `#__#countriesLongIpTable`");
		$this->sql->query("CREATE TABLE `#__#countriesCcTable` (`ci` TINYINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, `cc` CHAR(2) NOT NULL, `cn` VARCHAR(50) NOT NULL)");
		$this->sql->query("CREATE TABLE `#__#countriesLongIpTable` (`start` INT UNSIGNED NOT NULL, `end` INT UNSIGNED NOT NULL, `ci` TINYINT UNSIGNED NOT NULL)");

		$this->sql->query("INSERT INTO `#__#countriesCcTable` SELECT DISTINCT NULL, `cc`, `cn` FROM `#__#countryTmp`");
		$this->sql->query("INSERT INTO `#__#countriesLongIpTable` SELECT `start`, `end`, `ci` FROM `#__#countryTmp` NATURAL JOIN `#__#countriesCcTable`");

		$this->sql->query("DROP TABLE IF EXISTS `#__#countryTmp`");
		message("OK", $this->lang['updateOk']);
	} */

	private function setStatisticInformation() {
		global $_SERVER;

		$this->data = array_merge($this->data, array(
			"ip"			=> @$_SERVER['REMOTE_ADDR'],
			"ref"			=> @strtolower(trim($this->getArray['r'])),
			"br"			=> @$_SERVER['HTTP_USER_AGENT'],
			"js"			=> @strtoupper(substr($this->getArray['j'], 0, 1)),
			"width" 		=> @(int)$this->getArray['w'],
			"height"		=> @(int)$this->getArray['h'],
			"session"		=> @api::slashData(session_id()),
			"requestUri"	=> @$_SERVER['HTTP_REFERER'],
			));
	}

	private function setCountryCode () {
		if (!preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/", $this->data['ip'])) {
			$this->data['ip'] = "0.0.0.0";
		}

		$ipNum = sprintf("%u", ip2long($this->data['ip']));
		$this->sql->query("SELECT `cc` FROM `#__#countriesLongIpTable` NATURAL JOIN `#__#countriesCcTable` WHERE '".$ipNum."' BETWEEN `start` AND `end` LIMIT 0,1", true);
		if ((int)$this->sql->num_rows() === 0) {
			$this->data['countryCode'] = "FF";
		} else {
			$this->data['countryCode'] = $this->sql->result[0];
		}
 		return true;
	}

	private function setCountryString() {
		$countries = array(	"AU" => "Австралия",
							"AT" => "Австрия",
							"AZ" => "Азербайджан",
							"AL" => "Албания",
							"DZ" => "Алжир",
							"AS" => "Американское Самоа",
							"AI" => "Ангилья",
							"AO" => "Ангола",
							"AD" => "Андорра",
							"AQ" => "Антарктида",
							"AG" => "Антигуа и Барбуда",
							"AE" => "Арабские Эмираты",
							"AR" => "Аргентина",
							"AM" => "Армения",
							"AW" => "Аруба",
							"AF" => "Афганистан",
							"BS" => "Багамы",
							"BD" => "Бангладеш",
							"BB" => "Барбадос",
							"BH" => "Бахрейн",
							"BY" => "Беларусь",
							"BZ" => "Белиз",
							"BE" => "Бельгия",
							"BJ" => "Бенин",
							"CI" => "Берег Слоновой Кости",
							"BM" => "Бермуды",
							"MM" => "Бирма (Мьянма)",
							"BG" => "Болгария",
							"BO" => "Боливия",
							"BA" => "Босния и Герцеговина",
							"BW" => "Ботсвана",
							"BR" => "Бразилия",
							"BN" => "Бруней",
							"BF" => "Буркина Фасо",
							"BU" => "Бурма",
							"BI" => "Бурунди",
							"BT" => "Бутан",
							"VU" => "Вануату",
							"VA" => "Ватикан",
							"GB" => "Великобритания",
							"HU" => "Венгрия",
							"VE" => "Венесуэла",
							"VG" => "Виргинские о-ва, Брит.",
							"VN" => "Вьетнам",
							"WF" => "Вэллис и Футума о-ва",
							"GA" => "Габон",
							"HT" => "Гаити",
							"GY" => "Гайана",
							"GM" => "Гамбия",
							"GH" => "Гана",
							"GP" => "Гваделупа",
							"GT" => "Гватемала",
							"GN" => "Гвинея",
							"GW" => "Гвинея Бисау",
							"DE" => "Германия",
							"GI" => "Гибралтар",
							"NL" => "Голландия",
							"AN" => "Голландские Антильские о-ва",
							"HN" => "Гондурас",
							"HK" => "Гонконг",
							"GD" => "Гренада",
							"GL" => "Гренландия",
							"GR" => "Греция",
							"GE" => "Грузия",
							"GU" => "Гуам",
							"DK" => "Дания",
							"DJ" => "Джибути",
							"DM" => "Доминика",
							"DO" => "Доминиканская Республика",
							"EG" => "Египет",
							"ZR" => "Заир",
							"ZM" => "Замбия",
							"ZW" => "Зимбабве",
							"IL" => "Израиль",
							"IN" => "Индия",
							"ID" => "Индонезия",
							"JO" => "Иордания",
							"IQ" => "Ирак",
							"IR" => "Иран",
							"IE" => "Ирландия",
							"IS" => "Исландия",
							"ES" => "Испания",
							"IT" => "Италия",
							"YE" => "Йемен (Арабская республика)",
							"YD" => "Йемен (Народная республика)",
							"CV" => "Кабо Верде",
							"KZ" => "Казахстан",
							"KY" => "Каймановы о-ва",
							"KH" => "Камбоджа",
							"CM" => "Камерун",
							"CA" => "Канада",
							"QA" => "Катар",
							"KE" => "Кения",
							"CY" => "Кипр",
							"KG" => "Киргизстан",
							"KI" => "Кирибати",
							"CN" => "Китай",
							"KP" => "КНДР",
							"CC" => "Кокосовые о-ва",
							"CO" => "Колумбия",
							"KM" => "Коморские о-ва",
							"CG" => "Конго",
							"KR" => "Корея",
							"CR" => "Коста Рика",
							"CU" => "Куба",
							"KW" => "Кувейт",
							"CK" => "Кука о-ва",
							"LA" => "Лаос",
							"LV" => "Латвия",
							"LS" => "Лесото",
							"LR" => "Либерия",
							"LB" => "Ливан",
							"LY" => "Ливия",
							"LT" => "Литва",
							"LI" => "Лихтенштейн",
							"LU" => "Люксембург",
							"MU" => "Маврикий",
							"MR" => "Мавритания",
							"MG" => "Мадагаскар",
							"YT" => "Майотт о-в",
							"MO" => "Макао",
							"MK" => "Македония",
							"MW" => "Малави",
							"MY" => "Малайзия",
							"ML" => "Мали",
							"MV" => "Мальдивы",
							"MT" => "Мальта",
							"MA" => "Марокко",
							"MH" => "Маршалловы о-ва",
							"MX" => "Мексика",
							"FM" => "Микронезия",
							"MZ" => "Мозамбик",
							"MD" => "Молдова",
							"MC" => "Монако",
							"MN" => "Монголия",
							"MS" => "Монсеррат",
							"NA" => "Намибия",
							"NR" => "Науру",
							"NP" => "Непал",
							"NE" => "Нигер",
							"NG" => "Нигерия",
							"NI" => "Никарагуа",
							"NU" => "Ниуэ",
							"NZ" => "Новая Зеландия",
							"NC" => "Новая Каледония",
							"NO" => "Норвегия",
							"NF" => "Норфолк о-в",
							"OM" => "Оман",
							"PK" => "Пакистан",
							"PW" => "Палау о-ва",
							"PA" => "Панама",
							"PG" => "Папуа Новая Гвинея",
							"PY" => "Парагвай",
							"PE" => "Перу",
							"PL" => "Польша",
							"PT" => "Португалия",
							"PR" => "Пуэрто Рико",
							"RE" => "Реюньон",
							"CX" => "Рождества о-в",
							"RU" => "Россия",
							"RW" => "Руанда",
							"RO" => "Румыния",
							"SV" => "Сальвадор",
							"SM" => "Сан Марино",
							"ST" => "Сан Томе и Принсипи",
							"VC" => "Сан-Винсент/Гренадины",
							"LC" => "Санта Лючия",
							"SA" => "Саудовская Аравия",
							"SZ" => "Свазиленд",
							"SH" => "Святой Елены о-в",
							"SC" => "Сейшелы",
							"SN" => "Сенегал",
							"KN" => "Сен-Киттс Невис Ангилья",
							"PM" => "Сен-Пьер и Микелон",
							"SG" => "Сингапур",
							"SY" => "Сирия",
							"SK" => "Словакия",
							"SI" => "Словения",
							"US" => "Соединённые Штаты Америки",
							"SB" => "Соломоновы о-ва",
							"SO" => "Сомали",
							"SD" => "Судан",
							"SR" => "Суринам",
							"SL" => "Сьерра Леоне",
							"TJ" => "Таджикистан",
							"TW" => "Тайвань",
							"TH" => "Тайланд",
							"TZ" => "Танзания",
							"TC" => "Теркс и Кайкос о-ва",
							"TG" => "Того",
							"TK" => "Токелау о-ва",
							"TT" => "Тринидад и Тобаго",
							"TV" => "Тувалу",
							"TN" => "Тунис",
							"TM" => "Туркменистан",
							"TR" => "Турция",
							"UG" => "Уганда",
							"UZ" => "Узбекистан",
							"UA" => "Украина",
							"UY" => "Уругвай",
							"FO" => "Фаро о-ва",
							"FJ" => "Фиджи",
							"PH" => "Филиппины",
							"FI" => "Финляндия",
							"FK" => "Фолклендские (Мальвинские) о-ва",
							"GF" => "Французская Гвиана",
							"PF" => "Французская Полинезия",
							"HR" => "Хорватия",
							"CF" => "Центральноафриканская республика",
							"TD" => "Чад",
							"CZ" => "Чехия",
							"CL" => "Чили",
							"CH" => "Швейцария",
							"SE" => "Швеция",
							"LK" => "Шри-Ланка",
							"EC" => "Эквадор",
							"GQ" => "Экваториальная Гвинея",
							"ER" => "Эритрея",
							"EE" => "Эстония",
							"ET" => "Эфиопия",
							"ZA" => "ЮАР",
							"YU" => "Югославия",
							"JM" => "Ямайка",
							"JP" => "Япония",
							"FF" => "Другие"
		);

		$countryCode = $this->data['countryCode'];
		if (isset($countries[$countryCode])) {
			$this->data['countryString'] = $countries[$countryCode];
		} else {
			$this->data['countryString'] = $countries['FF'];
		}
		return true;
	}

	private function setIsNewUser() {
		$this->sql->query("SELECT COUNT(*) FROM `#__#statNowAndPoints` WHERE `session` = '".$this->data['session']."' && `dt` = DATE('".$this->currentDate."')", true);
		$this->data['isNewUser'] = ((int)$this->sql->result[0] === 0 ? true : false);
		return true;
	}

	private function setIsNewIpAddr() {
		$this->sql->query("SELECT COUNT(*) FROM `#__#statIpAddr` WHERE `ip` = '".$this->data['ip']."' && `dt` = DATE('".$this->currentDate."')", true);
		$this->data['isNewIpAddr'] = ((int)$this->sql->result[0] === 0 ? true : false);
		return true;
	}


	private function setReferDomain() {
		$ref = $this->data['ref'];
		if (!empty($ref) && preg_match("/^http\:\/\/([a-z0-9\-\.]+)\//is", $ref, $match)) {
				$this->data['refDomain'] = (!preg_match("/^www\./i", $match[1]) ? "www.".$match[1] : $match[1]);
			}
		return true;
	}

	private function setSearchWord() {
		$refDomain = $this->data['refDomain'];
		$searchSystems = array(
								"www.yandex.ru" => "text=",
								"www.google.ru" => "q=",
								"www.google.com" => "q=",
								"www.search.msn.com" => "q=",
								"www.search.yahoo.com" => "p=",
								"www.search.rambler.ru" => "words=",
								"www.rambler.ru" => "words=",
								"www.sm.aport.ru" => "r=",
								"www.search.mail.ru" => "q=",
								"www.search.liveinternet.ru" => "search_query=",
								);

		if (isset($searchSystems[$refDomain])) {
			$searchSystemVariable = $searchSystems[$refDomain];
			if (preg_match("/(?:\?|\&)".$searchSystemVariable."([^&]+)/i", $this->data['ref'], $match)) {
				$this->data['searchWord'] = $match[1];
			}
		}
		return true;
	}

	private function setResolution() {
		$width 	= (int)$this->data['width'];
		$height = (int)$this->data['height'];

		if ($width > 0 && $height > 0) {
			$this->data['resolution'] = $width."x".$height;
		}
		return true;
	}

	private function setJs() {
		$js = $this->data['js'];
		if ($js !== "Y" && $js !== "N") {
			$data['js'] = "N";
		}
		return true;
	}

	function __construct() {
		global $_GET, $POST, $sql;


		$this->sql = & $sql;

		/*$this->sql->query("CREATE TABLE IF NOT EXISTS `#__#statNowAndPoints`(`dt` DATE NOT NULL, `lastActionTime` TIMESTAMP, `joinPoint` TINYTEXT, `quitPoint` TINYTEXT, `session` TINYTEXT)");
		$this->sql->query("CREATE TABLE IF NOT EXISTS `#__#statIpAddr`(`dt` DATE NOT NULL, `ip` TINYTEXT, `count` INT)");
		$this->sql->query("CREATE TABLE IF NOT EXISTS `#__#statCountries`(`dt` DATE NOT NULL, `countryString` TINYTEXT, `count` INT)");
		$this->sql->query("CREATE TABLE IF NOT EXISTS `#__#statBr`(`dt` DATE NOT NULL, `br` TINYTEXT, `count` INT)");
		$this->sql->query("CREATE TABLE IF NOT EXISTS `#__#statJs`(`dt` DATE NOT NULL, `js` ENUM('Y','N'), `count` INT)");
		$this->sql->query("CREATE TABLE IF NOT EXISTS `#__#statRef`(`dt` DATE NOT NULL, `ref` TINYTEXT, `count` INT)");
		$this->sql->query("CREATE TABLE IF NOT EXISTS `#__#statResolution`(`dt` DATE NOT NULL, `resolution` TINYTEXT, `count` INT)");
		$this->sql->query("CREATE TABLE IF NOT EXISTS `#__#statRefDomain`(`dt` DATE NOT NULL, `refDomain` TINYTEXT, `count` INT)");
		$this->sql->query("CREATE TABLE IF NOT EXISTS `#__#statSearchWord`(`dt` DATE NOT NULL, `searchWord` TINYTEXT, `count` INT)");
		$this->sql->query("CREATE TABLE IF NOT EXISTS `#__#statSum`(`dt` DATE NOT NULL, `hits` INT, `hosts` INT, `visitors` INT)");*/


		$summerOffset = ($this->summerTime ? (int)date("I") : 0);

		$this->getArray		= api::slashData($_GET, true);
		$this->postArray	= api::slashData($_POST, true);
		$this->currentDate	= date("Y-m-d H:i:s", time() + ($this->timeZone + $summerOffset) * 60 * 60);

		$this->setStatisticInformation();
		$this->setCountryCode();
		$this->setCountryString();
		$this->setIsNewUser();
		$this->setIsNewIpAddr();
		$this->setReferDomain();
		$this->setSearchWord();
		$this->setResolution();
		$this->setJs();

		return true;
	}
}
?>
