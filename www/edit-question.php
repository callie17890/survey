<?php
  // including the db_connect file for database helper functions
  include 'db_connect.php';

  // opening the connection to the mysql database
  $mysql_link = connect('root', '', 'project3_db');

  $question_id = $_GET['id'];

  $question_info = $mysql_link->query("
    SELECT 
      text,
      type,
      survey_id
    FROM
      question
    WHERE id='$question_id'
  ");
  if($mysql_link->error) throw new \Exception($mysql_link->error);

  $question = $question_info->fetch_assoc();

  $choices = $mysql_link->query("
    SELECT 
      id,
      name
    FROM
      choice
    WHERE question_id='$question_id'
  ");
  if($mysql_link->error) throw new \Exception($mysql_link->error);

?><!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <a href="edit-survey.php?id=<?=$question['survey_id']?>">back to survey</a>
    <h1>[<?=$question['type']?>] <?=$question['text']?></h1>
    <?php if($question['type'] !== 'text'){ ?>
    <ul>
      <?php foreach($choices as $choice){ ?>
        <li><?= $choice['name']?></li>
      <?php } ?>
    </ul>
    <form action="create-choice.php?question_id=<?=$question_id?>" method="POST">
      <input type="text" name="name" />
      <button type="submit">
        add choice
      </button>
    </form>
    <?php } ?>
  </body>
</html>

