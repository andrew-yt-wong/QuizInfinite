<?php
	require 'config/config.php';

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$sql_find_quiz = "SELECT quiz_id FROM quizzes WHERE quiz_author = '" . $_SESSION['user'] . "' AND quiz_title = '" . $_GET['quiz_title'] . "' AND quiz_desc = '" . $_GET['quiz_desc'] . "';";
	
	$results_find_quiz = $mysqli->query($sql_find_quiz);
	if (!$results_find_quiz) {
		echo $mysqli->error;
		exit();
	}
	$quiz_id = $results_find_quiz->fetch_assoc()['quiz_id'];

	$sql_questions = "SELECT * FROM questions WHERE quiz_id = " . $quiz_id . ";";
	$results_questions = $mysqli->query($sql_questions);
	if (!$results_questions) {
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
		<div class="container-fluid" id="page">
			<div id="my-quiz-nav">
				<span class="quiz-nav" id="edit-nav">Edit Quiz</span>
				<span class="quiz-nav" id="resp-nav">Responses</span>
			</div>
			<div>
				<div class="quiz-title">
					<div class="row">
						<input type="text" name="quiz-title" placeholder="Title" value="<?php echo $_GET['quiz_title']; ?>" id="quiz-title">
					</div>
					<hr id="titlehr"/>
					<div class="row">
						<input type="text" name="quiz-desc" placeholder="Description" value="<?php echo $_GET['quiz_desc']; ?>" id="quiz-desc">
					</div>
					<hr id="deschr"/>
				</div>
				<?php while ($row = $results_questions->fetch_assoc()): ?>
					<?php
						$sql_options = "SELECT * FROM options WHERE question_id = " . $row['question_id'] . ";";
						$results_options = $mysqli->query($sql_options);
						if (!$results_options) {
							echo $mysqli->error;
							exit();
						}

						if ($row['question_type'] == "short_answer") {
							$menu = '<i class="fas fa-grip-lines"></i> Short Answer';
							$question_type = '<i class=\"far fa-circle\"></i>';
						}
						else if ($row['question_type'] == "multiple_choice") {
							$menu = '<i class="far fa-dot-circle"></i> Multiple Choice';
							$question_type = '<i class="far fa-circle"></i>';
						}
						else if ($row['question_type'] == "checkboxes") {
							$menu = '<i class="fas fa-check-square"></i> Checkboxes';
							$question_type = '<i class="far fa-square"></i>';
						}
						else {
							$menu = '<i class="fas fa-caret-square-down"></i> Dropdown';
							$question_type = '<i class="far fa-caret-square-down"></i>';
						}
					?>
					<div class="question">
						<div class="row">
							<div class="col-lg-7 col-md-8 col-sm-12">
								<input type="text" class="question-name" placeholder="Question" value="<?php echo $row['question'];?>" name="question-name">
								<hr/>
							</div>
							<div class="col-lg-5 col-md-4 col-sm-12">
								<div class="dropdown">
									<button class="btn dropdown-toggle dropdownMenuButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $menu; ?></button>
									<div class="dropdown-menu">
										<div class="dropdown-item"><i class="fas fa-grip-lines"></i> Short Answer</div>
										<div class="dropdown-item"><i class="far fa-dot-circle"></i> Multiple Choice</div>
										<div class="dropdown-item"><i class="fas fa-check-square"></i> Checkboxes</div>
										<div class="dropdown-item"><i class="fas fa-caret-square-down"></i> Dropdown</div>
									</div>
								</div>
							</div>
						</div>
						<div class="short-answer">
							<label>Short Answer</label>
							<hr/>
						</div>
						<div class="option-list">
							<?php while ($option_row = $results_options->fetch_assoc()): ?>
								<div class="option">
									<label><?php echo $question_type; ?></label><input type="text" class="option-input" placeholder="Option" value="<?php echo $option_row['option']; ?>"/><i class="fas fa-times delete-option"></i><hr/>
								</div>
							<?php endwhile; ?>
						</div>
						<i class="fas fa-plus-square add-option"></i>
						<i class="fas fa-trash delete-question"></i>
					</div>
				<?php endwhile; ?>
			</div>
			<i class="fas fa-plus-square add-question"></i>
			<div>
				<button type="button" class="btn btn-warning" id="submit-edits">Submit Edits</button>
				<button type="button" class="btn btn-danger" id="delete-quiz">Delete Quiz</button>
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

		$("#edit-nav").css("background-color", "#7953A9");

		function fixShortAns() {
			let $questions = $(".question");
			for (let i = 0; i < $questions.length; ++i) {
				if ($($questions.get(i)).find(".dropdownMenuButton").html() == "<i class=\"fas fa-grip-lines\" aria-hidden=\"true\"></i> Short Answer") {
					$($questions.get(i)).find(".short-answer").css("display", "block");
					$($questions.get(i)).find(".add-option").css("display", "none");
				}
			}
		}

		fixShortAns();

		$("#delete-quiz").on("click", function() {
			let quiz_id = "<?php echo $quiz_id; ?>";
			ajaxGet("db/db_quiz_deletion.php?quiz_id=" + quiz_id, function(results) {});
			location = "quiz_studio.php";
		});

		$("#submit-edits").on("click", function() {
			let quiz_id = "<?php echo $quiz_id; ?>";
			let quiz_title = $("#quiz-title").val();
			let quiz_desc = $("#quiz-desc").val();
			ajaxGet("db/db_quiz_edit.php?quiz_id=" + quiz_id + "&quiz_title=" + quiz_title + "&quiz_desc=" + quiz_desc, function(results) {});
			let $questions = $(".question");
			for (let i = 0; i < $questions.length; ++i) {
				let question = $($questions.get(i)).find(".question-name").val();
				let question_type = $($questions.get(i)).find(".dropdownMenuButton").html();
				if (question_type == "<i class=\"fas fa-grip-lines\" aria-hidden=\"true\"></i> Short Answer")
					question_type = "short_answer";
				else if (question_type == "<i class=\"far fa-dot-circle\" aria-hidden=\"true\"></i> Multiple Choice")
					question_type = "multiple_choice";
				else if (question_type == "<i class=\"fas fa-check-square\" aria-hidden=\"true\"></i> Checkboxes")
					question_type = "checkboxes";
				else
					question_type = "dropdown";
				ajaxGet("db/db_question_creation.php?question=" + question + "&question_type=" + question_type + "&quiz_id=" + quiz_id, function(results) {
					let question_id = parseInt(results);

					if (question_type != "short_answer") {
						let $options = $($questions.get(i)).find(".option-list").children();
						for (let j = 0; j < $options.length; ++j) {
							let option = $($options.get(j)).find(".option-input").val();
							ajaxGet("db/db_option_creation.php?option=" + option + "&question_id=" + question_id, function(results) {});
						}
					}
				});
			}
			location = "quiz_studio.php";
		});

		$("#resp-nav").on("click", function() {
			let quiz_id = "<?php echo $quiz_id; ?>";
			location = "quiz_responses.php?quiz_id=" + quiz_id;
		});
	</script>

	<?php $mysqli->close(); ?>

	<!-- Bootstrap -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>