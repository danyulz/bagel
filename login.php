<?php
require 'config/config.php';

$error_true = false;

if (
    !isset($_POST['username']) || empty($_POST['username'])
    || !isset($_POST['password']) || empty($_POST['password'])
) {
    $error = "Please fill out all required fields.";
    $error_true = true;
} else {

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }

    $password = hash("sha256", $_POST["password"]);

    $statement_registered = $mysqli->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $statement_registered->bind_param("ss", $_POST["username"], $password);
    $execute_registered = $statement_registered->execute();

    if (!$execute_registered) {
        echo $mysqli->error;
    }

    var_dump($_POST);
    $statement_registered->store_result();


    $isLoggedIn = false;

    if ($statement_registered->num_rows > 0) {
        $isLoggedIn = true;  
        $error = "Successfully Log In!";
        $statement_registered->close();
    } else {
        $error = "Could not Login!";
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
                <a href="login.php" class="button profile selected">me</a>
                <div class="icon">😉</div>
            </div>
        </div>
    </div>
    <form action="login.php" method="POST">

        <?php if ($error_true) : ?>

            <div class="container">
                <div class="login-wrapper">
                    <div class="bagel-hero">Bagel 🍩</div>
                    <div class="author-text">// by Daniel He</div>
                </div>
                <div class="line-vertical"></div>
                <div class="line-horizontal"></div>
                <div class="login-wrapper fade-in">
                    <div class="login-text">Welcome Back.</div>
                    <input type="text" class="login-input username" placeholder="username" name="username">
                    <input type="text" class="login-input password" placeholder="password" name="password">
                    <button class='login' onclick="location.href = 'login.php';">Let's Go! 🍩</button>
                    <div class="login-options">
                        <a href="register_form.php" class="text">i'm new!</a>
                        <a class="text">forgot password?</a>
                    </div>
                </div>
            </div>

        <?php else : ?>
            <div class="container">
                <div class="login-wrapper">
                    <div class="bagel-hero">Bagel 🍩</div>
                    <div class="author-text">// by Daniel He</div>
                </div>
                <div class="line-vertical"></div>
                <div class="line-horizontal"></div>
                <div class="login-wrapper fade-in">
                    <div class="login-text"><?php echo $error;?></div>
                </div>
            </div>
        <?php endif; ?>


    </form>
    <!-- <button class="box-shadow" id="addInputButton" type="button">+</button>
    <button class="box-shadow" id="infoButton" type="button">?</button> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="input/input.js"></script>
</body>

</html>