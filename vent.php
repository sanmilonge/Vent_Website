<?php
/**
 * Hydrothermal Vent Database - Single Vent Page
 * Displays details of a single vent
 *
 * SET08101 Web Technologies Coursework Starter Code
 */

require_once 'includes/db.php';

// Validate the vent ID parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$ventId = (int)$_GET['id'];
$pdo = getDbConnection();

// Fetch the vent details
$stmt = $pdo->prepare('SELECT id, name, location, type, depth_metres, discovery_year FROM vents WHERE id = ?');
$stmt->execute([$ventId]);
$vent = $stmt->fetch();

// Fetch the fauna details
$stmnt = $pdo->prepare('SELECT id, vent_id, name, scientific_name, description, image_url FROM fauna WHERE vent_id = ?');
$stmnt->execute([$ventId]);
$faunaList = $stmnt->fetchAll();

// If vent not found, redirect to home
if (!$vent) {
    header('Location: index.php');
    exit;
}
$pageTitle = $vent['name'];

require_once 'includes/header.php';
?>

<p><a href="index.php">&larr; Back to all vents</a></p>

<div class="vent-details">
    <h2><?php echo e($vent['name']); ?></h2>

    <dl>
        <dt>Location</dt>
        <dd id="location"><?php echo e($vent['location']); ?></dd>

        <dt>Type</dt>
        <dd><?php echo e($vent['type']); ?></dd>

        <dt>Depth</dt>
        <dd><?php echo e($vent['depth_metres']); ?> metres</dd>

        <dt>Discovery Year</dt>
        <dd><?php echo e($vent['discovery_year']); ?></dd>
    </dl>
</div>
<div id="map"></div>
<!-- If fauna not found, print error message -->
<?php if (empty($faunaList)): ?>
    <p class="error-message">No fauna found for this vent.</p>
<?php else: ?>
    <h3><?php echo e($pageTitle);?> Fauna</h3>
    <?php foreach ($faunaList as $fauna): ?>
        <div class="fauna-card">
            <img src="<?php echo e($fauna['image_url']); ?>" alt="The <?php echo e($fauna['scientific_name']); ?>">
            <div class="fauna-card-content">
                <h3><?php echo e($fauna['name']); ?></h3>
                <h5 class="sci">Scientific Name: <?php echo e($fauna['scientific_name']); ?></h5>
                <p><?php echo e($fauna['description']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>


<?php require_once 'includes/footer.php'; ?>
