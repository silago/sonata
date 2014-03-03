<?
class gallery_map {
	
	public function start() {
		$this->addSubTree(0, "", 0);

		return array(
						"moduleName"			=> "Галерея",
						"items"					=> $this->return
						);
	
	}	
	
	protected function addSubTree($ownerId, $currentUri, $currentLevel) {
		
		$re = mysql_query("
							SELECT
									`id`,
									`groupTitle`
							FROM
									`gallerygroups`
							WHERE
									`ownerId` = '".$ownerId."'
							ORDER BY
									`position`
							");

		while($res=mysql_fetch_array($re)) {
			                        $this->return[] = array(
									"title" => $res['groupTitle'],
									"url" => "/gallery/".$res['id']."/album.html",
									"level" => $currentLevel,
									);
									
			$this->addSubTree($res['id'], "", $currentLevel+1);
		}
	}
}
?>