<?php
	require '../config/config.php';

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$sql_find_user = "SELECT user_id FROM users WHERE username = '" . $_GET['author'] . "';";
	$results_find_user = $mysqli->query($sql_find_user);
	if (!$results_find_user) {
		echo $mysqli->error;
		exit();
	}
	$user_id = $results_find_user->fetch_assoc()['user_id'];

	$sql_insert_quiz = "INSERT INTO quizzes(quiz_author, quiz_title, quiz_desc, user_id) VALUES('" . $_GET['author'] . "', '" . $_GET['title'] . "', '" . $_GET['desc'] . "', " . $user_id . ");";
	$results_insert_quiz = $mysqli->query($sql_insert_quiz);
	if (!$results_insert_quiz) {
		echo $mysqli->error;
		exit();
	}

	$sql_find_quiz = "SELECT quiz_id FROM quizzes WHERE quiz_author = '" . $_GET['author'] . "' AND quiz_title = '" . $_GET['title'] . "' AND quiz_desc = '" . $_GET['desc'] . "' AND user_id = " . $user_id . ";";
	$results_find_quiz = $mysqli->query($sql_find_quiz);
	if (!$results_find_quiz) {
		echo $mysqli->error;
		exit();
	}
	$quiz_id = $results_find_quiz->fetch_assoc()['quiz_id'];
	echo $quiz_id;

	$mysqli->close();
?>