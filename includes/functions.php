<?php

function render($page_name, $values) {
	extract $values; 
	require("../templates/" . $page_name); 
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
