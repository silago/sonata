<?php

class plugin_searchForm {
	public function start() {
		$template = new template(api::setTemplate("plugins/searchForm/form.html"));
		return $template->get();
	}
}
?>