<?php 

ini_set("include_path",".:../");
include("common/classes.php");
$mre_base=new mre_base;
$title =   $mre_base->mre_base_sitename . " - Overall Summary Report";
$area = "overall"; 
$show_flash_link = 0;

$content = "<form method=\"get\" action=\"./overall_summary_2.php\">";


$functions = new functions;

$content .= "<p><label for='agency'>Select Year:</label> " . $functions->get_table_year("dd") . '</p>';

$content .= '<p><input type="submit" class="submit" value=" "></p>

</form>
<br>';							
									
$heading = 'Overall Summary report';
//write page
include("header.php");
echo $content;
include("footer.php");
?>