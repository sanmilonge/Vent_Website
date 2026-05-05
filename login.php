<?php
/**
 * Hydrothermal Vent Database - Login Page
 * Handles admin authentication using sessions
 * SET08101 Web Technologies Coursework
 */

require_once 'includes/db.php';
session_start();
// If already logged in, send straight to admin panel
if (isset($_SESSION['user_id'])) {
    header('Location: admin/manage.php');
    exit;
}
$pageTitle = 'Login';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        $pdo  = getDbConnection();

        $stmt = $pdo->prepare('SELECT id, username, password_hash FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Password matches — store user ID in session
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username']  = $user['username'];

            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            header('Location: admin/manage.php');
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
require_once 'includes/header.php';
?>
<div class="auth-wrap">
    <div class="auth-box">
        <h2>Admin Login</h2>

        <?php if ($error): ?>
            <div class="error-message"><?php echo e($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text"
                       id="username"
                       name="username"
                       class="textfield"
                       value="<?php echo e($_POST['username'] ?? ''); ?>"
                       autocomplete="username"
                       required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password"
                       id="password"
                       name="password"
                       class="textfield"
                       autocomplete="current-password"
                       required>
            </div>
            <button type="submit" class="btn btn-primary">
                Log In
            </button>
        </form>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>