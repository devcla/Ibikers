<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ibikers</title>
    <link rel="stylesheet" href="index-style.css">

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
            </div>
            <!--<div class="login-out">-->
            <div class="
            <?php 
            if ($is_logged) {
                echo "login-out logged";
            } else {
                echo "class='login-out";
            }
            ?>">
                <div class="login">
                    <button class="btnLogin-popup">Login</button>
                </div>
                <div class="logout">
                    <button id="btn-logout" class="btnLogin-popup">Logout</button>
                </div>
            </div>
        </nav>
    </header>

    <div class="post-container">
        <h1>COMMUNITY POSTS</h1>
        <div class="posts">
            <?php
            global $db;
            require_once 'db.php';

            $result = $db->get_all_posts();
            if ($result !== 1 && $result !== -1) {
                if ($is_logged) {
                    foreach ($result as $row) {
                        if (isset($_SESSION['username']) && $_SESSION['username'] == $row['username']) {
                            echo "<form method='post' id='post-form'>";
                            echo "    <div class='post'>";
                            echo "        <input type='hidden' name='id' value='{$row['id']}'>";
                            echo "        <input type='hidden' name='marca' value='{$row['marca']}'>";
                            echo "        <input type='hidden' name='username' value='{$row['username']}'>";
                            echo "        <input type='hidden' name='modello' value='{$row['modello']}'>";
                            echo "        <input type='hidden' name='anno' value='{$row['anno']}'>";
                            echo "        <input type='hidden' name='descrizione' value='{$row['descrizione']}'>";
                            echo "        <img src='{$row['image_path']}' alt='no image'>";
                            echo "        <p>User: @{$row['username']}</p>";
                            echo "        <p class='uppercase'>{$row['marca']}</p>";
                            echo "        <p>{$row['modello']}</p>";
                            echo "        <p>{$row['anno']}</p>";
                            echo "        <p>{$row['descrizione']}</p>";
                            echo "        <p class='icons'>";
                            echo "            <span class='edit'><button type='submit' name='edit_submit' class='btn-icon' onclick='editClicked()'><ion-icon name='create'></ion-icon></button></span>";
                            echo "            <span class='trash'><button type='submit' name='delete_submit' class='btn-icon' onclick='deleteClicked()'><ion-icon name='trash'></ion-icon></button></span>";
                            echo "        </p>";
                            echo "    </div>";
                            echo "</form>";
                        } elseif (isset($_COOKIE['username']) &&  $_COOKIE['username'] == $row['username']) {
                            echo "<form method='post' id='post-form'>";
                            echo "    <div class='post'>";
                            echo "        <input type='hidden' name='id' value='{$row['id']}'>";
                            echo "        <input type='hidden' name='marca' value='{$row['marca']}'>";
                            echo "        <input type='hidden' name='username' value='{$row['username']}'>";
                            echo "        <input type='hidden' name='modello' value='{$row['modello']}'>";
                            echo "        <input type='hidden' name='anno' value='{$row['anno']}'>";
                            echo "        <input type='hidden' name='descrizione' value='{$row['descrizione']}'>";
                            echo "        <img src='{$row['image_path']}' alt='no image'>";
                            echo "        <p>User: @{$row['username']}</p>";
                            echo "        <p class='uppercase'>{$row['marca']}</p>";
                            echo "        <p>{$row['modello']}</p>";
                            echo "        <p>{$row['anno']}</p>";
                            echo "        <p>{$row['descrizione']}</p>";
                            echo "        <p class='icons'>";
                            echo "            <span class='edit'><button type='submit' name='edit_submit' class='btn-icon' onclick='editClicked()'><ion-icon name='create'></ion-icon></button></span>";
                            echo "            <span class='trash'><button type='submit' name='delete_submit' class='btn-icon' onclick='deleteClicked()'><ion-icon name='trash'></ion-icon></button></span>";
                            echo "        </p>";
                            echo "    </div>";
                            echo "</form>";
                        } else {
                            echo "<div class='post'>";
                            echo "  <img src='{$row['image_path']}' alt='no image'>";
                            echo "  <p>User: @{$row['username']}</p>";
                            echo "  <p class='uppercase'>{$row['marca']}</p>";
                            echo "  <p>{$row['modello']}</p>";
                            echo "  <p>{$row['anno']}</p>";
                            echo "  <p>{$row['descrizione']}</p>";
                            echo "</div>";
                        }
                    }
                } else {
                    foreach ($result as $row) {
                        echo "<div class='post'>";
                        echo "  <img src='{$row['image_path']}' alt='no image'>";
                        echo "  <p>User: @{$row['username']}</p>";
                        echo "  <p class='uppercase'>{$row['marca']}</p>";
                        echo "  <p>{$row['modello']}</p>";
                        echo "  <p>{$row['anno']}</p>";
                        echo "  <p>{$row['descrizione']}</p>";
                        echo "</div>";
                    }
                }
            } else {
                echo "<div class='post'>";
                echo "  <p class='uppercase'>0 results</p>";
                echo "</div>";
            }

            ?>
        </div>
    </div>




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
                    <input type="text" id="username" name="username" required>
                    <label for="username" >Username</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" id="password" name="password" required>
                    <label for="password">Password</label>
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
                    <input type="text" id="username" name="username" required>
                    <label for="username">Username</label>
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
                    <input type="text" id="username" name="username" required>
                    <label for="username">Username</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="mail"></ion-icon>
                    </span>
                    <input type="email" id="email" name="email" required>
                    <label for="email">Email</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" id="password" name="password" required>
                    <label for="password">Password</label>
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

    <script src="index-script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>