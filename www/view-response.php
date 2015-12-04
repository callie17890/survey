<?php
  // including the db_connect file for database helper functions
  include 'db_connect.php';
  include 'security.php';

  // opening the connection to the mysql database
  $mysql_link = connect('root', '', 'project3_db');

  $response_id = $_GET['id'];

  $survey_info = $mysql_link->query("
    SELECT survey.name, survey_id, user.email as response_email
    FROM response 
    JOIN survey 
    ON response.survey_id = survey.id
    JOIN user 
    ON user.id = response.user_id
    WHERE response.id = '$response_id'
  ");

if($mysql_link->error) throw new \Exception($mysql_link->error);

$survey = $survey_info->fetch_assoc();
$survey_id = $survey['survey_id'];

  $questions = $mysql_link->query("
    SELECT text, type, id
    FROM question
    WHERE survey_id = '$survey_id'
  ");

  if($mysql_link->error) throw new \Exception($mysql_link->error);

  $answer_info = $mysql_link->query("
    SELECT question_id, text
    FROM answer
    WHERE response_id = '$response_id'
  ");

  if($mysql_link->error) throw new \Exception($mysql_link->error);

  $answers = [];
  foreach($answer_info as $answer) {
    if(IsSet($answers[$answer['question_id']])) {
    $answers[$answer['question_id']][] = $answer['text'];
  } else {
    $answers[$answer['question_id']] = [$answer['text']];
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <a href="view-responses.php?id=<?=$survey_id?>">back to response listing</a>
    <h1>Results for "<?= $survey['name'] ?>" by: <?=$survey['response_email']?></h1>
    <ul>
      <?php foreach($questions as $question) { ?>
      <li>
        <?= $question['text']?>
        <ul>
          <?php foreach($answers[$question['id']] as $answer) { ?>
          <li><?=$answer?></li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>
    </ul>
  </body>
</html>
