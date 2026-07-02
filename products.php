<?php
session_start();
include 'php/config.php';

$category_filter = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';
$grade_filter = isset($_GET['grade']) ? mysqli_real_escape_string($conn, $_GET['grade']) : '';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$query = "SELECT * FROM products WHERE 1=1";
if ($category_filter) $query .= " AND category='$category_filter'";
if ($grade_filter) $query .= " AND grade='$grade_filter'";
if ($search) $query .= " AND (name LIKE '%$search%' OR description LIKE '%$search%')";
$query .= " ORDER BY created_at DESC";

$result = mysqli_query($conn, $query);
$cart_count = isset($_SESSION['user_id']) ? getCartCount($conn, $_SESSION['user_id']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products – TechRefurb</title>
    <link rel="stylesheet" href="css/style.css?v=4">
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

    <section class="products-page">

        <div class="products-header">
            <h1>All Products</h1>
            <p>Browse our full range of certified refurbished tech</p>

            <!-- Search Bar -->
            <form method="GET" action="products.php" class="search-form">
                <div class="search-box">
                    <span class="search-icon">🔍</span>
                    <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
                    <?php if ($category_filter): ?>
                        <input type="hidden" name="category" value="<?php echo htmlspecialchars($category_filter); ?>">
                    <?php endif; ?>
                    <?php if ($grade_filter): ?>
                        <input type="hidden" name="grade" value="<?php echo htmlspecialchars($grade_filter); ?>">
                    <?php endif; ?>
                    <button type="submit" class="search-btn">Search</button>
                    <?php if ($search): ?>
                        <a href="products.php" class="search-clear">✕</a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if ($search): ?>
                <p class="search-results">Showing results for "<strong><?php echo htmlspecialchars($search); ?></strong>"</p>
            <?php endif; ?>
        </div>

        <!-- Filters -->
        <div class="filters">
            <a href="products.php" class="filter-btn <?php echo (!$category_filter && !$grade_filter && !$search) ? 'active' : ''; ?>">All</a>
            <a href="products.php?category=Laptop<?php echo $search ? '&search='.$search : ''; ?>" class="filter-btn <?php echo ($category_filter == 'Laptop') ? 'active' : ''; ?>">💻 Laptops</a>
            <a href="products.php?category=Phone<?php echo $search ? '&search='.$search : ''; ?>" class="filter-btn <?php echo ($category_filter == 'Phone') ? 'active' : ''; ?>">📱 Phones</a>
            <a href="products.php?category=Accessory<?php echo $search ? '&search='.$search : ''; ?>" class="filter-btn <?php echo ($category_filter == 'Accessory') ? 'active' : ''; ?>">🎧 Accessories</a>
            <span class="filter-divider">|</span>
            <a href="products.php?grade=A<?php echo $search ? '&search='.$search : ''; ?>" class="filter-btn <?php echo ($grade_filter == 'A') ? 'active' : ''; ?>">Grade A</a>
            <a href="products.php?grade=B<?php echo $search ? '&search='.$search : ''; ?>" class="filter-btn <?php echo ($grade_filter == 'B') ? 'active' : ''; ?>">Grade B</a>
            <a href="products.php?grade=C<?php echo $search ? '&search='.$search : ''; ?>" class="filter-btn <?php echo ($grade_filter == 'C') ? 'active' : ''; ?>">Grade C</a>
        </div>

        <!-- Product Grid -->
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