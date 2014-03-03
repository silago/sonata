<?php

class plugin_catalogLeftMenu {
    protected $pluginParams = array();     
	
	private $arrGroups;
	private $arrVisibleULs = array (0);
	 
    public function start() {
     	global $sql ,$ret;
     	
		$result = '';
		
		$activeUriGroup = isset ($ret['uriGroup']) ? $ret['uriGroup'] : '';
		
		$sql->query ("select `group_id`, `parent_group_id`, `name`, `uri` from `shop_groups` where `hidden` = 0 order by `position` asc");
		
		$this->arrGroups = array ();
		while ($sql->next_row ()) {
			$this->arrGroups[$sql->result['parent_group_id']][] = array ('gid' => $sql->result['group_id'], "pgid" => $sql->result['parent_group_id'], "gname" => $sql->result['name'], 
																	"guri" => $sql->result['uri'], "active" => $activeUriGroup == $sql->result['uri'] ? 1 : 0);
			if ($activeUriGroup == $sql->result['uri']) {
				$startActivepgid = $sql->result['parent_group_id'];
			}			
		}
		
		//print_r ($this->arrGroups);
		
		// назначить класс active всем родителям активной группы
		$this->findActiveElements (isset ($startActivepgid) ? $startActivepgid : 0);
		
		//print_r ($startActivepgid);
		//print_r ($this->arrGroups);
		
		// Построение меню
		$result = $this->getTree (0);
		
     	return $result;
    }
	 
	function findActiveElements ($groupid) {
		
		if ($groupid == 0) return;
		
		foreach ($this->arrGroups as $key => $group) {
			foreach ($group as $key2 => $groupItem) {
				if ($groupItem['gid'] == $groupid) {					
					$this->arrGroups[$key][$key2]['active'] = 1;	
					$this->arrVisibleULs[] = $groupid;
					$this->findActiveElements ($groupItem['pgid']);						
				}
			}
		}		
	}
	
	function getTree ($id, $lvl = 1, $act = 0) {
		$result = '';		
		$result .= "<ul>";
		
		foreach ($this->arrGroups[$id] as $key => $value) {
			$result .= "<li class='" . ($value['active'] == 1 ? "active" : "") . " ".($lvl == 1 ? 'cat-header' : '')."'><a href='/".$value['guri']."'>".$value['gname']."</a>";
			
			if (isset ($this->arrGroups[$value['gid']]) && is_array ($this->arrGroups[$value['gid']])) { 
				$result .= $this->getTree ($value['gid'], $lvl + 1, $value['active'] == 1 ? "1" : "0");
			}
			
			$result .= "</li>";
		}
		
		$result .= "</ul>";
		
		return $result;
	}

    function __construct($params) {
		$this->pluginParams = api::setPluginParams($params);
    }
}