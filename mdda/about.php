<?php
ini_set('display_errors', 'Off');
ini_set("include_path","../");
include("common/classes_md.php");
$template=new template;
$template->debug();
$template->define_file('mdda_template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - MDDA Employment Outcome Information System');
$template->add_region('sidebar','<?php $area="about" ; $show_flash_link=0; ?>');
$template->add_region('heading','About The MDDA Employment Outcome Information System');
$template->add_region('content','
<h2 id="toc_0">Why we collect data</h2>

<p>The Maryland Employment Outcome Information System is designed to help DDA and its community of stakeholders to develop the supports and infrastructure necessary to fulfill the vision and goals of Maryland’s Position Statement on Employment Services, and to provide longitudinal data that support Maryland’s goals to improve both participation in integrated employment and the quality of employment outcomes.</p>

<p>In October 2012 a cross stakeholder working group developed guiding principles and goals for this initiative. The goals that the Working Group agreed on included that:</p>

<ul>
<li><p>More people are employed with better hours and earned income</p></li>
<li><p>Stakeholders know the status and progress of employment and day services in state of Maryland</p></li>
<li><p>More people leave or reduce reliance on SSI</p></li>
<li><p>Families and individuals are making informed choices</p></li>
</ul>

<p>The data system has been developed and tested with input from DDA staff, advocates, and provider representatives. It will continue to evolve in response to feedback and the needs of Maryland.</p>
<h2>How we collect data</h2>

 

<p>Data on variables such as total wages or total hours of participation are based on a two-week period from which data is collected. This data is collected twice a year; once in May, and once in October.</p>
<h2 id="toc_1">Definitions</h2>

<dl>
<dt>Individual Competitive Job</lt>


<dd>Individual has a full or part time job in the typical labor market where the majority of persons employed are not persons with disabilities. The business is located within the community and is not owned or operated by the support organization. The person is on the payroll of the community business.</dd>


<dt>Individual Contracted Job</dt>


<dd>Individual has a full or part time job in the typical labor market where the majority of persons employed are not persons with disabilities. The business is located within the community but the person is on the payroll of the human service organization, or the human service organization schedules and supervises the work.</dd>

<dt>Group Integrated Job</dt>

<dd>The individual works in a group of 2 to 8 individuals with disabilities in a community setting that includes meaningful interaction with individuals without disabilities. This would typically include work settings described as enclaves or mobile work crews.</dd>
<dt> Self-employment</dt><dd>Includes self-employment or microenterprises owned by the individual. Does not include a business that is owned by the support organization.<br />

<em>Note that business income and expenses are reported over a 3-month period to capture fluctuations in business income.</em></dd>


<dt>Facility-Based Job/Sheltered Work:</dt>

<dd>Individual works in a group of individuals support organization, but may also occur in large groups in other settings such as a large enclave. This category would include any group larger than 8, and smaller group settings that involve little or no contact with workers without disabilities. Typically the position is located in a facility or business owned or operated by the support organization, but may also occur in large groups in other settings such as a large enclave.</dd>


<dt>Community-Based Non Work:</dt>

<dd>Individual spends unpaid time in an integrated community setting in a group of XX or less.</dd>


<dt>Volunteer Job</dt>

<dd>Individual is engaged in unpaid volunteer work within civic, religious, public service, or humanitarian organizations in the community.</dd>


<dt>Facility-Based Non-work:</dt>

<dd>Individual spends time in unpaid activities in a program setting with disabilities.</dd>
</dl>
<h3 id="toc_2"><a href="Maryland DDA Employment Outcomes Information System instructions FALL 2018.pdf" target="_blank">Instructions (pdf)</a></h3>

<h3 style="margin-bottom:2em;" id="toc_3"><a href="/mdda/Maryland_DDA_Outcome_Information_System_FAQ_2018.pdf">FAQ (PDF)</a></h3>
<hr>
');
//write page
include("header.php");
$template->make_template();
