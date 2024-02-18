<?php
global $db;
require_once 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $t = $db->delete_post($id);

    if ($t == 0) {
        echo 'success';
    } else {
        echo 'error';
    }
}
