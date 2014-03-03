<?
// Check e-mail
function checkEmail($email) {
	if (preg_match("/^[a-z0-9\.\-\_]+@[a-z0-9\.\-]+\.[a-z]{2,5}$/i", $email, $match)) {
		return true;
	}
	return false;
}


// Generate rand key
function genKey($len) {
	$rString=""; $incr=1;
	$buf="qwertyuiopasdfghjklzxcvbnm1234567890";
	while ($incr <= $len) {
		$incr++;
		$rString.=substr($buf, mt_rand(0, strlen($buf))-1, 1);
		}
	return $rString;
}

// Function slashes
function slash($string) {
	if (get_magic_quotes_gpc() == false) {
		return addslashes($string);
	} else {
		return $string;
	}

}

function slashArray($array) {
	$return = array();
	if (get_magic_quotes_gpc() == false) {
		foreach ($array as $key=>$value) {
			if (!is_array($array[$key])) $return[$key]=addslashes($value); else $return[$key] = slashArray($return[$key]);
		}
		return $return;
	} else {
		return $array;
	}

}

function strip($string) {
	return (!is_array($string) ? stripslashes($string) : stripArray($string));
}

function stripArray($array) {
	$return = array();
	foreach ($array as $key=>$value) {
		if (is_array($array[$key])) {
			$return[$key]=stripArray($array[$key]);
		} else {
			$return[$key]=stripslashes($value);
		}
	}
	return $return;
}
function go($uri) {
	header("Location: ".$uri);
	exit();
}

function page404() {
	global $mainTemplate, $main, $API;
	header("HTTP/1.1 404 Not found", true, 404);
	$mainTemplate->file($main->setTemplate("api/404.html"));
	$mainTemplate->assign("title", $main->getConfig("main", "api", "projectTitle"));
	$mainTemplate->stop();
}

function page403() {
	global $mainTemplate, $main;
	header("HTTP/1.1 403 Forbidden", true, 403);
	$mainTemplate->file($main->setTemplate("api/403.html"));
	$mainTemplate->assign("title", $main->getConfig("main", "api", "projectTitle"));
	$mainTemplate->stop();
}

function page500() {
	global $mainTemplate, $main;
	header("HTTP/1.1 500 Internal server error", true, 500);
	$mainTemplate->file($main->setTemplate("api/500.html"));
	$mainTemplate->assign("title", $main->getConfig("main", "api", "projectTitle"));
	$mainTemplate->stop();
}

function message($title, $desc = "", $uri = "", $class = "") {
	global $base, $lang, $module;

	if (preg_match("/^\/(.*)$/i", $uri, $match)) {
		$uri = $match[1];
	}


	if (empty($uri)) {
		$ref = getenv("HTTP_REFERER");
		$uri = (!empty($ref) ? $ref : '/');
	} else {
		$uri = "/".$uri;
	}

	$template = new template();

	if ($module === "admin") {			
			$area = 'admin';		
		//$template->file(api::setTemplate("api/message_admin.html"));
	} else {
			$area = 'public';
		//$template->file(api::setTemplate("api/message_site.html"));
	}
	
	$_SESSION['info'] = array(
							"area" => $area,
							"title" => $title,
							"desc" => $desc,
							"uri" => $uri,
                            "class" => $class,
						);	
	
	//$template->assign("title",	$title);
	//$template->assign("desc",	$desc);
	//$template->assign("uri",	$uri);
	//$template->out();
	
	go($uri);
}

function messageSessOnly($title, $desc = "", $class = "") {
						$_SESSION['info'] = array(
							"area" => 'public',
							"title" => $title,
							"desc" => $desc,							
                            "class" => $class,
						);
}

function sl($string) {
	return strtolower($string);
}

function su($string) {
	return strtoupper($string);
}

function moneyToString($number) {
	$origNumber = $number;
	$dop0	= array(
						"рублей",
						"тысяч",
						"миллионов",
						"миллиардов"
						);

	$dop1	= array(
						"рубль",
						"тысяча",
						"миллион",
						"миллиард"
						);

	$dop2	= array(	"рубля",
						"тысячи",
						"миллиона",
						"миллиарда"
						);

	$s1		= array(
						"",
						"один",
						"два",
						"три",
						"четыре",
						"пять",
						"шесть",
						"семь",
						"восемь",
						"девять"
						);

	$s11	= array(	"",
						"одна",
						"две",
						"три",
						"четыре",
						"пять",
						"шесть",
						"семь",
						"восемь",
						"девять"
						);

	$s2		= array(	"",
						"десять",
						"двадцать",
						"тридцать",
						"сорок",
						"пятьдесят",
						"шестьдесят",
						"семьдесят",
						"восемьдесят",
						"девяносто"
						);

	$s22	= array(
						"десять",
						"одиннадцать",
						"двенадцать",
						"тринадцать",
						"четырнадцать",
						"пятнадцать",
						"шестнадцать",
						"семнадцать",
						"восемнадцать",
						"девятнадцать");

	$s3		= array(
						"",
						"сто",
						"двести",
						"триста",
						"четыреста");

	if($number==0) {
		return "ноль ".$dop0[0];
	}


	$t_count = ceil(strlen($number)/3);

	for($i=0;$i<$t_count;$i++)	{
		$k = $t_count - $i - 1;
		$triplet[$k] = $number%1000;
		$number = floor($number/1000);
	}

	$res = "";

	for($i=0;$i<$t_count;$i++) {
		$t = $triplet[$i];
		$k = $t_count - $i - 1;
		$n1 = floor($t/100);
		$n2 = floor(($t-$n1*100)/10);
		$n3 = $t-$n1*100-$n2*10;


		if ($n1 < 5) {
			$res .= $s3[$n1]." ";
		} elseif ($n1) {
			$res .= $s1[$n1]."сот ";
		}

		if($n2 > 1) {
			$res .= $s2[$n2]." ";
		}

		if($n3 and $k==1) {
			$res .= $s11[$n3]." ";
		} elseif ($n3) {
			$res .= $s1[$n3]." ";
		} elseif($n2==1) {
			$res .= $s22[$n3]." ";
		} elseif($n3 and $k==1) {
			$res .= $s11[$n3]." ";
		} elseif($n3) {
			$res .= $s1[$n3]." ";
		}

		if($n3==1 and $n2!=1) {
			$res .= $dop1[$k]." ";
		} elseif($n3>1 and $n3<5 and $n2!=1) {
			$res .= $dop2[$k]." ";
		} elseif($t or $k==0) {
			$res .= $dop0[$k]." ";
		}

	}


	return trim($res.substr(sprintf("%01.2f", $origNumber), -2, 2)." копеек");
}


function trimString($text,$maxchar,$end='...')	{
		if (strlen($text) > $maxchar) {
			$words = explode(' ', $text);
				$output = '';
				$i=0;
				while(true) {
					$length = (strlen($output) + strlen($words[$i]));
					if ($length > $maxchar) break;
					else {
						$output = $output." ".$words[$i];
						++$i;
					}
				}
				$output.=$end;
		}
		else {
			$output = $text;
		}

		return $output;
}


function dataString($text) {
	$text = trim($text);
	$text = mysql_real_escape_string($text);
	$text = htmlspecialchars($text);
	return $text;
}


?>