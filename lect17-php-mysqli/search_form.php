<?php
// ---- STEP 1. Establish a database connection
// Store database credentials
$host = "303.itpwebdev.com";
$user = "nayeon_db_user";
$password = "uscItp2022!";
$db = "nayeon_song_db";

// Create an instance of the mysqli class
// When creating an instance of the mysqli class, mysqli class will also attempt to connect to the database using the credentials provided
$mysqli = new mysqli($host, $user, $password, $db);

//  Check for database connection errors right away
// connect_errno returns a error number if there was an error. will return false if no error was detected
if($mysqli->connect_errno) {
	// display the error message in plain english
	echo $mysqli->connect_error;
	// Terminate the program. PHP stops running after this statement and does not run any subsequent code.
	exit();
}

// ---- STEP 2: Generate & submit SQL query
$sql = "SELECT * FROM genres;";

// Submit the query to the database using query()
// query() will return information about the results
$results = $mysqli->query($sql);
// $results will be false if there were any errors in receiving the result
if(!$results) {
	// display the error message
	echo $mysqli->error;
	exit();
}

// ---- STEP 3: Display results
var_dump($results);
echo "<hr>";
echo "Number of results: " . $results->num_rows;

// fetch_assoc() - returns one result as an associative array
// echo "<hr>";
// var_dump($results->fetch_assoc());
// echo "<hr>";
// var_dump($results->fetch_assoc());

// fetch_assoc() will return NULL when it gets to the last result
// $row is a temporary variable that will store the fetch_assoc() result for that iteration
while($row = $results->fetch_assoc()) {
	echo "<hr>";
	var_dump($row);
}

// When you want to "reset" fetch_assoc() to show the first of the results again (not NULL) use data_seek()
$results->data_seek(0);

// echo "<hr>";
// var_dump($results->fetch_assoc());

$sql_media = "SELECT * FROM media_types;";
$results_media = $mysqli->query($sql_media);
// $results will be false if there were any errors in receiving the result
if(!$results_media) {
	// display the error message
	echo $mysqli->error;
	exit();
}

// ---- STEP 4: Close the db connection
$mysqli->close();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Song Search Form</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<style>
		.form-check-label {
			padding-top: calc(.5rem - 1px * 2);
			padding-bottom: calc(.5rem - 1px * 2);
			margin-bottom: 0;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Song Search Form</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">

		<form action="search_results.php" method="GET">

			<div class="form-group row">
				<label for="name-id" class="col-sm-3 col-form-label text-sm-right">Track Name:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="name-id" name="track_name">
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="genre-id" class="col-sm-3 col-form-label text-sm-right">Genre:</label>
				<div class="col-sm-9">

<select name="genre" id="genre-id" class="form-control">
	<option value="" selected>-- All --</option>

	<?php
		// while($row = $results->fetch_assoc()) {
		// 	echo "<option value='" . $row["genre_id"] . "'>" . $row["name"] . "</option>";
		// }
	?>

	<!-- Alternate PHP syntax -->
	<?php while($row = $results->fetch_assoc()): ?>
		<option value="<?php echo $row["genre_id"] ?>">
			<?php echo $row["name"]; ?>
		</option>
	<?php endwhile; ?>

	<!-- <option value='1'>Rock</option>
	<option value='2'>Jazz</option>
	<option value='3'>Metal</option>
	<option value='4'>Alternative & Punk</option>
	<option value='5'>Rock And Roll</option> -->

</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="media-type-id" class="col-sm-3 col-form-label text-sm-right">Media Type:</label>
				<div class="col-sm-9">
					<select name="media_type" id="media-type-id" class="form-control">
						<option value="" selected>-- All --</option>

						<!-- Alternate PHP syntax -->
						<?php while($row = $results_media->fetch_assoc()): ?>
							<option value="<?php echo $row["media_type_id"] ?>">
								<?php echo $row["name"]; ?>
							</option>
						<?php endwhile; ?>

					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Search</button>
					<button type="reset" class="btn btn-light">Reset</button>
				</div>
			</div> <!-- .form-group -->
		</form>
	</div> <!-- .container -->
</body>
</html>