<?php

/*
 * Copyright 2004 Corda Technologies, Inc., All Rights Reserved
 *
 * File: CordaEmbedder.php
 * Description: Corda Embedder PHP Version
 *
 * CVS: $Id: CordaEmbedder.php,v 1.21.2.16 2005/03/23 17:15:30 npilling Exp $
 *
 */

function indexOf($haystack, $needle)
{
	$pos = strpos($haystack, $needle);
	$strFound = true;
	if($pos === false) // note: three equal signs
	{
	    // not found...
	    $strFound = false;
	}

	if($strFound == false)
	{
		return -1;
	}
	return $pos;
}

// highwire private functions

function encodeAtUnderScore($str)
{
	//$str =~ s/\@_/\<atunderscore\/\>/g;
	return ereg_replace("@_", "<atunderscore/>", $str);
}

// internal constants
define("DEFAULT_LANGUAGE", "EN");

// output type constants
define("SVG", "SVG");
define("FLASH", "FLASH");
define("AUTO", "AUTO");
define("GIF", "GIF");
define("PNG", "PNG");
define("PDF", "PDF");
define("EPS", "EPS");
define("WBMP", "WBMP");
define("URL", "URL");
define("TIFF", "TIFF");
define("JPEG", "JPEG");

// fallback constants
define("STRICT", "STRICT");
define("LOOSE", "LOOSE");
define("NONE", "NONE");

// highwire internal constants
define("NO_SPDF", 0);
define("LOAD_HTML", 1);
define("SET_HTML", 2);

// highwire constants
define("AllowView", 0);
define("AllowDegradedPrinting", 4);
define("AllowModifyContents", 8);
define("AllowCopy", 16);
define("AllowModifyAnnotations", 32);
define("AllowFillIn", 256);
define("AllowScreenReaders", 512);
define("AllowAssembly", 1024);
define("AllowPrinting", 2052); // 2048 + degraded printing
define("AllowAll", AllowPrinting|AllowModifyContents|AllowCopy|AllowModifyAnnotations|AllowFillIn|AllowScreenReaders|AllowAssembly);
define("AllowDefaults", AllowPrinting|AllowCopy|AllowScreenReaders|AllowDegradedPrinting);

class CordaEmbedder
{
	// public vars
	var $appearanceFile		= null;		// string
	var $appendServerInfoSlash	= true;		// boolean
	var $autoSwitchToPNG		= true;		// boolean
	var $bgColor			= null;		// string
	var $clusterMonitorAddress	= null;		// string
	var $debugOn			= false;	// boolean
	private $externalServerAddress	= null;		// string
	var $extraCTSCommands		= null;		// string
	var $extraHTMLAttributes	= "";		// string
	var $fallback			= null;		// string
	var $height			= 0;		// int
	var $htmlHeight			= "0";		// string
	var $htmlWidth			= "0";		// string
	private $internalCommPortAddress	= null;		// string
	var $isPostRequest		= false;	// boolean
	var $language			= null;		// string
	var $makeFullRequest		= false;	// boolean
	var $maxRequestLength		= 0;		// int
	var $outputType			= null;		// string
	var $password			= null;		// string
	var $pcScript			= null;		// string
	var $pdfEmbedFonts		= false;	// boolean
	var $pdfEmbedFontsSet		= false;	// boolean
	var $returnDescriptiveLink	= false;	// boolean
	var $svgTemplate		= null;		// string
	var $useCache			= true;		// boolean
	var $useLogData			= false;	// boolean
	var $userAgent			= null;		// string
	var $width			= 0;		// int

	// deprecated public
	var $extraPCSCommands		= null;		// string
	var $imageType			= null;		// string

	// private vars
	var $tableObject	= null;		// string
	var $objectParamTag	= null;		// string
	var $cmdVector		= array();	// array
	var $embedderVersion	= "6.0.650";	// string
	var $loadFromServerCmd	= false;	// boolean
	var $loadFromServerFilename = null;	// string
	var $genericData	= null;		// string
	var $embedderType	= "PHP";	// string
	var $commportHost	= null;		// string
	var $commportPort	= 80;		// int
	var $lastUsedCommPort	= null;		// string
	var $requestPath	= "";		// string
	var $error		= false;	// boolean
	var $errorString	= null;		// string
	var $addSICommand	= false;	// boolean
	var $siFilename		= null;		// string
	var $cookieHeader	= null;		// string
	
	// highwire private variables
	var $highwireState	= NO_SPDF;	// int
	var $highwire		= "";		// string
	var $basePath		= "";		// string
	var $docEncoding	= "";		// string
	var $docOrientation	= "";		// string
	var $docOutputName	= "";		// string
	var $docPageMargins	= "";		// string
	var $docPageSize	= "";		// string
	var $docRoot		= "";		// string
	var $userPasswd		= "";		// string
	var $ownerPasswd	= "";		// string
	var $pdfLock		= AllowAll;	// int
	var $pdfLocked		= false;	// boolean
	var $pdfHighEnc		= false;	// boolean
	var $linkBehavior	= "";		// string
	var $loadVector		= array();	// array

	// encoding vars
	var $encodeURLAB	= array();	// 1-dimensional array
	var $encodeURLBAA	= array();	// 2-dimensional array
	var $encodeURLdone	= false;	// boolean

	//_________________________________________________________________________
	//
	// CordaEmbedder constructor
	//_________________________________________________________________________
	function __construct() {
		// if we haven't filled in these encoding arrays yet, do it now.
		if (!$this->encodeURLdone) {
			$this->buildURLEncodingArray();
		}
		$this->internalCommPortAddress = '127.0.0.1:8081';
		$this->externalServerAddress = '69.20.125.203:8080';
	}

