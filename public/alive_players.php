<?php
  require("../includes/config.php");

  $results = query("SELECT name FROM users WHERE dead != 1 ORDER BY name DESC");

  $alive_players = array();
  foreach($results as $result){
    $alive_players[] = $result['name'];
  }

  render("alive_players.php", array("title" => "Alive", "alive_players" => $alive_players));

?>