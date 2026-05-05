
<?php
/**
 * Hydrothermal Vent Database - Contact Page with Contact Form Logic
 *
 * SET08101 Web Technologies Coursework Starter Code
 */

require_once 'includes/config.php'; 
require_once 'includes/db.php';

$pageTitle = 'Contact Us';


// Set default values for form fields
$name = '';
$email = '';
$message = '';
$nameError = '';
$emailError = '';
$messageError = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');


    // server-side validation
    if ($name && $email && $message) {
        header('Location: contact.php?success=1');
        exit;
    } else {
        if (!$name) {
            $nameError = 'Please enter your name.';
        }
        if (!$email) {
            $emailError = 'Please enter your email.';
        }
        if (!$message) {
            $messageError = 'Please enter your message.';
        }    }
}

require_once 'includes/header.php';

// Show success or error message
if (isset($_GET['success'])) {
    echo '<p class="success-message">Thank you for your message! We will get back to you soon.</p>';
} elseif ($emailError || $nameError || $messageError) {
    echo '<p class="error-message"> Please correct the errors in the form.</p>';
}

?>
<h2>Contact Us</h2>
<p>If you have any questions or would like to contribute to our database, please fill out the form below:</p>   

<form action="contact.php" method="post" id="contact-form">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo e($name); ?>" required>
        <span class="field-error" id="name-error"><?php echo e($nameError); ?></span>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo e($email); ?>" required>
        <span class="field-error" id="email-error"><?php echo e($emailError); ?></span>
    </div>
    <div class="form-group">
        <label for="message">Message</label>
        <textarea id="message" name="message" rows="5" required><?php echo e($message); ?></textarea>
        <span class="field-error" id="message-error"><?php echo e($messageError); ?></span>
    </div>
    <button type="submit" class="btn-primary">Send Message</button>
</form>

<?php require_once 'includes/footer.php'; ?>