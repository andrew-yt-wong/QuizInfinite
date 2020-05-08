<?php
	require '../config/config.php';

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$sql_insert_option = "INSERT INTO options(option, question_id) VALUES('" . $_GET['option'] . "', " . $_GET['question_id'] . ");";
	$results_insert_option = $mysqli->query($sql_insert_option);
	if (!$results_insert_option) {
		echo $mysqli->error;
		exit();
	}

	$mysqli->close();
?>