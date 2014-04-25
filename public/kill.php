<?php
require("../includes/config.php"); 

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	extract($_GET); 
	if (!isset($uname, $hash) || !isValid($uname, $hash)) {
		render("login.php", array("fail" => isset($uname, $hash))); 
		exit; 
	}
	
	$tmp = query("SELECT * FROM users WHERE uname=?", $uname); 
	if($tmp == false || count($tmp) < 1) {
		apologize("You are so wrong"); 
	} else if ($tmp[0]["dead"] == 1) {
		render("dead.php", array("title" => "Death")); 
	}

	render("main.php", array("title" => "Eliot Assassins", "user" => $tmp)); 
	exit; 
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
	extract($_POST); 
	if (!isset($uname, $password)) {
		render("login.php"); 
		exit; 
	}
	$pass = query("SELECT * FROM users WHERE uname=?", $uname); 
	if($pass == false 
	|| count($pass) < 1
	|| $pass[0]["password"] != $password) {
		render("login.php", array("fail" => true)); 
		exit; 
	}
	
	header("Location: kill.php?uname=" . $uname . "&hash=" . convert($password));  

} else {
	apologize("You are so wrong"); 
}


?>
