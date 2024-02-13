<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ibikers</title>
    <link rel="stylesheet" href="insert-style.css">

    <?php
    require 'db.php';
    session_start();
    $is_logged = false;
    if (!isset($_SESSION['username']) || !isset($_COOKIE['username'])) {
        header('Location: index.php');
        exit();
    } else {
        $is_logged = true;
    }
    

    ?>
</head>

<body>
    <header>
        <nav class="navigation">
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="#">About</a>
                <a href="#">Services</a>
                <a href="#">Contact</a>
            </div>
            <!--<div class="login-out">-->
            <?php 
            if ($is_logged) {
                echo "<div class='login-out logged'>";
            } else {
                echo "<div class='login-out'>";
            }
            ?>
                <div class="login">
                    <button class="btnLogin-popup">Login</button>
                </div>
                <div class="logout">
                    <button id="btn-logout" class="btnLogin-popup">Logout</button>
                </div>
            </div>
        </nav>
    </header>

    <div class="wrapper">
        <div class="form-box insert">
            <h2>New Post</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" id="insert-form">
                <div class="input-box">
                    <input type="text" name="marca" required>
                    <label>Marca</label>
                </div>
                <div class="input-box">
                    <input type="text" name="modello" required>
                    <label>Modello</label>
                </div>
                <div class="input-box">
                    <input type="number" placeholder="YYYY" name="anno" min="1950" max="2025" required>
                    <label>Anno</label>
                </div>
                <div class="input-box">
                    <textarea name="descrizione" rows="5" cols="60"></textarea>
                    <label>Modello</label>
                </div>
                <button type="submit" name="submit-modify" class="btn">Reset</button>
                <div class="login-register">
                    <p>Already have an account? <a href="index.php" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="insert-script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>