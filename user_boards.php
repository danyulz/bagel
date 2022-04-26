<?php

session_start();

if ($_SESSION != null) {
    if ($_SESSION["isLoggedIn"]) {

        $showAnim = true;

        require('./util/db_connect.php');

        $sql = "SELECT * FROM user_boards WHERE user_id = " . $_SESSION["user_id"];

        $results = $mysqli->query($sql);

        // var_dump($_SESSION);

        if (!$results) {
            echo $mysqli->error;
            exit();
        }

        $mysqli->close();
    }
}

// echo $_SESSION["user_id"];


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
                <!-- <button class="insert-button" name="select" value="title">insert</button> -->
            </div>
            <hr>
            <div class="item-wrapper">
                <input id="board-input" class="board-item" placeholder="// start typing..."></input>
            </div>
        </div>
    </div>
    <!-- <button class="box-shadow" id="addInputButton" type="button">+</button>
    <button class="box-shadow" id="infoButton" type="button">?</button> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        //board-items
        let boardWrapper = document.querySelector(".item-wrapper");

        let lastItemId = 0;
        let userId = <?php echo $_SESSION["user_id"]; ?>;

        const createBoardItem = (id, name) => {
            let itemWrapper = document.createElement("div");
            // itemWrapper.href = "main.php";
            itemWrapper.className = "board-item fade-in";
            itemWrapper.id = "item-" + id;

            let itemName = document.createElement("a");
            itemName.href = "main.php";
            itemName.className = "board-item-name";
            itemName.innerText = name;
            itemName.id = "item-name-" + id;

            let lastUsed = document.createElement("div");
            lastUsed.className = "board-item-last-used";
            lastUsed.innerText = "2 hours ago";

            let closeButton = document.createElement("div");
            closeButton.className = "closeButton";

            closeButton.addEventListener("click", () => addDeleteBoard(itemWrapper));

            itemWrapper.append(itemName);
            itemWrapper.append(closeButton);
            itemWrapper.append(lastUsed);

            boardWrapper.append(itemWrapper);
        }

        <?php while ($row = $results->fetch_assoc()) : ?>
            lastItemId = <?php echo $row["board_items_id"] ?>;
            createBoardItem(<?php echo $row["board_items_id"] ?>, '<?php echo $row["name"] ?>');
        <?php endwhile; ?>
    </script>
    <script src="input/input.js"></script>
    <script>
        let boardInput = document.getElementById("board-input");
        console.log(boardInput);

        addListeners(boardInput, "boardInput");

        const addDeleteBoard = (board) => {

            let id = board.id.replace("item-", "");
            board.className += " pop-out";
            setTimeout(function() {
                board.remove();
            }, 150);

            var ajaxurl = 'deleteBoardItem.php',
                data = {
                    'board_items_id': id 
                };
            $.post(ajaxurl, data, function(response) {
                console.log(response);
            });
        }

    </script>
    <script>
        //ajax function
        $(document).ready(function() {
            $('.insert-button').click(function() {
                var clickBtnValue = $(this).val();
                var ajaxurl = 'createBoardItem.php',
                    data = {
                        'action': clickBtnValue,
                        'user_id': userId
                    };
                $.post(ajaxurl, data, function(response) {
                    // Response div goes here.
                    createBoardItem(++lastItemId, 'new board...')
                });
            });
        });
    </script>

</body>

</html>