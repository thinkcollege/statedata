<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<?php 
	//ini_set("include_path","../");
	//echo $sidebar;
	
	if (!isset($file_path)) {
		$file_path="../";
	} ?>
	<title><?php echo $title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="description" content="A free and accessible charting/graphing service that allows you to find data on disability and employment." />
	<meta name="keywords" content="Disability, employment, services, mental retardation, intellectual disability, developmental disability, outcomes, data, vocational rehabilitation, state agency" />
	<LINK REL='stylesheet' TYPE='text/css' HREF='<?php echo $file_path ?>common/styles.css'>
	<LINK REL='stylesheet' TYPE='text/css' HREF='<?php echo $file_path ?>common/side_menu.css'>
	<script type="text/javascript" src="<?php echo $file_path ?>common/jquery.js"></script>
	<script type="text/javascript" src="<?php echo $file_path ?>common/rollovers.js"></script>
	<script type="text/javascript" src="<?php echo $file_path ?>common/common.js"></script>
	<script type="text/javascript" src="<?php echo $file_path ?>common/functions.js"></script>
	<style type="text/css">
		input.submit { 
		/* text-indent:-999px; */
		background:#FFF url(../images/buttons/submit.jpg) no-repeat ; 
		border:0; 
		height:4em; 
		width:7em; 
	}
	</style>
	<!--[if ie]><style type="text/css">input.submit { background:#FFF url(../images/buttons/submit.jpg) no-repeat ; border:0; height:4em; width:60em; }</style><![endif]-->
</head>
<body bgcolor="#FFFFFF" text="#000000">
	<div id="skip"><a href="#side_menu">Skip to navigation and funders</a></div>
	<div id="main">
		<h1><?php echo $heading; ?></h1>