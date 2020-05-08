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
			<div>
				<div class="quiz-title">
					<div class="row">
						<input type="text" name="quiz-title" placeholder="Title" value="Untitled Quiz" id="quiz-title">
					</div>
					<hr id="titlehr"/>
					<div class="row">
						<input type="text" name="quiz-desc" placeholder="Description" id="quiz-desc">
					</div>
					<hr id="deschr"/>
				</div>
				<div class="question">
					<div class="row">
						<div class="col-lg-7 col-md-8 col-sm-12">
							<input type="text" class="question-name" placeholder="Question" value="Untitled Question" name="question-name">
							<hr/>
						</div>
						<div class="col-lg-5 col-md-4 col-sm-12">
							<div class="dropdown">
								<button class="btn dropdown-toggle dropdownMenuButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-dot-circle"></i> Multiple Choice</button>
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
						<div class="option">
							<label><i class="far fa-circle"></i></label><input type="text" class="option-input" placeholder="Option" value="Option"/><i class="fas fa-times delete-option"></i><hr/>
						</div>
					</div>
					<i class="fas fa-plus-square add-option"></i>
					<i class="fas fa-trash delete-question"></i>
				</div>
			</div>
			<i class="fas fa-plus-square add-question"></i>
			<div><button type="submit" class="btn btn-info">Create Quiz</button></div>
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

		$("form").on("submit", function(event) {
			let author = "<?php echo $_SESSION['user']; ?>";
			let title = $("#quiz-title").val().replace("'", "");
			let desc = $("#quiz-desc").val().replace("'", "");

			ajaxGet("db/db_quiz_creation.php?author=" + author + "&title=" + title + "&desc=" + desc, function(results) {
				let quiz_id = parseInt(results);

				let $questions = $(".question");
				for (let i = 0; i < $questions.length; ++i) {
					let question = $($questions.get(i)).find(".question-name").val().replace("'", "");
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
								let option = $($options.get(j)).find(".option-input").val().replace("'", "");
								ajaxGet("db/db_option_creation.php?option=" + option + "&question_id=" + question_id, function(results) {});
							}
						}
					});
				}
			});
		});
	</script>

	<!-- Bootstrap -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>