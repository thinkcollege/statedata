<?php 
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Data Note - No. 7, 2006');
$template->add_region('sidebar','<?php 
									$area="datanotes" ;
									$show_flash_link=0;
									?>');
$template->add_region('heading','StateData.info: Data Note - No. 7, 2006');
$template->add_region('content','
<h2>Relationship between MR/DD consumers in integrated employment and working SSI recipients</h2>
<h3>Data set: SSA</h3>
<p><a href="dn7.pdf">Download this Data Note (pdf).</a></p> 
<p>State mental retardation/developmental disability (MR/DD) agencies provided day and employment supports to over 466,500 people in 2001. Of these, 108,981 individuals were supported in integrated employment settings. The percentage of individuals working in integrated employment varied widely by state, from 56% in Washington to only 2% in Alabama.</p>
<p></p>
<p>The percentage of working SSI recipients (across agencies) also varied from state to state in 2001, suggesting that employment outcomes for individuals with disabilities may be related within each state. The following table and maps compare the percentage of consumers working in integrated employment with the percentage of working SSI recipients. Figures are rounded to the nearest percentage point.</p>
<table class="data" cellspacing="0" cellpadding="0">
	<tr>
		<th scope="col">State</th>
		<th scope="col">% Integrated Emp</th>
		<th scope="col">% SSI Working </th>
	</tr>
	<tr>
		<th scope="row">AK</th>
		<td>48</td>
		<td>8</td>
	</tr>
	<tr>
		<th scope="row">AL</th>
		<td>2</td>
		<td>3</td>
	</tr>
	<tr>
		<th scope="row">AR</th>
		<td>3</td>
		<td>5</td>
	</tr>
	<tr>
		<th scope="row">AZ</th>
		<td>N/A</td>
		<td>5</td>
	</tr>
	<tr>
		<th scope="row">CA</th>
		<td>19</td>
		<td>6</td>
	</tr>
	<tr>
		<th scope="row">CO</th>
		<td>34</td>
		<td>10</td>
	</tr>
	<tr>
		<th scope="row">CT</th>
		<td>52</td>
		<td>9</td>
	</tr>
	<tr>
		<th scope="row">DC</th>
		<td>4</td>
		<td>4</td>
	</tr>
	<tr>
		<th scope="row">DE</th>
		<td>33</td>
		<td>8</td>
	</tr>
	<tr>
		<th scope="row">FL</th>
		<td>N/A</td>
		<td>4</td>
	</tr>
	<tr>
		<th scope="row">GA</th>
		<td>39</td>
		<td>5</td>
	</tr>
	<tr>
		<th scope="row">HI</th>
		<td>N/A</td>
		<td>5</td>
	</tr>
	<tr>
		<th scope="row">IA</th>
		<td>N/A</td>
		<td>19</td>
	</tr>
	<tr>
		<th scope="row">ID</th>
		<td>10</td>
		<td>10</td>
	</tr>
	<tr>
		<th scope="row">IL</th>
		<td>12</td>
		<td>7</td>
	</tr>
	<tr>
		<th scope="row">IN</th>
		<td>19</td>
		<td>7</td>
	</tr>
	<tr>
		<th scope="row">KS</th>
		<td>24</td>
		<td>13</td>
	</tr>
	<tr>
		<th scope="row">KY</th>
		<td>29</td>
		<td>3</td>
	</tr>
	<tr>
		<th scope="row">LA</th>
		<td>41</td>
		<td>4</td>
	</tr>
	<tr>
		<th scope="row">MA</th>
		<td>27</td>
		<td>9</td>
	</tr>
	<tr>
		<th scope="row">MD</th>
		<td>42</td>
		<td>8</td>
	</tr>
	<tr>
		<th scope="row">ME</th>
		<td>31</td>
		<td>9</td>
	</tr>
	<tr>
		<th scope="row">MI</th>
		<td>38</td>
		<td>8</td>
	</tr>
	<tr>
		<th scope="row">MN</th>
		<td>47</td>
		<td>17</td>
	</tr>
	<tr>
		<th scope="row">MO</th>
		<td>12</td>
		<td>7</td>
	</tr>
	<tr>
		<th scope="row">MS</th>
		<td>8</td>
		<td>3</td>
	</tr>
	<tr>
		<th scope="row">MT</th>
		<td>N/A</td>
		<td>13</td>
	</tr>
	<tr>
		<th scope="row">NC</th>
		<td>9</td>
		<td>5</td>
	</tr>
	<tr>
		<th scope="row">ND</th>
		<td>N/A</td>
		<td>19</td>
	</tr>
	<tr>
		<th scope="row">NE</th>
		<td>23</td>
		<td>16</td>
	</tr>
	<tr>
		<th scope="row">NH</th>
		<td>51</td>
		<td>12</td>
	</tr>
	<tr>
		<th scope="row">NJ</th>
		<td>20</td>
		<td>7</td>
	</tr>
	<tr>
		<th scope="row">NM</th>
		<td>31</td>
		<td>5</td>
	</tr>
	<tr>
		<th scope="row">NV</th>
		<td>N/A</td>
		<td>7</td>
	</tr>
	<tr>
		<th scope="row">NY</th>
		<td>20</td>
		<td>6</td>
	</tr>
	<tr>
		<th scope="row">OH</th>
		<td>24</td>
		<td>8</td>
	</tr>
	<tr>
		<th scope="row">OK</th>
		<td>39</td>
		<td>6</td>
	</tr>
	<tr>
		<th scope="row">OR</th>
		<td>38</td>
		<td>9</td>
	</tr>
	<tr>
		<th scope="row">PA</th>
		<td>35</td>
		<td>6</td>
	</tr>
	<tr>
		<th scope="row">RI</th>
		<td>N/A</td>
		<td>7</td>
	</tr>
	<tr>
		<th scope="row">SC</th>
		<td>33</td>
		<td>6</td>
	</tr>
	<tr>
		<th scope="row">SD</th>
		<td>42</td>
		<td>20</td>
	</tr>
	<tr>
		<th scope="row">TN</th>
		<td>14</td>
		<td>4</td>
	</tr>
	<tr>
		<th scope="row">TX</th>
		<td>20</td>
		<td>5</td>
	</tr>
	<tr>
		<th scope="row">UT</th>
		<td>40</td>
		<td>12</td>
	</tr>
	<tr>
		<th scope="row">VA</th>
		<td>26</td>
		<td>6</td>
	</tr>
	<tr>
		<th scope="row">VT</th>
		<td>39</td>
		<td>11</td>
	</tr>
	<tr>
		<th scope="row">WA</th>
		<td>56</td>
		<td>7</td>
	</tr>
	<tr>
		<th scope="row">WI</th>
		<td>14</td>
		<td>14</td>
	</tr>
	<tr>
		<th scope="row">WV</th>
		<td>N/A</td>
		<td>3</td>
	</tr>
	<tr>
		<th scope="row">WY</th>
		<td>26</td>
		<td>15</td>
	</tr>
</table>
<p>A significant correlation (r = .35, p &lt; .05) indicates that higher percentages of individuals with disabilities working in integrated employment correlate with greater employment participation for SSI recipients. This relationship prompts inquiry into which state-level factors affect employment outcomes for individuals with disabilities.</p>
<p><img src="../images/dn7-1.gif" width="500" height="402" alt="Map of % SSI recients working" /></p>
<p><img src="../images/dn7-2.gif" width="500" height="402" alt="Map of % unemployment rate" /></p>
<p>Data sources: The Social Security Administration (<a href="http://www.ssa.gov/">www.ssa.gov</a>) and the Institute for Community Inclusion National Survey of Day and Employment Services for People with Developmental Disabilities</p>
<p>This is a publication of StateData.info, funded in part by the Administration on Developmental Disabilities, U.S. Department of Health and Human Services (#90DN0204). This Data Note was written by Katherine Fichthorn and Dana Scott Gilmore.</p>
');
//write page
include("header.php");
$template->make_template(); 
include("footer.php");
?>
