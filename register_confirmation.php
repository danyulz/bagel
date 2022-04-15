<?php
require 'config/config.php';

var_dump($_POST);

if (
    !isset($_POST['email']) || empty($_POST['email'])
    || !isset($_POST['username']) || empty($_POST['username'])
    || !isset($_POST['password']) || empty($_POST['password'])
) {
    $error = "Please fill out all required fields.";
} else {

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }

    $statement_registered = $mysqli->prepare("SELECT * FROM users WHERE username=? OR email=?");
    $statement_registered->bind_param("ss", $_POST["username"], $_POST["email"]);
    $execute_registered = $statement_registered->execute();

    if (!$execute_registered) {
        echo $mysqli->error;
    }

    $statement_registered->store_result();

    if ($statement_registered->num_rows > 0) {
        $error = "Username or Email already used!";
        $statement_registered->close();
    } else {
        $password = hash("sha256", $_POST["password"]);

        $statement = $mysqli->prepare("INSERT INTO users(username, email, password) VALUES (?,?,?)");

        $statement->bind_param("sss", $_POST["username"], $_POST["email"], $password);

        $executed = $statement->execute();

        if (!$executed) {
            echo $mysqli->error;
        }

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
            <div class="create-text success">Successfully created!</div>
            <button class="login" onclick="location.href = 'login.html';">Login! </button>
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