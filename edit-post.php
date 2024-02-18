<?php
global $db;
session_start();
require_once 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $marca = $_POST['marca'];
    $modello = $_POST['modello'];
    $anno = $_POST['anno'];
    $descrizione = $_POST['descrizione'];

    $t = $db->edit_post($id, $marca, $modello, $anno, $descrizione);

    if ($t == 0) {
        echo 'success';
    } else {
        echo 'error';
    }
}
