<?php
exit;
set_time_limit(300);
if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '98.216.239.14'))) {
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
}
if (function_exists('xdebug_disable')) {
	xdebug_disable();
}
define('LIVE', 1 || (isset($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] == '69.20.125.203') || (isset($_ENV['HOSTNAME']) && $_ENV['HOSTNAME'] == 'communityinclusion.org'));

$_ENV['PHP_CLASSPATH'] = dirname(__FILE__) . '/includes/';
include('./includes/constants.php');
include('./includes/utils.php');
include(LIVE ? '/home/nercve/lib/lib.php' : '/Users/umb/workspace/lib/lib.php');
if (LIVE) {
	include('/usr/local/Corda60/dev_tools/embedder/php/CordaEmbedder.php');
}
/*if (LIVE && !has_value($_SERVER, 'HTTPS')) {
	header('Location: https://' . DOMAIN . DIR . (strlen($_SERVER['QUERY_STRING']) > 0 ? '?' . $_SERVER['QUERY_STRING'] : ''), true, 301);
	exit;
}*/
session_set_cookie_params(0, DIR, LIVE ? DOMAIN : '', 0, true);
session_start();

$page = isset($_REQUEST['page']) ? preg_replace('/[^a-z0-9]+/i', '', $_REQUEST['page']) : '';
$report = isset($_GET['report']) ? $_GET['report'] : '';

$ajax = isset($_REQUEST['ajax']) ? preg_replace('/[^a-z0-9]+/i', '', $_REQUEST['ajax']) : '' ;
$template = template::getTemplate(TEMPLATE, 'http://' . DOMAIN . DIR);
$template->addRegion('title', ' - WA-DDD Employment Outcome Data');
$t = microtime(true);
$msgs = array('Start: ' . 0);
/*$user = user::getInstance();
if ($page == LOGOUT) {
	$user->logout();
}*/
/*if (isset($_POST['email']) && isset($_POST['password'])) {
	$user->login($_POST['email'], $_POST['password']);
}*/
if (has_value($_SESSION, 'loadingData', 1)) {
	$template->addRegion('content', '<h1>Loading data...</h1><p>The page should refresh automatically if it does not <a href="./">click to refresh</a>.</p><script type="text/javascript">setTimeout(navigator.location = "./", 1000);</scirpt>');
	print $template->getHTML();
	exit;
}

