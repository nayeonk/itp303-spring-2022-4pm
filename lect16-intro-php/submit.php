<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Intro to PHP</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Intro to PHP</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">
		<div class="row">

			<h2 class="col-12 mt-4 mb-3">PHP Output</h2>

			<div class="col-12">
				<!-- Display Test Output Here -->
				<?php
					// Comments
					/* multi-line comments*/
					# comments
					echo "Hello World!";
					echo "<hr>";
					echo "<strong>Hello</strong>";

					// ---- Variables
					$name = "Tommy";
					$age = 21;
					echo "<hr>";
					echo $name;
					echo "<hr>";

					// ---- Concatenation (use period)
					echo "My name is " . $name;
					echo "<hr>";
					// using double quotes for strings allows us to use interpolation
					echo "My name is $name";
					echo 'My name is $name';

					// ---- DATE/TIME
					// Set the timezone we want to use
					date_default_timezone_set("America/Los_Angeles");

					// Can get the current date/time using date()
					echo "<hr><br/>";
					echo date("m-d-y H:i");

					// ---- Arrays 
					$colors = ["red", "blue", "green"];
					echo "<hr>";
					echo $colors[0];

					// ASSOCIATIVE ARRAYS
					// stores key/value pairs
					// keys have to a string always
					// value can be any data type
					$courses = [
						"ITP 303" => "Full-stack Web Development",
						"ITP 404" => "Advanced Front-End Web Development",
						"ITP 405" => "Advanced Back-End Web Development"
					];
					echo "<hr>";
					foreach($courses as $courseNumber => $courseName) {
						echo $courseNumber . ": " . $courseName;
						echo "<br>";
					}
					echo "<hr>";
					echo $courses["ITP 303"];
					echo "<hr>";

					// Use this to quickly dump out what a variable holds
					var_dump($courses);
					echo "<hr>";

					// ---- SUPERGLOBAL variables
					// exist everywhere in PHP
					// prefixed with $_
					var_dump($_SERVER);
					echo "<hr>";
					echo $_SERVER["HTTP_HOST"];

					echo "<hr>";
					echo "GET superglobal here: <br/>";
					var_dump($_GET);

					echo "<hr>";
					echo "POST superglobal here: <br/>";
					var_dump($_POST);


				?>
			</div>

		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">
		<div class="row">

			<h2 class="col-12 mt-4">Form Data</h2>

		</div> <!-- .row -->

		<div class="row mt-3">
			<div class="col-3 text-right">Name:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				
				<?php 
					// isset() - is this variable name set? Does it exist?
					// emtpy() - is this variable empty or blank?
					if( isset($_POST["name"]) && !empty($_POST["name"])) {
						echo $_POST["name"];
					}
					else {
						echo "Name is empty. Please type in your name.";
					}
					 
				?>

			</div>
		</div> <!-- .row -->
		<div class="row mt-3">
			<div class="col-3 text-right">Email:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				<?php
					if( isset($_POST["email"]) && !empty($_POST["email"])) {
						echo $_POST["email"];
					}
					else {
						echo "Email is empty. Please type in your email.";
					}
				?>

			</div>
		</div> <!-- .row -->
		<div class="row mt-3">
			<div class="col-3 text-right">Current Student:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				<?php
					if( isset($_POST["current-student"]) && !empty($_POST["current-student"])) {
						echo $_POST["current-student"];
					}
					else {
						echo "Not provided.";
					}
				?>

			</div>
		</div> <!-- .row -->
		<div class="row mt-3">
			<div class="col-3 text-right">Subscribe:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				<?php
					if( isset($_POST["subscribe"]) && !empty($_POST["subscribe"])) {
						// Foreach loop to iterate
						foreach ( $_POST["subscribe"] as $sub ) {
							echo $sub . ", ";
						}
					}
					else {
						// class text-danger is coming from bootstrap
						echo "<div class='text-danger'>Not provided.</div>";
					}
				?>

			</div>
		</div> <!-- .row -->
		<div class="row mt-3">
			<div class="col-3 text-right">Subject:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				
			</div>
		</div> <!-- .row -->
		<div class="row mt-3">
			<div class="col-3 text-right">Message:</div>
			<div class="col-9">
				<!-- Display Form Data Here -->
				
			</div>
		</div> <!-- .row -->

		<div class="row mt-4 mb-4">
			<a href="form.php" role="button" class="btn btn-primary">Back to Form</a>
		</div> <!-- .row -->

	</div> <!-- .container -->
	
</body>
</html>