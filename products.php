<?php
session_start();
include 'php/config.php';

$category_filter = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';
$grade_filter = isset($_GET['grade']) ? mysqli_real_escape_string($conn, $_GET['grade']) : '';

$query = "SELECT * FROM products WHERE 1=1";
if ($category_filter) $query .= " AND category='$category_filter'";
if ($grade_filter) $query .= " AND grade='$grade_filter'";
$query .= " ORDER BY created_at DESC";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products – TechRefurb</title>
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
                <a href="#">Contact</a>
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
                    </a> &nbsp;|&nbsp;
                    <a href="logout.php">Logout</a>
                </div>
            <?php else: ?>
                <a href="login.php" class="nav-login">Login</a>
            <?php endif; ?>
        </div>
    </header>

    <section class="products-page">
        <div class="products-header">
            <h1>All Products</h1>
            <p>Browse our full range of certified refurbished tech</p>
        </div>

        <div class="filters">
            <a href="products.php" class="filter-btn <?php echo (!$category_filter && !$grade_filter) ? 'active' : ''; ?>">All</a>
            <a href="products.php?category=Laptop" class="filter-btn <?php echo ($category_filter == 'Laptop') ? 'active' : ''; ?>">💻 Laptops</a>
            <a href="products.php?category=Phone" class="filter-btn <?php echo ($category_filter == 'Phone') ? 'active' : ''; ?>">📱 Phones</a>
            <a href="products.php?category=Accessory" class="filter-btn <?php echo ($category_filter == 'Accessory') ? 'active' : ''; ?>">🎧 Accessories</a>
            <span class="filter-divider">|</span>
            <a href="products.php?grade=A" class="filter-btn <?php echo ($grade_filter == 'A') ? 'active' : ''; ?>">Grade A</a>
            <a href="products.php?grade=B" class="filter-btn <?php echo ($grade_filter == 'B') ? 'active' : ''; ?>">Grade B</a>
            <a href="products.php?grade=C" class="filter-btn <?php echo ($grade_filter == 'C') ? 'active' : ''; ?>">Grade C</a>
        </div>

        <div class="product-grid">
            <?php if (mysqli_num_rows($result) == 0): ?>
                <p class="no-products">No products found. <a href="products.php">Clear filters</a></p>
            <?php else: ?>
                <?php while ($product = mysqli_fetch_assoc($result)):
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
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </section>

    <footer>
        <div class="footer-top">
            <div class="footer-logo">TechRefurb</div>
            <div class="footer-links">
                <a href="index.php">Home</a>
                <a href="products.php">Products</a>
                <a href="about.php">About</a>
                <a href="login.php">Login</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright &copy; 2026 TechRefurb Store. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>