$msgs[] = 'Logic Started: ' . (microtime(true) - $t);
/*if (/*$user->loggedIn() && $report > 0 && has_value($_REQUEST, 'action', 'delete')) {
	report::deleteSavedReport($report);
	unset($_SESSION['report']);
	include('./includes/home.php');
} else */if (/*$user->loggedIn() && ($report > 0 || */report::validType($report)/*)*/) {
	$msgs[] = 'Found Valid report:' . (microtime(true) - $t);
	/*if ($report > 0) {
		$rpt = $_SESSION['report'] = report::getSavedReport($report);
	} else */if ((!isset($_SESSION['report']) || !($_SESSION['report'] instanceof report) || $_SESSION['report']->getType() != $report) && has_value($_SESSION, 'baseReport') && $_SESSION['baseReport'] instanceof report) {
		$_REQUEST = $_POST = $_GET = array();
		$rpt = $_SESSION['report'] = $_SESSION['baseReport']->copy();
		$rpt->setType($report);
		$msgs[] = 'Got report from  baseReport:' . (microtime(true) - $t);
	} else if (!isset($_SESSION['report']) || !($_SESSION['report'] instanceof report) || $_SESSION['report']->getType() != $report) {
		$_REQUEST = $_POST = $_GET = array();
		$rpt = $_SESSION['report'] =  new report($report);
		$msgs[] = 'Created new report:' . (microtime(true) - $t);
	} else if (isset($_SESSION['report']) && $_SESSION['report'] instanceof report) {
		$rpt = $_SESSION['report'];
		$msgs[] = 'Using saved report:' . (microtime(true) - $t);
	}
	if (isset($rpt)) {
		/*if (has_value($_REQUEST, 'save') && has_value($_REQUEST, 'title')) {
			$rpt->save($_REQUEST['title']);
		}*/
	
		if (count($_POST) > 0 || count($_GET) > 1) {
			$rpt->process();
			$msgs[] = 'Processed report:' . (microtime(true) - $t);
		}
		$msgs[] = 'Making report:' . (microtime(true) - $t);
		$template->addRegion('content', $rpt->make(has_value($_POST, 'to') && valid_email($_POST['to'])));
		$template->addRegion('title', $rpt->getLegend());
		$template->addRegion('heading', $rpt->getLegend());
		$msgs[] = 'Made report:' . (microtime(true) - $t);
		
		if (has_value($_POST, 'to')) {
			iF (!valid_email($_POST['to'])) {
				error('Invalid e-mail address.');
			} else {
				$msg = 'mode:' . $template->makeTemplate(template::MODE_EMAIL);
				$headers = "From: WA-DDD Employment Supports Performance Outcome Information System <waddd@statedata.info>\r\n"
						 . "Content-Type: text/html\r\n";
				mail($_POST['to'], 'WA-DDD ' . $rpt->getLegend(), $msg, $headers);
				$template->addRegion('content', $rpt->make(false));
			}
		}
	} else {
		error('Invalid Report.');
		include('./includes/home.php');
	}
} else if (/*$user->loggedIn() && */is_file('./includes/' . $page . '.php')) {
	unset($_SESSION['report']);
	include('./includes/' . $page . '.php');
} else if (/*$user->loggedIn() && */$ajax) {
	$reg = $cou = false;
	if ($ajax == 'getCounties') {
		/*if ($user->getRegion() != '') {
			$reg = $user->getRegion();
		} else */if (has_value($_REQUEST, 'region', REGEX_REGION_CODE, COMP_REGEX)) {
			$reg = $_REQUEST['region'];
		} else if (has_value($_REQUEST, 'region', 0)) {
			$reg = 'all';
		}
		
		echo $reg ? json_encode($_SESSION['baseReport']->getCountiesInRegion($reg)) : '[]';
	} else if ($ajax == 'getProviders') {
		/*if ($user->getRegion() != '') {
			$reg = $user->getRegion();
		} else */if (has_value($_REQUEST, 'region', REGEX_REGION_CODE, COMP_REGEX) || has_value($_REQUEST, 'region', 'all')) {
			$reg = $_REQUEST['region'];
		} else if (has_value($_REQUEST, 'region', 0)) {
			$reg = 'all';
		}
		/*if ($user->getCounty() != '') {
			$cou = $user->getCounty();
		} else */if (has_value($_REQUEST, 'county', REGEX_COUNTY_CODE, COMP_REGEX) || has_value($_REQUEST, 'county', 'all')) {
			$cou = $_REQUEST['county'];
		} else if (has_value($_REQUEST, 'county', 0)) {
			$cou = 'all';
		}
		echo $reg && $cou ? json_encode($_SESSION['baseReport']->getProvidersInRegionCounty($reg, $cou)) : '[]';
	} else if ($ajax == 'downloadReport') {
		$_SESSION['report']->exportCSV();
	}
	exit;
} else {
	unset($_SESSION['report']);
	$msgs[] = 'Loading homepage: ' . (microtime(true) - $t);
	include('./includes/home.php');
	$msgs[] = 'Loading homepage - Finished: ' . (microtime(true) - $t);
}

$msgs[] = 'Generating base report: ' . (microtime(true) - $t);
if (!isset($_SESSION['loadingData'])) {
	$msgs[] = 'Haven\'t loaded base report yet: ' . (microtime(true) - $t);
	$_SESSION['loadingData'] = 1;
	if (class_exists('memcache')) {
		$msgs[] = 'Using memcache: ' . (microtime(true) - $t);
		$m = new memcache;
		$m->connect('localhost');
		if ($m->get('WADDD-baseReport') == false) {
			$r = new report(0, true);
			$m->set('WADDD-baseReport', $r);
		} else if (!isset($_SESSION['baseReport']) || !($_SESSION['baseReport'] instanceof report)) {
			$r = $m->get('WADDD-baseReport');
		}
	} else {
		$r = new report(0, true);
	}
	$_SESSION['baseReport'] = $r;
	$_SESSION['loadingData'] = 2;
}
$content = $template->getRegion('content');
$template->addRegion('content', error() . $content . (LIVE ? '' : '<p>' . implode('<br />', $msgs) .'</p>'));

print $template->makeTemplate(template::MODE_DISPLAY);
