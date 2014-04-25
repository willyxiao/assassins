<?php
$pw = file_get_contents("password"); 

define("QUERY_DATABASE", "assassins"); 
define("QUERY_SERVER", "assassins.db.12019849.hostedresource.com"); 
define("QUERY_USERNAME", "assassins"); 
define("QUERY_PASSWORD", $pw); 

?>
