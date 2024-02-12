<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ibikers</title>
    <link rel="stylesheet" href="style.css">

    <?php
    require 'db.php';
    session_start();

    if (isset($_GET['token'])) {
        $token = $_GET['token'];
        $username = $_GET['username'];

        $token_valid = $db->check_token_isvalid($username, $token);

        if (!$token_valid == 0) {
            echo "<script>alert('token is invalid');</script>";
            header("Location: index.php");
            exit();
        }

        $_SESSION['username'] = $_GET['username'];

    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password_one = $_POST['password-one'];
        $password_two = $_POST['password-two'];
        $username = $_SESSION['username'];

        if ($password_one === $password_two) {
            $password = password_hash($password_one, PASSWORD_BCRYPT);
            $db->modify_password($username, $password);
            session_destroy();
            header("Location: index.php");
            exit();
        }
        else {
            echo "<script>alert('Le password non coincidono');</script>";
        }
    }

    ?>
</head>

<body>

    <div class="wrapper active-popup modify">
        <div class="form-box modify">
            <h2>Reset password</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" id="modify-form">
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" name="password-one" required>
                    <label>Password</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" name="password-two" required>
                    <label>Repeat Password</label>
                </div>
                <button type="submit" name="submit-modify" class="btn">Reset</button>
                <div class="login-register">
                    <p>Already have an account? <a href="index.php" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>