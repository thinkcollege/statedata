<?php 
ini_set("include_path","../");
include("common/classes.php");
$template=new template;
$template->debug();
$template->define_file('sample_template.php');
$template->add_region('title','<?php $mre_base=new mre_base; echo $mre_base->mre_base_sitename;?> - D Link');
$template->add_region('sidebar','<?php 
									$area="Feedback" ;
									$show_flash_link=0;
									?>');
$template->add_region('heading','Feedback');
$template->add_region('content','

<p>
Use the form below to submit any feedback or problems you are experiencing. Please be sure to fill out your contact information if you would like to be contacted directly.</p>

<form ACTION="process.php" METHOD="POST">

<p><label for="name">Name:</label>
<br><input size=40 type=text id=name name=name></p>

<p><label for="phone">Phone:</label>
<br><input size=40 type=text id=phone name=phone></p>

<p><label for="email">Email:</label>
<br><input size=40 type=text id=email name=email></p>
<p><label for="State">State:</lable>
		<br><select  name=state id=state STYLE="font-size:1em;">
                  <option value=nil >Choose State</option>
                <option value=AL >Alabama</option>
                <option value=AK > Alaska</option>
                <option value=AZ > Arizona</option>
                <option value=AR > Arkansas</option>
                <option value=CA > California</option>
                <option value=CO > Colorado</option>
                <option value=CT > Connecticut</option>
                <option value=DE > Delaware</option>
                <option value=DC > District of Columbia</option> 
                <option value=FL > Florida</option>
                <option value=GA > Georgia</option>
                <option value=HI > Hawaii</option>
                <option value=ID > Idaho</option>
                <option value=IL > Illinois</option>
                <option value=IN > Indiana</option>
                <option value=IA > Iowa</option>
                <option value=KS > Kansas</option>
                <option value=KY > Kentucky</option>
                <option value=LA > Louisiana</option>
                <option value=ME > Maine</option>
                <option value=MD > Maryland</option>
                <option value=MA > Massachusetts</option>
                <option value=MI > Michigan</option>
                <option value=MN > Minnesota</option>
                <option value=MS > Mississippi</option>
                <option value=MO > Missouri</option>
                <option value=MT > Montana</option>
                <option value=NE > Nebraska</option>
                <option value=NV > Nevada</option>
                <option value=NH > New Hampshire</option>
                <option value=NJ > New Jersey</option>
                <option value=NM > New Mexico</option>
                <option value=NY > New York</option>
                <option value=NC > North Carolina</option>
                <option value=ND > North Dakota</option>
                <option value=OH > Ohio</option>
                <option value=OK > Oklahoma</option>
                <option value=OR > Oregon</option>
                <option value=PA > Pennsylvania</option>
                <option value=PR > Puerto Rico</option>
                <option value=RI > Rhode Island</option>
                <option value=SC > South Carolina</option>
                <option value=SD > South Dakota</option>
                <option value=TN > Tennessee</option>
                <option value=TX > Texas</option>
                <option value=UT > Utah</option>
                <option value=VT > Vermont</option>
                <option value=VA > Virginia</option>
                <option value=WA > Washington</option>
                <option value=WV > West Virginia</option>
                <option value=WI > Wisconsin</option>
                <option value=WY > Wyoming</option>
                <option value=Other > Other</option>
              </select></p>
			  	  
<p><label for="org">Organization:</label>
<br><input size=40 type=text id=org name=organization></p>


<p><label for="comment">Feedback/Inquiry:</label>
<br><textarea rows=7 cols=60 id=question name="comment"></textarea>
<br>
<input type="hidden" name="subject" value="Sample - feedback">
<input type="submit" value="SUBMIT"></form></p>

');
//write page
include("header.php");
$template->make_template(); 
include("footer.php");
?>



