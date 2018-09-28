<?php   

//define('MRE_DEBUG', ($_SERVER['REMOTE_ADDR'] == '158.121.240.90'));  //mre_debug = true;
define('MRE_DEBUG', false);  //mre_debug = true;
$mre_debug = MRE_DEBUG;
if (MRE_DEBUG) {
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
} else {
	error_reporting(E_ERROR);
}
//ini_set('display_errors', '1');
function write_debug($msg = '', $color='red') {
	global $mre_debug;
	static $mre_counter = 0;
	//if (MRE_DEBUG == true) {
	if ($mre_debug == true) {
		$mre_counter++;
		$color = (preg_match('/([a-zA-Z]+|#\d{3}|#\d{6})/', $color, $m)) ? $m[1] : 'red';
		echo "<span style=\"color:$color\">$mre_counter $msg</span><br/>";
	}
}


require_once("config.php"); 	

//require_once("article.php");
require_once("bug.php");
//require_once("calendar.php");
require_once("database.php");
//require_once("forum.php");
require_once("item.php");
require_once("maillib.php");
require_once("notification.php");
require_once("page.php");
require_once("permission.php");
require_once("template.php");
require_once("tree.php");
require_once("error.php");
require_once("http.php");
require_once("filesystem.php");
require_once("formBase.php");
require_once("form.php");
require_once("mysql2json.class.php");

//require_once("user.php");


//statedata specific
require_once("CordaEmbedder.php");
require_once("chart.php");
require_once("functions.php");
require_once("tracker.php");
require_once("downloads.php");

//dmr specific
require_once('dmr.php');
require_once("dds.php");

//sample specific
require_once("sample.php");

?>
