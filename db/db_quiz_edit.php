<?php
	require '../config/config.php';

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$sql_find_questions = "SELECT * FROM questions WHERE quiz_id = " . $_GET['quiz_id'] . ";";
	$results_find_questions = $mysqli->query($sql_find_questions);
	if (!$results_find_questions) {
		echo $mysqli->error;
		exit();
	}

	while ($question = $results_find_questions->fetch_assoc()) {
		$question_id = $question['question_id'];
		$sql_find_options = "SELECT * FROM options WHERE question_id = " . $question_id . ";";
		$results_find_options = $mysqli->query($sql_find_options);
		if (!$results_find_options) {
			echo $mysqli->error;
			exit();
		}

		while ($option = $results_find_options->fetch_assoc()) {
			$sql_delete_option = "DELETE FROM options WHERE option_id = " . $option['option_id'] . ";";
			$results_delete_option = $mysqli->query($sql_delete_option);
			if (!$results_delete_option) {
				echo $mysqli->error;
				exit();
			}
		}

		$sql_delete_question = "DELETE FROM questions WHERE question_id = " . $question_id . ";";
		$results_delete_question = $mysqli->query($sql_delete_question);
		if (!$results_delete_question) {
			echo $mysqli->error;
			exit();
		}
	}

	$sql_update_quiz = "UPDATE quizzes SET quiz_title = '" . $_GET['quiz_title'] . "', quiz_desc = '" . $_GET['quiz_desc'] . "' WHERE quiz_id = " . $_GET['quiz_id'] . ";";
	$results_update_quiz = $mysqli->query($sql_update_quiz);
	if (!$results_update_quiz) {
		echo $mysqli->error;
		exit();
	}

	$mysqli->close();
?>