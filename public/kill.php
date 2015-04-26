<?php
require("../includes/config.php");

$alive = query("SELECT count(*) as alive FROM users WHERE dead != 1"); 
$alive = $alive[0]["alive"];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	extract($_GET);
	if (!isset($uname, $hash) || !isValid($uname, $hash)) {
		render("login.php", array("fail" => isset($uname, $hash), "alive" => $alive));
		exit;
	}

	$tmp = query("SELECT * FROM users WHERE uname=?", $uname);
	if($tmp == false || count($tmp) < 1) {
		apologize("You are so wrong");
	} else if ($tmp[0]["dead"] == 1) {
		render("dead.php", array("title" => "Death", "user" => $tmp));
	}

	render("main.php", array("title" => "Eliot Assassins", "user" => $tmp));
	exit;
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
	extract($_POST);
	if (!isset($uname, $password)) {
		render("login.php", array("alive" => $alive));
		exit;
	}
	$pass = query("SELECT * FROM users WHERE uname=?", $uname);
	if($pass == false
	|| count($pass) < 1
	|| $pass[0]["password"] != $password) {
		render("login.php", array("fail" => true, "alive" => $alive));
		exit;
	}

	header("Location: kill.php?uname=" . $uname . "&hash=" . convert($password));

} else {
	apologize("You are so wrong");
}


?>
