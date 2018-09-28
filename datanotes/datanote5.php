<?php 
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - Data Note - No. 5, 2006');
$template->add_region('sidebar','<?php 
									$area="datanotes" ;
									$show_flash_link=0;
									?>');
$template->add_region('heading','StateData.info: Data Note - No. 5, 2006');
$template->add_region('content','
<h2>Relationship between SSI recipients who work and state unemployment rate</h2>
<h3>Data set: SSA</h3>

<p><a href="dn.pdf">Download this Data Note (pdf).</a></p>
<p>The Supplemental Security Income program (SSI) administered by the Social Security Administration provides cash assistance to low-income individuals who are seniors, blind, or have a disability.</p>
<p>Many people who receive SSI benefits are unemployed. However, in 2004 the percentage of SSI recipients who were working varied considerably by state. To understand this variation, researchers correlated the percentage of employed SSI recipients with 2004 state unemployment rates. The following table and maps show the percentage of SSI recipients who were working in 2004 and state unemployment rates (UR), rounded to the nearest percentage point. </p>
<p>A significant inverse correlation was determined, r = -.48, p &lt; .001, indicating that the higher percentages of SSI recipients who were working in 2004 correlate to lower state unemployment rates. This finding suggests that a state\'s economic situation impacts all workers, including those who receive SSI benefits.</p>

<table class="data" cellspacing="0" cellpadding="0">
	<tr>
		<th scope="col">State</th>
		<th scope="col">% SSI working</th>
		<th scope="col">UR (%)</th>
	</tr>
	<tr>			
		<th scope="row">AK</th>
		<td>7</td>
		<td>8</td>
	</tr>
	<tr>			
		<th scope="row">AL</th>
		<td>3</td>
		<td>6</td>
	</tr>
	<tr>			
		<th scope="row">AR</th>
		<td>5</td>
		<td>6</td>
	</tr>
	<tr>			
		<th scope="row">AZ</th>
		<td>4</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">CA</th>
		<td>5</td>
		<td>6</td>
	</tr>
	<tr>			
		<th scope="row">CO</th>
		<td>8</td>
		<td>6</td>
	</tr>
	<tr>			
		<th scope="row">CT</th>
		<td>8</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">DC</th>
		<td>3</td>
		<td>8</td>
	</tr>
	<tr>			
		<th scope="row">DE</th>
		<td>7</td>
		<td>4</td>
	</tr>
	<tr>			
		<th scope="row">FL</th>
		<td>4</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">GA</th>
		<td>4</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">HI</th>
		<td>5</td>
		<td>3</td>
	</tr>
	<tr>			
		<th scope="row">IA</th>
		<td>16</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">ID</th>
		<td>9</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">IL</th>
		<td>6</td>
		<td>6</td>
	</tr>
	<tr>			
		<th scope="row">IN</th>
		<td>6</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">KY</th>
		<td>3</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">LA</th>
		<td>4</td>
		<td>6</td>
	</tr>
	<tr>			
		<th scope="row">MA</th>
		<td>8</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">MD</th>
		<td>7</td>
		<td>4</td>
	</tr>
	<tr>			
		<th scope="row">ME</th>
		<td>7</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">MI</th>
		<td>7</td>
		<td>7</td>
	</tr>
	<tr>			
		<th scope="row">MN</th>
		<td>15</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">MO</th>
		<td>7</td>
		<td>6</td>
	</tr>
	<tr>			
		<th scope="row">MS</th>
		<td>3</td>
		<td>6</td>
	</tr>
	<tr>			
		<th scope="row">MT</th>
		<td>13</td>
		<td>4</td>
	</tr>
	<tr>			
		<th scope="row">NC</th>
		<td>5</td>
		<td>6</td>
	</tr>
	<tr>			
		<th scope="row">ND</th>
		<td>19</td>
		<td>3</td>
	</tr>
	<tr>			
		<th scope="row">NE</th>
		<td>15</td>
		<td>4</td>
	</tr>
	<tr>			
		<th scope="row">NH</th>
		<td>10</td>
		<td>4</td>
	</tr>
	<tr>			
		<th scope="row">NJ</th>
		<td>6</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">NM</th>
		<td>5</td>
		<td>6</td>
	</tr>
	<tr>			
		<th scope="row">NY</th>
		<td>6</td>
		<td>6</td>
	</tr>
	<tr>			
		<th scope="row">OH</th>
		<td>7</td>
		<td>6</td>
	</tr>
	<tr>			
		<th scope="row">OK</th>
		<td>5</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">OR</th>
		<td>7</td>
		<td>7</td>
	</tr>
	<tr>			
		<th scope="row">PA</th>
		<td>5</td>
		<td>6</td>
	</tr>
	<tr>			
		<th scope="row">RI</th>
		<td>6</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">SC</th>
		<td>5</td>
		<td>7</td>
	</tr>
	<tr>			
		<th scope="row">SD</th>
		<td>19</td>
		<td>4</td>
	</tr>
	<tr>			
		<th scope="row">TN</th>
		<td>4</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">TX</th>
		<td>4</td>
		<td>6</td>
	</tr>
	<tr>			
		<th scope="row">UT</th>
		<td>11</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">VA</th>
		<td>6</td>
		<td>4</td>
	</tr>
	<tr>			
		<th scope="row">VT</th>
		<td>10</td>
		<td>4</td>
	</tr>
	<tr>			
		<th scope="row">WA</th>
		<td>6</td>
		<td>6</td>
	</tr>
	<tr>			
		<th scope="row">WI</th>
		<td>12</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">WV</th>
		<td>3</td>
		<td>5</td>
	</tr>
	<tr>			
		<th scope="row">WY</th>
		<td>14</td>
		<td>4</td>
	</tr>
</table>
<p><img src="../images/dn5-1.gif" width="500" height="402" alt="Map of % working on SSI" /></p>
<p><img src="../images/dn5-2.gif" width="500" height="402" alt="Map of % integrated employment" /></p>
<p>Data sources: Bureau of Labor Statistics (<a href="http://www.bls.gov">www.bls.gov</a>) and Social Security Administration (<a href="http://www.ssa.gov">www.ssa.gov</a>).</p>
<p></p>
<p>This is a publication of StateData.info, funded in part by the Administration on Developmental Disabilities, U.S. Department of Health and Human Services (#90DN0204). This Data Note was written by Katherine Fichthorn and Dana Scott Gilmore.</p>
');
//write page
include("header.php");
$template->make_template(); 
include("footer.php");
?>
