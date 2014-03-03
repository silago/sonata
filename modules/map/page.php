<?
class page_map {
	
	public function start() {
		$this->addSubTree(0, "", 0);

		return array(
						"moduleName"			=> "Страницы",
						"items"					=> $this->return
						);
	
	}	
	
	protected function addSubTree($ownerId, $currentUri, $currentLevel) {
		
		$re = mysql_query("
							SELECT
									`id`,
									`title`,
									`uri`
							FROM
									`pages`
							WHERE
									`ownerId` = '".$ownerId."'
							ORDER BY
									`position`
							");

		while($res=mysql_fetch_array($re)) {
			                        $this->return[] = array(
									"title" => $res['title'],
									"url" => "/page".$currentUri."/".$res['uri'].".html",
									"level" => $currentLevel,
									);
									
			$this->addSubTree($res['id'], $currentUri."/".$res['uri'], $currentLevel+1);
		}
	}
}
?>