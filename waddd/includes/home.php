<?php
$template->addRegion('heading','WA-DDD Employment Supports Performance Outcome Information System');
$content = '<p><strong>DDD Employment Supports Performance Outcome Information System</strong><br />
This web site summarizes data collected on employment supports funded by the Washington Division of Developmental Disabilities and counties. Data are reported monthly at the individual level. The query modules allow users to create reports and graphs based on a number of individual characteristics.</p>';
if ($user->loggedIn()) {
	$content .= '<p>Select from the menu at the left or using the links below to view data in two ways:</p>
<p><a href="./?report=' . report::TREND . '">Trend Report</a>: Provides a graph of trends in employment services data for an individual variable such as gross pay or average hours in paid work.<p>
<p><a href="./?report=' . report::SUMMARY . '">Summary Report</a>: Provides a summary of employment outcomes or supports at the state, region, County, or provider levels for a single month. Three different report choices are available:</p>
<ul><li>Hours of participation by activity.</li>
	<li>Monthly wages by activity.</li>
	<li>Supports provided by activity.</li></ul> ' . report::getSavedReports();
} else {
	$content .= '<form action="./' . (has_value($_SERVER, 'QUERY_STRING', '', COMP_NE) ? '?' . $_SERVER['QUERY_STRING'] : '') . '" method="post">
		<p><label for="email">E-mail:</label> <input type="text" id="email" name="email" value="' . (isset($_POST['email']) ? htmlentities($_POST['email'], ENT_COMPAT, 'UTF-8') : '') . '" size="30" /></p>
		<p><label for="pass">Password:</label> <input type="password" id="pass" name="password" value="" /></p>
		<input type="submit" value="Login" />
		<noscript>
		 <input type="hidden" name="nojs" value="1" />
		 <p style="color:blue;">You are not using a Javascript enabled web broswer.  While this will not reduce the functionality of this site. To achieve the same functionality it may take more steps.</p>
		</noscript>
	   </form>
	   <script type="text/javascript">window.onload=function(e){document.getElementById(\'email\').focus();};</script>';
}
$content .= '<p>This site was developed by StateData.info, a project of the Institute for Community Inclusion, University of Massachusetts Boston, for the Washington DSHS Division of Developmental Disabilities. For more information on StateData.info or the work of the Institute for Community Inclusion.</p>
<p class="center float-left" style="width:49%;">Frank A. Smith, M.A.<br />Project Coordinator<br /><a href="mailto:frank.smith@umb.edu?subject=Question/Comment about WA-DDD">frank.smith@umb.edu</a><br />617.287.4374.</p>
<p class="center float-right" style="width:49%;">John Butterworth, Ph.D.<br />Research Coordinator<br /><a href="mailto:john.butterworth@umb.edu?subject=Question/Comment about WA-DDD">john.butterworth@umb.edu</a><br />617.287.4357</p>';

$template->addRegion('content', $content);