<?php
  function connect($user, $password, $database, $port=3306){
    $mysql_link = new \mysqli(
      '192.168.3.56',
      $user,
      $password,
      $database,
      $port
    );
    $mysql_link->set_charset("utf8");

    return $mysql_link;
  }

  function get_uuid($mysql_link){
    $uuid = $mysql_link->query("SELECT UUID() as uuid");
    if($mysql_link->error) throw new \Exception($mysql_link->error);
    $uuid = $uuid->fetch_assoc();
    return $uuid['uuid'];
  }
?>

