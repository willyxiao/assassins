<?php 
	$alive = query("SELECT count(*) as alive FROM users WHERE dead != 1"); 
	$alive = $alive[0]["alive"]; 
?>

<html>
<head>
	<title><?= "Assassin" ?></title>
	<link href="css/normalize.css" rel="stylesheet" >
	<link href="css/foundation.css" rel="stylesheet" >
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
	<script src="js/vendor/modernizr.js"></script>
	<link rel="icon" type="image/png" href="img/logo.png">
</head>
<body>
<?php require("../data/google_analytics.php"); ?>
<nav class="top-bar" data-topbar>
  <ul class="title-area">
    <li class="name">
      <h1><a href="/">Eliot Assassins</a></h1>
    </li>
    <li class="toggle-topbar menu-icon"><a href="#">Menu</a></li>
  </ul>
  <section class="top-bar-section">
    <ul class="right">
    	<li class="active"><a href="alive_players.php"><?= $alive ?> Left</a></li>
    </ul>
    <ul class="left">
        <li class="active"><a href="rules.php">Rules</a></li>
    </ul>
  </section>
</nav>
