<?php 
$footer = '<div id="footer">
<p>
The recommended citation for these charts and data is: Institute for Community Inclusion. (n.d.) <em>StateData.info</em>. Retrieved [today\'s 
date] from http://www.statedata.info.</p>
<br />
<p>
This is a project of the Institute for Community Inclusion at UMass Boston supported in part by the Administration on Developmental Disabilities, U.S. Department of Health and Human Services under cooperative agreement #90DN0126 with additional support from the National Institute on Disability and Rehabilitation Research of the U.S. Department of Education under grant #H133A021503. The opinions contained in this website are those of the grantee and do not necessarily reflect those of the funders.</p>
<br />
<p style="text-align:center;">
<!-- Creative Commons License -->
<a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.0/"><img alt="Creative Commons License" border="0" src="http://creativecommons.org/images/public/somerights20.gif" /></a><br />
This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.0/">Creative Commons License</a>.
<!-- /Creative Commons License -->


<!--

<rdf:RDF xmlns="http://web.resource.org/cc/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
<Work rdf:about="">
   <license rdf:resource="http://creativecommons.org/licenses/by-nc-nd/2.0/" />
</Work>

<License rdf:about="http://creativecommons.org/licenses/by-nc-nd/2.0/">
   <permits rdf:resource="http://web.resource.org/cc/Reproduction" />
   <permits rdf:resource="http://web.resource.org/cc/Distribution" />
   <requires rdf:resource="http://web.resource.org/cc/Notice" />
   <requires rdf:resource="http://web.resource.org/cc/Attribution" />
   <prohibits rdf:resource="http://web.resource.org/cc/CommercialUse" />
</License>

</rdf:RDF>

-->
</p>


</div>';
ini_set("include_path","../");
set_include_path(get_include_path().':/Library/Webserver/lib/'.':lib/:/home/ici/lib/');
function __autoload($class_name) {
   require_once $class_name . '.php';
}

$db_obj = new icidb('localhost','ici','iciici99','ici');

if (!$_GET['article_id']){
$article_id = $_POST['article_id'];
}
else {
$article_id = $_GET['article_id'];
}	

$a = $db_obj->get_row("SELECT * from article WHERE article_id=$article_id");
$authors = $db_obj->get_results('SELECT staff.staff_id, staff_lname, staff_fname, staff_active, rank from staff, article_staff WHERE article_staff.staff_id=staff.staff_id and article_staff.article_id = '.$article_id.' ORDER BY rank');
$num_auths = $db_obj->num_rows;
if ( $num_auths > 0 )
{
	$count = 1;
	$text .= '<p>By '; 
	foreach( $authors as $author )
	{
		$text .= $author->staff_fname.' '.$author->staff_lname;
		if ( ($count <= $num_auths-2) && ($num_auths > 2) )
		{
			$text .= ', '; 
		} 
		elseif ( $count <= $num_auths-1 )
		{
			$text .= ' and ';
		}
		$count++;
	}
	$text .= '.</p>';
}
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('template.php');
$template->add_region('title',$a->article_title);
$template->add_region('sidebar','<?php 
									$area="datanotes" ;
									$show_flash_link=0;
									?>');
$template->add_region('heading',$a->article_title);
if ( $a->pdf)
{
	$pdf = '<p><a href="pdf/'.$a->pdf.'">Download this publication (pdf)</a>.</p>';
}
$article_text = str_replace  ( '$', '&#36;', $a->article_text );

$template->add_region('content','<h2>'.$a->article_sub_title.'</h2>'.$pdf.$text.$article_text.$footer);
//write page
include("header.php");
$template->make_template(); 
include("footer.php");
?>