	function __set($name, $value) {
		if ($name != 'internalCommPortAddress' && $name != 'externalServerAddress') {
			$this->$name = $value;
		}
	}

	function __get($name) {
		$this->$name;
	}

        //_________________________________________________________________________
	//
	// buildURLEncodingArray
	//_________________________________________________________________________
	function buildURLEncodingArray()
	{
		$this->encodeURLdone = true;

		// 1-dimensional array
		$this->encodeURLAB = array();

		// 2-dimensional array
		$this->encodeURLBAA = array();

		$badCharacters = " +#%<>?[]^`{|}~";

		$len = strlen($badCharacters);
		for ($i = 0; $i < $len; $i++)
		{
			$c = ord($badCharacters[$i]);
			$hexChars = dechex("$c");

			$this->encodeURLAB[$c] = true;
			$this->encodeURLBAA[$c][0] = ord('%'); // (byte)'%';
			$this->encodeURLBAA[$c][1] = ord($hexChars[0]); //(byte)hexChars.charAt(0);
			$this->encodeURLBAA[$c][2] = ord($hexChars[1]); //(byte)hexChars.charAt(1);
		}

		// encode linefeeds && newlines as spaces
		$badCharacters = "\r\n";
		$hexChars = dechex(ord(' ')); //Integer.toHexString(' ');
		$len = strlen($badCharacters);
		for ($i = 0; $i < $len; $i++)
		{
			$c = ord($badCharacters[$i]);
			$this->encodeURLAB[$c] = true;
			$this->encodeURLBAA[$c][0] = ord('%'); // (byte)'%';
			$this->encodeURLBAA[$c][1] = ord($hexChars[0]); //(byte)hexChars.charAt(0);
			$this->encodeURLBAA[$c][2] = ord($hexChars[1]); //(byte)hexChars.charAt(1);
		}
	}
	
	// regular public functions

	//_________________________________________________________________________
	//
	// addHTMLTable(String obj, String title)
	//
	// no parameters: use "graph" element and title if there is one
	// parameters: obj, title (for an appearance file graph object and title)
	// title parameter is optional
	//
	// this function can be called multiple times and the parameters will
	// be appended to the previous ones.
	//
	// calling it with no parameters clears the list
	//_________________________________________________________________________

	function addHTMLTable($obj=null, $title=null)
	{
		$delim = "PCDELIM";
		$bTag = "<".$delim.">";
		$eTag = "</".$delim.">";

		if(empty($obj))
		{
			$this->tableObject = "";
		}
		else
		{
			// replace empty or null tableObject string
			if(!$this->tableObject)
			{
				$this->tableObject = $bTag . $obj . $eTag;
			}
			else // append to tableObject string
			{
				$this->tableObject .= $bTag . $obj . $eTag;
			}

			// add title to tableObject string
			if(!empty($title))
			{
				$this->tableObject .= $bTag . $title . $eTag;
			}
			else
			{
				$this->tableObject .= $bTag . $eTag;
			}
		}
	}

	//_________________________________________________________________________
	//
	// addObjectParamTag -- Add name="value" to <object><param /></object> tag
	//
	// Can be called multiple times.
	//_________________________________________________________________________

	function addObjectParamTag($name, $value)
	{
		$delim = "PCDELIM";
		$bTag = "<".$delim.">";
		$eTag = "</".$delim.">";

		if($this->objectParamTag != null && strlen($this->objectParamTag) > 0)
		{
			$this->objectParamTag .= $bTag . $name . $eTag . $bTag . $value . $eTag;
		}
		else
		{
			$this->objectParamTag = $bTag . $name . $eTag . $bTag . $value . $eTag;
		}
	}

	//_________________________________________________________________________
	//
	// addPCXML -- add or set xml data tailored to Corda Server
	//
	// add pcXml string with @_PCXML to cmdVector
	//_________________________________________________________________________

	function addPCXML($pcxml)
	{
		if(!empty($pcxml))
		{
			$this->cmdVector[] = "@_PCXML" . $pcxml;
		}
	}

	//_________________________________________________________________________
	//
	// getCordaEmbedderVersion()
	//_________________________________________________________________________

	function getCordaEmbedderVersion()
	{
		return "CordaEmbedder Version " . $this->embedderVersion;
	}

	//_________________________________________________________________________
	//
	// 4.x deprecated function
	// getPCEmbedderVersion()
	//
	// getPCEmbedderVersion was renamed to getCordaEmbedderVersion
	//_________________________________________________________________________

	function getPCEmbedderVersion()
	{
		return $this->getCordaEmbedderVersion();
	}

	//_________________________________________________________________________
	//
	// getEmbeddingHTML()
	// returns string
	//_________________________________________________________________________

	function getEmbeddingHTML()
	{
		$requestBP = "@_RTNHTML@_EMBVER" . $this->embedderVersion . "@_EMBTYPE" . $this->embedderType;
		$request = $this->getCommPortRequest("");
		$response = "";

		$workingServerAddress = $this->externalServerAddress;

		if($this->internalCommPortAddress != null)
		{
			$this->setCommportAddress($this->internalCommPortAddress);
		}

		$done = false;
		while(!$done)
		{
			if($this->clusterMonitorAddress != null)
				$workingServerAddress = $this->setServerInfoFromClusterMonitor();
			else
				$done = true;

			if($this->error)
				return $this->errorString;
			if($workingServerAddress == null)
				return  "<b>ERROR: No server address specified</b>";
			if($this->commportHost == null)
				return  "<b>ERROR: No commport address specified</b>";

			if($this->debugOn)
			{
				if(!empty($this->clusterMonitorAddress))
				{
					echo "<b>clusterMonitorAddress: $this->clusterMonitorAddress</b>\n";
				}
				echo "<b>externalServerAddress: $workingServerAddress</b>\n";
			}

			$cmdStr = "";
			if(empty($this->externalServerAddress))
			{
				$cmdStr = "@_SVRADDRESS" . $workingServerAddress;
			}

			$response = $this->sendCommportCommand($requestBP . $cmdStr . $request);
			if(empty($response))
			{
				if((empty($this->clusterMonitorAddress)) ||
					((indexOf($this->commportHost, "127.0.0.1") == 0) && ($this->commportPort == 2002)))
				{
					$response = "<b>ERROR: Can't connect to the commport of Corda Server - Connection Failed</b>";
					$done = true;
				}
			}
			else
			{
				$done = true;
			}
		}

		return $response;
	}

