<?php
	require 'config/config.php';

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$sql_quiz = "SELECT * FROM quizzes WHERE quiz_id = " . $_GET['quiz_id'] . ";";
	
	$results_quiz = $mysqli->query($sql_quiz);

	if (!$results_quiz) {
		echo $mysqli->error;
		exit();
	}

	$quiz = $results_quiz->fetch_assoc();

	$sql_questions = "SELECT * FROM questions WHERE quiz_id = " . $_GET['quiz_id'] . ";";
	
	$results_questions = $mysqli->query($sql_questions);

	if (!$results_questions) {
		echo $mysqli->error;
		exit();
	}

	$user = null;

	if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"])
		$user = "anonymous";
	else
		$user = $_SESSION["user"];
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
	<div class="container-fluid" id="page">
		<div>
			<div class="quiz-title">
				<div class="row">
					<div id="quiz-title"><?php echo $quiz['quiz_title']?></div>
				</div>
				<hr id="titlehr"/>
				<div class="row">
					<div id="quiz-desc"><?php echo $quiz['quiz_desc']?></div>
				</div>
				<hr id="deschr"/>
			</div>
			<?php while ($question = $results_questions->fetch_assoc()): ?>
				<div class="question">
					<div class="row">
						<div class="question-name"><?php echo $question['question'] ?></div>
						<div class="hidden-desc"><?php echo $question['question_type'] ?></div>
						<div class="hidden-id"><?php echo $question['question_id'] ?></div>
					</div>
					<?php
						$sql_options = "SELECT * FROM options WHERE question_id = " . $question['question_id'] . ";";

						$results_options = $mysqli->query($sql_options);

						if (!$results_options) {
							echo $mysqli->error;
							exit();
						}
						if ($question['question_type'] == "short_answer") { 
					?>
						<input type="text" class="short-answer-option" placeholder="Response" value="Response"/><hr/>
					<?php } else if ($question['question_type'] == "multiple_choice") { ?>
						<form class="option-list">
						<?php while ($option = $results_options->fetch_assoc()): ?>
							<div class="radio">
								<label><input type="radio" name="optradio" value="<?php echo $option['option']; ?>"> <?php echo $option['option']; ?></label>
							</div>
						<?php endwhile; ?>
						</form>
					<?php } else if ($question['question_type'] == "checkboxes") { ?>
						<form class="option-list">
						<?php while ($option = $results_options->fetch_assoc()): ?>
							<div class="checkbox">
								<label><input type="checkbox" name="optcheckbox" value="<?php echo $option['option']; ?>"> <?php echo $option['option']; ?></label>
							</div>
						<?php endwhile; ?>
						</form>
					<?php } else { ?>
						<form class="option-list">
							<div class="form-group">
								<select class="form-control">
									<?php while ($option = $results_options->fetch_assoc()): ?>
										<option><?php echo $option['option']; ?></option>
									<?php endwhile; ?>
								</select>
							</div>
						</form>
					<?php } ?>
				</div>
			<?php endwhile; ?>
		</div>
		<div><button type="button" class="btn btn-info" id="submit-quiz">Submit</button></div>
	</div>

	<div id="extra-margin"></div>

	<!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

	<script>
		let user = "<?php echo $user; ?>";
		let quiz_id = "<?php echo $_GET['quiz_id']; ?>";

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

		$("#submit-quiz").on("click", function(event) {
			$questions = $(".question");
			for (let i = 0; i < $questions.length; ++i) {
				let question = $($questions.get(i)).find(".question-name").html();
				let answer = null;
				if ($($questions.get(i)).find(".hidden-desc").html() == "short_answer") {
					answer = $($questions.get(i)).find(".short-answer-option").val();
					if (answer == "") 
						answer = "No Response";
				}
				else if ($($questions.get(i)).find(".hidden-desc").html() == "multiple_choice") {
					answer = $($questions.get(i)).find("input:checked").val();
					if (answer == null) 
						answer = "No Response";
				}
				else if ($($questions.get(i)).find(".hidden-desc").html() == "checkboxes") {
					let $checked = $($questions.get(i)).find("input:checked");
					answer = "";
					if ($checked.length > 1) {
						for (let j = 0; j < $checked.length - 1; ++j) {
							answer += ($($checked.get(j)).val() + ", ");
						}
						answer += $($checked.get($checked.length - 1)).val();
					}
					else {
						answer = $checked.val();
					}
					if (answer == null)
						answer = "No Response";
				}
				else {
					answer = $($questions.get(i)).find("select").val();
				}
				ajaxGet("db/db_response_handler.php?quiz_id=" + quiz_id + "&question=" + question + "&response=" + answer + "&user=" + user, function(results) {});
				location = "home.php";
			}
		});

		$("#page").on("focus", ".short-answer-option", function() {
			$(this).css("outline", "none");
			$(this).select();
			$(this).next().css("border-color", "#663399");
		});

		$("#page").on("blur", ".short-answer-option", function() {
			$(this).next().css("border-color", "lightgrey");
		});

		$("#homepage").addClass("active");
	</script>

	<?php $mysqli->close(); ?>

	<!-- Bootstrap -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>