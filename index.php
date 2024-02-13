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
    $is_logged = false;
    if (isset($_SESSION['username']) || isset($_COOKIE['username'])) {
        $is_logged = true;
    }
    ?>
</head>

<body>


    <header>
        <nav class="navigation">
            <div class="nav-links">
                <a href="index.php">Home</a>
                <?php
                if ($is_logged) {
                    echo "<a href='insert.php'>Crea Post</a>";
                }
                ?>
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
        <span class="icon-close">
            <ion-icon name="close"></ion-icon>
        </span>

        <div class="form-box login">
            <h2>Login</h2>
            <form method="post" action="login.php" id="login-form">
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
                    <a class="modify-link" href="#">Forgot Password?</a>
                </div>
                <button type="submit" name="submit-login" class="btn">Login</button>
                <div class="login-register">
                    <p>Don't have an account? <a href="#" class="register-link">Register</a></p>
                </div>
            </form>
        </div>

        <div class="form-box modify">
            <h2>Modify</h2>
            <form method="post" action="modify.php" id="modify-form">
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="person"></ion-icon>
                    </span>
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <button type="submit" name="submit-modify" class="btn">Modify</button>
                <div class="login-register">
                    <p>Already have an account? <a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div>

        <div class="form-box register">
            <h2>Registration</h2>
            <form action="register.php" method="post" id="register-form">
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