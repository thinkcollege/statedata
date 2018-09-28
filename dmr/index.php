<?php 
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('dmr_template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - DMR Employment Outcome Data');
$template->add_region('sidebar','<?php 
									$area="home" ;
									$show_flash_link=0;
									
									?>');
$template->add_region('heading','DMR Employment Supports Performance Outcome Information System');
$template->add_region('content','
<P>This web site summarizes findings from data collected on employment supports during a four-week period each April. Data were collected at the individual level for individuals who receive employment supports funded by the Department of Mental Retardation. Data on variables such as total wages or total hours of participation are for the full four-week data collection interval.  

<P>Select from the menu at the left or using the links below to view data in four ways:

<P><a class="sectionLink"  href="charts/activity_1.php">Summary by Activity:</a> Provides a summary across five major life activities included in the Employment Supports Performance Outcome Information System at the state, region, or provider levels.

<P><a class="sectionLink"  href="charts/region_1.php">Summary by Region:</a> Provides a comparison of performance across the regions for a selected variable

<P><a class="sectionLink"  href="charts/provider_1.php">Provider Summary Report:</a> Provides a detailed report in table form summarizing the performance of providers at the state or region levels. Three different report choices address number participating by activity, hours of participation by activity, and monthly wages.

<P><a class="sectionLink"  href="charts/provider_individual_1.php">Provider Individual Report:</a> Provides a detailed report in table form summarizing the performance of a single provider at the state or region level. Each report addresses number participating by activity, hours of participation by activity, and monthly wages.

<p><blockquote style="border:gray 1px dashed; padding:1em;">
This site was developed by StateData.info, a project of the Institute for Community Inclusion, University of Massachusetts Boston, for the Massachusetts Department of Mental Retardation. For more information on StateData.info or the work of the Institute for Community Inclusion select one of the links in the menu bar or contact:
<P>Frank A. Smith, M.A. <br>
Project Coordinator<br>
<a href="mailto:frank.smith@umb.edu">frank.smith@umb.edu</a><br>
617/287-4374</p>


<P>John Butterworth, Ph.D. <br>
Research Coordinator<br>
<a href="mailto:john.butterworth@umb.edu">john.butterworth@umb.edu</a><br>
617/287-4357
</blockquote></p>







');
//write page
include("header.php");
$template->make_template(); 
include("footer.php");
?>
