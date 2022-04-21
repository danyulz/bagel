<div class="navbar">
    <div class="navbar-logo">
        <div id="navbar-title">🍩 bagel.</div>
    </div>
    <div class="navbar-buttons">
        <div class="button-wrapper">
            <?php if ($type == "home") : ?>
                <a href="main.php" class="button home selected">home</a>
            <?php else : ?>
                <a href="main.php" class="button home">home</a>
            <?php endif; ?>
            <div class="icon">🚩</div>
        </div>
        <div class="button-wrapper">
            <?php if ($type == "board") : ?>
                <a href="user_boards.php" class="button boards selected">boards</a>
            <?php else : ?>
                <a href="user_boards.php" class="button boards">boards</a>
            <?php endif; ?> 
            <div class="icon">📋</div>
        </div>
        <div class="button-wrapper">
            <?php if ($type == "login") : ?>
                <a href="login.php" class="button profile selected">me</a>
            <?php else : ?>
                <a href="login.php" class="button profile">me</a>
            <?php endif; ?>
            <div class="icon">😉</div>
        </div>
    </div>
</div>