<?php 
ini_set("include_path","../../");
include("common/classes_md.php");
$template = new template;
$template->debug();
$print = !empty($_REQUEST["print"]);
$sumtype = !empty($_REQUEST["sumtype"]) ? $_REQUEST["sumtype"] : '';

$template->define_file($print ? 'mdda_print_template.php' : 'mdda_template.php');
if ($sumtype =='wages') {
   $template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Wage Summary');
$template->add_region('heading', 'Wage Summary');
$variable 	= 'percent'; } 
else if ($sumtype == 'hours') {
   $template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Hours Summary');
$template->add_region('heading', 'Hours Summary'); 
   $variable 	= 'hoursumm';
} 
else if ($sumtype == 'selfEmployment') {
   $template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Self Employment Summary');
$template->add_region('heading', 'Self Employment Summary'); 
   $variable 	= 'selfEmployment';
}
else {
   $template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Hours Summary');
$template->add_region('heading', 'Hours Summary'); 
   $variable 	= 'hoursumm';
   
}
$template->add_region("sidebar", "<?php \$area = \"activity\"; \$show_flash_link = " . ($print + 0) . "; ?>");


$f			= mdda::getFilterValues();
if (empty($sumtype)) {
	$template->add_region('content', '<p class="error">Please select a summary type on the previous page.</p><p><a href="' . str_replace('_2.php', '_1.php', $_SERVER['REQUEST_URI']) . '">Back</a></p>');
	include('header.php');
	$template->make_template();
	include('footer.php');
	exit;
}
$data = array();
if ($f['provider'] && $f['provider']) {
	$provider = mdda::getProviderName($f['provider']);
} else {
	$provider = "ALL";
	$providerId = 0;
}
$legend		= mdda::getLegendName($variable, $f['region'], $provider, $f['year']);
$colors		= array("9900CC", "FF9900", "993333"); // purple, orange, brown



$data0 = mdda::formatCurrency(mdda::getActivityVariableArray('totalwages'));

$data1 = mdda::formatCurrency(mdda::getActivityVariableArray('meanwage'));

$data2 = mdda::formatUS(mdda::getActivityVariableArray('numberinactivity2'));
$data3 = mdda::getActivityVariableArray('percent2');
$data4 = mdda::formatCurrency(mdda::getActivityVariableArray('meanhourlywage'));
 $data5 = mdda::getActivityVariableArray('totalhours');
$data6 = mdda::getActivityVariableArray('paidtimeoff');
$data7 = mdda::getActivityVariableArray('setaside');
$data8 = mdda::getActivityVariableArray('avghours');
$data9 = mdda::formatUS(mdda::getActivityVariableArray('numover20'));
$data10 = mdda::getActivityVariableArray('percover20');
$data11 = mdda::getActivityVariableArray('percvol');
$data12 = mdda::formatUS(mdda::getActivityVariableArray('numberinactivity'));
$data13 = mdda::getActivityVariableArray('percent');
$data14 = mdda::getActivityVariableArray('selfEmpnum');
$data15 = mdda::getActivityVariableArray('selfEmpperc');
$data16 = mdda::formatCurrency(mdda::getActivityVariableArray('meanSelfemp'));
$data17 = mdda::formatCurrency(mdda::getActivityVariableArray('totalSelfemp'));

$data18 = mdda::formatCurrency(mdda::getActivityVariableArray('lowSelfemp'));
$data19 = mdda::formatCurrency(mdda::getActivityVariableArray('highSelfemp'));

