<?php
	require("../includes/config.php"); 

	if(RESHUFFLE_ACCEPTING == false) {
		die("Nooooope;"); 
	}

	$alive = query("SELECT userid FROM users WHERE dead != 1"); 

    echo "<p>"; 
    var_dump($alive); 
    echo "</p>"; 
    
	shuffle($alive); 
	
    echo "<p>"; 
    var_dump($alive); 
    echo "</p>"; 
    
	for($i = 0; $i < count($alive); $i++) {
		$query = "UPDATE users SET to_kill=" 
            . ($i == count($alive) - 1 ? $alive[0]['userid'] : $alive[$i + 1]['userid'])
            . " WHERE userid=" . $alive[$i]['userid'];
        echo "<p>" . $query . "</p>"; 
        
        if(RESHUFFLE_ACCEPTING == true) {
            query($query); 
        }
	}

?>
