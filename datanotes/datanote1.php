<?php 
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Data Note - No. 1, 2005');
$template->add_region('sidebar','<?php 
									$area="datanotes" ;
									$show_flash_link=0;
									?>');
$template->add_region('heading','StateData.info: Data Note - No. 1, 2005');
$template->add_region('content','

<h2>What do Vocational Rehabilitation (VR) services cost?</h2>
<p><a href="datanote1.pdf">Download this Data Note in pdf</a></p>


<p>The VR system has the flexibility to purchase a wide array of services to support an employment outcome, including vocational evaluation, vocational training and postsecondary education, transportation, supported employment, interpreters, and adaptive equipment. VR services include core counseling and guidance provided by a VR counselor as well as services that are purchased based on an individual employment plan.</p>

<p>In fiscal year 2003, the average cost of the purchased services that resulted in an employment outcome 
was \$4,008 for individuals who successfully completed their employment plan, and \$2,161 for all closures 
including individuals who did not achieve a rehabilitation goal.</p>

<p>The cost of services varied significantly by disability, ranging from an average of \$2,923 for each 
successful closure for individuals with a primary disability of substance abuse to \$5,577 for individuals 
with a primary disability that was orthopedic in nature.</p>

<caption>
<h2>Vocational Rehabilitation Services Cost per Case<a href="#1">*</a> by Disability and Type of Closure: Fiscal Year 2003</h2>
</caption>



<table align="center" border="1" cellpadding="5" cellspacing="3" 

summary="Vocational Rehabilitation Services Cost per Case* by Disability and Type of Closure: Fiscal Year 2003">



<colgroup span="2"></colgroup>

<colgroup span="2"></colgroup>



<thead>

<tr>

<th>&nbsp;</th><th class="center" colspan="2" scope="colgroup" >All closures<a href="#2">**</a></th><th class="center" colspan="2" scope="colgroup">Successful closures<a href="#2">**</a></th>

</tr>

<tr>

<th scope="col" >Disability</th><th scope="col" >Number of closures</th><th scope="col" >Mean cost/case</th><th scope="col" >Number of closures</th><th scope="col" >Mean cost/case</th>

</tr>

</thead>



<tbody>

<tr>

<td scope="row">Visual</td><td>29,540</td><td>\$3,894</td><td>15,442</td><td>\$5,267</td>

</tr>

<tr>

<td scope="row">Hearing</td><td>29,869</td><td>3,403</td><td>18,747</td><td>4,170</td>

</tr>

<tr>

<td scope="row">Orthopedic</td><td>114,021</td><td>2,861</td><td>37,660</td><td>5,577</td>

</tr>

<tr>

<td scope="row">Mental retardation</td><td>48,068</td><td>2,616</td><td>19,942</td><td>4,096</td>

</tr>

<tr>

<td scope="row">Substance abuse</td><td>35,594</td><td>1,682</td><td>12,424</td><td>2,923</td>

</tr>

<tr>

<td scope="row">Mental illness</td><td>108,724</td><td>1,775</td><td>31,147</td><td>3,502</td>

</tr>

<tr>

<td scope="row">Learning disability</td><td>58,600</td><td>1,581</td><td>22,977</td><td>2,939</td>

</tr>

<tr>

<td scope="row">Other</td><td>193,345</td><td>1,659</td><td>59,218</td><td>3,510</td>

</tr>

</tbody>



<tfoot>

<td scope="row">Total</td><td>617,761</td><td>2,161</td><td>217,557</td><td>4,008</td>

</tfoot>



</table>

<p><a id="1" /></a>* "Cost" is the cost of purchased services, and does not include administrative costs or the cost of core rehabilitation counseling services provided by the VR agency.</p>

<p><a id="2" /></a>** "All closures" includes successful rehabilitations; unsuccessful closures (after an individualized plan for employment has been developed); and individuals closed before eligibility determination, not accepted for services, or after eligibility determination but prior to an individualized plan for employment. </p>

<p>Sample purchased services available as part of an individual employment plan: </p>

<ul>
<li>Assessment and evaluation </li>
<li>Diagnosis and treatment </li>
<li>College/university training </li>
<li>Occupational/vocational training </li>
<li>On-the-job training</li> 
<li>Job readiness training </li>
<li>Job search services </li>
<li>Job placement services </li>
<li>On-the-job supports </li>
<li>Transportation </li>
<li>Rehabilitation or assistive technology </li>
<li>Reader, interpreter, or personal assistance services or supports </li>
</ul>

<p>Source: RSA 911 database for FY2003 </p>

<p>StateData.info <br />
A project of the Institute for Community Inclusion at UMass Boston</p>
');
//write page
include("header.php");
$template->make_template(); 
include("footer.php");
?>
