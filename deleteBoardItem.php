<?php

require('./util/db_connect.php');

$sql = "DELETE FROM user_boards WHERE board_items_id = " . $_POST["board_items_id"];

$results = $mysqli->query($sql);

if (!$results) {
    echo $mysqli->error;
    exit();
}

echo $_POST["board_items_id"];

// $num_boards = $results->num_rows;

// echo $num_boards;

$mysqli->close();

?>