<?php
function get_randomword($len = 10) {
    $word = array_merge(range('a', 'z'), range('A', 'Z'));
    shuffle($word);
    return substr(implode($word), 0, $len);
}


	require("../includes/config.php"); 
	
	if(!NEW_GAME_RECEIVING) {
		die("NOPEFISH"); 
	}	

	if($_SERVER["REQUEST_METHOD"] == "GET") {
		render("new_game_template.php"); 
	} else {
		echo "<p>" ;
		var_dump($_FILES); 		
		echo "</p>"; 		

		$uploaddir = "../data/"; 
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
		
		var_dump($uploadfile); 
		if(move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
			echo "<p>Uploaded file...working on moving into MySQL Table</p>"; 
		} else {
			die("Possible file upload attack!"); 
		}	
			
		$csvData = file_get_contents($uploadfile);
		$lines = explode(PHP_EOL, $csvData);
		$array = array();
		foreach ($lines as $line) {
			$array[] = str_getcsv($line);
		}
		
		echo "<p>"; 
		var_dump($array); 
		echo "</p>"; 
		
		for($i = 0; $i < 7; $i++) {
			shuffle($array); 
		}
		
		file_put_contents("../data/backup", json_encode($array)); 

		query("TRUNCATE TABLE users"); 
		query("TRUNCATE TABLE killstory"); 
		
		for($i = 0; $i < count($array); $i++) {
			$pw = get_randomword(4); 
			$to = $array[$i][1] . "@college.harvard.edu"; 
			$subject = "Your mission, should you choose to accept it is..."; 
			$message = 
				"Welcome to Eliot House Assassins. Your missions is a dangerous one and not to be taken lightly. To find your target, visit: " . URL . ". \n\n"
				. "Your username is your @college username (" . $array[$i][1] . ") and your password is: " . $pw . "\n\n"
				. "Do not show anyone your password and do not give anyone the link once you login...security is not that tight. Hence why it is dangerous...\n\n"
				. "May the odds be ever in your favor,\n\n"
				. "FDDE"; 
			$from = "From: willy@williamxiao.com\r\n";
			$bcc = "Bcc: " . ADMIN_EMAIL . "\r\n"; 
			file_put_contents("../data/mail/" . $i . ".mail", json_encode(array($to, $subject, $message, $from . $bcc))); 
			mail($to, $subject, $message, $from . $bcc);  
			query("INSERT INTO users (userid, name, uname, codename, password, dead, killed, to_kill) VALUES (?, ?,?,?,?,?,?,?)", 
				$i + 1, $array[$i][0], $array[$i][1], $array[$i][2], $pw, 0, 0, ($i == count($array) - 1 ? 1 : $i + 2));     	
		}
		
		echo "<p>Done! May the games begin.</p>"; 
	}

	

?>
