<?php

include("../includes/config.php"); 
extract($_POST); 

$user = query("SELECT * FROM users WHERE userid=?", $userid); 
$user = $user[0]; 

if ($hash != $user["password"]) {
	die("GTFO"); 
}

if($action == "dead") {
	query("UPDATE users SET dead=1 WEHRE userid=?", $userid);
	$assassin = query("SELECT * FROM users WHERE to_kill=?", $userid); 
	$assassin = $assassin[0]; 
	if ( $assassin["killed"] == 1) {
		query("UPDATE users SET killed=0, to_kill=? WHERE userid=?", $user["to_kill"], $assassin["userid"]); 
	}	
} else if ($action == "killed") {
	query("UPDATE users SET killed=1 WHERE userid=?", $userid); 
	$target = query("SELECT * FROM users WHERE userid=?", $user["to_kill"]); 
	$target = $target[0]; 
	if ($target["dead"] == 1) {
		query("UPDATE users SET killed=0, to_kill=? WHERE userid=?", $target["to_kill"], $userid); 
	}
}



?>
