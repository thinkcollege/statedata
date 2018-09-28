<?php 
if(isset($_POST['compareid'])) $result = $_POST['compareid'];


$info = new stdClass();
$info->{'compareid'} = $result;
return json_encode($result);
?>