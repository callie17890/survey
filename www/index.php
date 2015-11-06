<?php
  // including the db_connect file for database helper functions
  include 'db_connect.php';

  // opening the connection to the mysql database
  $mysql_link = connect('root', '', 'project3_db');

  $surveys = $mysql_link->query("
    SELECT name, id
    FROM survey
  ");
  if($mysql_link->error) throw new \Exception($mysql_link->error);
?><!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <h1>Survey Listing</h1>
    <ul>
    <?php foreach($surveys as $survey){ ?>
      <li>
        <?=$survey['name']?>
        <a href="edit-survey.php?id=<?=$survey['id']?>">edit</a>
        <a href="view-survey.php?id=<?=$survey['id']?>">view</a>
      </li>
    <?php } ?>
    </ul>
    <h3>Add new survey</h3>
    <form method="POST" action="create-survey.php">
      <input type="text" name="name" />
      <button type="submit">
        add a survey
      </button>
    </form>
  </body>
</html>
