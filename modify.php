<?php
require_once 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $t = $db->modify_password($username, $password);

        if($t == 0) {
            echo 'success';
        } else {
            echo 'error';
        }
}
?>