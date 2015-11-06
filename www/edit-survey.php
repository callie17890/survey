<?php
  // including the db_connect file for database helper functions
  include 'db_connect.php';

  // opening the connection to the mysql database
  $mysql_link = connect('root', '', 'project3_db');

  $survey_id = $_GET['id'];

  $survey_info = $mysql_link->query("
    SELECT 
      name
    FROM
      survey
    WHERE id='$survey_id'
  ");
  if($mysql_link->error) throw new \Exception($mysql_link->error);

  $survey = $survey_info->fetch_assoc();

  $questions = $mysql_link->query("
    SELECT 
      id,
      text,
      type
    FROM
      question
    WHERE survey_id='$survey_id'
  ");
  if($mysql_link->error) throw new \Exception($mysql_link->error);

?><!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <a href="/">home</a>
    <h1><?=$survey['name']?></h1>
    <ul>
      <?php foreach($questions as $question){ ?>
        <li><?= $question['type']?> - <?=$question['text']?>
          <a href="edit-question.php?id=<?=$question['id']?>">edit</a>
        </li>
      <?php } ?>
    </ul>
    <form action="create-question.php?survey_id=<?=$survey_id?>" method="POST">
      <input type="text" name="text" />
      <select name="type">
        <option value="text">Text</option>
        <option value="radio">Radio</option>
        <option value="checkbox">Checkbox</option>
      </select>
      <button type="submit">
        add question
      </button>
    </form>
  </body>
</html>
