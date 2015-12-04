<?php
// including the db_connect file for database helper functions
include 'db_connect.php';
include 'security.php';

// opening the connection to the mysql database
$mysql_link = connect('root', '', 'project3_db');
$user_id = $_SESSION['user_id'];
$survey_id = $_GET['id'];

$survey_info = $mysql_link->query("
  SELECT name 
  FROM survey 
  WHERE id = '$survey_id'
");
if($mysql_link->error) throw new \Exception($mysql_link->error);

$survey = $survey_info->fetch_assoc();

$responses = $mysql_link->query("
  SELECT response.id, user_id, email
  FROM response
  JOIN user 
  ON response.user_id = user.id
  WHERE survey_id = '$survey_id'
");
if($mysql_link->error) throw new \Exception($mysql_link->error);
?>

<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
  	<a href="/">Home</a>
    <h1> Results for a &quot;<?= $survey['name'] ?>&quot;</h1>
    <ul>
    <?php foreach($responses as $response) { ?>
    	<li><?= $response['email'] ?>
    	<a href = "view-response.php?id=<?=$response['id']?>">results</a>
    	</li>
    <?php } ?>
  </body>
</html>