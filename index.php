<?php
	require 'config/config.php';
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
	<link rel="stylesheet" type="text/css" href="css/index.css"/>

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<div class="container-fluid" id="page">
		<div id="intro">
			<h1 id="title">QuizInfinite</h1>
			<div id="navigation">
				<ul id="nav" class="nav justify-content-center">
				  	<li class="nav-item">
				    	<a class="nav-link" href="home.php">HOME</a>
				  	</li>
				  	<?php if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) { ?>
				  	<?php } else { ?>
				  		<li class="nav-item">
					    	<a class="nav-link" href="quiz_studio.php">QUIZ STUDIO</a>
					  	</li>
					<?php } ?>
				  	<li class="nav-item">
				    	<a class="nav-link" href="https://github.com/andrew-yt-wong/QuizInfinite">GITHUB</a>
				 	</li>
				 	<?php if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) { ?>
					  	<li class="nav-item">
					    	<a class="nav-link" href="login-signup.php">LOGIN / SIGNUP</a>
					  	</li>
				  	<?php } else { ?>
				  		<li class="nav-item">
					    	<a class="nav-link" href="logout.php">LOGOUT</a>
					  	</li>
				  	<?php } ?>
				</ul>
			</div>
			<hr/>
			<div class="head" id="head1">Welcome to QuizInfinite!</div>
			<div class="head" id="head2">Build great-looking online quizzes that hook people in.</div>
			<div class="head" id="head3">QuizInfinite's quiz builder is fast, easy-to-use, and intuitive.</div>
		</div>
	</div>

	<!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

	<script>
		$("#title").slideDown(500);
		$("#title").fadeIn(500);
		$("#navigation").slideDown(600);
		$("#navigation").fadeIn(600);
		$("hr").slideDown(700);
		$("hr").fadeIn(700);
		$("#head1").slideDown(800);
		$("#head1").fadeIn(800);
		$("#head2").slideDown(900);
		$("#head2").fadeIn(900);
		$("#head3").slideDown(1000);
		$("#head3").fadeIn(1000);

		$(".nav-link").hover(function() {
			if ($(this).css("opacity") == "1")
				$(this).css("opacity", "0.5");
			else
				$(this).css("opacity", "1");
		});
	</script>

	<!-- Bootstrap -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>