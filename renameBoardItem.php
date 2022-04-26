<?php

require('./util/db_connect.php');

$sql = "UPDATE user_boards SET (name) VALUES ('".$_POST["action"]."');";

$results = $mysqli->query($sql);

if (!$results) {
    echo $mysqli->error;
    exit();
}

$num_boards = $results->num_rows;

echo $num_boards;

$mysqli->close();

?>