if ($sumtype == 'wages') {
$data = array_merge_recursive($data2,$data3,$data1,$data4,$data0,/*$data5,*/$data6,$data7);


$totalpar = mdda::getActivityTotalArray('grandtotalwages'); 
$totalrow = number_format($totalpar['totalparticipants'],0,'.',',');

$totavggross =  mdda::getActivityTotalArray('averagegrosswage'); 
$totalrow2 = $totavggross['avggrosswage'];
$totavghourly = mdda::getActivityTotalArray('averagehourly');
 $totalrow3 = $totavghourly['averagehourly'];
$coltotwages= mdda::getActivityTotalArray('coltotwages');
$totalrow4 = $coltotwages['coltotwages'];
$totpto = mdda::getActivityTotalArray('percentpto');
$totalrow5 = $totpto['paidtimeoff'];
$totsa = mdda::getActivityTotalArray('percentsa');
$totalrow6 = $totsa['setaside']; }
else if ($sumtype == 'hours') {
   $data = array_merge_recursive($data12,$data13,$data8,$data9,$data10,$data5);
   
   $totalpar = mdda::getActivityTotalArray('grandtotal'); 
$totalrow =    number_format($totalpar['totalparticipants'],0,'.',',');

   $colavghrs =  mdda::getActivityTotalArray('colavghrs'); 
   $totalrow2 = $colavghrs['avghrs'];
   $numover20 = mdda::getActivityTotalArray('colnumover20');
    $totalrow3 = $numover20['numover20'];
   
   $colpercover20= mdda::getActivityTotalArray('colpercover20');
   $totalrow4 = $colpercover20['percover20'];
   
   
   $coltotalhours = mdda::getActivityTotalArray('coltotalhrs');
   $totalrow5 = $coltotalhours['totalhours'];
   $colpercvol = mdda::getActivityTotalArray('colpercvol');
   $totalrow6 = $colpercvol['percvol'];
}

else if ($sumtype == 'selfEmployment') {
$data = array_merge_recursive($data14,$data15);
$data2 = array_merge_recursive($data16,$data17,$data18,$data19);


 }
//$labels		= implode(';', array_keys($data));
//$cats		= implode(';', $data);
$pcScript	= "graph.setcategories($labels;)\ngraph.setseries((CLR_{$colors[0]})'$legend';$cats;)\n"
			. "main.AddPCXML(<Textbox Name='title' Top='0' Left='0' Width='615' Height='24'><Properties AutoWidth='False' HJustification='Center' LeftMargin='5' RightMargin='5' FillColor='#BACBDB' Font='Size:14; Style:Bold Italic; Color:#5C656A;'/>\n"
			. "<Text>$legend</Text></Textbox>)\n"
 			. "main.AddPCXML(<Textbox Name='axis1' Top='120' Left='10' Width='75' Height='70'>\n"
			. "<Properties BorderType='None' AutoWidth='True' HJustification='Center' LeftMargin='5' RightMargin='5' FillColor='#ffffff' Font='Size:10; Style:Bold ; Color:black;' />\n"
			. "<Text>" . mdda::getAxisLabel($variable) . "</Text></Textbox>)\n"
 			. "graph.AddPCXML(<CategoryScale LimitLabelLength='False' MaxLengthRotatedText='10' StaggerLabels='False' RotateLabels='-45' LowOuterLine='Color:#7f7f7f;'  HighOuterLine='Color:#7f7f7f;'  MajorTick='Visible:False;'  MinorTick='Size:Large;'  MajorGrid='Color:#7f7f7f;'  Font='Size:12; Style:Bold Italic; Color:#3366ff;' MinorFont='Size:10;' />)";
$mychart = new chart;
$mychart->externalServerAddress = "http://www.communityinclusion.org:8080";
$mychart->internalCommPortAddress = "http://www.communityinclusion.org:8081";
$mychart->appearanceFile = "apfiles/dmr_activity.pcxml";
$mychart->width = 616;
$mychart->height = 430;
$mychart->userAgent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
$mychart->returnDescriptiveLink = true;
$mychart->language = "EN";
$mychart->pcScript = $pcScript;
$mychart->imageType = !$print ? "JPEG" : 'JPG';

preg_match('/^(number|percent|total|mean)/i', $variable, $th);


if ($sumtype == 'wages') {
   $html 	=  /* $mychart->getEmbeddingHTML() . */ '<table id="tablehold" border="1" cellpadding="3" cellspacing="0">'
		. "<caption>$legend</caption><thead><tr><th>Activity</th><th>Number of Individuals<br /> in Activity</th><th>Percent of Individuals<br /> in Activity</th><th>Average Gross Wage</th><th>Average Hourly Wage</th><th>Total Wages</th><th>Percent Who Receive<br />Paid Time Off</th><th>Percent Who Work<br />On a Set-aside Contract</th></thead><tbody>";
} else if ($sumtype == 'hours') {
   
   $html 	= '<table id="tablehold" border="1" cellpadding="3" cellspacing="0">'
   		. "<caption>$legend</caption><thead><tr><th>Activity</th><th>Number of Individuals<br /> in Activity</th><th>Percent of Individuals<br /> in Activity</th><th>Average Hours in Activity</th><th>Number worked more than 20 hours/week</th><th>Percent worked more than 20 hours /week</th><th>Total hours worked this period</th><tbody>";
   
}


