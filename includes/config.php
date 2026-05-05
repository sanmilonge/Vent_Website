<?php
/**
 * Configuration file for the Hydrothermal Vent Database
 * SET08101 Web Technologies Coursework
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'vent_fauna');
define('DB_USER', 'root');
define('DB_PASS', '');

// Character encoding
define('DB_CHARSET', 'utf8mb4');

/**
 * HTML escape helper function
 * Always use this when outputting user data or database content to HTML
 *
 * @param string $string The string to escape
 * @return string The escaped string safe for HTML output
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
