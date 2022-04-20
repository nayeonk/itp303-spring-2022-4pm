<?php
//session_start();// have to call session_start() before anything else

require '../config/config.php';

// Giant if statement here. If user is NOT logged in, do the usual things. Check password, etc etc. Else, redirect the user out of this page
if( !isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {

	// There are two ways for user to get to this page. If they simply clicked on a link to get to login.php, they used a GET request. Therefore the below if statement will not be run
	// If user is actually submitting the form, it would be via the POST request. Therefore the below if statement will run.
	if ( isset($_POST['username']) && isset($_POST['password']) ) {
		// Check if username and password fields have been submitted
		if ( empty($_POST['username']) || empty($_POST['password']) ) {

			$error = "Please enter username and password.";

		}
		else {
			// user has provided username and password. Connect to the database and check if this username/password combination is correct!
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			if($mysqli->connect_errno) {
				echo $mysqli->connect_error;
				exit();
			}

			// hash the user's password input
			$passwordInput = hash("sha256", $_POST["password"]);

			// Search the users table. See if there is a record with the given username AND password
			$sql = "SELECT * FROM users
						WHERE username = '" . $_POST['username'] . "' AND password = '" . $passwordInput . "';";

			echo "<hr>" . $sql . "<hr>";
			
			$results = $mysqli->query($sql);

			if(!$results) {
				echo $mysqli->error;
				exit();
			}

			// If the username/password combo is correct, there should be only ONE record returned.
			if($results->num_rows == 1) {
				// Username/password combo is correct! Log the user in.

				// Store some user info in session
				$_SESSION["logged_in"] = true;
				$_SESSION["username"] = $_POST["username"];

				// Redirect the user to the home page (index.php)
				// header() function makes a GET request
				// header("Location: https://www.google.com");
				header("Location: ../song-db/index.php");
			
			}
			else {
				$error = "Invalid username or password.";
			}
		} 
	}
}
else {
	// Redirect the user out of this page
	header("Location: ../song-db/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login | Song Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<?php include '../song-db/nav.php'; ?>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Login</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<form action="login.php" method="POST">

			<div class="row mb-3">
				<div class="font-italic text-danger col-sm-9 ml-sm-auto">
					<!-- Show errors here. -->
					<?php
						if ( isset($error) && !empty($error) ) {
							echo $error;
						}
					?>
				</div>
			</div> <!-- .row -->
			

			<div class="form-group row">
				<label for="username-id" class="col-sm-3 col-form-label text-sm-right">Username:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="username-id" name="username">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="password-id" class="col-sm-3 col-form-label text-sm-right">Password:</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="password-id" name="password">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Login</button>
					<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Cancel</a>
				</div>
			</div> <!-- .form-group -->
		</form>

		<div class="row">
			<div class="col-sm-9 ml-sm-auto">
				<a href="register_form.php">Create an account</a>
			</div>
		</div> <!-- .row -->

	</div> <!-- .container -->
</body>
</html>