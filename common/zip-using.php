<?php

$zipfile = new zipfile();  

// add the subdirectory ... important!
$zipfile -> add_dir("dir/");

// add the binary data stored in the string 'filedata'
$filedata = "(read your file into $filedata)";  
$zipfile -> add_file($filedata, "dir/file.txt");  

// the next three lines force an immediate download of the zip file:
header("Content-type: application/octet-stream");  
header("Content-disposition: attachment; filename=test.zip");  
echo $zipfile -> file();  


// OR instead of doing that, you can write out the file to the loca disk like this:
$filename = "output.zip";
$fd = fopen ($filename, "wb");
$out = fwrite ($fd, $zipfile -> file());
fclose ($fd);

// then offer it to the user to download:
<a href="output.zip">Click here to download the new zip file.</a>

?>

<P>Final notes and usage

<P>That's it for the script! Before I wrap up this series, let me quickly give you some helpful pointers on using the script. Because of the nature of the Zip file structure, all files and directories should never be left blank or null. If you would like the file, when extracted, to extract to the current directory you can use the directory name ./.

<P>Also note that the directory where a file is to be extracted must be a part of the file name. Therefore, if you wanted to create a file foo.txt in the directory /foo/bar, you should first add the directory to the Zip file and then add the file using the file name foo/bar/foo.txt.

<P>Finally, you may have noticed that the file() function simply returns the Zip file structure as a variable. If you wish, this Zip file can be sent immediately to the browser by first sending the appropriate headers followed by a simple echo statement. The MIME format to use when sending a Zip file to the browser is:

<P>Content-type: application/octet-stream

<P>Content-disposition: attachment; filename=myzip.zip

<P>Note that the filename portion of the second header should reflect the filename of the Zip file. If you wish to store the file locally, simply write the contents of the Zip file directly to the file system using PHP's file system functions. 