<?
  class plugin_counters {
    protected $pluginParams = array();
	public $uri	= array();
  
    public function start() {
      global $sql;
	  
	  if(@$this->pluginParams['ID'] == "1") {
	    $sql->query("SELECT * FROM #__#counters WHERE count_id = '1'", true);
		return $sql->result[1];
	  }
	  
	  if(@$this->pluginParams['POS'] == "1") {
	    $sql->query("SELECT * FROM #__#counters WHERE count_pos = '1' AND count_url = '".getenv('REQUEST_URI')."'", true);
		return $sql->result[1];
	  }
	  
	  if(@$this->pluginParams['POS'] == "2") {
	    $sql->query("SELECT * FROM #__#counters WHERE count_pos = '2' AND count_url = '".getenv('REQUEST_URI')."'", true);
		return $sql->result[1];
	  }

	}
	
 	function __construct($params) {
		$this->pluginParams = api::setPluginParams($params);
	}
  
  }
?>