<?php

function hash_password ($password) {
$salt = "random";
$password = $salt.$password;
$password = hash("sha256", $password);

return $password;
}

?>