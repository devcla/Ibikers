<?php
global $db;
session_start();
require_once 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $email = $_POST['email'];

        $t = $db->register_user($username,$email,$password);

        if($t == 0) {
            echo 'success';
        } else {
            echo 'error';
        }
}