	//_________________________________________________________________________
	//
	// String getBytes() (returns image byte array as a string)
	//_________________________________________________________________________

	function getBytes()
	{
		$imageBytes = "";

		$request = "@_MPR" . trim($this->getMainPortRequest());

		// if imageType and not outputType set, override outputType with imageType
		if(empty($this->outputType) && !empty($this->imageType))
		{
			$this->outputType = $this->imageType;
		}

		if(!empty($this->outputType))
		{
			$request .= "@_" . strtoupper($this->outputType);
		}

		if($this->debugOn)
		{
			echo "Get Bytes request string: $request\n";
		}

		if(!empty($this->internalCommPortAddress))
		{
			$this->setCommPortAddress($this->internalCommPortAddress);
		}

		$done = false;
		while(!$done)
		{
			if(!empty($this->clusterMonitorAddress))
			{
				$this->setServerInfoFromClusterMonitor();
			}
			else
			{
				$done = true;
			}

			if($this->error || empty($this->commportHost))
			{
				if($this->debugOn)
				{
					echo "CordaEmbedder getBytes(): commport address not set or other error\n";
				}
				return "";
			}

			$imageBytes = $this->sendCommportCommand($request);
			if(!empty($imageBytes))
			{
				$done = true;
			}
			else
			{
				if(empty($this->clusterMonitorAddress) ||
					((indexOf($this->commportHost, "127.0.0.1") == 0) && ($this->commportPort == 2002)))
				{
					$done = true;
				}
			}
		}

		return $imageBytes;
	}

	//_________________________________________________________________________
	//
	// 5.x deprecated function
	// getImageData()
	//
	// getImageData was renamed to getBytes
	//_________________________________________________________________________

	function getImageData()
	{
		return $this->getBytes();
	}

	//_________________________________________________________________________
	//
	// String getBytesNTO() (getBytes with no socket timeout)
	//_________________________________________________________________________

	function getBytesNTO()
	{
		$imageBytes = "";
		$sleepSeconds = 1;

		$cpRemoveCmd = "@_RMTMPFILE";
		$cpPasswdCmd = "@_PW";
		if(!empty($this->password))
		{
			$cpPasswdCmd .= $this->password;
		}
		else
		{
			$cpPasswdCmd = "";
		}

		$name = "images/random-name";

		$cpSaveTmpCmd = trim($this->getMainPortRequest());

		// if imageType and not outputType set, override outputType with imageType
		if(empty($this->outputType) && !empty($this->imageType))
		{
			$this->outputType = $this->imageType;
		}
		
		// add output type command
		if(!empty($this->outputType))
		{
			$cpSaveTmpCmd .= "@_" . strtoupper($this->outputType);
		}

		$cpSaveTmpCmd .= "@_SAVETMP" . $cpPasswdCmd;

		if(!empty($this->internalCommPortAddress))
		{
			$this->setCommPortAddress($this->internalCommPortAddress);
		}

		$name = $this->sendCommportCommand($cpSaveTmpCmd);
		if($this->debugOn)
		{
			echo "CordaEmbedder getBytesNTO(): tmp filename: $name\n";
		}

		if(!empty($name) && (strtoupper($name) != "FAIL"))
		{
			sleep($sleepSeconds);
			$getStatusCmd = "@_GETSAVESTATUS" . $name;
			$status = $this->sendCommportCommand($getStatusCmd);
			if($this->debugOn)
			{
				echo "CordaEmbedder getBytesNTO(): saveStatus: $status\n";
			}
			while(!empty($status) && ($status != "FAIL") && ($status != "OK") && (!strpos($status, "Exception")))
			{
				sleep($sleepSeconds);
				$status = $this->sendCommportCommand($getStatusCmd);
				if($this->debugOn)
				{
					echo "CordaEmbedder getBytesNTO(): saveStatus: $status\n";
				}
			}

			if(!empty($status) && ($status == "OK"))
			{
				$this->loadFromCordaServer($name);
				$imageBytes = $this->getBytes();
				$this->sendCommportCommand($cpRemoveCmd . $name . $cpPasswdCmd);
			}
			else
			{
				if($this->debugOn)
				{
					echo "CordaEmbedder getBytesNTO(): error generating image\n";
				}
			}
		}
		else
		{
			if($this->debugOn)
			{
				echo "CordaEmbedder getBytesNTO(): password, or save permissions problem\n";
			}
		}

		return $imageBytes;
	}

	//_________________________________________________________________________
	//
	// loadCommandFile(String ldRQ, String encoding=null)
	//
	// takes a url or filename
	// add ldRQ string with @_LOADREQUEST to cmdVector
	//_________________________________________________________________________
	
	function loadCommandFile($ldRQ, $encoding=null)
	{
		if(!empty($ldRQ))
		{
			if(!empty($encoding))
			{
				$this->cmdVector[] = "@_ENCLOADREQUEST" . $encoding . "," . $ldRQ;
			}
			else
			{
				$this->cmdVector[] = "@_LOADREQUEST" . $ldRQ;
			}
		}
	}

