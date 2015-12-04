<?php
  // including the db_connect file for database helper functions
  include 'db_connect.php';
  include 'security.php';

  // opening the connection to the mysql database
  $mysql_link = connect('root', '', 'project3_db');

  $survey_id = $_GET['id'];

  $survey_info = $mysql_link->query("
    SELECT name, id
    FROM survey
    WHERE id = '$survey_id'
  ");

if($mysql_link->error) throw new \Exception($mysql_link->error);

$survey = $survey_info->fetch_assoc();

  $questions = $mysql_link->query("
    SELECT text, type, id
    FROM question
    WHERE survey_id = '$survey_id'
  ");

  if($mysql_link->error) throw new \Exception($mysql_link->error);

  function display_possible_answers_for($id, $type, $mysql_link) {
    if($type !== "text") {
      //retrieve all possible options
      $choices = $mysql_link->query("
        SELECT id, name
        FROM choice
        WHERE question_id = '$id'
        ");
      if($mysql_link->error) throw new \Exception($mysql_link->error);
      $response = make_html_for($id, $choices, $type);

    } else {
      //return a input box
      $response = "<input type=\"text\" name=\"question[$id]\" />";
    }
    return $response;
  }

  function make_html_for($question_id, $choices, $type) {
    $response = "<ul>";
    if($type === "radio") {
      foreach($choices as $choice) {
        $name = $choice['name'];
        $choice_id = $choice['id'];
        $response = $response . "<li><input type='radio' value='$choice_id' name='question[$question_id]' />$name</li>";
      }
    } elseif($type === "checkbox") {
      foreach($choices as $choice) {
      $name = $choice['name'];
      $choice_id = $choice['id'];
      $response = $response . "<li><input type='checkbox' value='$choice_id' name='question[$question_id][]' />$name</li>";
    }
  }
    $response .= "</ul>";
    return $response;
  }

?>

<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <h1><?= $survey['name'] ?></h1>
    <form method="POST" action="answer-survey.php?id=<?=$survey_id?>">
    <ul>
    <?php foreach($questions as $question){ ?>
      <li>
        <?=$question['text']?>
        <?= display_possible_answers_for($question['id'], $question['type'], $mysql_link) ?>
      </li>
    <?php } ?>
    </ul>
    <button type="submit">
      Submit
    </button>
  </form>
  </body>
</html>
