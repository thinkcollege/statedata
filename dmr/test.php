<?PHP
ini_set('include_path', '../');
function __autoload($class) {
	include('common/' . $class . '.php');
}

$chart = new chart;
$chart->externalServerAddress = 'localhost';
$chart->internalCommPortAddress = 'localhost';

var_dump($chart);
