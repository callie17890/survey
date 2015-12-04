<?php
// including the db_connect file for database helper functions
include 'db_connect.php';
include 'security.php';

// opening the connection to the mysql database
$mysql_link = connect('root', '', 'project3_db');

// TODO: generate a new UUID and set it to a variable
$survey_id = get_uuid($mysql_link);


$name = $mysql_link->real_escape_string($_POST['name']);

$user_id = $_SESSION['user_id'];

// TODO: change this query so that it uses the UUID generated above
$users = $mysql_link->query("
  INSERT INTO survey (
    id,
    user_id,
    name
  ) VALUES (
    '$survey_id',
    '$user_id',
    '$name'
  )
");
if($mysql_link->error) throw new \Exception($mysql_link->error);

header("location:/edit-survey.php?id=$survey_id");
?>
