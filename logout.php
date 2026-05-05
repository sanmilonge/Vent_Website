<?php
/**
 * Hydrothermal Vent Database - Logout
 * Destroys the session and redirects to home
 * SET08101 Web Technologies Coursework
 */

session_start();

// Destroy all session data — this logs the user out
$_SESSION = [];
session_destroy();

header('Location: index.php');
exit;