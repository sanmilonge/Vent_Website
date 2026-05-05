<?php
/**
 * Hydrothermal Vent Database - Edit Vent
 * Pre-populates a form with existing vent data and handles UPDATE
 * SET08101 Web Technologies Coursework
 */

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$cssPath = '../';
require_once '../includes/db.php';

// Validate the ID from the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manage.php');
    exit;
}

$ventId = (int)$_GET['id'];
$pdo    = getDbConnection();

// Fetch existing vent so we can pre-fill the form
$stmt = $pdo->prepare('SELECT * FROM vents WHERE id = ?');
$stmt->execute([$ventId]);
$vent = $stmt->fetch();

if (!$vent) {
    header('Location: manage.php');
    exit;
}

$pageTitle = 'Edit — ' . $vent['name'];
$errors    = [];

// Initialise fields from the database
$name           = $vent['name'];
$location       = $vent['location'];
$type           = $vent['type'];
$depth_metres   = $vent['depth_metres'];
$discovery_year = $vent['discovery_year'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Overwrite with submitted values
    $name           = trim($_POST['name']           ?? '');
    $location       = trim($_POST['location']       ?? '');
    $type           = trim($_POST['type']           ?? '');
    $depth_metres   = trim($_POST['depth_metres']   ?? '');
    $discovery_year = trim($_POST['discovery_year'] ?? '');

    // Validate
    if ($name === '')     $errors['name']     = 'Name is required.';
    if ($location === '') $errors['location'] = 'Location is required.';
    if ($type === '')     $errors['type']     = 'Type is required.';

    if (!is_numeric($depth_metres) || (int)$depth_metres <= 0) {
        $errors['depth_metres'] = 'Depth must be a positive number.';
    }

    if (!is_numeric($discovery_year) ||
        (int)$discovery_year < 1900  ||
        (int)$discovery_year > (int)date('Y')) {
        $errors['discovery_year'] = 'Enter a valid 4-digit year.';
    }

    if (empty($errors)) {
        // UPDATE using a prepared statement
        $upd = $pdo->prepare(
            'UPDATE vents SET name=?, location=?, type=?, depth_metres=?, discovery_year=?
             WHERE id=?'
        );
        $upd->execute([
            $name,
            $location,
            $type,
            (int)$depth_metres,
            (int)$discovery_year,
            $ventId,
        ]);

        header('Location: manage.php?saved=1');
        exit;
    }
}

require_once '../includes/header.php';
?>

<a href="manage.php" class="back-link">&larr; Back to manage</a>

<h2>Edit Vent</h2>

<?php if (!empty($errors)): ?>
    <div class="error-message">Please correct the errors below.</div>
<?php endif; ?>

<div class="card">
    <form method="POST" action="edit_vent.php?id=<?php echo e($ventId); ?>">

        <div class="form-row">
            <div class="form-group">
                <label for="name">Vent Name</label>
                <input type="text" id="name" name="name"
                       value="<?php echo e($name); ?>"
                       class="<?php echo isset($errors['name']) ? 'error' : ''; ?>">
                <?php if (isset($errors['name'])): ?>
                    <span class="field-error"><?php echo e($errors['name']); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="type">Vent Type</label>
                <input type="text" id="type" name="type"
                       value="<?php echo e($type); ?>"
                       class="<?php echo isset($errors['type']) ? 'error' : ''; ?>">
                <?php if (isset($errors['type'])): ?>
                    <span class="field-error"><?php echo e($errors['type']); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" id="location" name="location"
                   value="<?php echo e($location); ?>"
                   class="<?php echo isset($errors['location']) ? 'error' : ''; ?>">
            <?php if (isset($errors['location'])): ?>
                <span class="field-error"><?php echo e($errors['location']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="depth_metres">Depth (metres)</label>
                <input type="number" id="depth_metres" name="depth_metres"
                       value="<?php echo e($depth_metres); ?>"
                       class="<?php echo isset($errors['depth_metres']) ? 'error' : ''; ?>">
                <?php if (isset($errors['depth_metres'])): ?>
                    <span class="field-error"><?php echo e($errors['depth_metres']); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="discovery_year">Discovery Year</label>
                <input type="number" id="discovery_year" name="discovery_year"
                       value="<?php echo e($discovery_year); ?>"
                       class="<?php echo isset($errors['discovery_year']) ? 'error' : ''; ?>">
                <?php if (isset($errors['discovery_year'])): ?>
                    <span class="field-error"><?php echo e($errors['discovery_year']); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="manage.php" class="btn btn-muted">Cancel</a>
        </div>

    </form>
</div>

<!-- Fauna management for this vent -->
<?php
$faunaStmt = $pdo->prepare('SELECT id, name, scientific_name FROM fauna WHERE vent_id = ? ORDER BY name');
$faunaStmt->execute([$ventId]);
$faunaList = $faunaStmt->fetchAll();
?>

<h2 class="section-heading">Fauna Records</h2>
<p>
    <a href="add_fauna.php?vent_id=<?php echo e($ventId); ?>" class="btn btn-sm btn-primary">
        + Add Fauna
    </a>
</p>

<?php if (empty($faunaList)): ?>
    <p class="text-muted">No fauna records yet.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Common Name</th>
                <th>Scientific Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($faunaList as $f): ?>
                <tr>
                    <td><?php echo e($f['name']); ?></td>
                    <td><em><?php echo e($f['scientific_name']); ?></em></td>
                    <td class="action-btns">
                        <a href="edit_fauna.php?id=<?php echo e($f['id']); ?>&vent_id=<?php echo e($ventId); ?>"
                           class="btn btn-sm btn-warm">Edit</a>
                        <a href="delete_fauna.php?id=<?php echo e($f['id']); ?>&vent_id=<?php echo e($ventId); ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Delete this fauna record?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>