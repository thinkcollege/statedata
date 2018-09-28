<?php 
ini_set("include_path","../");
include("common/classes.php");

$print = !empty($_REQUEST["print"]);
$mre_base=new mre_base;

//$template->define_file($print ? 'print_template.php' : 'template.php');
$title =  $mre_base->mre_base_sitename . " - Over all summary report";
$area="overall" ;

if ($print) {
	$show_flash_link = 0;
} else {	 
	$show_flash_link = 1;
}

$functions	= new functions;
$overallsummary = new overallsummary;

$year	= !empty($_REQUEST['year']) ? preg_replace('/[^a-z0-9_-]/i', '', $_REQUEST['year']) : '';

$heading = "Overall program summary report for FY " . $year;


$full_url = $functions->getFullUrl(1);

$dd = $overallsummary->generate_dd($year);
$dl = $overallsummary->generate_dl($year);
$rrr = $overallsummary->generate_rrr($year);
$fl = $overallsummary->generate_fl($year);
$tp = $overallsummary->generate_tp($year);
$lf = $overallsummary->generate_lf($year);
include("header.php");
?>
	<table border=0 bordercolor=green>
		<tr>

			<td valign='top'><img src='../images/plus.gif' border = '0' id='exp_1' class='expandImage' />&nbsp;</td>

			<td class='activityContainer' id='cont_1'><span class="tableCaption">Table 1. Summary of Device Demonstration</span>
				<div style='display:none'>
					<?php echo $overallsummary->html_format($dd); ?>
				</div>
			</td>
		</tr>
		<tr>
			<td valign='top'><img src='../images/plus.gif' border = '0' id='exp_2' class='expandImage' />&nbsp;</td>

			<td class='activityContainer' id='cont_2'><span class="tableCaption">Table 2. Summary of Device Loan</span>
				<div style='display:none'>
					<?php echo $overallsummary->html_format($dl); ?>
				</div>
			</td>
		</tr>
		<tr>
			<td valign='top'><img src='../images/plus.gif' border = '0' id='exp_3' class='expandImage' />&nbsp;</td>

			<td class='activityContainer' id='cont_3'><span class="tableCaption">Table 3. Summary of Device Reutilization Programs</span>
				<div style='display:none'>
					<?php echo $overallsummary->html_format($rrr); ?>
				</div>
			</td>
		</tr>
		<tr>
			<td valign='top'><img src='../images/plus.gif' border = '0' id='exp_4' class='expandImage' />&nbsp;</td>

			<td class='activityContainer' id='cont_4'><span class="tableCaption">Table 4. Summary of State Financing Programs</span>
				<div style='display:none'>
					<?php echo $overallsummary->html_format($fl); ?>
				</div>
			</td>
		</tr>
		<tr>
			<td valign='top'><img src='../images/plus.gif' border = '0' id='exp_5' class='expandImage' />&nbsp;</td>

			<td class='activityContainer' id='cont_5'><span class="tableCaption">Table 5. Summary of State Leadership Activities</span>
				<div style='display:none'>
					<?php echo $overallsummary->html_format($tp); ?>
				</div>
			</td>
		</tr>
		<tr>
			<td valign='top'><img src='../images/plus.gif' border = '0' id='exp_6' class='expandImage' />&nbsp;</td>

			<td class='activityContainer' id='cont_6'><span class="tableCaption">Table 6. Summary of Federal and Leveraged Funding</span>
				<div style='display:none'>
					<?php echo $overallsummary->html_format($lf); ?>
				</div>
			</td>
		</tr>
	</table>
	<script type='text/javascript'>  
	$(function() { 
		init_overview_hierarchy();
		}
	);
	</script>

<?php
include("footer.php");
?>