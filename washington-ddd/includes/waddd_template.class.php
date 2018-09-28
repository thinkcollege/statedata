<?php
class waddd_template extends template {

	private $url = '';

	static public function getInstance($base = '') {
		static $instance = null;
		if ($instance === null) {
			$instance = new self($base);
		}
		return $instance;
	}

	protected function __construct($base) {
		parent::__construct($base);
	}

	public function setUrl($url) {
		$this->url = $url;
	}

	public function getHTML($mode = template::MODE_DISPLAY) {
		return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head><title>{title}</title>
 <base href="{_base}" />
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <link rel="stylesheet" type="text/css" href="https://www.statedata.info/common/styles.css" media="all" />
 <link rel="stylesheet" type="text/css" href="https://www.statedata.info/common/side_menu.css" media="screen" />
 <link rel="stylesheet" type="text/css" href="./includes/waddd-2.css" media="screen" />
 <link rel="stylesheet" type="text/css" href="./includes/print.css" media="print" />'
. ($mode == template::MODE_EMAIL ? '<link rel="stylesheet" type="text/css" href="./includes/email.css" media="all" />' : '') . '
 <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
 <script type="text/javascript" src="./waddd2.js"></script>
 <script>
   (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
   (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
   m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
   })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');

   ga(\'create\', \'UA-962830-32\', \'auto\');
   ga(\'send\', \'pageview\');

 </script>
</head>
<body>
<div id="skip"><a href="#side_menu">Skip to navigation and funders</a></div>
<div id="main">
	<h1>{heading}</h1>
	{content}
</div> <!--end main div-->
<div id="top">WA-DDD Employment Supports Information System.</div>
<div id="side_menu"><ul>
<li><a href="./">Project home</a></li>
<li><a href="/washington/search"><span style="color: red; font-weight: bold;">New: </span> WA Provider Search</a></li>
<li><a href="./?report=' . report::TREND . (isset($_SESSION['report']) && $_SESSION['report']->getType() == report::TREND ? '&amp;restart' : '') . '">Trend Report</a></li>
<li><a href="./?report=' . report::SUMMARY . (isset($_SESSION['report']) && $_SESSION['report']->getType() == report::SUMMARY ? '&amp;restart' : '') . '">Summary Report</a></li>
<li><a href="./?page=feedback">Feedback</a></li>
</ul>
<ul id="funders">
<li><a href="http://dshs.wa.gov/ddd/"><img src="https://www.statedata.info/images/dshs.jpg" alt="dshs.wa.gov/ddd/" /></a></li>
<li>
 <a class="splitLeft" href="http://www.communityinclusion.org/"><img src="https://www.statedata.info/images/icigreendark.gif" width="72" height="72" alt="www.communityinclusion.org" /></a>
 <a class="splitRight" href="http://www.umb.edu/"><img src="https://www.statedata.info/images/UMB_informal.gif" width="65" height="72" alt="www.umb.edu" /></a>
</li>
<li><a href="http://www.statedata.info/"><img src="https://www.statedata.info/images/statedata_side.gif" alt="www.statedata.info" /></a></li>
</ul><!--end funders div-->
</div><!--end sidemenu div-->
</body></html>';
	}
} ?>
