<?php

$error_true = false;

if (
    !isset($_POST['username']) || empty($_POST['username'])
    || !isset($_POST['password']) || empty($_POST['password'])
) {
    $error = "Please fill out all required fields.";
    $error_true = true;
} else {

    require('./util/db_connect.php');

    $statement_registered = $mysqli->prepare("SELECT * FROM users WHERE username=?");
    $statement_registered->bind_param("s", $_POST["username"]);
    $execute_registered = $statement_registered->execute();

    if (!$execute_registered) {
        echo $mysqli->error;
    }

    $statement_registered->store_result();

    if ($statement_registered->num_rows > 0) {
        $error_true = true;
        $error = "Username already taken!";
        $statement_registered->close();
    } else {
        $password = hash("sha256", $_POST["password"]);

        $statement = $mysqli->prepare("INSERT INTO users(username, password) VALUES (?,?)");

        $statement->bind_param("ss", $_POST["username"], $password);

        $executed = $statement->execute();

        if (!$executed) {
            echo $mysqli->error;
        }

        $error = "Created Successfully!";

        $statement->close();
    }
}
?>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="navbar-styles.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="login-styles.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="navbar">
        <div class="navbar-logo">
            <div id="navbar-title">🍩 bagel.</div>
        </div>
        <div class="navbar-buttons">
            <div class="button-wrapper">
                <a href="main.html" class="button home">home</a>
                <div class="icon">🚩</div>
            </div>
            <div class="button-wrapper">
                <a href="user_boards.html" class="button boards">boards</a>
                <div class="icon">📋</div>
            </div>
            <div class="button-wrapper">
                <a href="login.html" class="button profile selected">me</a>
                <div class="icon">😉</div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="login-wrapper">
            <div class="bagel-hero">Bagel 🍩</div>
            <div class="author-text">// by Daniel He</div>
        </div>
        <div class="line-vertical"></div>
        <div class="line-horizontal"></div>
        <div class="login-wrapper fade-in">
            <div class="login-text">Create Account.</div>
            <?php if ($error_true) : ?>
                <div class='create-text failed'><?php echo $error; ?></div>
                <button class='login' onclick="location.href = 'register_form.php';">Go Back</button>
            <?php else : ?>
                <div class='create-text success'><?php echo $error; ?></div>
                <button class='login' onclick="location.href = 'login.php';">Login</button>
            <?php endif; ?>
            <div class="login-options">
            </div>
        </div>
    </div>
    <!-- <button class="box-shadow" id="addInputButton" type="button">+</button>
    <button class="box-shadow" id="infoButton" type="button">?</button> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="input/input.js"></script>
</body>

</html>