	//_________________________________________________________________________
	//
	// loadData(objectName, path/url, append, id, encoding)
	//
	// 1) objectName must be an existing graph object name in the current apFile
	// 2) path/url is a filename or url with the data we want to load
	// 3) append is a boolean value which signifies whether you want to override
	// existing data or add to it
	// 4) id is the number of the table in the file or a named id of some type
	// 5) encoding is the character encoding string for the file/url
	//_________________________________________________________________________

	function loadData($objName, $path, $append_replace="replace", $id=null, $encoding=null)
	{
		// pcscript loadfile command will be modified
		// on server-side to accept filenames or urls
		$ldPCS = $objName . ".loadfile(" . $path . "," . $append_replace;

		if(!empty($id))
		{
			$ldPCS .= "," . $id;
		}

		if(!empty($encoding))
		{
			if(empty($id))
			{
				$ldPCS .= ",";
			}
			$ldPCS .= "," . $encoding;
		}

		$ldPCS .= ")";

		$this->cmdVector[] = "@_PCSCRIPT" . $ldPCS;
	}

	//_________________________________________________________________________
	//
	// loadFromCordaServer(String fileName)
	//_________________________________________________________________________

	function loadFromCordaServer($fileName)
	{
		$this->loadFromServerCmd = true;
		$this->loadFromServerFilename = $fileName;
	}

	//_________________________________________________________________________
	//
	// 5.x deprecated function
	// loadServerSideImage(String fileName)
	//
	// loadServerSideImage was renamed to loadFromCordaServer
	//_________________________________________________________________________

	function loadServerSideImage($fileName)
	{
		$this->loadFromCordaServer($fileName);
	}

	//_________________________________________________________________________
	//
	// loadMapData(objectName, layerName, path/url, id, encoding)
	//
	// 1) objectName must be an existing graph object name in the current apFile
	// 2) layerName is the layer to apply the data to
	// 3) path/url is a filename or url with the data we want to load
	// 4) id is the number of the table in the file or a named id of some type
	// 5) encoding is the character encoding string for the file/url
	//_________________________________________________________________________

	function loadMapData($objName, $layerName, $path, $id=null, $encoding=null)
	{
		// pcscript loadfile command will be modified
		// on server-side to accept filenames or urls
		$ldPCS = $objName . ".loadmapfile(" . $layerName . "," . $path;

		if(!empty($id))
		{
			$ldPCS .= "," . $id;
		}

		if(!empty($encoding))
		{
			if(empty($id))
			{
				$ldPCS .= ",";
			}
			$ldPCS .= "," . $encoding;
		}

		$ldPCS .= ")";

		$this->cmdVector[] = "@_PCSCRIPT" . $ldPCS;
	}

	//_________________________________________________________________________
	//
	// loadPCXML -- load a file or http url
	//
	// add path-filename or url with @_LOADPCXML to cmdVector
	//_________________________________________________________________________

	function loadPCXML($pcxmlFile)
	{
		if(!empty($pcxmlFile))
		{
			$this->cmdVector[] = "@_LOADPCXML" . $pcxmlFile;
		}
	}

	//_________________________________________________________________________
	//
	// promptToSave -- add SI command to image request
	//
	//_________________________________________________________________________

	function promptToSave($filename=null)
	{
		$this->addSICommand = true;
		if(!empty($filename))
		{
			$this->siFilename = $filename;
		}
	}

	//_________________________________________________________________________
	//
	// reset -- prepare embedder object for reuse
	//_________________________________________________________________________

	function reset()
	{
		$this->addSICommand = false;
		$this->genericData = null;
		$this->loadFromServerCmd = false;
		$this->pcScript = null;
		$this->pdfEmbedFontsSet = false;
		$this->highwireState = NO_SPDF;
		$this->tableObject = null;
		$this->useLogData = false;

		$this->loadVector = array();
		$this->cmdVector = array();
	}

	//_________________________________________________________________________
	//
	// resetPCXML -- clear cmdVector
	//_________________________________________________________________________

	function resetPCXML()
	{
		$this->cmdVector = array();
	}

	//_________________________________________________________________________
	//
	// saveToAppServer(String path, String fileName)
	//_________________________________________________________________________

	function saveToAppServer($path, $fileName)
	{
		if(!empty($path) && !empty($fileName))
		{
			$ba = $this->getBytes();

			$fp = fopen("$path/$fileName", "wb");
			if($fp)
			{
				if(!fwrite($fp, $ba, strlen($ba)))
				{
					if($this->debugOn)
					{
						echo "<b>saveToAppServer: could not write $path/$fileName</b>\n";
					}
					return false;
				}
				fclose($fp);
			}
		}
		else
		{
			if($this->debugOn)
			{
				echo "<b>saveToAppServer requires path and filename arguments.</b>\n";
			}
			return false;
		}

		return true;
	}

	//_________________________________________________________________________
	//
	// 5.x deprecated function
	// saveImageToAppServer(String path, String fileName)
	//
	// saveImageToAppServer was renamed to saveToAppServer
	//_________________________________________________________________________

	function saveImageToAppServer($path, $fileName)
	{
		return $this->saveToAppServer($path, $fileName);
	}

	//_________________________________________________________________________
	//
	// saveToCordaServer(String fileName)
	//_________________________________________________________________________

