<?php
/**
 * Hydrothermal Vent Database - Home Page
 * Displays a searchable, filterable list of all hydrothermal vents
 * SET08101 Web Technologies Coursework
 */

require_once 'includes/db.php';

$pageTitle = 'All Vents';
$pdo = getDbConnection();

// ── Search / filter logic ─────────────────────────────────────────────────
// Collect inputs from GET — all user input must be validated/escaped
$search     = isset($_GET['search'])    ? trim($_GET['search'])    : '';
$typeFilter = isset($_GET['type'])      ? trim($_GET['type'])      : '';
$depthMin   = isset($_GET['depth_min']) && is_numeric($_GET['depth_min']) ? (int)$_GET['depth_min'] : '';
$depthMax   = isset($_GET['depth_max']) && is_numeric($_GET['depth_max']) ? (int)$_GET['depth_max'] : '';


$where  = [];
$params = [];

if ($search !== '') {
    $where[]  = '(name LIKE ? OR location LIKE ?)';
    $params[] = '%' . $search . '%';
    $params[] = '%' . $search . '%';
}

if ($typeFilter !== '') {
    $where[]  = 'type = ?';
    $params[] = $typeFilter;
}

if ($depthMin !== '') {
    $where[]  = 'depth_metres >= ?';
    $params[] = $depthMin;
}

if ($depthMax !== '') {
    $where[]  = 'depth_metres <= ?';
    $params[] = $depthMax;
}

$sql = 'SELECT id, name, location, type, depth_metres, discovery_year FROM vents';
if (!empty($where)) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY name';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$vents = $stmt->fetchAll();

// Fetch distinct vent types for the filter dropdown
$types = $pdo->query('SELECT DISTINCT type FROM vents ORDER BY type')
             ->fetchAll(PDO::FETCH_COLUMN);

// Total count for stats
$totalVents = $pdo->query('SELECT COUNT(*) FROM vents')->fetchColumn();

// Is any filter active? Used to keep panel open on page reload
$filterActive = ($search !== '' || $typeFilter !== '' || $depthMin !== '' || $depthMax !== '');

require_once 'includes/header.php';
?>

<div class="vent-list-header">
    <h2>All Vents</h2>
    <button class="search-filter" id="filterToggle">
        <?php echo $filterActive ? '▲ Filter' : '▼ Filter'; ?>
    </button>
</div>

<p>Explore our database of hydrothermal vents from the Western Pacific region.</p>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-box">
        <span class="stat-number"><?php echo $totalVents; ?></span>
        <span class="stat-label">Total Vents</span>
    </div>
    <div class="stat-box">
        <span class="stat-number"><?php echo count($types); ?></span>
        <span class="stat-label">Vent Types</span>
    </div>
    <div class="stat-box">
        <span class="stat-number"><?php echo count($vents); ?></span>
        <span class="stat-label">Showing</span>
    </div>
</div>

<!-- Search / filter panel — toggled by the button above -->
<div class="search-panel <?php echo $filterActive ? 'open' : ''; ?>" id="searchPanel">
    <form method="GET" action="index.php" class="search-panel-inner">

        <div class="form-group">
            <label for="search">Search</label>
            <input type="text"
                   id="search"
                   name="search"
                   placeholder="Name or location…"
                   value="<?php echo e($search); ?>">
        </div>

        <div class="form-group">
            <label for="type">Vent Type</label>
            <select id="type" name="type">
                <option value="">All Types</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?php echo e($type); ?>"
                        <?php echo ($typeFilter === $type) ? 'selected' : ''; ?>>
                        <?php echo e($type); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="depth_min">Min Depth (m)</label>
            <input type="number"
                   id="depth_min"
                   name="depth_min"
                   placeholder="e.g. 1000"
                   value="<?php echo e($depthMin); ?>">
        </div>

        <div class="form-group">
            <label for="depth_max">Max Depth (m)</label>
            <input type="number"
                   id="depth_max"
                   name="depth_max"
                   placeholder="e.g. 3000"
                   value="<?php echo e($depthMax); ?>">
        </div>

        <div class="form-group">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-primary">Apply</button>
        </div>

        <?php if ($filterActive): ?>
        <div class="form-group">
            <label>&nbsp;</label>
            <a href="index.php" class="btn btn-muted">Clear</a>
        </div>
        <?php endif; ?>

    </form>
</div>

<!-- Results table -->
<?php if (empty($vents)): ?>
    <div class="alert-info">No vents found matching your search criteria.</div>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Location</th>
                <th>Type</th>
                <th>Depth (m)</th>
                <th>Discovered</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vents as $vent): ?>
                <tr>
                    <td><?php echo e($vent['name']); ?></td>
                    <td><?php echo e($vent['location']); ?></td>
                    <td><span class="badge badge-type"><?php echo e($vent['type']); ?></span></td>
                    <td><span class="badge badge-depth"><?php echo e($vent['depth_metres']); ?>m</span></td>
                    <td><?php echo e($vent['discovery_year']); ?></td>
                    <td>
                        <a href="vent.php?id=<?php echo e($vent['id']); ?>" class="btn btn-sm btn-primary">
                            View &rarr;
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>