<?php
session_start();
if (isset($_SESSION['username']) || isset($_COOKIE['username'])) {
    // Unset all of the session variables
    $_SESSION = array();
    setcookie("username", "", time() - 3600);

    // Destroy the session
    session_destroy();

    // Send a response indicating successful logout
    http_response_code(200);
} else {
    // Send a response indicating unauthorized access
    http_response_code(403);
}
?>