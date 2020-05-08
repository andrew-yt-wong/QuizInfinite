<?php
	require 'config/config.php';

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$sql = "SELECT * FROM quizzes;";
	
	$results = $mysqli->query($sql);

	if (!$results) {
		echo $mysqli->error;
		exit();
	}

	$mysqli->close();
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
	<link rel="stylesheet" type="text/css" href="css/home.css"/>

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<?php include 'nav/nav.php'; ?>
	<div class="container-fluid" id="page">
		<div class="title"></div>
		<input type="text" class="form-control" placeholder="Search Quizzes" id="search-quizzes">
		<div id="quiz-list">
		<?php while($row = $results->fetch_assoc()): ?>
			<div class="quiz">
				<div class="quiz_name"><?php echo $row['quiz_title']; ?></div>
				<hr/>
				<div class="quiz_author"><?php echo $row['quiz_author']; ?></div>
				<div class="hidden-id"><?php echo $row['quiz_id']; ?></div>
			</div>
		<?php endwhile; ?>
		</div>
	</div>

	<!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

	<script>
		$("#homepage").addClass("active");

		$("#search-quizzes").on("keyup", function() {
			$("#quiz-list").children().each(function() {
				if ($(this).find(".quiz_name").html().includes($("#search-quizzes").val()) || $(this).find(".quiz_author").html().includes($("#search-quizzes").val()))
					$(this).css("display", "block");
				else
					$(this).css("display", "none");
			});
		});

		$("#page").on("click", ".quiz", function() {
			location = "take_quiz.php?quiz_id=" + $(this).find(".hidden-id").html();
		});
	</script>

	<!-- Bootstrap -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>