	function saveToCordaServer($fileName)
	{
		$request = "";
		$response = "";

		if(!empty($fileName))
		{
			$request = $this->getMainPortRequest();

			// if imageType and not outputType set, override outputType with imageType
			if(empty($this->outputType) && !empty($this->imageType))
			{
				$this->outputType = $this->imageType;
			}

			if(!empty($this->outputType))
			{
				$request .= "@_" . strtoupper($this->outputType);
			}

			$request .= "@_SAVE" . $fileName;

			if(!empty($this->password))
			{
				$request .= "@_PW" . $this->password;
			}

			if($this->debugOn)
			{
				echo "Save to Corda Server request string: $request\n";
			}
		}
		else
		{
			if($this->debugOn)
			{
				echo "usage: saveToCordaServer(\"path/filename.ext\");\n";
			}
		}

		if(!empty($request))
		{
			if(!empty($this->internalCommPortAddress))
			{
				$this->setCommPortAddress($this->internalCommPortAddress);
			}

			$done = false;
			while(!$done)
			{
				if(!empty($this->clusterMonitorAddress))
				{
					$this->setServerInfoFromClusterMonitor();
				}
				else
				{
					$done = true;
				}

				if($this->error || empty($this->commportHost))
				{
					if($this->debugOn)
					{
						echo "CordaEmbedder saveToCordaServer(): commport address not set or other error\n";
					}
					return false;
				}

				$response = $this->sendCommportCommand($request);
				if(!empty($response))
				{
					$done = true;
				}
				else
				{
					if(empty($this->clusterMonitorAddress) ||
						((indexOf($this->commportHost, "127.0.0.1") == 0) && ($this->commportPort == 2002)))
					{
						if($this->debugOn)
						{
							echo "<b>ERROR: Can't connect to the commport of Corda Server - Connection Failed</b>\n";
						}
						$done = true;
					}
				}
			}
		}

		return (!empty($response) && (strtoupper($response) == "OK"));
	}

	//_________________________________________________________________________
	//
	// 5.x deprecated function
	// saveImageToCordaServer(String fileName)
	//
	// saveImageToCordaServer was renamed to saveToCordaServer
	//_________________________________________________________________________

	function saveImageToCordaServer($fileName)
	{
		return $this->saveToCordaServer($fileName);
	}

	//_________________________________________________________________________
	//
	// 4.x deprecated function
	// saveImageToPopChartServer(String fileName)
	//
	// saveImageToPopChartServer was renamed to saveToCordaServer
	//_________________________________________________________________________

	function saveImageToPopChartServer($fileName)
	{
		return $this->saveToCordaServer($fileName);
	}

	//_________________________________________________________________________
	//
	// setData(objName, dataString)
	//
	// send one or many generic xml data sets to Corda Server
	// targeted at specific objects
	//_________________________________________________________________________

	function setData($objName, $dataString)
	{
		$delim = "PCDELIM";
		$bTag = "<".$delim.">";
		$eTag = "</".$delim.">";

		// replace all occurances of \n with <PCNL> in dataString
		$dataString = preg_replace("/\n/", "<PCNL>", $dataString);

		$tmpData = $bTag . "setdata" . $eTag . $bTag . $objName . $eTag . $bTag . $dataString . $eTag;

		if($this->genericData != null && strlen(trim($this->genericData)) > 0)
		{
			$this->genericData .= $tmpData;
		}
		else //genericData empty or null
		{
			$this->genericData = $tmpData;
		}
	}

	//_________________________________________________________________________
	//
	// setMapData(objName, dataString)
	//
	// send one or many generic xml data sets to Corda Server
	// targeted at specific objects
	//_________________________________________________________________________

	function setMapData($objName, $layerName, $dataString)
	{
		$delim = "PCDELIM";
		$bTag = "<".$delim.">";
		$eTag = "</".$delim.">";

		// replace all occurances of \n with <PCNL> in dataString
		$dataString = preg_replace("/\n/", "<PCNL>", $dataString);

		$tmpData = $bTag . "setmapdata" . $eTag . $bTag . $objName . $eTag . $bTag . $layerName . $eTag . $bTag . $dataString . $eTag;

		if($this->genericData != null && strlen(trim($this->genericData)) > 0)
		{
			$this->genericData .= $tmpData;
		}
		else //genericData empty or null
		{
			$this->genericData = $tmpData;
		}
	}

	//_________________________________________________________________________
	//
	// setPdfEmbedFonts(boolean val)
	//
	// Instruct Corda Server to override its default Embed Fonts in PDF
	// documents setting for this request.
	//_________________________________________________________________________

	function setPdfEmbedFonts($val)
	{
		$this->pdfEmbedFontsSet = true;
		$this->pdfEmbedFonts = $val;
	}

	// highwire public functions

	function appendDoc($furl, $pdf=false)
	{
		// always set highwire state
		$this->highwireState = LOAD_HTML;
		if($pdf)
		{
			$this->loadVector[] = "@_DOC_LOAD_PDF" . $furl;
		}
		else
		{
			$this->loadVector[] = "@_DOC_LOAD" . $furl;
		}
	}

	function loadDoc($furl)
	{
		// always set highwireState
		$this->highwireState = LOAD_HTML;
		$this->highwire = $furl;
	}

	function lockPDF($userPW="", $ownerPW="", $opts="", $highEnc=false)
	{
		$this->pdfLocked = true;

		if(empty($userPW) && empty($ownerPW) && empty($opts) && empty($highEnc))
		{
			$this->pdfLock = AllowDefaults;
		}
		else
		{
			if(!empty($userPW))
			{
				$this->userPasswd = $userPW;
			}

			if(!empty($ownerPW))
			{
				$this->ownerPasswd = $ownerPW;
			}

			if(!empty($opts))
			{
				$this->pdfLock = $opts;
			}

			if($highEnc)
			{
				$this->pdfHighEnc = $highEnc;
			}
		}
	}

	function setCookieHeader($str)
	{
		$this->cookieHeader = $str;
	}

	function setDoc($html, $bp, $encoding="")
	{
		// always set highwireState
		$this->highwireState = SET_HTML;
		if(!empty($html))
		{
			$this->highwire = encodeAtUnderScore($html);
			$this->basePath = $bp;
		}

		if(!empty($encoding))
		{
			$this->docEncoding = $encoding;
		}
	}

