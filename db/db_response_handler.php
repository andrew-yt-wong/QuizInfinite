<?php
	require '../config/config.php';

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$sql = "INSERT INTO responses(quiz_id, question, response, user) VALUES('" . $_GET['quiz_id'] . "', '" . $_GET['question'] . "', '" . $_GET['response'] . "', '" . $_GET['user'] . "');";
	$results = $mysqli->query($sql);
	if (!$results) {
		echo $mysqli->error;
		exit();
	}

	$mysqli->close();
?>