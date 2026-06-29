<?php include 'php/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechRefurb Store</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <header>
        <div class="navbar">
            <div class="logo">TechRefurb</div>
            <nav>
                <a href="#">Home</a>
                <a href="#">Products</a>
                <a href="#">About</a>
                <a href="#">Contact</a>
            </nav>
            <a href="#" class="nav-login">Login</a>
        </div>
    </header>

    <!-- Hero -->
    <section class="hero">
        <p class="hero-eyebrow">Certified Refurbished</p>
        <h1>The best tech.<br>At honest prices.</h1>
        <p class="hero-sub">Shop refurbished laptops, phones and accessories — all graded, tested and ready.</p>
        <div class="hero-buttons">
            <a href="#" class="btn-primary">Shop Now</a>
            <a href="#" class="btn-ghost">Learn more ›</a>
        </div>
    </section>

    <!-- Divider -->
    <div class="divider"></div>

    <!-- Products -->
    <section class="products">
        <h2>Featured Products</h2>
        <p class="section-sub">Handpicked. Tested. Guaranteed.</p>
        <div class="product-grid">

            <div class="product-card">
                <div class="product-img">💻</div>
                <span class="grade grade-a">Grade A</span>
                <h3>Dell Latitude 5490</h3>
                <p>Intel i5 · 8GB RAM · 256GB SSD</p>
                <div class="price">QAR 1,299</div>
                <a href="#" class="btn-card">Add to Cart</a>
            </div>

            <div class="product-card">
                <div class="product-img">📱</div>
                <span class="grade grade-a">Grade A</span>
                <h3>Samsung Galaxy S21</h3>
                <p>128GB · Excellent condition</p>
                <div class="price">QAR 899</div>
                <a href="#" class="btn-card">Add to Cart</a>
            </div>

            <div class="product-card">
                <div class="product-img">💻</div>
                <span class="grade grade-b">Grade B</span>
                <h3>HP EliteBook 840</h3>
                <p>Intel i7 · 16GB RAM · 512GB SSD</p>
                <div class="price">QAR 1,799</div>
                <a href="#" class="btn-card">Add to Cart</a>
            </div>

            <div class="product-card">
                <div class="product-img">📱</div>
                <span class="grade grade-a">Grade A</span>
                <h3>iPhone 13</h3>
                <p>256GB · Battery 89%</p>
                <div class="price">QAR 1,499</div>
                <a href="#" class="btn-card">Add to Cart</a>
            </div>

            <div class="product-card">
                <div class="product-img">🎧</div>
                <span class="grade grade-b">Grade B</span>
                <h3>Sony WH-1000XM4</h3>
                <p>Noise Cancelling · Good condition</p>
                <div class="price">QAR 499</div>
                <a href="#" class="btn-card">Add to Cart</a>
            </div>

            <div class="product-card">
                <div class="product-img">💻</div>
                <span class="grade grade-c">Grade C</span>
                <h3>Lenovo ThinkPad T470</h3>
                <p>Intel i5 · 8GB RAM · 256GB SSD</p>
                <div class="price">QAR 799</div>
                <a href="#" class="btn-card">Add to Cart</a>
            </div>

        </div>
    </section>

    <!-- Divider -->
    <div class="divider"></div>

    <!-- Why Us -->
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

    <!-- Footer -->
    <footer>
        <div class="footer-top">
            <div class="footer-logo">TechRefurb</div>
            <div class="footer-links">
                <a href="#">Home</a>
                <a href="#">Products</a>
                <a href="#">About</a>
                <a href="#">Contact</a>
                <a href="#">Login</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright &copy; 2026 TechRefurb Store. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>