	function setDocRoot($str)
	{
		$this->docRoot = $str;
	}

	function setLinkBehavior($str)
	{
		$this->linkBehavior = $str;
	}

	function setOrientation($str)
	{
		$this->docOrientation = $str;
	}

	function setOutputName($str)
	{
		$this->docOutputName = $str;
	}

	function setPageMargins($str)
	{
		$this->docPageMargins = $str;
	}

	function setPageSize($str)
	{
		$this->docPageSize = $str;
	}

	// functions used internally (private)

	//_________________________________________________________________________
	//
	// encodeString(String str)
	// should be able to take multibyte characters
	//_________________________________________________________________________

	function encodeString($str)
	{
		$encodedStr = "";
		$encodeIndex = 0;

		$encodeBuffer = array();

		if(strlen($str) > 0)
		{
			$len = strlen($str);
			$c = 0;
			$wrote = false;

			for($i=0; $i < $len; $i++)
			{
				$c = ord($str[$i]);
				$wrote = false;
				if($c <= 0x07F)
				{
					if(isset($this->encodeURLAB[$c]))
					{
						// Check to see if this char is a % and if the next one is a u.
						// if so, skip encoding the %.  We always use the %uXXXX method for now!

						if( ($str[$i] == '%') && ($str[$i+1] == 'u') )
						{
							$encodeBuffer[$encodeIndex++] = $str[$i];
							$wrote = true;
						}
						else //its just one of the normal "encode me" characters
						{
							//encode the char
							$encodeBuffer[$encodeIndex++] = chr($this->encodeURLBAA[$c][0]);
							$encodeBuffer[$encodeIndex++] = chr($this->encodeURLBAA[$c][1]);
							$encodeBuffer[$encodeIndex++] = chr($this->encodeURLBAA[$c][2]);
							$wrote = true;
						}
					}
				}
				else
				{
					$encodeBuffer[$encodeIndex++] = '%';
					$encodeBuffer[$encodeIndex++] = 'u';

					if($c <= 0x0FF)
						$encodeBuffer[$encodeIndex++] = '0';
					if($c <= 0x0FFF)
						$encodeBuffer[$encodeIndex++] = '0';

					$hstr = dechex($c);
					for($j = 0; $j < strlen($hstr); $j++)
					{
						$encodeBuffer[$encodeIndex++] = $hstr[$j];
					}

					$wrote = true;
				}
				if(!$wrote)
					$encodeBuffer[$encodeIndex++] = $str[$i];
			}
		}
		// append last part to string
		if($encodeIndex > 0)
		{
			$encodedStr = implode("", $encodeBuffer);
		}
		// delete the temp buffer
		if($encodeBuffer != null)
			$encodeBuffer = null;

		return $encodedStr;
	}

	//_________________________________________________________________________
	//
	// setCommportAddress
	//_________________________________________________________________________

	function setCommportAddress($cpa)
	{
		$port = 80;

		$i = indexOf($cpa, "://");
		if($i >= 0)
			$cpa = substr($cpa, $i+3);
		// peal off the port number
		$i = indexOf($cpa, ':');
		if ($i >= 0)
		{
			$this->commportHost = substr($cpa, 0, $i);
			$this->commportPort = (int)substr($cpa, $i+1);
		}
		else
		{
			$this->commportHost = $cpa;
			$this->commportPort = $port;
		}

		$i = indexOf($cpa, "/");
		if ($i >= 0)
		{
			$this->requestPath = substr($cpa, $i);
		}
		else
		{
			$this->requestPath = "/";
		}

		$this->error = false;
	}

	//_________________________________________________________________________
	//
	// setServerInfoFromClusterMonitor()
	//
	// returns a workingServerAddress (String)
	//_________________________________________________________________________

	function setServerInfoFromClusterMonitor()
	{
		$workingServerAddress = $this->externalServerAddress;

		$request = $this->clusterMonitorAddress;
		if($this->lastUsedCommPort != null)
			$request = $this->clusterMonitorAddress . "?noresponse^^" . $this->lastUsedCommPort;

		// create a URL to contact the Cluster Monitor
		$serverInfo = $this->getExternalServerAddress($request);
		$query =	"GET $request HTTP/1.0\r\n" .
				"Host: ".$serverInfo['host'].":".$serverInfo['port']."\r\n" .
				"\r\n";

		// open server connection
		$fp = fsockopen($serverInfo['host'], $serverInfo['port']);

		if(!$fp)
		{
			echo "<b>Error Contacting Corda Cluster Monitor - Connection Failed</b>";
		}
		else
		{
			fputs($fp, $query);

			// discard HTTP header
			while(trim(fgets($fp, 1024)) != "");

			// assign the rest of the file to response
			while(!feof ($fp))
			{
				$buffer = fgets($fp, 1024);
				$response .= $buffer;
			}

			// close server connection
			fclose($fp);

			$address = $response;

			$cpIndex = indexOf($address, ',');
			$this->lastUsedCommPort = substr($address, $cpIndex + 1);
			$this->setCommportAddress($this->lastUsedCommPort);
			if($this->externalServerAddress == null)
				$workingServerAddress = "http://" . substr($address, 0, $cpIndex);
//			echo "Results from clusterMonitor : " . $address . "<br />";
		}

		return $workingServerAddress;
	}

	//_________________________________________________________________________
	//
	// getExternalServerAddress
	//_________________________________________________________________________

