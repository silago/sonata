<?
class catalog_map {
	
	public function start() {
		$this->addSubTree(0, "", 0);

		return array(
						"moduleName"			=> "Каталог",
						"items"					=> $this->return
						);
	
	}	
	
	protected function addSubTree($ownerId, $currentUri, $currentLevel) {
		
		$re = mysql_query("
							SELECT
									`id`,
									`title`
							FROM
									`cataloggroups`
							WHERE
									`ownerId` = '".$ownerId."'
							ORDER BY
									`position`
							");

		while($res=mysql_fetch_array($re)) {
			                        $this->return[] = array(
									"title" => $res['title'],
									"url" => "/catalog/".$res['id']."/showGroup.php",
									"level" => $currentLevel,
									);
									
			$this->addSubTree($res['id'], "", $currentLevel+1);
		}
	}
}
?>