<?php

require('./util/db_connect.php');

$sql = "INSERT INTO user_boards (user_id, name) VALUES (1, '". $_POST["action"] ."');";

$results = $mysqli->query($sql);

if (!$results) {
    echo $mysqli->error;
    exit();
}

$num_boards = $results->num_rows;

echo $num_boards;

$mysqli->close();

?>