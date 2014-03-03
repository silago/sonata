<?php

class plugin_stat {
	function start() {
		return "<script language=\"javascript\">
  					swlog_r=\"r=\"+escape(document.referrer);
				</script>

				<script language=\"javascript1.1\">
				  swlog_js=\"1.1\"; swlog_r+=\"&j=\"+(navigator.javaEnabled()? \"Y\":\"N\")
				</script>

				<script language=\"javascript1.2\">
				  swlog_r+=\"&w=\"+screen.width+'&h='+screen.height;
				</script>

				<script language=\"javascript\">swlog_r+=\"&js=1\";
				  document.write(\"<img src='/stat/img.php?\"+swlog_r+\"&' border=0 width=88 height=32 alt='Statistic informer'>\")
				</script>

				<noscript>
				  <img src=\"/stat/img.php\" width=88 height=32 alt=\"PlazaCMS Statistic\">
				</noscript>
				";
	}
}


?>
