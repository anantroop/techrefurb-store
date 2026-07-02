<?php
session_start();
include 'php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechRefurb Store</title>
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
            <?php if (isset($_SESSION['user_id'])):
                $cart_count = getCartCount($conn, $_SESSION['user_id']);
            ?>
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

    <section class="hero">
        <p class="hero-eyebrow">Certified Refurbished</p>
        <h1>The best tech.<br>At honest prices.</h1>
        <p class="hero-sub">Shop refurbished laptops, phones and accessories — all graded, tested and ready.</p>
        <div class="hero-buttons">
            <a href="products.php" class="btn-primary">Shop Now</a>
            <a href="#" class="btn-ghost">Learn more ›</a>
        </div>
    </section>

    <div class="divider"></div>

    <section class="products">
        <h2>Featured Products</h2>
        <p class="section-sub">Handpicked. Tested. Guaranteed.</p>
        <div class="product-grid">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM products LIMIT 6");
            while ($product = mysqli_fetch_assoc($result)) {
                $icon = "💻";
                if ($product['category'] == "Phone") $icon = "📱";
                if ($product['category'] == "Accessory") $icon = "🎧";
                $grade_class = "grade-" . strtolower($product['grade']);
            ?>
                <div class="product-card">
                    <div class="product-img"><?php echo $icon; ?></div>
                    <span class="grade <?php echo $grade_class; ?>">Grade <?php echo $product['grade']; ?></span>
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <div class="price">QAR <?php echo number_format($product['price'], 2); ?></div>
                    <a href="<?php echo isset($_SESSION['user_id']) ? 'cart.php?add=' . $product['id'] : 'login.php'; ?>" class="btn-card">Add to Cart</a>
                </div>
            <?php } ?>
        </div>
    </section>

    <div class="divider"></div>

    <section class="why-us">
        <h2>Why TechRefurb?</h2>
        <p class="section-sub">Every device earns its place.</p>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🔍</div>
                <h3>30-Point Inspection</h3>
                <p>Every device is tested thoroughly before it's listed</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🏷️</div>
                <h3>Honest Grading</h3>
                <p>Grade A, B, C — you know exactly what you're buying</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3>1 Year Warranty</h3>
                <p>All products backed by a minimum 1 year warranty</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🚚</div>
                <h3>Fast Delivery</h3>
                <p>Same day delivery across Doha, next day across Qatar</p>
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
    </footer>

</body>
</html>