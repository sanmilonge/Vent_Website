<?php
/**
 * Hydrothermal Vent Database - About Page
 * SET08101 Web Technologies Coursework
 */

require_once 'includes/db.php';
$pageTitle = 'About';
$pdo = getDbConnection();
$totalVents = $pdo->query('SELECT COUNT(*) FROM vents')->fetchColumn();

require_once 'includes/header.php';
?>
<main>
    <section class="stats-row" style="max-width: 700px; margin: 2rem auto 0 auto;">
        <div class="stat-box">
            <span class="stat-number"><?php echo $totalVents; ?></span>
            <span class="stat-label">Total Vents</span>
        </div>
    </section>
    <section class="about-card">
        <h2>About the Hydrothermal Vent Database</h2>
        <p>
            This website is a student coursework project for SET08101 Web Technologies. It provides a searchable, interactive resource for exploring hydrothermal vent fields and the unique fauna that inhabit them.
        </p>
        <h3>Project Features</h3>
        <ul>
            <li>Browse and search through a list of hydrothermal vents</li>
            <li>View detailed information and associated fauna for each vent</li>
            <li>Contact form for questions and contributions</li>
            <li>Admin panel for managing vent and fauna records (secure login required)</li>
            <li>Responsive and accessible design</li>
        </ul>
        <h3>Technologies Used</h3>
        <ul>
            <li>PHP (with PDO for secure database access)</li>
            <li>MySQL</li>
            <li>HTML5 &amp; CSS3 (Flexbox, custom variables, responsive design)</li>
            <li>JavaScript (form validation, UI enhancements)</li>
        </ul>
        <h3>Credits &amp; Attribution</h3>
        <ul>
            <li>Vent and fauna data: Sourced from scientific literature and open databases</li>
            <li>Static map image: Wikimedia Commons (CC BY-SA)</li>
            <li>Live map: Leaflet javascript library</li>
            <li>Map tile: Open Street Map</li>
            <li>Project by: Oluwasanmi Longe</li>
        </ul>
    </section>
</main>
<?php require_once 'includes/footer.php'; ?>