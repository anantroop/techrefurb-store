<?php
session_start();
include 'php/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_count = getCartCount($conn, $user_id);

// Get all orders for this user
$orders_query = mysqli_query($conn, "
    SELECT * FROM orders 
    WHERE user_id = $user_id 
    ORDER BY created_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders – TechRefurb</title>
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
            <div class="nav-user">
                👋 <?php echo htmlspecialchars($_SESSION['user_name']); ?> &nbsp;|&nbsp;
                <a href="cart.php" class="cart-link">
                    🛒 Cart <?php if ($cart_count > 0): ?>
                        <span class="cart-badge"><?php echo $cart_count; ?></span>
                    <?php endif; ?>
                </a> &nbsp;|&nbsp;
                <a href="orders.php">My Orders</a> &nbsp;|&nbsp;
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>

    <section class="orders-section">
        <h2>My Orders</h2>

        <?php if (mysqli_num_rows($orders_query) == 0): ?>
            <div class="orders-empty">
                <span>📦</span>
                <h3>No orders yet</h3>
                <p>You haven't placed any orders yet.</p>
                <a href="products.php" class="btn-primary">Start Shopping</a>
            </div>
        <?php else: ?>
            <div class="orders-list">
                <?php while ($order = mysqli_fetch_assoc($orders_query)):
                    // Get order items
                    $items_query = mysqli_query($conn, "
                        SELECT order_items.quantity, order_items.price, products.name, products.category
                        FROM order_items
                        JOIN products ON order_items.product_id = products.id
                        WHERE order_items.order_id = {$order['id']}
                    ");

                    $status_colors = [
                        'pending' => 'status-pending',
                        'processing' => 'status-processing',
                        'delivered' => 'status-delivered'
                    ];
                    $status_class = $status_colors[$order['status']] ?? 'status-pending';
                ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <h3>Order #<?php echo str_pad($order['id'], 5, '0', STR_PAD_LEFT); ?></h3>
                                <p class="order-date"><?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></p>
                            </div>
                            <div class="order-header-right">
                                <span class="order-status <?php echo $status_class; ?>"><?php echo ucfirst($order['status']); ?></span>
                                <p class="order-total">QAR <?php echo number_format($order['total_price'], 2); ?></p>
                            </div>
                        </div>

                        <div class="order-items">
                            <?php while ($item = mysqli_fetch_assoc($items_query)):
                                $icon = "💻";
                                if ($item['category'] == "Phone") $icon = "📱";
                                if ($item['category'] == "Accessory") $icon = "🎧";
                            ?>
                                <div class="order-item">
                                    <span><?php echo $icon; ?></span>
                                    <span class="order-item-name"><?php echo htmlspecialchars($item['name']); ?></span>
                                    <span class="order-item-qty">Qty: <?php echo $item['quantity']; ?></span>
                                    <span class="order-item-price">QAR <?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
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