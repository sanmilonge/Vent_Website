<?php
/**
 * Hydrothermal Vent Database - Delete Fauna
 * Deletes a single fauna record and returns to the vent edit page
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

$faunaId = (int)$_GET['id'];
$ventId  = isset($_GET['vent_id']) && is_numeric($_GET['vent_id']) ? (int)$_GET['vent_id'] : null;

require_once '../includes/db.php';
$pdo = getDbConnection();

$stmt = $pdo->prepare('DELETE FROM fauna WHERE id = ?');
$stmt->execute([$faunaId]);

// Return to the vent's edit page, or manage if no vent ID
if ($ventId) {
    header('Location: edit_vent.php?id=' . $ventId . '&deleted=1');
} else {
    header('Location: manage.php?deleted=1');
}
exit;