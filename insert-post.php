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

    $t = $db->insert_post($username, $marca, $modello, $anno, $descrizione);

    if ($t == 0) {
        echo 'success';
    } else {
        echo 'error';
    }
}