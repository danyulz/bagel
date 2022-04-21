<?php

include './config/config.php';

// var_dump($_SESSION);

function insert()
{

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }

    $sql = "INSERT INTO user_boards (user_id, name) VALUES (1, 'temp');";

    $results = $mysqli->query($sql);

    if (!$results) {
        echo $mysqli->error;
        exit();
    }

    $num_boards = $results->num_rows;

    echo $num_boards;

    $mysqli->close();
}


?>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="navbar-styles.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="user_boards.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php $type = "board";
    require('./navbar/navbar.php') ?>

    <form>
        <div class="container container-boards fade-in">
            <div class="boards-wrapper">
                <div class="boards-title">my boards</div>
                <input type="submit" class="button" name="select" value="insert" />
                <hr>
                <div class="item-wrapper">
                    <div class="board-item">
                        <a href="main.html" class="board-item-name">Template 1</a href="main.html">
                        <div class="board-item-last-used">2 hours ago</div>
                    </div>
                    <div class="board-item">
                        <a href="main.html" class="board-item-name">Template 1</a href="main.html">
                        <div class="board-item-last-used">3 days ago</div>
                    </div>
                    <div class="board-item">
                        <a href="main.html" class="board-item-name">Template 1</a href="main.html">
                        <div class="board-item-last-used">2+ months ago</div>
                    </div>
                </div>
            </div>
        </div>

    </form>
    <!-- <button class="box-shadow" id="addInputButton" type="button">+</button>
    <button class="box-shadow" id="infoButton" type="button">?</button> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.button').click(function() {
                var clickBtnValue = $(this).val();
                var ajaxurl = 'user_boards.php',
                    data = {
                        'action': clickBtnValue
                    };
                $.post(ajaxurl, data, function(response) {
                    // Response div goes here.
                    alert("action performed successfully");
                });
            });
        });
    </script>
</body>

</html>