<?php

include("../includes/config.php");

extract($_POST);
// action
// hash
// userid
// story

$user = query("SELECT * FROM users WHERE userid=?", $userid); 
$user = $user[0];

// validation
if ($hash != $user["password"]) {
	die("GTFO");
} else if ($user["dead"] == 1) {
	die("you dead doe...");
}

if ($action == "kill") {
	mail(ADMIN_EMAIL, "Kill Report", $user["name"] . " killed...");
	$target = query("SELECT * FROM users WHERE userid=?", $user["to_kill"]);
	$target = $target[0];
	query("UPDATE users SET to_kill=? WHERE userid=?", $target["to_kill"], $userid);
	query("UPDATE users SET dead=1 WHERE userid=?", $target["userid"]);
	query("INSERT INTO killstory (killer, dead, is_kill_story, story) VALUES (?,?,?,?)", $userid, $target["userid"], 1, $story);
}



?>
