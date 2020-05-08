<?php
	require 'config/config.php';

	if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {

		// Check if user username/password POST exists
		if (isset($_POST['login-username']) && isset($_POST['login-password'])) {

			// If username OR password was not filled out
			if (empty($_POST['login-username']) || empty($_POST['login-password'])) {
				$loginerror = "Please enter username and password.";
			}

			// User filled out username AND password. Need to check that the username/password combination is correct
			else {
				$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
				if($mysqli->connect_errno) {
					echo $mysqli->connect_error;
					exit();
				}

				// Hash the password user typed in. Use this hased version to compare it to the pw saved in the DB.
				$passwordInput = hash("sha256", $_POST["login-password"]);

				// Search the users table, look for the username & pw combo that the user entered
				$sql = "SELECT * FROM users
							WHERE username = '" . $_POST['login-username'] . "' AND password = '" . $passwordInput . "';";
				
				$results = $mysqli->query($sql);

				if (!$results) {
					echo $mysqli->error;
					exit();
				}

				// If there is a match, we will get at least one record back
				if ($results->num_rows > 0) {
					$_SESSION["user"] = $_POST["login-username"];
					$_SESSION["logged_in"] = true;

					// Redirect the logged in user to the home page
					header("Location: home.php");
				}
				else {
					$loginerror = "Invalid username or password.";
				}
				$mysqli->close();
			} 
		}

		// Check if user username/password POST exists
		if (isset($_POST['signup-username']) && isset($_POST['signup-email']) && isset($_POST['signup-password']) && isset($_POST['signup-cpassword'])) {

			// If username OR password was not filled out
			if (empty($_POST['signup-username']) || empty($_POST['signup-email']) || empty($_POST['signup-password']) || empty($_POST['signup-cpassword'])) {
				$signuperror = "Please fill in all fields.";
			}

			// User filled out username AND password. Need to check that the username/password combination is correct
			else {
				$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
				if($mysqli->connect_errno) {
					echo $mysqli->connect_error;
					exit();
				}

				// Search the users table, look for the username & pw combo that the user entered
				$sql = "SELECT * FROM users
							WHERE username = '" . $_POST['signup-username'] . "' AND email = '" . $_POST['signup-email'] . "';";
				
				$results = $mysqli->query($sql);

				if (!$results) {
					echo $mysqli->error;
					exit();
				}

				// If there is a match, we will get at least one record back
				if ($results->num_rows > 0) {
					$signuperror = "Username or email already taken.";
				}
				else {
					if ($_POST["signup-password"] == $_POST["signup-cpassword"]) {
						// Hash the password user typed in. Use this hased version to compare it to the pw saved in the DB.
						$password = hash("sha256", $_POST["signup-password"]);
						$sql_signup = "INSERT INTO users(username, email, password) VALUES('" . $_POST["signup-username"] ."','" 
										. $_POST["signup-email"] . "','" . $password . "');";
						$results_signup = $mysqli->query($sql_signup);
						if(!$results_signup) {
							echo $mysqli->error;
							exit();
						}
						$_SESSION["user"] = $_POST["signup-username"];
						$_SESSION["logged_in"] = true;

						// Redirect the logged in user to the home page
						header("Location: home.php");
					}
					else {
						$signuperror = "Passwords don't match.";
					}
				}
				$mysqli->close();
			} 
		}
	}
	else {

		// Logged in user will ge redirected
		header("Location: home.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>QuizInfinite</title>

	<!-- Shortcut Icon -->
	<link rel="shortcut icon" type="image/png" href="img/icon.png">

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">

	<!-- Stylesheets -->
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<link rel="stylesheet" type="text/css" href="css/login-signup.css"/>

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<?php include 'nav/nav.php'; ?>
	<div class="container-fluid" id="page">
		<div class="forms">
			<div id="myrow">
				<div class="col" id="login">
					<form action="login-signup.php" method="POST" class="login-form">
						<div class="logintitle">Login</div>
						<div class="form-group">
							<label class="form-check-label" for="login-username">Username</label>
							<input type="text" class="form-control" name="login-username" id="login-username" placeholder="Username">
							<label class="form-check-label" for="login-password">Password</label>
							<input type="password" class="form-control" name="login-password" id="login-password" placeholder="Password">
							<button type="submit" class="form-control btn btn-danger">
								<i class="fas fa-sign-in-alt"></i> Sign In
							</button>
							<div id="login-error" class="text-danger font-italic">
								<?php
									if (isset($loginerror) && !empty($loginerror)) {
										echo $loginerror;
									}
								?>
							</div>
							<img src="img/mathematical.png" alt="mathematical"/>
						</div>
					</form>
				</div>
				<div class="col" id="signup">
					<form action="login-signup.php" method="POST" class="signup-form">
						<div class="logintitle">Sign Up</div>
						<div class="form-group">
							<label class="form-check-label" for="signup-email">Email</label>
							<input type="email" class="form-control" name="signup-email" id="signup-email" placeholder="Email">
							<label class="form-check-label" for="signup-username">Username</label>
							<input type="text" class="form-control" name="signup-username" id="signup-username" placeholder="Username">
							<label class="form-check-label" for="signup-password">Password</label>
							<input type="password" class="form-control" name="signup-password" id="signup-password" placeholder="Password">
							<label class="form-check-label" for="signup-cpassword">Confirmation Password</label>
							<input type="password" class="form-control" name="signup-cpassword" id="signup-cpassword" placeholder="Confirm Password">
							<button type="submit" class="form-control btn btn-danger">
								<i class="fas fa-user-plus"></i> Create Account
							</button>
							<div id="create-error" class="text-danger font-italic">
								<?php
									if (isset($signuperror) && !empty($signuperror)) {
										echo $signuperror;
									}
								?>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

	<script>
		function loadWidth() {
			let width = $(window).width();
			if (width >= 991)
				$("#myrow").addClass("row");
			else
				$("#myrow").removeClass("row");
		}

		$(window).resize(function() {
			let width = $(this).width();
			if (width >= 991)
				$("#myrow").addClass("row");
			else
				$("#myrow").removeClass("row");
		});

		loadWidth();

		$("#loginpage").addClass("active");
	</script>

	<!-- Bootstrap -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>