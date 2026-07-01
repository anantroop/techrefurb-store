<?php
session_start();
include 'php/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$cart_count = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed – TechRefurb</title>
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
                <a href="#">About</a>
                <a href="#">Contact</a>
            </nav>
            <div class="nav-user">
                👋 <?php echo htmlspecialchars($_SESSION['user_name']); ?> &nbsp;|&nbsp;
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>

    <section class="success-section">
        <div class="success-card">
            <div class="success-icon">✅</div>
            <h2>Order Placed!</h2>
            <p>Thank you for your order. Your refurbished tech is on its way!</p>
            <p class="order-number">Order #<?php echo str_pad($order_id, 5, '0', STR_PAD_LEFT); ?></p>
            <div class="success-buttons">
                <a href="products.php" class="btn-primary">Continue Shopping</a>
                <a href="index.php" class="btn-ghost">Back to Home ›</a>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-top">
            <div class="footer-logo">TechRefurb</div>
            <div class="footer-links">
                <a href="index.php">Home</a>
                <a href="products.php">Products</a>
                <a href="#">About</a>
                <a href="login.php">Login</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright &copy; 2026 TechRefurb Store. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>