<?
class parcer {
        function parceMarkEval($mid, $sid, $markTitle, $count) {
                global $returnMark;
                $returnMark[]=array(intval($mid), intval($sid), "\"".$markTitle."\"", intval($count));
                return true;
                }

        function parceMark($string) {
                global $returnMark;
                $returnMark = array();

                preg_replace("/<a href=\?mid=([0-9]+)[\&]*(cid=[0-9]+){0,1}>([a-z]+)[\s]*\(([0-9]+)+\)[\s]*<\/a>/ies", "\$this->parceMarkEval('\\1', '\\2', '\\3', '\\4')", $string);
//                exit(htmlspecialchars($string));
//                var_dump($returnMark);
//                exit();
                return $returnMark;
                }

        function parceLink($link) {
                preg_match("/^http\:\/\/([a-z\.\-]*)(\/.*)$/is", $link, $match);
                return array($match[1], $match[2]);
                }

        function getMark($cityId, $fId, $pg=1) {
                global $socket;

                if ($fId != "all" && $cityId == "all") $link="http://www.auto.vl.ru/sales/?fid=".$fId;
                if ($fId != "all" && $cityId != "all") $link="http://www.auto.vl.ru/sales/?fid=".$fId."&cid=".$cityId;

                $linkInfo=$this->parceLink($link);
                $data = $socket->get($linkInfo[0], $linkInfo[1]);

                $marks=$this->parceMark($data);
                return $marks;
                }

        function getFIdFomTitle($string) {
                 global $fIds;
                 if (($key=array_search($string, $fIds)) !== false) {
                         return $key;
                         } else {
                                 return "all";
                                 }
                        }

        function getData($mid, $cid, $order, $orderType, $page, $photo = "0", $s="") {
                global $socket;
                $link="http://www.auto.vl.ru/sales/?mid=".$mid."&cid=".$cid."&order=".$order."&order_d=".$orderType."&pg=".$page."&s=".$s."&ph=".$photo;
                $linkInfo=$this->parceLink($link);
                $data = $socket->get($linkInfo[0], $linkInfo[1]);

                $data=$this->parceTableNoPhoto($data);
                return $data;
                }
        function getDataSearch($uri, $page, $order, $orderType) {
                global $socket;
                $link="http://www.auto.vl.ru/sales/".$uri."&pg=".$page."&order=".$order."&order_d=".$orderType;
//                exit($link);
                $linkInfo=$this->parceLink($link);
                $data = $socket->get($linkInfo[0], $linkInfo[1]);
                $data=$this->parceTableNoPhoto($data);
                return $data;
                }

        function parceTableNoPhoto($data){
                global $tableReturn;
                $tableReturn = array();
                preg_replace("/<tr(?:[^>]*)><td(?:[^>]*)><a(?:[^>]*)\?id=([0-9]+){1,1}(?:[^>]*)>([0-9\-]+){1,1}<\/a><\/td><td(?:[^>]*)>((?:[^\/]|<b>|<\/b>|<strike>|<\/strike>)*)<\/td><td(?:[^>]*)>([0-9a-z\;\&\s]*)?<\/td><td(?:[^>]*)>([a-z\;\&0-9\s]*)?<\/td><td(?:[^>]*)>([a-z\;\&а-я\s\.\-]*)?<\/td><td(?:[^>]*)>([a-z\;\&0-9а-я\s\.\-]*)?<\/td><td(?:[^>]*)>([a-z\;\&0-9а-я\s\.\-]*)<\/td><td(?:[^>]*)>([\$0-9a-zа-я\s\&\;\/]*)<\/td><td(?:[^>]*)>([0-9a-z\;\&а-я\s\.\-]*)?<\/td>(?:<td[^>]*)>(?:<a(?:[^>]*)?><img(?:[^>]*)>)?([a-z\;\&а-я\s\.\-]*)(?:<\/a>)?<\/td>(?:<td(?:[^>]*)>(?:<b>|<strong>)?([a-z\;\&\s0-9а-я\-\.\/]*)(?:<\/b>|<\/strong>)?<\/td>)?<td(?:[^>]*)>([0-9a-z\;\&а-я\s]*)<\/td>/ise", "\$this->parceTableNoPhotoEval('\\1', '\\2', '\\3', '\\4', '\\5', '\\6', '\\7', '\\8', '\\9', '\\10', '\\11', '\\12', '\\13')", $data);

//                preg_match_all("/<tr(?:[^>]*)><td(?:[^>]*)><a(?:[^>]*)\?id=([0-9]+){1,1}(?:[^>]*)>([0-9\-]+){1,1}<\/a><\/td><td(?:[^>]*)>([^\/]|<b>|<\/b>|<strike>|<\/strike>)*<\/td>/ise", $data, $match);
//                echo nl2br(htmlspecialchars(var_export($match, true)));
//                exit();
//                var_dump($tableReturn);
//                exit();
                return $tableReturn;
                }

