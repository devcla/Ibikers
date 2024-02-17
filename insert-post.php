<?php
global $db;
require_once 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = '';
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    } elseif (isset($_COOKIE['username'])) {
        $username = $_COOKIE['username'];
    }
    $marca = $_POST['marca'];
    $modello = $_POST['modello'];
    $anno = $_POST['anno'];
    $descrizione = $_POST['descrizione'];

    $target_directory = "uploads/";
    $target_file = $target_directory.basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    if ($_FILES["image"]["size"] > 10485760) {
        $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo 'error';
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $t = $db->insert_post($username, $marca, $modello, $anno, $descrizione);

            if ($t == 0) {
                echo 'success';
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }
}