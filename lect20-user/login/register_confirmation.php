<?php

require '../config/config.php';

var_dump($_POST);

// server-side validation check. Second layer of defense. Make sure required fields have been submitted.
if ( !isset($_POST['email']) || empty($_POST['email'])
	|| !isset($_POST['username']) || empty($_POST['username'])
	|| !isset($_POST['password']) || empty($_POST['password']) ) {
	$error = "Please fill out all required fields.";
}

else {
	// Connect to the database and insert this user into the users table
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	// Check the users table and see if username or email address already exists
	$statement_registered = $mysqli->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
	$statement_registered->bind_param("ss", $_POST["username"], $_POST["email"]);
	$executed_registered = $statement_registered->execute();
	if(!$executed_registered) {
		echo $mysqli->error;
	}
	// prepared statement for SELECT require an extra method to get result
	$statement_registered->store_result();
	// $statement->num_rows will return how many results we got back.
	$numrows = $statement_registered->num_rows;
	echo "<hr> $numrows";
	$statement_registered->close();

	// if there is more than one match of the same username/email
	if( $numrows > 0) {
		$error = "Username or email address has already been taken. Please choose another one.";
	}
	else {
		// Hash the password
		// 1st arg: the hashing algorithm
		// 2nd arg: the string you want to hash
		$password = hash("sha256", $_POST["password"]);
		echo "<hr>" . $password . "<hr>";

		$password2 = hash("sha256", "usc");
		echo $password2 . "<hr>";


		// Write SQL to insert this user into the table
		$statement = $mysqli->prepare("INSERT INTO users(username, email, password) VALUES(?,?,?)");

		$statement->bind_param("sss", $_POST["username"], $_POST["email"], $password);
		$executed = $statement->execute();
		if(!$executed) {
			echo $mysqli->error;
		}
		$statement->close();
	}
	$mysqli->close();
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registration Confirmation | Song Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">User Registration</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger"><?php echo $error; ?></div>
				<?php else : ?>
					<div class="text-success"><?php echo $_POST['username']; ?> was successfully registered.</div>
				<?php endif; ?>
		</div> <!-- .col -->
	</div> <!-- .row -->

	<div class="row mt-4 mb-4">
		<div class="col-12">
			<a href="login.php" role="button" class="btn btn-primary">Login</a>
			<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Back</a>
		</div> <!-- .col -->
	</div> <!-- .row -->

</div> <!-- .container -->

</body>
</html>