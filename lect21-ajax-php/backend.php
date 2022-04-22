<?php
	$php_array = [
		"first_name" => "Tommy",
		"last_name" => "Trojan",
		"age" => 21,
		"phone" => [
			"cell" => "123-123-1234",

			"home" => "456-456-4567"
		],
	];

	// whatever is echoed out, will get returned to the frontend
	// echo can only echo out STRINGS. cannot echo out associative arrays.

	// json_encode() is a function that will convert an array into a JSON string
	// echo json_encode($php_array);

	$host = "303.itpwebdev.com";
	$user = "nayeon_db_user";
	$pass = "uscItp2022!";
	$db = "nayeon_song_db";

	$mysqli = new mysqli($host, $user, $pass, $db);
	if ( $mysqli->errno ) {
		echo $mysqli->error;
		exit();
	}
	
	$sql = "SELECT * FROM tracks WHERE name LIKE '%" . $_GET["term"] ."%' LIMIT 10;";

	$results = $mysqli->query($sql);
	if ( !$results ) {
		echo $mysqli->error;
		exit();
	}
	// Create an array that will be filled with results which will be sent to the front-end
	$results_array = [];

	// fill the results array with the results
	while( $row = $results->fetch_assoc()) {
		array_push($results_array, $row);
	}

	// Convert the results into a string
	echo json_encode($results_array);

	$mysqli->close();


?>