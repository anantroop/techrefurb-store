<?php
session_start();
include 'php/config.php';
$cart_count = isset($_SESSION['user_id']) ? getCartCount($conn, $_SESSION['user_id']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About – TechRefurb</title>
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
    <section class="about-hero">
        <p class="hero-eyebrow">Our Story</p>
        <h1>Tech for everyone.<br>Not just the lucky ones.</h1>
        <p class="hero-sub">TechRefurb was built on a simple idea — quality technology shouldn't cost a fortune. We source, test, and grade refurbished devices so you can buy with confidence.</p>
    </section>

    <div class="divider"></div>

    <!-- Mission -->
    <section class="about-mission">
        <div class="about-grid">
            <div class="about-text">
                <h2>Our Mission</h2>
                <p>We believe everyone deserves access to reliable technology. By giving pre-owned devices a second life, we make premium tech affordable while reducing electronic waste.</p>
                <p>Every device on TechRefurb goes through a rigorous 30-point inspection and is honestly graded — Grade A, B, or C — so you always know exactly what you're getting.</p>
            </div>
            <div class="about-stats-grid">
                <div class="about-stat">
                    <h3>500+</h3>
                    <p>Products Listed</p>
                </div>
                <div class="about-stat">
                    <h3>1,200+</h3>
                    <p>Happy Customers</p>
                </div>
                <div class="about-stat">
                    <h3>3</h3>
                    <p>Grade Levels</p>
                </div>
                <div class="about-stat">
                    <h3>1 Year</h3>
                    <p>Warranty on All Items</p>
                </div>
            </div>
        </div>
    </section>

    <div class="divider"></div>

    <!-- Grade Explanation -->
    <section class="about-grades">
        <div class="section-header">
            <h2>Understanding Our Grades</h2>
            <p>Honest ratings so you always know what you're buying</p>
        </div>
        <div class="grades-grid">
            <div class="grade-card">
                <span class="grade grade-a">Grade A</span>
                <h3>Like New</h3>
                <p>Minimal to no signs of use. Fully functional, clean screen, no scratches. Best condition available.</p>
            </div>
            <div class="grade-card">
                <span class="grade grade-b">Grade B</span>
                <h3>Good Condition</h3>
                <p>Minor cosmetic marks or light scratches. Fully functional with no impact on performance.</p>
            </div>
            <div class="grade-card">
                <span class="grade grade-c">Grade C</span>
                <h3>Fair Condition</h3>
                <p>Visible wear and scratches. Fully functional — best value for budget-conscious buyers.</p>
            </div>
        </div>
    </section>

    <div class="divider"></div>

    <!-- Values -->
    <section class="why-us">
        <h2>What We Stand For</h2>
        <p class="section-sub">Our values guide everything we do</p>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">♻️</div>
                <h3>Sustainability</h3>
                <p>Every refurbished device is one less item in a landfill</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔎</div>
                <h3>Transparency</h3>
                <p>Honest grading — no surprises when your order arrives</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💰</div>
                <h3>Affordability</h3>
                <p>Premium tech at prices that make sense for everyone</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🤝</div>
                <h3>Trust</h3>
                <p>Every purchase backed by our 1 year warranty promise</p>
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