<?php 
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Data Note - No. 3, 2005');
$template->add_region('sidebar','<?php 
									$area="datanotes" ;
									$show_flash_link=0;
									?>');
$template->add_region('heading','StateData.info: Data Note - No. 3, 2005');
$template->add_region('content','






<h2>SSA work incentives enrollment, 1990-2004</h2>
<p><a href="datanote3.pdf">Download this Data Note in pdf</a></p>

<p>To encourage employment for individuals with disabilities, the Social Security Administration (SSA) offers special provisions that limit the impact of work on Social Security Disability Insurance (SSDI) or Supplemental Security Income (SSI) benefits. These provisions are called <strong>work incentives</strong> and include the Plan to Achieve Self-Support (PASS), Impairment-Related Work Expenses (IRWE), and Blind Work Expenses (BWE).</p> 

<p>PASS, IRWE, and BWE allow individuals to set aside money, resources, and expenses to be excluded from total earned income calculations. PASS allows people to set aside money and resources to be used for attaining a work goal such as going back to school, finding a better job, or starting a business. IRWE allows people to exclude expenses that are necessary for work, such as wheelchairs, transportation, or specialized equipment. BWE allows the exclusion of expenses such as service animals, income taxes, and visual/sensory aids.</p>

<p>The table below displays the national mean number of people enrolled per state in these work incentive programs from 1990 to 2004:</p>

<table class="data"><caption><strong>Work Incentives Enrollment, 1990-2004</strong></caption>
<tr><th scope="col">Year</th>
<th scope="col">PASS</th>
<th scope="col">IRWE</th>
<th scope="col">BWE</th></tr>
<tr><th scope="row">1990</th>
<td>44</td>
<td>106</td>
<td>86</td></tr>
<tr><th scope="row">1991</th>
<td>70</td>
<td>128</td>
<td>85</td></tr>
<tr><th scope="row">1992</th>
<td>115</td>
<td>153</td>
<td>87</td></tr>
<tr><th scope="row">1993</th>
<td>159</td>
<td>169</td>
<td>86</td></tr>
<tr><th scope="row">1994</th>
<td>203</td>
<td>186</td>
<td>86</td></tr>
<tr><th scope="row">1995</th>
<td>202</td>
<td>195</td>
<td>87</td></tr>
<tr><th scope="row">1996</th>
<td>92</td>
<td>192</td>
<td>83</td></tr>
<tr><th scope="row">1997</th>
<td>39</td>
<td>189</td>
<td>81</td></tr>
<tr><th scope="row">1998</th>
<td>21</td>
<td>182</td>
<td>75</td></tr>
<tr><th scope="row">1999</th>
<td>20</td>
<td>187</td>
<td>78</td></tr>
<tr><th scope="row">2000</th>
<td>27</td>
<td>184</td>
<td>76</td></tr>
<tr><th scope="row">2001</th>
<td>31</td>
<td>173</td>
<td>71</td></tr>
<tr><th scope="row">2002</th>
<td>34</td>
<td>158</td>
<td>66</td></tr>
<tr><th scope="row">2003</th>
<td>35</td>
<td>152</td>
<td>61</td></tr>
<tr><th scope="row">2004</th>
<td>32</td>
<td>137</td>
<td>57</td></tr>
</table>



<p>A notable trend is the <strong>sharp drop in the number of people enrolled in the PASS program</strong> in 1996. This decline followed a publication of the General Accounting Office that criticized SSA for being too lenient in accepting applicants into a program they deemed to be ineffective for achieving the goal of self-support. The procedures for acceptance were then reevaluated by SSA and amended, resulting in fewer approvals in subsequent years.</p>

<h3>References</h3>


<p>Social Security Administration. (n.d.) <em>Work incentives.</em> <a href="http://www.socialsecurity.gov/disabilityresearch/workincentives.htm">http://www.socialsecurity.gov/disabilityresearch/workincentives.htm</a></p>

<p>U.S. General Accounting Office. (1996). <em>PASS program: SSA work incentive for disabled beneficiaries poorly managed</em> (GAO/HEHS-96-51). Washington, DC: Author.</p>



<p>This is a publication of StateData.info, funded in part by the Administration on Developmental Disabilities, U.S. Department of Health and Human Services (#90DN0204). This <em>Data Note</em> was written by Katherine Fichthorn and Dana Scott Gilmore.<a href="index.php">Read more <em>Data Notes</em></a>.</p>


<p>StateData.info <br />
A project of the Institute for Community Inclusion at UMass Boston</p>
');
//write page
include("header.php");
$template->make_template(); 
include("footer.php");
?>
