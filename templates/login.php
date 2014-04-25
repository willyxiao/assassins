<html>
<head>
	<title><?= (isset($fail) ? "Error" : "Assassin")  ?></title>
</head>
<body>
	<form action="kill.php" method="POST">
	<input type="text" name="uname" placeholder="@FAS Username"></input>
	<input type="text" name="password" placeholder="Password"></input>
	<input type="submit"></input>
	</form>
</body>
</html>
