<?php
function smarty_function_pages_menu_ul($params,&$smarty)
{
    $class= new smarty_plugin_pagesMenuUL($params);
    return $class->start();
}


//эта фига для быстрого переноса плагинов. можно бы сделать и лучше
class smarty_plugin_pagesMenuUL {
	protected $pluginParams = array();	
	protected $limitLevel = 3;
	protected $ownerId = 0;
	protected $tableName = '#__#pages';
	protected $pDir = 'pagesMenuUL';

 	public function start() {
		$result = $this->loadTreeSQL($this->ownerId);
		$template = new template(api::setTemplate('plugins/'.$this->pDir.'/index.body.tmpl'));
		$template->assign('body', $result);
 		return $template->get();
 	}
 	 	
 	protected function loadTreeSQL($ownerId, $level = 0) {
		global $sql;
		
		if ($level > $this->limitLevel) return;
		
		$query = "SELECT `id`, `title`, `uri`, `redirect` FROM ".$this->tableName." WHERE `ownerId` = '".$ownerId."' AND `navigationShow` = 'y' ORDER BY `position`";
		$sql->query($query);
		$rows = $sql->getList();
 		
		$result = '';
		foreach ($rows as $row) {			
			$query = "SELECT `id`, `title`, `uri`, `redirect` FROM ".$this->tableName." WHERE `ownerId` = '".$row['id']."' AND `navigationShow` = 'y' ORDER BY `position`";
			$sql->query($query);
			
			$template = new template(api::setTemplate('plugins/'.$this->pDir.'/index.item.tmpl'));
								
			if ($sql->num_rows() > 0) {
				$template->assign('title', $row['title']);
				$template->assign('uri', !empty($row['redirect']) ? $row['redirect'] : '/'.$row['uri'].'.html');
				$result .= $template->get();
				$result .= '<ul>'.$this->loadTreeSQL($row['id'], $level++).'</ul>';					
				$result .= '</li>';
			}
			else {
				$template->assign('title', $row['title']);
				$template->assign('uri', !empty($row['redirect']) ? $row['redirect'] : '/'.$row['uri'].'.html');
				$result .= $template->get().'</li>';
			}
		}
				
		return $result;
 	}

 	function __construct($params) {		
 		$this->pluginParams = api::arrayKeysSL(api::setPluginParams($params));
 		$this->pluginParams = $params;
 		
 		if (isset($this->pluginParams['limit'])) {
 			$this->limitLevel = $this->pluginParams['limit'];
 		}
 		
 		if (isset($this->pluginParams['owner'])) {
 			$this->ownerId = $this->pluginParams['owner'];
 		}
	}
}

