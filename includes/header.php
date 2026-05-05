<?php
/**
 * Hydrothermal Vent Database - Header Template
 * Included at the top of every page
 * SET08101 Web Technologies Coursework
 */

// Start session on every page so $_SESSION is always available.
// session_start() is safe to call multiple times — it only creates
// a new session if one doesn't already exist.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? e($pageTitle) . ' — ' : ''; ?>Hydrothermal Vent Database</title>
    <link rel="stylesheet" href="<?php echo isset($cssPath) ? $cssPath : ''; ?>css/reset.css">
    <link rel="stylesheet" href="<?php echo isset($cssPath) ? $cssPath : ''; ?>css/styles.css">
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="crossorigin=""></script>
</head>
<body>
<header>
    <h1>Hydrothermal Vent Database</h1>
    <nav>
        <a href="<?php echo isset($cssPath) ? $cssPath : ''; ?>index.php"
           <?php if(basename($_SERVER['PHP_SELF']) === 'index.php') echo 'class="active"'; ?>>
            Home
        </a>
        <a href="<?php echo isset($cssPath) ? $cssPath : ''; ?>vent_map.html"
           <?php if(basename($_SERVER['PHP_SELF']) === 'vent_map.html') echo 'class="active"'; ?>>
            Vent Map
        </a>
        <a href="<?php echo isset($cssPath) ? $cssPath : ''; ?>contact.php"
           <?php if(basename($_SERVER['PHP_SELF']) === 'contact.php') echo 'class="active"'; ?>>
            Contact
        </a>
        <a href="<?php echo isset($cssPath) ? $cssPath : ''; ?>about.php"
           <?php if(basename($_SERVER['PHP_SELF']) === 'about.php') echo 'class="active"'; ?>>
            About
        </a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="<?php echo isset($cssPath) ? $cssPath : ''; ?>admin/manage.php"
               <?php if(basename($_SERVER['PHP_SELF']) === 'manage.php') echo 'class="active"'; ?>>
                Admin
            </a>
            <a href="<?php echo isset($cssPath) ? $cssPath : ''; ?>logout.php"
               class="btn btn-sm btn-warm">
                Logout
            </a>
        <?php else: ?>
            <a href="<?php echo isset($cssPath) ? $cssPath : ''; ?>login.php"
               <?php if(basename($_SERVER['PHP_SELF']) === 'login.php') echo 'class="active"'; ?>>
                Login
            </a>
        <?php endif; ?>
    </nav>
</header>
<main>