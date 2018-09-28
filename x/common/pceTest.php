<html>
<head>
<title>PHP CordaEmbedder Test</title>
<?php

require("CordaEmbedder.php");
//include("CordaEmbedder.php");

$ce = new CordaEmbedder();

// set CordaServer port and commport addresses
$ce->externalServerAddress = "http://10.0.1.94:2001";
$ce->internalCommPortAddress = "http://127.0.0.1:2002";

// set appearance file
//$ce->appearanceFile = "examples/apfiles/bar.pcxml";

// set height and width
//$ce->width = 800;
//$ce->height = 600;

// set chart background color
$ce->bgColor = "C0C000";

// set imageType and fallback
//$ce->imageType = "SVG";
$ce->imageType = "FLASH";
$ce->fallback = "STRICT";

// set the user agent
// setting the user agent allows popchart server to tailor the javascript it produces for a client browser
// also allows PNG images to be served to browsers that support it,
// but only if the popchart server is set to autoswitch to png

// set user agent string in PHP 4.1.0 and above
//$ce->userAgent =  $_SERVER['HTTP_USER_AGENT'];

// set user agent string pre PHP 4.1.0
$ce->userAgent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];

// pass data
//$ce->pcScript = "graph.categories(Nate,Will,Ken,Jason)graph.series(Batting Average,0.500,0.432,0.928,0.665)";

$ce->loadPCXML("examples/apfiles/stackedbar.pcxml");

/*
$ce->addPCXML("<?xml version='1.0' encoding='ISO-8859-1'?>" .
"<Chart Version='4.0' BGColor='White' Width='450' Height='325'>" .
"<Graph Name='graph' Top='55' Left='30' Width='390' Height='235' Type='Bar' SubType='Basic'>" .
"</Graph>" .
"<Textbox Name='title' Top='30' Left='225' Width='1' Height='1' Anchor='MiddleCenter'>" .
"<Properties Font='Name:Arial Unicode MS; Size:14;'/>" .
"<Text>Vertical Bar</Text>" .
"</Textbox>" .
"</Chart>");
*/

$ce->addPCXML("<?xml version='1.0' encoding='ISO-8859-1'?>" .
"<Chart Version='4.0'>" .
"<Graph Name='graph'>" .
"<Properties Effect='2d'/>" .
"</Graph>" .
"</Chart>");

// return descriptive link
//$ce->returnDescriptiveLink = true;
$ce->language = "EN";

// display an HTML table
//$ce->addHTMLTable();

$ce->svgTemplate = "svg_templates/Grow.svg";
//pce.svgTemplate = "svg_templates/RotateIn.svg";

//$ce->loadCommandFile("http://10.0.1.94/gif.html?testParam=testVal");

$ce->saveImageToCordaServer("images/junk.swf", "password");

// request embeddingHTML
$eHTML =  $ce->getEmbeddingHTML();

?>
</head>
<body>
<table border="1">
<tr>
<td>
<? echo $eHTML; ?>
</td>
<td>
Second Column
</td>
</tr>
<tr>
<td>
Second Row, Column 1
</td>
<td>
Second Row, Column 2
</td>

</body>
</html>
