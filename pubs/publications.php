<?php 
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - About the project');
$template->add_region('sidebar','<?php 
									$area="trends" ;
									$show_flash_link=0;
									?>');
$template->add_region('heading','State Trends');
$template->add_region('content','
<h1>Publications from the Institute for Community Inclusion</h1>

<ul>
<li><a href="#data">Data Analysis</a></li>
<li><a href="#policy">State Systems Policy</a></li>
</ul>

<h2>Data Analysis</h2>

<a id="rp39"></a><p><strong>The National Survey of Community Rehabilitation Providers, FY2002-2003, Report 2: Non-Work Services</strong><br />
(September 2004, Order #RP39)<br />
The second in a series exploring the services people with developmental
disabilities receive from community rehabilitation providers (CRPs).
Despite recent ideological emphasis on work, the majority of CRPs
continued to offer non-work programs and a substantial proportion of
the people they served were involved in those programs. Overall, the
findings raise questions about CRP commitment to community integration.</p>

<blockquote><a href="pub.php?page=rp39">The National Survey of Community Rehabilitation Providers, Report 2 - text</a><br />
<a href="http://www.communityinclusion.org/publications/pdf/rp39.pdf">The National Survey of Community Rehabilitation Providers, Report 2 - pdf</a></blockquote>

<a id="rp38"></a><p><strong>The National Survey of Community
Rehabilitation Providers, FY2002-2003, Report 1: Overview of Services
and Provider Characteristics</strong><br />
(August 2004, Order #RP38)<br />
Two new Research to Practice briefs examine the services people with
developmental disabilities receive from community rehabilitation
providers (CRPs). Despite recent emphasis on work in the disability
field, people with DD were predominantly in sheltered employment or
non-work services. Of people with DD in integrated employment, the
majority had individual competitive jobs. However, three group
employment models had above-average percentages of individuals with DD.</p>

<blockquote><a href="pub.php?page=rp38">The National Survey of Community Rehabilitation Providers, Report 1 - text</a><br />
<a href="http://www.communityinclusion.org/publications/pdf/rp38.pdf">The National Survey of Community Rehabilitation Providers, Report 1 - pdf</a></blockquote>

<a id="wiahoffparker"></a><p><strong>The One-Stop System and Customers
with Disabilities: An Analysis of Workforce Investment Act and
Wagner-Peyser Act Funded Services to Customers with Disabilities,
Program Years 2000 and 2001</strong><br />
(May 2004)<br />
This paper presents an evaluation of the performance of One-Stop System
employment services for persons with disabilities in program years 2000
and 2001. General findings indicate that WIA customers who have
disabilities are typically less likely to enter and retain employment
in some target groups when compared to their non-disabled peers. In
addition, it appears that Wagner-Peyser Act customers are more likely
to be male, older, and economically disadvantaged than their
non-disabled peers. </p>

<blockquote><a href="word/WIA2001FinalReport.doc">The One-Stop System and Customers with Disabilities - MS Word</a><br />
<a href="http://www.communityinclusion.org/publications/pdf/WIA2001FinalReport.pdf">The One-Stop System and Customers with Disabilities - pdf</a></blockquote>


<p><a id="mon29" /></a><strong>Vocational Rehabilitation Outcomes for People with Mental Retardation, Cerebral Palsy, and Epilepsy: An Analysis of Trends from 1985 to 1998</strong><br />
(2001, Order #MON29, $7.00)<br />
This monograph presents the results of secondary analysis of the RSA-911 database from the Rehabilitation Services Administration. All successful VR closures for individuals with mental retardation, cerebral palsy, and epilepsy for six data points between 1985 and 1998 were investigated. Trends in competitive labor market and extended employment (sheltered workshops) closures were examined. The use of supported employment in the VR system and its outcomes were also discussed. Findings include increased incidence of competitive labor market closures and supported employment services, with a decrease in extended employment closures.</p>
<blockquote><a href="http://www.communityinclusion.org/publications/pdf/vroutcomes.pdf">VR Outcomes Trends 1985-1998, pdf</a></blockquote>

<p><A id="rp29" /></a><strong>Postsecondary Education as a Critical Step Toward Meaningful Employment: Vocational Rehabilitation's Role</strong><br />
(July 2001, Order #RP29)<br />
Postsecondary education opens up a world of opportunities for high school graduates. Research shows that access to the opportunities afforded by a postsecondary education makes an enormous difference in the employability of people with disabilities. This brief focuses on people who have received education supports from Vocational Rehabilitation (VR) agencies and their rehabilitation outcomes. </p>
<blockquote> <a href="http://www.communityinclusion.org/publications/pdf/rp29.pdf">Postsecondary Education: VR's Role - pdf</a></blockquote>

<p><a id="rp28" /></a><strong>National Day and Employment Service Trends in MR/DD Agencies (1988 - 1999)</strong> <br />
(July 2001, Order #RP28)<br />
The past twenty years have seen an increasing emphasis on community-based services and equal access to employment for all individuals, including those with the most significant disabilities. The question is, to what extent have changes in philosophy translated into changes for state agencies and the people they serve? The brief analyzes MR/DD agencies day and employment service trends from 1988 to 1999 and discusses relevant trends in policy and legislation.</p>
<blockquote><a href="text/rp28.html">MR/DD Day &amp; Employment Trends - text</a><br />
<a href="http://www.communityinclusion.org/publications/pdf/rp28.pdf">MR/DD Day &amp; Employment Trends - pdf</a></blockquote>

<p><a id="rp27" /></a><strong>Vocational Rehabilitation Outcomes and General Economic Trends</strong><br />
(June 2001, Order #RP27)<br />
Comparison of Vocational Rehabilitation (VR) outcomes and U.S. economic trends between 1985 and 1998 show that access to employment through VR is meaningfully related to the overall performance of the economy. These data vary from trend data reported on the general population of individuals with disabilities.</p>
<blockquote><a href="http://www.communityinclusion.org/publications/pdf/rp27.pdf">VR Outcomes &amp; Economic Trends - pdf</a>/blockquote>

<p><a id="rp25" /></a><strong>Work Status Trends for People with Mental Retardation, FY 1985 to FY 1998</strong><br />
(December 2000, Order #RP25)<br />
National trends regarding extended and competitive employment closures from state Vocational Rehabilitation systems between 1985 - 1998. </p>
<blockquote><a href="text/rp25.html">Work Status Trends - text</a><br />
<a href="http://www.communityinclusion.org/publications/pdf/rp25.pdf">Work Status Trends - pdf</a></font></p> </blockquote>

<p><a id="mon25" /></a><strong>State Trends in Employment Services for People with Developmental Disabilities: Multiyear Comparisons Based on State MR/DD Agency and Vocational Rehabilitation (RSA) Data</strong><br />
(une 1999, Order #MON25, $20.00)<br />
The last 15 years have seen a significant emphasis on integrated employment opportunities for persons with disabilities. For those who have been a part of this effort, it has been a time of exciting changes in service delivery philosophy, employment services, and outcome evaluation. This monograph provides the most comprehensive summary available of national and state level changes in employment patterns for individuals with mental retardation and other developmental disabilities. The monograph presents longitudinal data from state MR/DD agencies covering eight years between FY88 and FY96, and for federal/state vocational rehabilitation services covering the years FY85 to FY95. <em>Contact ICI at <a href="mailto:ici@umb.edu">ici@umb.edu</a> to order.</em></p>

<p>Highlights:</p>
<ul>
<li>National summary of day and employment services in MR/DD agencies</li>
<li>National summary of employment outcomes in the state/federal Vocational Rehabilitation system</li>
<li>Analysis of state investment in employment outcomes, including a comparison of MR/DD and VR agency experiences</li>
<li>Detailed four-page profile for each of the 50 states and DC</li>
</ul>


<hr>
<h2>State Systems Policy</h2>

<a id="stateinnov"></a><p><strong>State Innovations in Employment Supports</strong><br />
A series covering updates on community services for people with developmental disabilities in <a href="http://www.communityinclusion.org/publications/pub.php?page=stateinnov#co">Colorado</a>, Florida, Maine, Maryland, <a href="http://www.communityinclusion.org/publications/pub.php?page=stateinnov#nh">New Hampshire</a>, and <a href="http://www.communityinclusion.org/publications/pub.php?page=stateinnov#wa">Washington</a>.</p>
<blockquote><a href="http://www.communityinclusion.org/publications/pub.php?page=stateinnov">State Innovations in Employment Supports</a></blockquote>

<p><strong>From the Field</strong><br />
(May 2003, online only)<br />
By combining financial resources, the Minnesota Rehabilitation Services
and Department of Mental Health created the Coordinated Employability
Projects to expand employment services for people with mental
illnesses. Two members of the team discuss the value of this
collaboration and present challenges, strategies, and outcomes that
have strengthened activities between their two agencies. </p>
<blockquote><a href="http://www.communityinclusion.org/publications/pub.php?page=fromthefield">From the Field - text</a></blockquote>

<a id="rp32"></a><p><strong>High-Performing States in Integrated Employment</strong><br /> 
(February 2003, Order #RP32)<br />
Despite recent improvements, community employment outcomes vary widely
across states. This report highlights successful practices of states
that were identified as "high performers" in integrated employment for
people served by state MR/DD agencies.</p>
<blockquote><a href="http://www.communityinclusion.org/publications/pdf/rp32.pdf">High-Performing States in Integrated Employment</a> - pdf</blockquote>

<p><strong>Patterns of Collaboration Among State Agencies and Employment Outcomes</strong><br />
(Chapter from <em>Improving Employment Outcomes: Collaboration Across the Disability and Workforce Development Systems, A State of the Science Conference</em>)<br />
In the last several years, several policy initiatives have encouraged or mandated collaboration among multiple public social service systems, particularly in the workforce development and poverty arenas. This article and conference response examine how states have structured their public services, how agencies communicate with each other, what collaborative activities they have undertaken, whether they prioritize employment for people with disabilities, and what relationship exists between collaboration/coordination and employment outcomes for people with disabilities. <em>Contact ICI at <a href="mailto:ici@umb.edu">ici@umb.edu</a> to order.</em></p>

<p><a name="rp30"></a><strong>The Extent of Consumer-Directed Funding by MR/DD State Agencies in Day and Employment Services</strong><br />
(September 2001, Order #RP30)<br />
Individual control over service delivery and life choices is well established as a value in supports for individuals with developmental disabilities. One strategy for expanding choice is the use of mechanisms that provide for consumer direction of funding resources. This brief reports on the prevalence of these options for day and employment services in state MR/DD agencies in 1999.</p>
 
<blockquote><a href="http://www.communityinclusion.org/publications/pdf/rp30.pdf">Consumer-Directed Funding - pdf</a></blockquote>

<p>

</p>

');
//write page
include("header.php");
$template->make_template(); 
include("footer.php");
?>
