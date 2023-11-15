<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} // Start the session

// Unset all of the session variables.
session_unset();

// Destroy the session.
session_destroy();

// Redirect to login page or homepage
header("Location: /login");
exit();
