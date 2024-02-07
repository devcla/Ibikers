<?php
session_start();
if (isset($_SESSION['username'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Send a response indicating successful logout
    http_response_code(200);
} else {
    // Send a response indicating unauthorized access
    http_response_code(403);
}
?>