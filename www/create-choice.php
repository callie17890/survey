<?php
// including the db_connect file for database helper functions
include 'db_connect.php';

// opening the connection to the mysql database
$mysql_link = connect('root', '', 'project3_db');

// TODO: generate a new UUID and set it to a variable
$question_id = $_GET['question_id'];


$name = $mysql_link->real_escape_string($_POST['name']);

// TODO: change this query so that it uses the UUID generated above
$users = $mysql_link->query("
  INSERT INTO choice (
    id,
    name,
    question_id
  ) VALUES (
    UUID(),
    '$name',
    '$question_id'
  )
");
if($mysql_link->error) throw new \Exception($mysql_link->error);

header("location:/edit-question.php?id=$question_id");
?>


