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
    <?php
    $type = "login";
    require('./navbar/navbar.php') ?>
    <form action="register_confirmation.php" method="POST">

        <div class="container">
            <div class="login-wrapper">
                <div class="bagel-hero">Bagel 🍩</div>
                <div class="author-text">// by Daniel He</div>
            </div>
            <div class="line-vertical"></div>
            <div class="line-horizontal"></div>
            <div class="login-wrapper fade-in">
                <div class="login-text">Create Account.</div>

                <input type="text" class="login-input username" placeholder="username" name="username">
                <input type="text" class="login-input password" placeholder="password" name="password">

                <button type="submit" class="login">Register! 😎</button>
                <div class="login-options">
                    <a href="login.php" class="text">
                        << sign in </a>
                </div>
            </div>
        </div>

    </form>
    <!-- <button class="box-shadow" id="addInputButton" type="button">+</button>
    <button class="box-shadow" id="infoButton" type="button">?</button> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="input/input.js"></script>
</body>

</html>