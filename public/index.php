<?php


if ($_SERVER["REQUEST_METHOD"] == "GET") {
	extract $_GET; 
	if (!isset($uname, $hash) || !isValid($uname, $hash)) {
		
		redirect("login.php"); 
	}
	
	render("main.php", array("title" => Eliot Assassins)); 
} else {
	apologize("You are like...so wrong..."); 
}

}

?>
