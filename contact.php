<?php
session_start();
include 'php/config.php';
$cart_count = isset($_SESSION['user_id']) ? getCartCount($conn, $_SESSION['user_id']) : 0;

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if ($name && $email && $subject && $message) {
        $success = "Thanks for reaching out, $name! We'll get back to you within 24 hours.";
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact – TechRefurb</title>
    <link rel="stylesheet" href="css/style.css?v=3">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <div class="navbar">
            <div class="logo"><a href="index.php">TechRefurb</a></div>
            <nav>
                <a href="index.php">Home</a>
                <a href="products.php">Products</a>
                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
            </nav>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="nav-user">
                    👋 <?php echo htmlspecialchars($_SESSION['user_name']); ?> &nbsp;|&nbsp;
                    <a href="cart.php" class="cart-link">
                        🛒 Cart <?php if ($cart_count > 0): ?>
                            <span class="cart-badge"><?php echo $cart_count; ?></span>
                        <?php endif; ?>
                    <a href="orders.php">My Orders</a> &nbsp;|&nbsp;
                    <a href="logout.php">Logout</a>
                </div>
            <?php else: ?>
                <a href="login.php" class="nav-login">Login</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Hero -->
    <section class="contact-hero">
        <p class="hero-eyebrow">Get in Touch</p>
        <h1>We'd love to<br>hear from you.</h1>
        <p class="hero-sub">Have a question about a product, order, or anything else? Our team is here to help.</p>
    </section>

    <div class="divider"></div>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="contact-grid">

            <!-- Left: Info -->
            <div class="contact-info">
                <h3>Contact Information</h3>
                <div class="contact-item">
                    <span class="contact-icon">📍</span>
                    <div>
                        <p class="contact-label">Location</p>
                        <p class="contact-value">Doha, Qatar</p>
                    </div>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">📧</span>
                    <div>
                        <p class="contact-label">Email</p>
                        <p class="contact-value">support@techrefurb.qa</p>
                    </div>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">📞</span>
                    <div>
                        <p class="contact-label">Phone</p>
                        <p class="contact-value">+974 4000 0000</p>
                    </div>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">🕐</span>
                    <div>
                        <p class="contact-label">Working Hours</p>
                        <p class="contact-value">Sun – Thu, 9am – 6pm</p>
                    </div>
                </div>
            </div>

            <!-- Right: Form -->
            <div class="contact-form-box">
                <h3>Send us a Message</h3>

                <?php if ($success): ?>
                    <p class="auth-success"><?php echo $success; ?></p>
                <?php endif; ?>
                <?php if ($error): ?>
                    <p class="auth-error"><?php echo $error; ?></p>
                <?php endif; ?>

                <form method="POST" action="contact.php">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" placeholder="Your full name" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="you@example.com" required>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="subject" placeholder="What's this about?" required>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" placeholder="Write your message here..." rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Send Message</button>
                </form>
            </div>

        </div>
    </section>

    <footer>
        <div class="footer-top">
            <div class="footer-logo">TechRefurb</div>
            <div class="footer-links">
                <a href="index.php">Home</a>
                <a href="products.php">Products</a>
                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
                <a href="login.php">Login</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright &copy; 2026 TechRefurb Store. All rights reserved. &nbsp;·&nbsp; <a href="admin_login.php" class="admin-footer-link">Admin</a></p>
        </div>
    </footer>

</body>
</html>