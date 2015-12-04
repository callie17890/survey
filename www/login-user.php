<?php
//session information
session_start();


// including the db_connect file for database helper functions
include 'db_connect.php';
include 'helpers.php';

// opening the connection to the mysql database
$mysql_link = connect('root', '', 'project3_db');


$email = $mysql_link->real_escape_string($_POST['email']);
$password = $mysql_link->real_escape_string($_POST['password']);

$password = hash_password($password);

$user_info = $mysql_link->query("
  SELECT
    id
  FROM user
  WHERE email = '$email'
  AND password = '$password'
");

if($mysql_link->error) throw new \Exception($mysql_link->error);

if($user_info->num_rows === 0) {
  header("location:/login.php");
}
else {
  $user = $user_info->fetch_assoc();
  $_SESSION['user_id'] = $user['id'];
  header("location:/");
}

?>
