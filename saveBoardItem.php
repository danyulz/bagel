<?php

//props $board_id, $board_item_id, $css_id, $css_class, $css_style, $css_attributes, $css_value, $start_idx

require('./util/db_connect.php');

$sql = "SELECT * FROM board_items WHERE css_id = " . $_POST['css_id'];

$results = $mysqli->query($sql);

if (!$results) {
    echo $mysqli->error;
    exit();
}

echo $results->num_rows;

if ($results->num_rows > 0) {
    $statement_registered = $mysqli->prepare("UPDATE board_items SET css_class = ?, css_style = ?, css_attributes = ?, css_value = ?, start_idx = ?, css_textarea_styles = ? WHERE css_id = ?");
    $statement_registered->bind_param("ssssisi", $_POST['css_class'], $_POST['css_style'], $_POST['css_attributes'], $_POST['css_value'], $_POST['start_idx'], $_POST['css_textarea_style'], $_POST['css_id']);
    $execute_registered = $statement_registered->execute();
    
    if (!$execute_registered) {
        echo $mysqli->error;
    }
} 
else {
    echo "inserting!~";
    $statement_registered = $mysqli->prepare("INSERT INTO board_items (board_id, css_id, css_class, css_style, css_attributes, css_value, start_idx, css_textarea_styles) VALUES (?,?,?,?,?,?,?,?)");
    $statement_registered->bind_param("iissssis", $_POST['board_id'], $_POST['css_id'], $_POST['css_class'], $_POST['css_style'], $_POST['css_attributes'], $_POST['css_value'], $_POST['start_idx'], $_POST['css_textarea_style']);
    $execute_registered = $statement_registered->execute();
    
    if (!$execute_registered) {
        echo $mysqli->error;
    }
}


$statement_registered->close();

?>