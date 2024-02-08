<?php
session_start();
require_once 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $t = $db->check_login($username, $password);

        if($t == 0 && isset($_POST['remember'])) {
            $_SESSION['username'] = $username;
            echo 'success';
        } elseif ($t == 0) {
            echo 'success';
        } else {
            echo 'error';
        }


}
?>