	function getExternalServerAddress($sa)
	{
		$host = "";
		$port = 80;

		$i = indexOf($sa, "://");
		if($i >= 0)
			$sa = substr($sa, $i+3);

		// remove query string
		$i = indexOf($sa, '?');
		if($i >= 0)
		{
			$sa = substr($sa, 0, $i);
		}

		// remove path
		$i = indexOf($sa, '/');
		if($i >= 0)
		{
			$sa = substr($sa, 0, $i);
		}

		// peal off the port number
		$i = indexOf($sa, ':');
		if ($i >= 0)
		{
			$host = substr($sa, 0, $i);
			$port = substr($sa, $i+1);
		}
		else
		{
			$host = $sa;
		}
		return array('host' => $host, 'port' => (int)$port);
	}

	function getMainPortRequest()
	{
		$request = "";

		// Highwire request
		if($this->highwireState != NO_SPDF)
		{
			if(!empty($this->highwire) || count($this->loadVector) == 0)
			{
				// add html/xhtml command
				$request .= "@_DOC_";
				if($this->highwireState == SET_HTML)
				{
					$request .= "HTML";
				}
				else // default hwState == LOAD_HTML
				{
					$request .= "LOAD";
				}
				$request .= trim($this->highwire);
			}

			// support multiple @_DOC_LOAD* commands
			for($i=0; $i < count($this->loadVector); $i++)
			{
				$request .= $this->loadVector[$i];
			}

			// add doc base path
			if($this->highwireState == SET_HTML)
			{
				$request .= "@_DOC_BASEPATH" . $this->basePath;
				if($this->docEncoding)
				{
					$request .= "@_DOC_ENCODING" . $this->docEncoding;
				}
			}

			if(!empty($this->docOrientation))
			{
				$request .= "@_DOC_ORIENTATION" . $this->docOrientation;
			}

			if(!empty($this->docPageMargins))
			{
				$request .= "@_DOC_PAGEMARGINS" . $this->docPageMargins;
			}

			if(!empty($this->docPageSize))
			{
				$request .= "@_DOC_PAGESIZE" . $this->docPageSize;
			}

			if(!empty($this->docRoot))
			{
				$request .= "@_DOC_ROOT" . $this->docRoot;
			}

			if($this->pdfEmbedFontsSet)
			{
				$request .= "@_PDFEMBEDFONTS";
				if(!$this->pdfEmbedFonts)
					$request .= "no";
			}
			
			// screen readers allowed -> send dlink.xml langauge code
			if(($this->pdfLock & AllowScreenReaders) == AllowScreenReaders)
			{
				$request .= "@_LANG";
				if(!empty($this->language))
				{
					$request .= $this->language;
				}
				else
				{
					$request .= DEFAULT_LANGUAGE;
				}
			}

			// pdf lock code
			if($this->pdfLocked)
			{
				// user lock password
				if(!empty($this->userPasswd))
				{
					$request .= "@_UPW" . $this->userPasswd;
				}
				
				// owner password
				if(!empty($this->ownerPasswd))
				{
					$request .= "@_OPW" . $this->ownerPasswd;
				}

				if($this->pdfLock == AllowDefaults)
				{
					$request .= "@_LOCK";
				}
				else
				{
					$request .= "@_LOCK" . $this->pdfLock;
				}

				// use high encryption
				if($this->pdfHighEnc)
				{
					$request .= "@_ECH";
				}
			}

			// pdf link behavior
			if(!empty($this->linkBehavior))
			{
				$request .= "@_DOC_LINKBEHAVIOR" . $this->linkBehavior;
			}

			// pdf output name
			if(!empty($this->docOutputName))
			{
				$request .= "@_DOC_OUTPUTNAME" . $this->docOutputName;
			}

			// 4.x deprecated extraPCSCommands comes right before extraCTSCommands
			if(!empty($this->extraPCSCommands))
			{
				$request .= $this->extraPCSCommands;
			}

			// make sure extraCTSCommands is last
			if(!empty($this->extraCTSCommands))
			{
				$request .= $this->extraCTSCommands;
			}

			$request .= "@_END";

			return $request;
		}

		// PopChart/OptiMap request

		// add the log graph if necessary
		if($this->useLogData)
		{
			if(!empty($this->password))
			{
				$request .= "@_PW" . $this->password;
			}
			$request .= "@_LOGgraph";
			$this->useCache = false;
			if(empty($this->appearanceFile))
			{
				$request .= "@_X1";
				$this->bgColor = "E5E5E5";
				$this->width = 500;
				$this->height = 470;
			}
			if(empty($this->pcScript))
			{
				$this->pcScript = "title.settext(" . $this->externalServerAddress . ")hh.series(hits,PCIS.hitsByHourSeries)dh.series(hits,PCIS.hitsByDaySeries(90))mh.categories(PCIS.hitsByMonthCategories)mh.series(hits,PCIS.hitsByMonthSeries)";
			}
		}

		if(!$this->useCache)
		{
			$request .= "@_DONTCACHE";
		}

		if($this->width > 0)
		{
			$request .= "@_WIDTH".$this->width;
		}

		if($this->height > 0)
		{
			$request .= "@_HEIGHT".$this->height;
		}

		// add load command then return
		if($this->loadFromServerCmd)
		{
			$request .= "@_LOAD" . $this->loadFromServerFilename;

			return $request;
		}

		if(!empty($this->appearanceFile))
		{
			$request .= "@_FILE".$this->appearanceFile;
		}

		if(!empty($this->bgColor))
		{
			$request .= "@_BGCOLOR".$this->bgColor;
		}

		if(!empty($this->svgTemplate))
		{
			$request .= "@_USESVGTEMPLATE".$this->svgTemplate;
		}

		if(!empty($this->language))
		{
			$request .= "@_LANG".$this->language;
		}

		// add commands in cmdVector to request
		if($this->cmdVector != null && count($this->cmdVector) > 0)
		{
			for($i=0; $i < count($this->cmdVector); $i++)
			{
				$request .= $this->cmdVector[$i];
			}
		}

		if(!empty($this->genericData))
		{
			$request .= "@_OBJCMD" . $this->genericData;
		}

		if(!empty($this->pcScript))
		{
			$request .= "@_PCSCRIPT" . $this->pcScript;
		}

		if($this->pdfEmbedFontsSet)
		{
			$request .= "@_PDFEMBEDFONTS";
			if(!$this->pdfEmbedFonts)
				$request .= "no";
		}

		// suppress server-side auto switch from gif to png
		if(!$this->autoSwitchToPNG)
		{
			// if imageType and not outputType set, override outputType with imageType
			if(empty($this->outputType) && !empty($this->imageType))
			{
				$this->outputType = $this->imageType;
			}

			if(empty($this->outputType) || (strcasecmp($this->outputType, "AUTO") == 0) || (strcasecmp($this->outputType, "GIF") == 0))
			{
				$request .= "@_NOPNGAUTOSWITCH";
			}
		}

		// 4.x deprecated extraPCSCommands comes right before extraCTSCommands
		if(!empty($this->extraPCSCommands))
		{
			$request .= $this->extraPCSCommands;
		}

		// make sure extraCTSCommands is last
		if(!empty($this->extraCTSCommands))
		{
			$request .= $this->extraCTSCommands;
		}

		return $request;
	}

