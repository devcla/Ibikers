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
            <div class="logout">
                <button id="btn-logout" class="btnLogout-popup">Logout</button>
            </div>
        </nav>
    </header>

    <div class="wrapper">
        <span class="icon-back">
            <ion-icon name="arrow-back"></ion-icon>
        </span>

        <div class="form-box insert">
            <h2>New Post</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" id="insert-form">
                <div class="input-box">
                    <input type="text" id="marca" name="marca" required>
                    <label for="marca">Marca</label>
                </div>
                <div class="input-box">
                    <input type="text" id="modello" name="modello" required>
                    <label for="modello">Modello</label>
                </div>
                <div class="input-box">
                    <input type="number" id="anno" name="anno" min="1950" max="2025" required>
                    <label for="anno">Anno</label>
                </div>
                <div class="textarea-box">
                    <textarea id="descrizione" name="descrizione" rows="10" cols="40"></textarea>
                    <label for="descrizione">Descrizione</label>
                </div>
                <button type="submit" name="submit-insert" class="btn">Insert</button>
            </form>
        </div>
    </div>

    <script src="insert-script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>