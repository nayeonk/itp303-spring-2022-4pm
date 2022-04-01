<?php
require "config/config.php";

$isUpdated = false;

var_dump($_POST);

// Check that the require fields are given
if ( !isset($_POST['track_name']) || empty($_POST['track_name']) 
	|| !isset($_POST['genre']) || empty($_POST['genre']) ) {

	$error = "Please fill out all required fields.";
}
else {

	// Connect to the database to update the song
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	//Cover optional field composer
	if ( isset($_POST['composer']) && !empty($_POST['composer']) ) {
		$composer = $_POST['composer'];
	} else {
		$composer = null;
	}

	// SQL statement for update
	$sql = "UPDATE tracks
	SET name = '" . $_POST["track_name"] . "', 
	genre_id = " . $_POST["genre"] ." , 
	composer = " . $composer . 
	"WHERE track_id = " . $_POST["track_id"] . ";";

	// Use Prepared Statements
	// 1. prepare sql query with user inputs as placeholders
	$statement = $mysqli->prepare("UPDATE tracks SET name = ?, genre_id = ?, composer = ? WHERE track_id = ?");

	// 2. Bind variables to the placeholders by stating each variable, along with its data type
	// 1st arg: data types
	// 2nd+ arg: alll the user inputs, in order
	$statement->bind_param("sisi", $_POST["track_name"], $_POST["genre"], $composer, $_POST["track_id"]);

	// 3. Execute the statement!
	// execute() will return false if an error occurred
	$executed = $statement->execute();
	if(!$executed) {
		echo $mysqli->error;
	}

	// Similar to insert, check affected_rows to see if update was succesful
	echo "<hr>" . $statement->affected_rows;

	if( $statement->affected_rows == 1 ) {
		$isUpdated = true;
	}
	$statement->close();

	$mysqli->close();

}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Confirmation | Song Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item"><a href="details.php?track_id=<?php echo $_POST['track_id']; ?>">Details</a></li>
		<li class="breadcrumb-item"><a href="edit_form.php?track_id=<?php echo $_POST['track_id']; ?>">Edit</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Edit Confirmation</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

		<?php if ( isset($error) && !empty($error) ) : ?>
			<div class="text-danger">
				<?php echo $error; ?>
			</div>
		<?php endif; ?>

		<?php if ($isUpdated) : ?>
			<div class="text-success">
				<span class="font-italic"><?php echo $_POST['track_name']; ?></span> was successfully edited.
			</div>
		<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="details.php?track_id=<?php echo $_POST['track_id']; ?>" role="button" class="btn btn-primary">Back to Details</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>