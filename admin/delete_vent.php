<?php
/**
 * Hydrothermal Vent Database - Delete Vent
 * Deletes a vent and all its associated fauna (via CASCADE)
 * SET08101 Web Technologies Coursework
 */

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manage.php');
    exit;
}

$ventId = (int)$_GET['id'];
require_once '../includes/db.php';
$pdo = getDbConnection();

// DELETE with a prepared statement.
// The fauna table has ON DELETE CASCADE so related fauna are
// automatically removed when their parent vent is deleted.
$stmt = $pdo->prepare('DELETE FROM vents WHERE id = ?');
$stmt->execute([$ventId]);

header('Location: manage.php?deleted=1');
exit;