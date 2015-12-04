<?php
// including the db_connect file for database helper functions
include 'db_connect.php';
include 'security.php';

// opening the connection to the mysql database
$mysql_link = connect('root', '', 'project3_db');

$survey_id = $_GET['id'];

$user_id = $_SESSION['user_id'];

$question_info = $mysql_link->query("
	SELECT type, id
   	FROM question
   	WHERE survey_id = '$survey_id'
");
if($mysql_link->error) throw new \Exception($mysql_link->error);

$questions = [];
foreach($question_info as $question) {
	$questions[$question['id']] = $question['type'];
}

$response_id = get_uuid($mysql_link);

$mysql_link->query("
	INSERT INTO response(
		id, user_id, survey_id, created_at
	) VALUES (
		'$response_id',
		'$user_id',
		'$survey_id',
		NOW()
		)
");

if($mysql_link->error) throw new \Exception($mysql_link->error);

$answers = $_POST['question'];

foreach($answers as $question_id => $answer) {
	if(!is_array($answer)){
		record_response($questions, $question_id, $response_id, $answer, $mysql_link);
	} else{
		foreach($answer as $ans) {
			record_response($questions, $question_id, $response_id, $ans, $mysql_link);
		}
	}
}

function record_response ($questions, $question_id, $response_id, $answer, $mysql_link) {
	if($questions[$question_id] !== "text") {
		$choice_id = $answer;
		$choice_info = $mysql_link->query("
			SELECT name
			FROM choice
			WHERE id = '$choice_id'
		");
		if($mysql_link->error) throw new \Exception($mysql_link->error);

		$answer = $choice_info->fetch_assoc();
		$answer = $answer['name'];
	}
if($mysql_link->error) throw new \Exception($mysql_link->error);

$mysql_link->query("
	INSERT INTO answer(
		id, question_id, response_id, choice_id, text
	) VALUES (
		UUID(),
		'$question_id',
		'$response_id',
		'$choice_id',
		'$answer'
	)
");
}

if($mysql_link->error) throw new \Exception($mysql_link->error);

header("location: /");
?>