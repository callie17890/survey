<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <form action="create-recipient.php?survey_id=<?=$_GET['survey_id']?>" method="POST">
      Email: <input type="text" name="email" />
      <button type="submit">
        + add private recipient
      </button>
    </form>
  </body>
</html>