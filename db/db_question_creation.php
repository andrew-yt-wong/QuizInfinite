<?php
	require '../config/config.php';

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$sql_insert_question = "INSERT INTO questions(question, question_type, quiz_id) VALUES('" . $_GET['question'] . "', '" . $_GET['question_type'] . "', " . $_GET['quiz_id'] . ");";
	$results_insert_question = $mysqli->query($sql_insert_question);
	if (!$results_insert_question) {
		echo $mysqli->error;
		exit();
	}

	$sql_find_question = "SELECT question_id FROM questions WHERE question = '" . $_GET['question'] . "' AND question_type = '" . $_GET['question_type'] . "' AND quiz_id = " . $_GET['quiz_id'] . ";";
	$results_find_question = $mysqli->query($sql_find_question);
	if (!$results_find_question) {
		echo $mysqli->error;
		exit();
	}
	$question_id = $results_find_question->fetch_assoc()['question_id'];
	echo $question_id;

	$mysqli->close();
?>