if ($sumtype == 'wages') { 
   $html 	= $table = /* $mychart->getEmbeddingHTML() . */ '<table id="tablehold" border="1" cellpadding="3" cellspacing="0">'
		. "<caption>$legend</caption><thead><tr><th>Activity</th><th>Number of Individuals<br /> in Activity</th><th>Percent of Individuals<br /> in Activity</th><th>Average Gross Wage</th><th>Average Hourly Wage</th><th>Total Wages</th><th>Percent Who Receive<br />Paid Time Off</th><th>Percent Who Work<br />On a Set-aside Contract</th></thead><tbody>";
} else if ($sumtype == 'hours') {
   
   $html 	=  '<table id="tablehold" border="1" cellpadding="3" cellspacing="0">'
   		. "<caption>$legend</caption><thead><tr><th>Activity</th><th>Number of Individuals<br /> in Activity</th><th>Percent of Individuals<br /> in Activity</th><th>Average Hours in Activity</th><th>Number worked more than 20 hours/week</th><th>Percent worked more than 20 hours /week</th><th>Total hours worked this period</th></thead><tbody>";
   
}

else if ($sumtype == 'selfEmployment') {
   
   $html 	=  $table = '<h3>' . $legend . '</h3><br /><table id="tablehold" border="1" cellpadding="3" cellspacing="0">'
   		. "<thead><tr><th>&nbsp;</th><th>Number of individuals</th><th>Percent of total served</th></thead><tbody>";
   
}

$where ="";

$aWhere = array();

foreach ($data as $label=>$val) {

   if (is_array($val)) { 
       $aWhere = '<tr><th scope ="row">' . $label . '</th><td>'. implode('</td><td>',$val);
   }
   else {
       $aWhere = '<tr><th scope ="row">' . $label . '</th><td>' . $val;
   }
   $where .=  $aWhere . "</td></tr>";
   
}

$html .= $where;
$table .= $where;
if($sumtype != 'selfEmployment') $html .= "<tr class=\"totalrow\"><th>Unduplicated Total</th><td>$totalrow</td>" . ($sumtype != 'hours' ? "<td colspan=\"6\">"  : "<td colspan=\"6\">") . "</td></tr>";
$html .= "</tbody></table>"; $table .= "</tbody></table>";
if($sumtype == 'selfEmployment') {
   $html 	.=  '<br /><table id="tablehold2" border="1" cellpadding="3" cellspacing="0">'
   		. '<thead>
       <tr><th rowspan="2">&nbsp;</th><th rowspan="2">Mean</th><th rowspan="2">Total</th><th colspan="2">Range</th></tr>     <tr><th>Low</th><th>High</th></thead><tbody>';
          $table 	.=  '<br /><table border="1" cellpadding="3" cellspacing="0">'
          		. '<thead>
              <tr><th rowspan="2">&nbsp;</th><th rowspan="2">Mean</th><th rowspan="2">Total</th><th colspan="2">Range</th></tr>     <tr><th>Low</th><th>High</th></thead><tbody>';
          $where ="";

          $aWhere = array();
        
          foreach ($data2 as $label=>$val) {

             if (is_array($val)) { 
                
                
                
                 $aWhere = '<tr><th scope ="row">' . $label . '</th><td>'. implode('</td><td>',$val);
                 
                 
             }
             else {
                 $aWhere = '<tr><th scope ="row">' . $label . '</th><td>' . $val;
             }
             $where .=  $aWhere . "</td></tr>";
          }
          $html .= $where;
$html .= "</tbody></table>";
         


       }
     $html .= "<a class=\"getfile\" style='display:block; height: 12px;' >Download spreadsheet of this data.</a>";


$template->add_region('content', $html); ?>

<?php include("header.php");

$template->make_template(); 

include("footer.php");
