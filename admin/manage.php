<?php
/**
 * Hydrothermal Vent Database - Admin Management Page
 * Lists all vents with options to add, edit, and delete
 * SET08101 Web Technologies Coursework
 */

// The session must be started before we can read $_SESSION
session_start();

// Redirects to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// cssPath tells header.php how to find css/ and js/ from inside admin/
$cssPath = '../';

require_once '../includes/db.php';

$pageTitle = 'Admin — Manage Vents';
$pdo = getDbConnection();

// Fetch all vents for the management table
$vents = $pdo->query('SELECT id, name, type, depth_metres, discovery_year FROM vents ORDER BY name')
             ->fetchAll();

require_once '../includes/header.php';
?>

<div class="vent-list-header">
    <h2>Manage Vents</h2>
    <a href="add_vent.php" class="btn btn-primary">+ Add Vent</a>
</div>

<p>Logged in as <strong><?php echo e($_SESSION['username']); ?></strong>.
   <a href="../logout.php">Log out</a></p>

<?php if (isset($_GET['deleted'])): ?>
    <div class="success-message">Vent deleted successfully.</div>
<?php endif; ?>

<?php if (isset($_GET['saved'])): ?>
    <div class="success-message">Vent saved successfully.</div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Depth (m)</th>
            <th>Discovered</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($vents as $vent): ?>
            <tr>
                <td><?php echo e($vent['name']); ?></td>
                <td><span class="badge badge-type"><?php echo e($vent['type']); ?></span></td>
                <td><?php echo e($vent['depth_metres']); ?>m</td>
                <td><?php echo e($vent['discovery_year']); ?></td>
                <td>
                    <a href="../vent.php?id=<?php echo e($vent['id']); ?>"
                       class="btn btn-sm btn-muted">View</a>
                    <a href="edit_vent.php?id=<?php echo e($vent['id']); ?>"
                       class="btn btn-sm btn-warm">Edit</a>
                    <a href="delete_vent.php?id=<?php echo e($vent['id']); ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Delete <?php echo e(addslashes($vent['name'])); ?>? This will also delete all its fauna records.')">
                       Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>