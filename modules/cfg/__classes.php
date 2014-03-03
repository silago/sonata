<?php
if (!defined("API")) {
	exit("Main include fail");
}

class cfg {
	public $return		= array();
	public $lang		= array();
  	public $curLang		= "ru";
	public $uri			= array();
	public $sql			= false;
	public $postArray	= array();
	public $errorParam	= false;
	public $api			= array();


	public function show() {
		$this->return['content'] = '<div id="info">
                                        <ul class="breadcrumb">
                                            <li><a href="#">Настройка модуля &laquo;'.$this->uri[3].'&raquo;</a></li>
                                        </ul>
                                     </div>';
        $this->return['content'] .= "<form action=\"save.php?lang=".$this->curLang."\" method=\"post\" id='form'>";

        $mCfg = new mCfg();

        foreach ($mCfg->cfg as $key=>$empty) {

            if (isset($this->postArray['cfgParams'][$paramName = $mCfg->cfg[$key][0]])) {
                $defaultValue = htmlspecialchars(stripslashes($this->postArray['cfgParams'][$paramName]));
            } else {
                $defaultValue = api::getConfig("modules", $this->uri[3], $mCfg->cfg[$key][0]);
            }

            switch ($mCfg->cfg[$key][3]) {
                case "text":
                    $formHtmlCode = "<input type=\"text\" name=\"cfgParams[".$mCfg->cfg[$key][0]."]\" value=\"".$defaultValue."\" style=\"width: 95%;\">";
                    break;

                case "textarea":
                    $formHtmlCode = "<textarea name=\"cfgParams[".$mCfg->cfg[$key][0]."]\" style=\"width: 95%; height: 150px\">".$defaultValue."</textarea>";
                    break;

                case "select":
					$this->sql->query("SELECT `value` FROM `#__#config` WHERE `category` = 'modules' && `type` = '".$this->uri[3]."' && `name` = '".$mCfg->cfg[$key][0]."'", true);					
					$opts = $mCfg->cfg[$key][4];					
					foreach($opts as $key1 => $value1){
						$select = ($this->sql->result['value'] == $value1['value']) ? 'selected' : '';						
						$options .="<option value='".$value1['value']."' $select>".$value1['text']."</option>";
					}					
					$formHtmlCode = "<select style=\"width:100%\" name=\"cfgParams[".$mCfg->cfg[$key][0]."]\">$options</select>";
				
				break;
				
				default:
                    continue;
                    break;
            }

            $mainTitle =  $mCfg->cfg[$key][1];
            $class = ($mCfg->cfg[$key][0] === $this->errorParam ? 'error' : '');
            $error = ($mCfg->cfg[$key][0] === $this->errorParam ? 'ОШИБКА! Поле не заполнено или заполнено неверно!' : '');
            $star =  (strtolower($mCfg->cfg[$key][5]) === "yes" ? '<span style="color:red;">&nbsp;*</span>' : '');

            $this->return['content'] .=     '<div class="control-group '.$class.'">
                                                <label class="control-label" for="inputWarning"><strong>'.$mainTitle.$star.'</strong><br><small>'.$mCfg->cfg[$key][2].'</small><br/>'.$error.'</label>
                                                <div class="controls">
                                                    '.$formHtmlCode.'
                                                </div>
                                            </div>';
        }

	//$addButton = ($this->uri[3] == 'security') ? '&nbsp;&nbsp;<button type="button" onclick="return addparam();" class="btn btn-primary">Добавить параметр</button>' : '';
	$this->return['content'] .= '<button type="submit" class="btn btn-primary">Сохранить</button></form>';
	}


	public function save() {
		$mCfg = new mCfg();

		foreach ($cfgArray = &$mCfg->cfg as $key=>$empty) {
			if (strtolower($cfgArray[$key][5]) === "yes" && (!isset($this->postArray['cfgParams'][$paramName = $cfgArray[$key][0]]) || empty($this->postArray['cfgParams'][$paramName]))) {
				$this->errorParam = $paramName;
				return $this->show();
			}
		}

		mCfg::check();

		if ($this->errorParam !== false){
			return false;
		}

		$queries = "<strong>Были выполнены следующие запросы</strong><br><br>";

		foreach ($cfgArray as $key=>$empty) {
			$paramName	= $cfgArray[$key][0];
			$paramValue	= $this->postArray['cfgParams'][$paramName];

			$this->sql->query("SELECT COUNT(*) FROM `#__#config` WHERE `category` = 'modules' && `type` = '".$this->uri[3]."' && `name` = '".$paramName."' && lang = '".$this->curLang."'", true);
			if ((int)$this->sql->result[0] === 0) {
				$this->sql->query($query = "INSERT INTO `#__#config`(`category`,
																	`type`,
																	`name`,
																	`value`,
																	`lang`)
															VALUES(
																	'modules',
																	'".$this->uri[3]."',
																	'".$paramName."',
																	'".$paramValue."',
																	'".$this->curLang."')");
				$queries .= "SQL\t".htmlspecialchars($query)."<br>";
			} else {
				$this->sql->query($query = "UPDATE `#__#config` SET  `value` = '".$paramValue."' WHERE `category` = 'modules' && `type` = '".$this->uri[3]."' && `name` = '".$paramName."' && lang = '".$this->curLang."'");
			}
		}
		message("OK", (@$this->postArray['showSql'] == 1 ? $queries : ""), "admin/index.php");
	}


	function __construct() {
		global $_POST;
		$this->postArray = api::slashData($_POST);

	}

}


?>
