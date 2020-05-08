<?php
	require 'config/config.php';

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$sql_find_quiz = "SELECT * FROM quizzes WHERE quiz_id = " . $_GET['quiz_id'] . ";";
	
	$results_find_quiz = $mysqli->query($sql_find_quiz);
	if (!$results_find_quiz) {
		echo $mysqli->error;
		exit();
	}

	$quiz = $results_find_quiz->fetch_assoc();

	$sql_responses = "SELECT * FROM responses WHERE quiz_id = " . $_GET['quiz_id'] . ";";
	$results_responses = $mysqli->query($sql_responses);
	if (!$results_responses) {
		echo $mysqli->error;
		exit();
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
	<link rel="stylesheet" type="text/css" href="css/quiz_studio.css"/>

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<?php include 'nav/nav.php'; ?>
	<form action="quiz_studio.php" method="POST">
		<div class="container-fluid" id="responsepage">
			<div id="my-quiz-nav">
				<span class="quiz-nav" id="edit-nav">Edit Quiz</span>
				<span class="quiz-nav" id="resp-nav">Responses</span>
			</div>
			<div id="responses">
				<hr>
				<div class="row">
					<div class="col head">Question</div>
					<div class="col head">Response</div>
					<div class="col head">User</div>
				</div>
				<hr>
				<?php while ($row = $results_responses->fetch_assoc()): ?>
					<div class="row">
						<div class="col"><?php echo $row['question']; ?></div>
						<div class="col"><?php echo $row['response']; ?></div>
						<div class="col"><?php echo $row['user']; ?></div>
					</div>
					<hr>
				<?php endwhile; ?>
			</div>
		</div>
	</form>

	<div id="extra-margin"></div>

	<!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

	<script src="js/create_quiz.js"></script>

	<script>
		function ajaxGet(endpointUrl, returnFunction) {
			let xhr = new XMLHttpRequest();
			xhr.open('GET', endpointUrl, false);
			xhr.onreadystatechange = function() {
				if (xhr.readyState == XMLHttpRequest.DONE) {
					if (xhr.status == 200) {
						returnFunction(xhr.responseText);
					}
					else {
						alert('AJAX Error.');
						console.log(xhr.status);
					}
				}
			}
			xhr.send();
		}

		$("#resp-nav").css("background-color", "#7953A9");

		$("#edit-nav").on("click", function() {
			let quiz_title = "<?php echo $quiz['quiz_title']; ?>";
			let quiz_desc = "<?php echo $quiz['quiz_desc']; ?>";
			location = "edit_quiz.php?quiz_title=" + quiz_title + "&quiz_desc=" + quiz_desc;
		});
	</script>

	<?php $mysqli->close(); ?>

	<!-- Bootstrap -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>