        function parceTableNoPhotoEval($id, $date, $model, $year, $volume, $kpp, $fuel, $priv, $cost, $city, $photo, $run, $view) {
                global $tableReturn;
                $tableReturn[] = array($id, $date, $model, $year, $volume, $kpp, $fuel, $priv, $cost, $city, $photo, $run, $view);
                return true;
                }

        function getInfo($id) {
                global $socket;
                $link="http://www.auto.vl.ru/sales/?id=".$id;
                $linkInfo=$this->parceLink($link);
                $data = $socket->get($linkInfo[0], $linkInfo[1]);
                $data=$this->parceInfo($data);
                return $data;

                }

        function parceInfo($data) {
                global $parceInfo, $info, $tmpStr;
                $info=array(); $tmpStr = "";
                preg_replace("/Объявление ([0-9]+)? от ([0-9\-]+)?/ise", "\$info['id']='\\1';", $data);
                preg_replace("/от ([0-9\-]+)?/ise", "\$info['date']='\\1';", $data);
                preg_replace("/<\/b><h4>([0-9a-zа-я\"\-\.\,\s]*)?/ise", "\$info['title']='\\1'", $data);
                preg_replace("/Двигатель:<\/td><td(?:[^>]*)>([^<]*)?<\/td>/ise", "\$info['dvig']='\\1'", $data);
                preg_replace("/Трансмиссия:<\/td><td(?:[^>]*)>([^<]*)?<\/td>/ise", "\$info['trans']='\\1'", $data);
                preg_replace("/Привод:<\/td><td(?:[^>]*)>([^<]*)?<\/td>/ise", "\$info['privod']='\\1'", $data);
                preg_replace("/Дополнительно:<\/td><td(?:[^>]*)>([^<]*)?<\/td>/ise", "\$info['addOn']=stripslashes('\\1')", $data);
                preg_replace("/Пробег по России:<\/td><td(?:[^>]*)>([^<]*)?<\/td>/ise", "\$info['runRus']=strip_tags('\\1')", $data);
                preg_replace("/Город:<\/td><td(?:[^>]*)>([^<]*)?<\/td>/ise", "\$info['city']=strip_tags('\\1')", $data);
                preg_replace("/Контакт:<\/td><td(?:[^>]*)>([^<]*)?/ise", "\$info['cont']=strip_tags('\\1')", $data);
                preg_replace("/<h4>Цена:\s?([\$0-9]*)?/ise", "\$info['cost']='\\1'", $data);

                // Searching and decode e-mail
                preg_replace("/Контакт:<\/td><td(?:[^>]*)>(.*)(?:Цена)/ise", "\$tmpStr='\\1'", $data);
                preg_match("/([a-z0-9_\.]+\@[a-z0-9_\.\-]+)/is", $tmpStr, $match);
                if (empty($match[1])) preg_match("/document\.write\(([^\)]*)/is", $tmpStr, $match);
                @$email=str_replace("+", "", $match[1]); $email=str_replace("\\", "", $email); $info['email']=str_replace("'", "", $email);

                $info['photos']=$this->searchPhotoParce($info['id'], $data);

                //echo nl2br(var_export($info, true));
                // exit();
                return $info;
                }

        // search photo
        function searchPhotoParce($id, $data) {
                global $photos, $idPhoto;
                $idPhoto = $id;
                $photos = array();
                preg_replace("/\/sales\/photos\/([0-9]+)\/".$id."\/(?:tn_)?([0-9]+)\.jpg/ise", "\$this->searchPhotoParceEval(\\1, \\2)", $data);
                //exit(htmlspecialchars(var_dump($photos)));
                return $photos;
                }

        function searchPhotoParceEval($subCat, $num){
                global $photos, $idPhoto;
                $photos[] = array('from' => "/sales/photos/$subCat/$idPhoto/$num.jpg", 'fromSmall' => "/sales/photos/$subCat/$idPhoto/tn_$num.jpg", "id" => $idPhoto, "num" => $num, "subCat" => $subCat);
                }

        }
?>