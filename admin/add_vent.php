<?php
/**
 * Hydrothermal Vent Database - Add Vent
 * Handles the form for creating a new vent record
 * SET08101 Web Technologies Coursework
 */

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$cssPath = '../';
require_once '../includes/db.php';

$pageTitle = 'Add Vent';

// Field values — pre-populated on validation failure so user doesn't retype
$name          = '';
$location      = '';
$type          = '';
$depth_metres  = '';
$discovery_year = '';
$errors        = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitise input
    $name           = trim($_POST['name']           ?? '');
    $location       = trim($_POST['location']       ?? '');
    $type           = trim($_POST['type']           ?? '');
    $depth_metres   = trim($_POST['depth_metres']   ?? '');
    $discovery_year = trim($_POST['discovery_year'] ?? '');

    // Server-side validation
    if ($name === '')           $errors['name']           = 'Name is required.';
    if ($location === '')       $errors['location']       = 'Location is required.';
    if ($type === '')           $errors['type']           = 'Type is required.';

    if (!is_numeric($depth_metres) || (int)$depth_metres <= 0) {
        $errors['depth_metres'] = 'Depth must be a positive number.';
    }

    if (!is_numeric($discovery_year) ||
        (int)$discovery_year < 1900  ||
        (int)$discovery_year > (int)date('Y')) {
        $errors['discovery_year'] = 'Enter a valid 4-digit year.';
    }

    if (empty($errors)) {
        $pdo  = getDbConnection();

        // INSERT using a prepared statement — all values safely bound
        $stmt = $pdo->prepare(
            'INSERT INTO vents (name, location, type, depth_metres, discovery_year)
             VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $name,
            $location,
            $type,
            (int)$depth_metres,
            (int)$discovery_year,
        ]);

        // Redirect with success flag — prevents resubmission on refresh
        header('Location: manage.php?saved=1');
        exit;
    }
}

require_once '../includes/header.php';
?>

<a href="manage.php" class="back-link">&larr; Back to manage</a>

<h2>Add New Vent</h2>

<?php if (!empty($errors)): ?>
    <div class="error-message">Please correct the errors below.</div>
<?php endif; ?>

<div class="card">
    <form method="POST" action="add_vent.php">

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
                       placeholder="e.g. Back-arc basin"
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
                   placeholder="e.g. Bismarck Sea, Papua New Guinea (3.5S, 151.5E)"
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
                       placeholder="e.g. 1650"
                       value="<?php echo e($depth_metres); ?>"
                       class="<?php echo isset($errors['depth_metres']) ? 'error' : ''; ?>">
                <?php if (isset($errors['depth_metres'])): ?>
                    <span class="field-error"><?php echo e($errors['depth_metres']); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="discovery_year">Discovery Year</label>
                <input type="number" id="discovery_year" name="discovery_year"
                       placeholder="e.g. 1985"
                       value="<?php echo e($discovery_year); ?>"
                       class="<?php echo isset($errors['discovery_year']) ? 'error' : ''; ?>">
                <?php if (isset($errors['discovery_year'])): ?>
                    <span class="field-error"><?php echo e($errors['discovery_year']); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Save Vent</button>
            <a href="manage.php" class="btn btn-muted">Cancel</a>
        </div>

    </form>
</div>

<?php require_once '../includes/footer.php'; ?>