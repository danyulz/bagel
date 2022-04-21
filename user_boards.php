<?php

$showAnim = true;

require('./util/db_connect.php');

$sql = "SELECT * FROM user_boards";

$results = $mysqli->query($sql);

if (!$results) {
    echo $mysqli->error;
    exit();
}

// while ($row = $results->fetch_assoc()) {
//     var_dump($row);
//     echo "<hr></hr>";
// }

$mysqli->close();
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

    <div class="container container-boards fade-in">
        <div class="boards-wrapper">
            <div style="display: flex; justify-content: space-between">
                <div class="boards-title">my boards</div>
                <button class="insert-button" name="select" value="title" >insert</button>
            </div>
            <hr>
            <div class="item-wrapper">

                <?php while ($row = $results->fetch_assoc()) : ?>
                    <div class="board-item fade-in">
                        <a href="main.php" class="board-item-name" id=<?php echo $row["board_items_id"] ?>><?php echo $row["name"] ?></a>
                        <div class="board-item-last-used">2 hours ago</div>
                    </div>
                    <script>
                        var item = document.getElementById("<?php echo $row["board_items_id"] ?>");

                        console.log(item);

                        var closeButton = document.createElement("div");
                        closeButton.className = "closeButton";

                        item.append(closeButton)

                        closeButton.addEventListener("click", () => {
                            deleteHelper(item);
                        });
                    </script>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <!-- <button class="box-shadow" id="addInputButton" type="button">+</button>
    <button class="box-shadow" id="infoButton" type="button">?</button> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.insert-button').click(function() {
                var clickBtnValue = $(this).val();
                var ajaxurl = 'backend.php',
                    data = {
                        'action': clickBtnValue
                    };
                $.post(ajaxurl, data, function(response) {
                    // Response div goes here.
                });
            });
        });

        function ajaxGet(endpointUrl, returnFunction) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', endpointUrl, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    if (xhr.status == 200) {
                        // When ajax call is complete, call this function, pass a string with the response
                        returnFunction(xhr.responseText);
                    } else {
                        alert('AJAX Error.');
                        console.log(xhr.status);
                    }
                }
            }
            xhr.send();
        };

        function ajaxPost(endpointUrl, returnFunction) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', endpointUrl, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    if (xhr.status == 200) {
                        returnFunction(xhr.responseText);
                    } else {
                        alert('AJAX Error.');
                        console.log(xhr.status);
                    }
                }
            }
            xhr.send(postdata);
        };
    </script>
</body>

</html>