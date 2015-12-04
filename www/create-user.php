<?php

//starting a session
session_start();

// including the db_connect file for database helper functions
include 'db_connect.php';
include 'helpers.php';

// opening the connection to the mysql database
$mysql_link = connect('root', '', 'project3_db');

$user_id = get_uuid($mysql_link);

$name = $mysql_link->real_escape_string($_POST['name']);
$email = $mysql_link->real_escape_string($_POST['email']);
$password = $mysql_link->real_escape_string($_POST['password']);


$password = hash_password($password);

$users = $mysql_link->query("
  INSERT INTO user (
    id,
    name,
    email,
    password
  ) VALUES (
    '$user_id',
    '$name',
    '$email',
    '$password'
  )
");
if($mysql_link->error) throw new \Exception($mysql_link->error);

$_SESSION['user_id'] = $user_id;

header("location:/");
?>
