<?php

function render($page_name, $values = array()) {
	extract($values); 
	require(realpath(dirname(__FILE__)) . "/../templates/header.php"); 
	require(realpath(dirname(__FILE__) . "/../templates/" . $page_name)); 
	exit;
}

function alphanumeric($string) {
	return preg_replace("/[^a-z0-9.]+/i", "", $string);
}

function isValid($uname, $hash) {
	$tmp = query("SELECT * FROM users WHERE uname=?", $uname); 
	if ($tmp == false || count($tmp) < 1) {
		throw new Exception("Nopefish"); 
	}
	
	$a = alphanumeric(crypt($tmp[0]["password"] . date("D"), date("i"))); 
	$b = alphanumeric(crypt($tmp[0]["password"] . date("D"), date("i") -1)); 	
	$c = alphanumeric(crypt($tmp[0]["password"] . date("D"), date("H"))); 
	//var_dump($a); 
	//var_dump($b); 
	//var_dump($c); 
	return ($hash == $a || $hash == $b); 
}

function convert($pw) {
	return alphanumeric(crypt($pw . date("D"), date("i"))); 
}


function query(/* $sql [, ... ] */) {
	// SQL statement
	$sql = func_get_arg(0);

	// parameters, if any
	$parameters = array_slice(func_get_args(), 1);

	// try to connect to database
	static $handle;
	if (!isset($handle)) {
		try {
			// connect to database
			$handle = new PDO("mysql:dbname=" . QUERY_DATABASE . ";host=" . QUERY_SERVER, QUERY_USERNAME, QUERY_PASSWORD);

			// ensure that PDO::prepare returns false when passed invalid SQL
			$handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
		}
		catch (Exception $e) {
			// trigger (big, orange) error
			trigger_error($e->getMessage(), E_USER_ERROR);
			exit;
		}
	}

	// prepare SQL statement
	$statement = $handle->prepare($sql);
	if ($statement === false) {
		$tmp = array(); 
		$tmp = $handle->errorInfo(); 
		
		// trigger (big, orange) error
		trigger_error($tmp[2], E_USER_ERROR);
		exit;
	}

	// execute SQL statement
	$results = $statement->execute($parameters);

	// return result set's rows, if any
	if ($results !== false) {
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	else {
		return "FAIL";
	}
}

?>
