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

<div valign="middle"><blockquote>
  <img style="float: left; margin: 0px 15px 15px 0px; max-width:200px;" src="images/zenis.png" alt="Bernie Zenis">
  <p style="font-size:larger; color:#57962A; font-style:italic;">
“The Developmental Disabilities Administration has a robust data collection system that shows how we inform stakeholders and leaders of progress toward employment goals, and opportunities to improve system’s performance. This data has assisted us in making policy and budgetary decisions.”</p>

<p>- Bernie Simons<br>
Deputy Secretary for Developmental Disabilities</p>
</blockquote>
<p><strong>For more information visit <a href="http://dda.dhmh.maryland.gov/Pages/Employment.aspx">Employment 1st Maryland</a></strong></p>
</div>

<hr style="clear:both;">

<p style="font-size:larger;">This website summarizes data collected at the individual level for people who receive employment or related day supports funded by the Maryland Developmental Disabilities Administration. Data on variables such as total wages or total hours of participation are for the two-week data collection interval.</p>



<p>Select from the menu at the left or using the links below to view data in three ways: </p>

<p><strong><a href="./charts/activity_1.php">Summary Reports:</a></strong> Provides a summary for a selected reporting period across each major life activity included in the Employment Supports Performance Outcome Information System at the state, region, county, or provider levels. Reports are available for:</p>

<ul>
<li>Hours worked</li>
<li>Wages earned</li>
<li>Self-employment</li>
</ul>

<p><strong><a href="./charts/provider_1.php">Provider Comparison Report:</a></strong> Provides a detailed report in table form summarizing the performance of providers at the state, region, or county levels. Reports are available for:</p>

<ul>
<li>Number participating by activity</li>
<li>Hours of participation by activity</li>
<li>Wages earned by activity</li>
<li>Paid time off </li>
</ul>

<p><strong><a href="./charts/provider_individual_1.php">Provider Individual Report:</a></strong> Provides a detailed report in table form summarizing a single provider at the state or region level. Each report addresses number participating by activity, hours of participation by activity, and wages during a two-week reporting period.</p>

<div class="footer">
<p class="clearfix" style="text-align: center margin: 14px auto;"><a href="http://communityinclusion.org/"><img style="float: left; margin-right: 14px;" src="../images/icigreendark.gif" width="40" height="40" alt="communityinclusion.org" /></a><a href="http://www.umb.edu"><img style="float: left;" src="../images/UMB_informal.gif" width="40" height="40" alt="umb.edu" /></a></p>
<p>This site was developed by StateData.info, a project of the Institute for Community Inclusion, University of Massachusetts Boston, and by staff of the State Employment Leadership Network for the Maryland Developmental Disabilities Services Administration (&copy; 2017). For more information on StateData.info or the State Employment Leadership Network contact:</p>

<p>Agnes Zalewska, MPH<br>
<a href="agnes.zalewska@umb.edu">agnes.zalewska@umb.edu</a><br>
617/287-4393</p>

<p>John Butterworth, Ph.D.<br>
<a href="john.butterworth@umb.edu">john.butterworth@umb.edu</a><br>
617/287-4357</p>
</div>






');
//write page
include("header.php");
$template->make_template();
