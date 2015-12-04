<?php
  // including the db_connect file for database helper functions
  include 'db_connect.php';
  include 'security.php';

  // opening the connection to the mysql database
  $mysql_link = connect('root', '', 'project3_db');

  $user_id = $_SESSION['user_id'];

  $surveys = $mysql_link->query("
    SELECT name, id
    FROM survey
    WHERE private IS NULL or private != '1'
  ");

if($mysql_link->error) throw new \Exception($mysql_link->error);

$my_completed_surveys = $mysql_link->query("
  SELECT survey.id
  FROM response
  JOIN survey
  ON survey.id = response.survey_id
  WHERE response.user_id = '$user_id'
  AND survey.private = '1'
  ");
if($mysql_link->error) throw new \Exception($mysql_link->error);

$where = [];
foreach($my_completed_surveys as $survey) {
  $where[] = "survey.id != '".$survey['id']."'";
}

if(sizeof($where) > 0) {
  $where = " AND ". join(" AND ", $where);
}
else {
  $where = '';
}

if($mysql_link->error) throw new \Exception($mysql_link->error);

$my_surveys = $mysql_link->query("
    SELECT name, id
    FROM survey
    JOIN survey_recipient
    ON survey_recipient.survey_id = survey.id 
    WHERE private = '1'
    AND survey_recipient.user_id = '$user_id'
    $where
  ");

if($mysql_link->error) throw new \Exception($mysql_link->error);

?>

<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <a href="logout.php">Logout</a>
    <?php if($my_surveys->num_rows > 0) { ?>
    <h1>Private Survey Listing</h1>
    <ul>
    <?php foreach($my_surveys as $survey){ ?>
      <li>
        <?=$survey['name']?>
        <a href="edit-survey.php?id=<?=$survey['id']?>">edit</a>
        <a href="view-survey.php?id=<?=$survey['id']?>">view</a>
        <a href="view-responses.php?id=<?=$survey['id']?>">results</a>
      </li>
    <?php } ?>
    </ul>
    <?php } ?>
    <h1>Survey Listing</h1>
    <ul>
    <?php foreach($surveys as $survey){ ?>
      <li>
        <?=$survey['name']?>
        <a href="edit-survey.php?id=<?=$survey['id']?>">edit</a>
        <a href="view-survey.php?id=<?=$survey['id']?>">view</a>
        <a href="view-responses.php?id=<?=$survey['id']?>">results</a>
      </li>
    <?php } ?>
    </ul>
    <h3>Add New Survey:</h3>
    <form method="POST" action="create-survey.php">
      <input type="text" name="name" />
      <button type="submit">
        + add a survey
      </button>
    </form>
  </body>
</html>
