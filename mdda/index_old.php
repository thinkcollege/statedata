<?php
ini_set('display_errors', 'Off'); 
ini_set("include_path","../");
include("common/classes_md.php");
$template=new template;
$template->debug();
$template->define_file('mdda_template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - MDDA Employment Outcome Information System');
$template->add_region('sidebar','<?php $area="home" ; $show_flash_link=0; ?>');
$template->add_region('heading','MDDA Employment Outcome Information System');
$template->add_region('content','
<p>This web site summarizes data collected at the individual level for individuals who receive employment or related day supports funded by the Maryland Developmental Disabilities Administration. Data on variables such as total wages or total hours of participation are for the full four-week data collection interval.</p
<p>Select from the menu at the left or using the links below to view data in three ways:</p
<p><a class="sectionLink"  href="./charts/activity_1.php">Summary Reports:</a> Provides a summary for a selected reporting period across each major life activity included in the Employment Supports Performance Outcome Information System at the state, region, county or provider levels. Reports are available for:</p><ul><li>Hours worked</li><li>
Wages earned</li><li>
Self employment</li></ul>


<p><a class="sectionLink"  href="./charts/provider_1.php">Provider Comparison Report:</a> Provides a detailed report in table form summarizing the performance of providers at the state, region or county levels. Reports are available for:</p>
<ul><li>Number participating by activity</li><li>
Hours of participation by activity</li><li>
Wages earned by activity</li><li>
Paid time off</li></ul>

<p><a class="sectionLink"  href="./charts/provider_individual_1.php">Provider Individual Report:</a> Provides a detailed report in table form summarizing a single provider at the state or region level. Each report addresses number participating by activity, hours of participation by activity, and wages during a two-week reporting period.</p>
<blockquote style="border:gray 1px dashed; padding:1em;">This site was developed by StateData.info, a project of the Institute for Community Inclusion, University of Massachusetts Boston, and by staff of the State Employment Leadership Network for the Maryland Developmental Disabilities Services Administration. For more information on StateData.info or the State Employment Leadership Network contact:</p>
<p>Frank A. Smith, M.A.<br />
<a href="mailto:frank.smith@umb.edu">frank.smith@umb.edu</a><br />
617/287-4374</p>
<p>John Butterworth, Ph.D.<br />
<a href="mailto:john.butterworth@umb.edu">john.butterworth@umb.edu</a><br />
617/287-4357</p>
</blockquote>');
//write page
include("header.php");
$template->make_template(); 

