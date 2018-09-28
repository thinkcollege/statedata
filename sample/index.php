<?php 
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('sample_template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - DRM Sample');
$template->add_region('sidebar','<?php 
									$area="home" ;
									$show_flash_link=0;
									
									?>');
$template->add_region('heading','Employment Supports Performance Outcome Information System Sample Data Display');
$template->add_region('content','
<P>This website provides an example of a state-level employment supports
outcome data collection and reporting system using the <a href="http://www.statedata.info">StateData.info</a>
web platform to present a comprehensive data summary. The website
summarizes findings from sample data representing a four-week period.

<P>Data would be collected at the individual level for individuals who
receive employment supports. Data on variables such as total wages or
total hours of participation are for the full four-week data collection
interval. The providers included in this report are samples only, and do
not represent actual data. The project can use existing state-level data
or work with a state to provide and customize a data collection approach
and data collection tools.

<P>Select from the menu at the left or the links below to view data in
three ways:

<P><a class="sectionLink"  href="charts/activity_1.php">Summary by Activity:</a>  A summary across five major life activities at the state, region, or provider levels.

<P><a class="sectionLink"  href="charts/region_1.php">Summary by Region:</a> A comparison of performance across the regions for a selected variable.

<P><a class="sectionLink"  href="charts/provider_1.php">Provider Report:</a> A detailed report in table form summarizing the
performance of providers at the state or region levels. Three different
report choices address number participating by activity, hours of
participation by activity, and monthly wages.


<p><blockquote style="border:gray 1px dashed; padding:1em;">
This site was developed by <a href="http://www.statedata.info">StateData.info</a>, a project of the Institute
for Community Inclusion at the University of Massachusetts Boston. For
more information on <a href="http://www.statedata.info">StateData.info</a> or the Institute for Community
Inclusion, select from the menu bar links or contact:


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
