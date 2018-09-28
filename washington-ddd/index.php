<?php
set_time_limit(300);
// if (in_array($_SERVER['REMOTE_ADDR'], array('98.216.239.14'))) {
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
// }
if (function_exists('xdebug_disable')) {
	xdebug_disable();
}
define('LIVE', (isset($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] == '162.209.10.199') || (isset($_ENV['HOSTNAME']) && $_ENV['HOSTNAME'] == 'communityinclusion.org'));
$_ENV['PHP_CLASSPATH'] = __DIR__ . '/includes/';
include('./includes/constants.php');
include('./includes/utils.php');
include(LIVE ? '/home/nercve/lib/lib.php' : '/Volumes/Stuff/umb/lib/lib.php');
if (LIVE) {
	include('/usr/local/Corda60/dev_tools/embedder/php/CordaEmbedder.php');
}
$cookies = "\n<!-- start " . print_r($_COOKIE, true) . " -->\n";
session_set_cookie_params(0, DIR, LIVE ? DOMAIN : '', 0, 0);
session_start();

if (empty($_SESSION['baseReport2'])) {
	if (class_exists('memcache')) {
		$m = new memcache;
		$m->connect('localhost');
		if (($r = $m->get('WADDD-baseReport2')) == false) {
			$r = new report(0, true);
			$midnight = 86400 - time() + mktime(0,0,0);
			$m->set('WADDD-baseReport2', $r, 0, $midnight);
		}
	} else {
		$r = new report(0, true);
	}
	$_SESSION['baseReport2'] = $r;
}

$page = isset($_REQUEST['page']) ? preg_replace('/[^a-z0-9]+/i', '', $_REQUEST['page']) : '';
$report = isset($_GET['report']) ? $_GET['report'] : '';

$ajax = isset($_REQUEST['ajax']) ? preg_replace('/[^a-z0-9]+/i', '', $_REQUEST['ajax']) : '' ;
$template = template::getTemplate(TEMPLATE, 'https://' . DOMAIN . DIR);
$template->addRegion('title', ' - WA-DDD Employment Outcome Data');
$t = microtime(true);
$msgs = array('Start: ' . 0);
if (report::validType($report)) {
	$msgs[] = 'Found Valid report:' . (microtime(true) - $t);
	if ((!isset($_SESSION['report']) || !($_SESSION['report'] instanceof report) || $_SESSION['report']->getType() != $report) && has_value($_SESSION, 'baseReport2') && $_SESSION['baseReport2'] instanceof report) {
		//$_REQUEST = $_POST = $_GET = array();
		$rpt = $_SESSION['report'] = $_SESSION['baseReport2']->copy();
		$rpt->setType($report);
	} else if (!isset($_SESSION['report']) || !($_SESSION['report'] instanceof report) || $_SESSION['report']->getType() != $report) {
		$_REQUEST = $_POST = $_GET = array();
		$rpt = $_SESSION['report'] =  new report($report, true);
	} else if (isset($_SESSION['report']) && $_SESSION['report'] instanceof report) {
		$rpt = $_SESSION['report'];
	}
	if (isset($rpt)) {
		if (count($_POST) > 0 || count($_GET) > 1) {
			$rpt->process();
			$template->setUrl(DIR . 'report/' . $rpt->getType() . '/generate');
		} else {
			$template->setUrl(DIR . 'report/' . $rpt->getType() . '/statrt');
		}
		$template->addRegion('content', $rpt->make(has_value($_POST, 'to') && valid_email($_POST['to'])));
		$template->addRegion('title', $rpt->getLegend());
		$template->addRegion('heading', $rpt->getLegend());
	} else {
		error('Invalid Report.');
		$template->setUrl(DIR);
		include('./includes/home.php');
	}
} else if (/*$user->loggedIn() &&*/ is_file("./includes/$page.php")) {
	unset($_SESSION['report']);
	$template->setUrl(DIR . $page);
	include("./includes/$page.php");
} else if ($ajax) {
	$reg = $cou = false;
	header('Content-type:application/json');
	if ($ajax == 'getCounties') {
		if (has_value($_REQUEST, 'region', REGEX_REGION_CODE, COMP_REGEX)) {
			$reg = $_REQUEST['region'];
		} else if (has_value($_REQUEST, 'region', 0)) {
			$reg = 'all';
		}
		echo $reg ? json_encode($_SESSION['baseReport2']->getCountiesInRegion($reg)) : '[]';
	} else if ($ajax == 'getProviders') {
		if (has_value($_REQUEST, 'region', REGEX_REGION_CODE, COMP_REGEX) || has_value($_REQUEST, 'region', 'all')) {
			$reg = $_REQUEST['region'];
		} else if (has_value($_REQUEST, 'region', 0)) {
			$reg = 'all';
		}
		if (has_value($_REQUEST, 'county', REGEX_COUNTY_CODE, COMP_REGEX) || has_value($_REQUEST, 'county', 'all')) {
			$cou = $_REQUEST['county'];
		} else if (has_value($_REQUEST, 'county', 0)) {
			$cou = 'all';
		}
		echo $reg && $cou ? json_encode($_SESSION['baseReport2']->getProvidersInRegionCounty($reg, $cou)) : '[]';
	} else if ($ajax == 'downloadReport') {
		$_SESSION['report']->exportCSV();
	}
	exit;
} else {
	unset($_SESSION['report']);
	include('./includes/home.php');
}
$content = $template->getRegion('content');
$template->addRegion('content', error() . $content);

print $template->makeTemplate(template::MODE_DISPLAY);
print "$cookies<!-- "; print_r($_COOKIE); print " -->";
