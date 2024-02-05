<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ibikers</title>
    <link rel="stylesheet" href="style.css">

    <?php

    session_start();
    require_once 'db.php';

    $username = $email = $password = $remember = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit-login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $t = $db->check_login($username, $password);
        echo $t;

        if($t == 0) {
            $_SESSION['username'] = $username;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit-register'])) {
        echo "REGISTER";
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
            <button class="btnLogin-popup">
                <?php
                if (!isset($_SESSION['username'])) {
                    echo 'Login';
                }
                else {
                    echo $_SESSION['username'];
                }
                ?>
            </button>
        </nav>
    </header>

    <div class="wrapper">
        <span class="icon-close">
            <ion-icon name="close"></ion-icon>
        </span>

        <div class="form-box login">
            <h2>Login</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person"></ion-icon>
                    </span>
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox" name="remember">Remember me</label>
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit" name="submit-login" class="btn">Login</button>
                <div class="login-register">
                    <p>Don't have an account? <a href="#" class="register-link">Register</a></p>
                </div>
            </form>
        </div>

        <div class="form-box register">
            <h2>Registration</h2>
            <form form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person"></ion-icon>
                    </span>
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="mail"></ion-icon>
                    </span>
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox" required> agree to the terms & conditions</label>
                </div>
                <button type="submit" name="submit-register" class="btn">Register</button>
                <div class="login-register">
                    <p>Already have an account? <a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div>

    </div>

    <script src="script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>