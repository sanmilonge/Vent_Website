<?php
/**
 * Hydrothermal Vent Database - Edit Fauna
 * Pre-populates form with existing fauna data and handles UPDATE
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

$cssPath = '../';
require_once '../includes/db.php';

$pdo  = getDbConnection();
$stmt = $pdo->prepare('SELECT * FROM fauna WHERE id = ?');
$stmt->execute([$faunaId]);
$fauna = $stmt->fetch();

if (!$fauna) { header('Location: manage.php'); exit; }

// Use vent_id from DB if not in URL
if (!$ventId) $ventId = $fauna['vent_id'];

$pageTitle = 'Edit Fauna — ' . $fauna['name'];
$errors    = [];

$name            = $fauna['name'];
$scientific_name = $fauna['scientific_name'];
$description     = $fauna['description'];
$image_url       = $fauna['image_url'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name            = trim($_POST['name']            ?? '');
    $scientific_name = trim($_POST['scientific_name'] ?? '');
    $description     = trim($_POST['description']     ?? '');
    $image_url       = trim($_POST['image_url']       ?? '');

    if ($name === '')            $errors['name']            = 'Common name is required.';
    if ($scientific_name === '') $errors['scientific_name'] = 'Scientific name is required.';

    if (empty($errors)) {
        $upd = $pdo->prepare(
            'UPDATE fauna SET name=?, scientific_name=?, description=?, image_url=?
             WHERE id=?'
        );
        $upd->execute([$name, $scientific_name, $description, $image_url, $faunaId]);

        header('Location: edit_vent.php?id=' . $ventId . '&saved=1');
        exit;
    }
}

require_once '../includes/header.php';
?>

<a href="edit_vent.php?id=<?php echo e($ventId); ?>" class="back-link">&larr; Back to vent</a>

<h2>Edit Fauna</h2>

<?php if (!empty($errors)): ?>
    <div class="error-message">Please correct the errors below.</div>
<?php endif; ?>

<div class="card">
    <form method="POST" action="edit_fauna.php?id=<?php echo e($faunaId); ?>&vent_id=<?php echo e($ventId); ?>">

        <div class="form-row">
            <div class="form-group">
                <label for="name">Common Name</label>
                <input type="text" id="name" name="name"
                       value="<?php echo e($name); ?>"
                       class="<?php echo isset($errors['name']) ? 'error' : ''; ?>">
                <?php if (isset($errors['name'])): ?>
                    <span class="field-error"><?php echo e($errors['name']); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="scientific_name">Scientific Name</label>
                <input type="text" id="scientific_name" name="scientific_name"
                       value="<?php echo e($scientific_name); ?>"
                       class="<?php echo isset($errors['scientific_name']) ? 'error' : ''; ?>">
                <?php if (isset($errors['scientific_name'])): ?>
                    <span class="field-error"><?php echo e($errors['scientific_name']); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description"><?php echo e($description); ?></textarea>
        </div>

        <div class="form-group">
            <label for="image_url">Image Path</label>
            <input type="text" id="image_url" name="image_url"
                   value="<?php echo e($image_url); ?>">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="edit_vent.php?id=<?php echo e($ventId); ?>" class="btn btn-muted">Cancel</a>
        </div>

    </form>
</div>

<?php require_once '../includes/footer.php'; ?>