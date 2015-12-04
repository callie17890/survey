<?php

session_start();
if(!IsSet($_SESSION['user_id'])) {
	header("location:/login.php");
	die();
}

?>