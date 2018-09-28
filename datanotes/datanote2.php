<?php 
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Data Note - No. 2, 2005');
$template->add_region('sidebar','<?php 
									$area="datanotes" ;
									$show_flash_link=0;
									?>');
$template->add_region('heading','StateData.info: Data Note - No. 2, 2005');
$template->add_region('content','

<h2>Employment outcomes for people with diabetes in the Vocational Rehabilitation system</h2>
<p><a href="datanote2.pdf">Download this Data Note in pdf</a></p>

<p>Approximately 18 million people in the U.S. have diabetes. Diabetes in and of itself does not necessarily qualify any given individual for disability services. However, for some individuals, diabetes can be serious enough or can lead to secondary conditions that enable them to qualify for Vocational Rehabilitation (VR) services.</p> 

<caption><h3 align=center>Employment Outcomes</h3></caption>

<table align="center" border="1" cellpadding="5" cellspacing="3" summary="Employment Outcomes">

<colgroup span="1"></colgroup>
<colgroup span="3"></colgroup>
<colgroup span="3"></colgroup>


<thead>

<tr>

<th class="center" scope="colgroup" >Employment outcomes</th>
<th class="center" scope="colgroup" colspan="3">General population (N=213,616)</th>
<th class="center" scope="colgroup" colspan="3">People with diabetes (N=3,958)</th>

</tr>
<tr>
<th class="center" scope="colgroup">&nbsp;</th>
<th class="center" scope="colgroup">%</th>
<th class="center" scope="colgroup">Mean weekly earnings ($)</th>
<th class="center" scope="colgroup">Mean weekly hours</th>
<th class="center" scope="colgroup">%</th>
<th class="center" scope="colgroup">Mean weekly earnings ($)</th>
<th class="center" scope="colgroup">Mean weekly hours</th>
</tr>

</thead>
<tbody>

<tr>
<td scope="row">Integrated employment</td><td>85.0</td><td>332.8</td><td>34</td><td>74.3</td><td>355.7</td><td>34</td>
</tr>
<tr>
<td scope="row">Self-employment (except BEP)</td><td>2.3</td><td>301.8</td><td>28</td><td>4.7</td><td>228.6</td><td>26</td>

</tr>
<tr>
<td scope="row">Supported employment</td><td>8.4</td><td>170.8</td><td>24</td><td>1.6</td><td>236.8</td><td>27</td>
</tr>
<tr>
<td scope="row">Other employment outcomes</td><td>.1</td><td>N/A</td><td>N/A</td><td>.3</td><td>N/A</td><td>N/A</td>

</tr>
<tr>
<td scope="row">Homemaker and unpaid family worker</td><td>4.1</td><td>N/A</td><td>N/A</td><td>19.2</td><td>N/A</td><td>N/A</td>
</tr>
</tbody>
</table>
<p>Source: Rehabilitation Services Administration (2003 data)</p>

<p>The most striking difference between people with diabetes and those without is in <strong>the rate of closure to homemaker or unpaid family worker status. About one-fifth of people with diabetes are closed into this status.</strong> Upon further analysis, those closed into this status are blind or visually impaired (87%); are women (68%); have an average age of 57; and were not working at the time of application (95%). </p>

<p>People with diabetes are closed into integrated employment less often than people without diabetes. However, people with diabetes closed into integrated employment earn more, with weekly wages more than \$20 higher than the general VR population, although mean weekly hours are about the same. People with diabetes are much less frequently closed into supported employment than the general population of people receiving VR services. </p>

<p>This finding may indicate that about one-fifth of people with diabetes use VR services for independent living goals rather than employment. If people acquire adult-onset disabilities, are they retiring by choice or opting out of work due to a lack of accommodations or job opportunities? Does homemaker status constitute a successful closure?</p>


<h3>Reference</h3>

<p>
American Diabetes Association. (2005). <em>National Diabetes Fact Sheet.</em>
<a href="http://www.diabetes.org/diabetes-statistics/national-diabetes-fact-sheet.jsp">http://www.diabetes.org/diabetes-statistics/national-diabetes-fact-sheet.jsp</a>
</p>

<p>For further information, see the Institute for Community Inclusion brief <em>Diabetes and Vocational Rehabilitation Employment Services and Outcomes</em>, which adds additional findings from this research. <a href="http://www.communityinclusion.org">http://www.communityinclusion.org</a>.</p>

<p>This is a publication of StateData.info, funded in part by the the
Administration on Developmental Disabilities, U.S. Department of Health and
Human Services (#90DN0204) and the Emerging Disabilities, Employment
Outcomes, and Systems Change Project (#H133A021503) funded by the National
Institute on Disability Rehabilitation and Research at the U.S. Department
of Education. This <em>Data Note</em> was written by Jonathan Woodring, Susan Foley, and Lauren Miller. <a href="index.php">Read more <em>Data Notes</em></a>.</p>


<p>StateData.info <br />
A project of the Institute for Community Inclusion at UMass Boston</p>
');
//write page
include("header.php");
$template->make_template(); 
include("footer.php");
?>
