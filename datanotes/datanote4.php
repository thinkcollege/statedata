<?php 
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Data Note - No. 4, 2006');
$template->add_region('sidebar','<?php 
									$area="datanotes" ;
									$show_flash_link=0;
									?>');
$template->add_region('heading','StateData.info: Data Note - No. 4, 2006');
$template->add_region('content','

<h2>VR outcomes for people with spinal cord injury</h2>
<h3>Data set: RSA (VR)</h3>

<p><a href="datanote4.pdf">Download this Data Note in pdf.</a></p>

<p>An estimated 250,000 people are living with a spinal cord injury (SCI). Since 2000, the average age of injury has been 38, with almost 80% of new injuries affecting men<sup>1</sup>. Approximately 7,154 persons with SCI entered the VR service system in 2004. In 2004, 2382 individuals with SCI achieved successful rehabilitation with the support of state vocational rehabilitation agencies. </p>

<p>The average age at application for VR customers with SCI is 37 years, compared with 35 years for other applicants. Individuals with SCI are more likely to have a postsecondary degree or certificate at application than other VR customers. People with SCI show varying results compared to the general VR population. Fewer people with SCI are successfully rehabilitated (status 26). However, customers with SCI who enter integrated and supported employment earn more than customers without SCI. While equal rates close into integrated employment, people with SCI are less likely to be in supported employment (2% versus 9%) and more likely to run their own businesses (6% versus 2%). </p>

<h3>Rehabilitation Rate (%)</h3>
<a name="0.1_table01"></a>
<div >
<table class="data" cellspacing="0" cellpadding="0">
<tr valign="top">
  <td> </td>
  <th scope="col">Rehabilitated</th>
  <th scope="col">Not rehabilitated</th></tr>
<tr valign="top">
  <th scope="row">SCI</th>
  <td>47</td>
  <td>53</td></tr>
<tr valign="top">
	<th scope="row">Not SCI</th>
  <td>56</td>
  <td>44</td></tr>
</table>
</div>
<h3>Work Status at Closure (%)</h3>
<a name="0.1_table02"></a>
<div>
<table class="data" cellspacing="0" cellpadding="0">
<tr valign="top"><td width="58%"></td>
  <th scope="col">SCI</th>
  <th scope="col">Not SCI</th></tr>
<tr valign="top">
	<th scope="row">Integrated employment</th>
  <td>86</td>
  <td>85</td></tr>
<tr valign="top">
	<th scope="row">Supported employment</th>
  <td>2</td>
  <td>9</td></tr>
<tr valign="top">
	<th scope="row">Self-employment</th>
  <td>6</td>
  <td>2</td></tr>
</table>
</div>
<h3>Hours and Earnings at Closure</h3>
<a name="0.1_table03">
<div>
<table class="data" cellspacing="0" cellpadding="0">
<tr valign="top"><td width="12%"></td>
  <th id="int" colspan="2">Integrated employment</th>
  <th id="sup" colspan="2">Supported employment</th>
  <th id="self" colspan="2">Self-employment</th></tr>
<tr valign="top"><td width="12%"></td>
  <th id="hrs">Hours</th>
  <th id="ern">Weekly earnings</th>
  <th id="hrs">Hours</th>
  <th id="ern">Weekly earnings</th>
  <th id="hrs">Hours</th>
  <th id="ern">Weekly earnings</th></tr>

<tr valign="top"><th id="sch">SCI</th>  <td headers="int hrs sci">33</td>  <td headers="int ern sci">414.21</td>  <td headers="int hrs sci">28</td>  <td headers="sup ern sci">286.10</td>  <td headers="self hrs sci">26</td>  <td headers="self ern sci">284.35</td></tr><tr valign="top"><th id"notsci">Not   SCI</th>  <td headers="int hrs notsci">34</td>  <td headers="int ern notsci">337.43</td>  <td headers="sup hrs notsci">24</td>  <td headers="sup ern notsci">172.10</td>  <td headers="self hrs notsci">28</td>  <td headers="self ern notsci">322.18</td></tr>

</table>
</div>
<p>Source: RSA-911 database for FY2004</p>
<p>This is a publication of StateData.info, funded in part by the Administration on Developmental Disabilities, U.S. Department of Health and Human Services (#90DN0204). This Data Note was written by Frank A. Smith, Dana S. Gilmore, and John Butterworth. <a href="http://www.statedata.info/datanotes/">Read more Data Notes.</a></p>
<h3>References</h3>
<p>1. Spinal Cord Information Network (June 2005). Facts and figures at a glance. Retrieved from <a href="http://www.spinalcord.uab.edu/show.asp?durki=21446" target="_blank">http://www.spinalcord.uab.edu<WBR>/show.asp?durki=21446</a></p>

<p>StateData.info <br />
A project of the Institute for Community Inclusion at UMass Boston</p>
');
//write page
include("header.php");
$template->make_template(); 
include("footer.php");
?>
