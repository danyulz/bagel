<?php

include './config/config.php';

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($mysqli->connect_errno) {
echo $mysqli->connect_error;
exit();
}
?>