	function getCommPortRequest($type)
	{
		$request = $type;

		if(!empty($this->fallback) && (strcasecmp($this->fallback, "none") != 0))
		{
			// valid options: "strict", and "loose"
			if((strcasecmp($this->fallback, "strict") == 0) || (strcasecmp($this->fallback, "loose") == 0))
				$request .= "@_FALLBACK".$this->fallback;
		}

		if(!empty($this->extraHTMLAttributes))
		{
			$request .= "@_HTMLATTRIBUTES" . $this->extraHTMLAttributes;
		}

		if($this->htmlWidth != "0")
		{
			$request .= "@_HTMLWIDTH" . $this->htmlWidth;
		}

		if($this->htmlHeight != "0")
		{
			$request .= "@_HTMLHEIGHT" . $this->htmlHeight;
		}

		// if imageType and not outputType set, override outputType with imageType
		if(empty($this->outputType) && !empty($this->imageType))
		{
			$this->outputType = $this->imageType;
		}

		if(!empty($this->outputType))
		{
			$request .= "@_IMGTYPE".$this->outputType;
		}

		// return full url request(s) within the embedding html
		if($this->makeFullRequest)
		{
			// maxRequestLength is zero when not set
			// must be (greater than zero) and (less than/equal to request len)
			if(($this->maxRequestLength == 0) || ($this->maxRequestLength > 0 && strlen($request) <= $this->maxRequestLength))
			{
				$request .= "@_MAKEFULLREQUEST";
			}
		}

		// appendServerInfoSlash boolean value instructs Corda Server to either
		// add a slash to the server info upon return or not
		// this is a work around for WebLogic using the Corda Servlet Redirector
		if(!$this->appendServerInfoSlash)
		{
			$request .= "@_NOSINFOSLASH";
		}

		if(!empty($this->objectParamTag))
		{
			$request .= "@_OPTAG" . $this->objectParamTag;
		}

		if(!empty($this->externalServerAddress))
		{
			$request .= "@_SVRADDRESS" . $this->externalServerAddress;
		}

		if(!empty($this->tableObject))
		{
			$request .= "@_TABLEOBJECT" . $this->tableObject;
		}

		if($this->returnDescriptiveLink)
		{
			$request .= "@_TDREQUIRED";
			if(!empty($this->language))
			{
				$request .= $this->language;
			}
			else
			{
				$request .= DEFAULT_LANGUAGE;
			}
		}

		if(!empty($this->userAgent))
		{
			$request .= "@_USRAGENT" . $this->userAgent;
		}

		if($this->addSICommand)
		{
			$request .= "@_PTS" . $this->siFilename;
		}

		// append marker signifying the end of commport only commands
		$request .= "@_MARKER";

		$request .= $this->getMainPortRequest();

		return $request;
	}

	function getCommPortResponse($socket, $request)
	{
		$response = "";
		$httpRequest = "";
		$extraHeaders = "";

		if(!empty($this->cookieHeader))
		{
			$extraHeaders .= "Cookie: " . $this->cookieHeader . "\r\n";
		}

		// build http request
		if($this->isPostRequest)
		{
			$httpRequest =	"POST " . $this->requestPath . " HTTP/1.0\r\n" .
					"Host: $this->commportHost:$this->commportPort\r\n" .
					"Content-Length: " . strlen($request) . "\r\n" .
					"Content-Type: text/html\r\n" .
					$extraHeaders .
					"\r\n" .
					$request;
		}
		else
		{
			$httpRequest =	"GET $this->requestPath?$request HTTP/1.0\r\n" .
					"Host: $this->commportHost:$this->commportPort\r\n" .
					$extraHeaders .
					"\r\n";
		}

		// send query
		fputs($socket, $httpRequest);

		// discard HTTP header
		while(trim(fgets($socket, 1024)) != "");

		// assign the rest of the file to response
		while(!feof ($socket))
		{
			$buffer = fgets($socket, 1024);
			$response .= $buffer;
		}

		return $response;
	}

	function sendCommportCommand($command)
	{
		$command = $this->encodeString($command);
		$response = "";

		if(!empty($this->commportHost))
		{
			if($this->debugOn)
			{
				echo "<b>Commport Address: $this->commportHost:$this->commportPort</b>\n";
			}

			// open socket connection to commport
			$fp = fsockopen($this->commportHost, $this->commportPort);

			// connection did not fail
			if($fp)
			{
				$response = $this->getCommPortResponse($fp, $command);
				fclose($fp);
			}
		}

		return $response;
	}

} // end of class definition

?>
