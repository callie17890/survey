<?php
// including the db_connect file for database helper functions
include 'db_connect.php';
include 'security.php';

// opening the connection to the mysql database
$mysql_link = connect('root', '', 'project3_db');

$survey_id = $_GET['survey_id'];
$user_email = $_POST['email'];

$mysql_link->query("
	UPDATE survey
	SET private = '1'
	WHERE id = '$survey_id'
");
if($mysql_link->error) throw new \Exception($mysql_link->error);

$user_info = $mysql_link->query("
	SELECT id
	FROM user
	WHERE email = '$user_email'
");
if($mysql_link->error) throw new \Exception($mysql_link->error);

$user = $user_info->fetch_assoc();
$user_id = $user['id'];

$mysql_link->query("
	INSERT INTO
		survey_recipient(
			user_id,
			survey_id
	) VALUES (
	'$user_id',
	'$survey_id'
	)
");
if($mysql_link->error) throw new \Exception($mysql_link->error);

header("location:/edit-survey.php?id=$survey_id");
?>