<?php
// including the db_connect file for database helper functions
include 'db_connect.php';
include 'security.php';

// opening the connection to the mysql database
$mysql_link = connect('root', '', 'project3_db');

// TODO: generate a new UUID and set it to a variable
$survey_id = $_GET['survey_id'];


$text = $mysql_link->real_escape_string($_POST['text']);
$type = $mysql_link->real_escape_string($_POST['type']);

// TODO: change this query so that it uses the UUID generated above
$users = $mysql_link->query("
  INSERT INTO question (
    id,
    text,
    type,
    survey_id
  ) VALUES (
    UUID(),
    '$text',
    '$type',
    '$survey_id'
  )
");
if($mysql_link->error) throw new \Exception($mysql_link->error);

header("location:/edit-survey.php?id=$survey_id");
?>

