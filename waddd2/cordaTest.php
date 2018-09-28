
<?PHP
$pcScript = "graph.setCategories(Jan. 09;Feb. 09;Mar. 09;Apr. 09;May. 09;Jun. 09)graph.SetSeries((CLR_9900CC)Avg. Gross Wages for Individual Employment from Jan. 09 to Jun. 
09;724.22;682.54;719.74;722.98;706.97;709.04)main.title(Avg. Gross Wages for Individual Employment from Jan. 09 to Jun. 09)main.AddPCXML(<Textbox Name='title' Top='0' Left='0' 
Width='615' Height='24'><Properties AutoWidth='False' HJustification='Center' LeftMargin='5' RightMargin='5' FillColor='#BACBDB' Font='Size:14; Style:Bold Italic; 
Color:#5C656A;'/><Text>Avg. Gross Wages for Individual Employment from Jan. 09 to Jun. 09</Text></Textbox>)main.AddPCXML(<Textbox Name='axis1' Top='120' Left='10' Width='75' 
Height='70'><Properties BorderType='None' AutoWidth='True' HJustification='Center' LeftMargin='5' RightMargin='5' FillColor='#ffffff' Font='Size:10; Style:Bold; Color:black;' 
/><Text>Avg.</Text></Textbox>)graph.AddPCXML(<CategoryScale LimitLabelLength='False' MaxLengthRotatedText='10' StaggerLabels='False' RotateLabels='-45' 
LowOuterLine='Color:#7f7f7f;' HighOuterLine='Color:#7f7f7f;' MajorTick='Visible:False;' MinorTick='Size:Large;' MajorGrid='Color:#7f7f7f;' Font='Size:12; Style:Bold Italic; 
Color:#3366ff;' MinorFont='Size:10;' />)";

include('/usr/local/Corda60/dev_tools/embedder/php/CordaEmbedder.php');
$myImage = new CordaEmbedder;
$myImage->externalServerAddress = ''; #"69.20.125.203:8080";
$myImage->internalCommPortAddress = ''; #"69.20.125.203:8081";
$myImage->appearanceFile = "apfiles/waddd.pcxml";
$myImage->userAgent = $_SERVER['HTTP_USER_AGENT'];
$myImage->width = 540;
#$myImage->height = 330;
$myImage->returnDescriptiveLink = true;
$myImage->language = "EN";
$myImage->pcScript = $pcScript;
$myImage->outputType = "JPG";
$myImage->debugOn = true;
print 'Server: ' . $myImage->externalServerAddress . ' CommPort: ' . $myImage->internalCommPortAddress . ' Cluster: ' . $myImage->clusterMonitorAddress . '<br />';
ini_set('display_errors', 'On');
error_reporting(E_ALL);

$fp = fsockopen('69.20.125.203', 8081);
fputs($fp, "GET / HTTP/1.0\n\n");
$nobr = false;
while (!feof($fp)) {
	$line = fgets($fp);
	$nobr = strlen($line) == 0 || $nobr;
	print $line . $nobr ? '' : "<br />";
}
#print '<div class="float-left">' . preg_replace('#<(no)?script.*</\1?script>#sUi', '', $myImage->getEmbeddingHTML()) . '</div>';
