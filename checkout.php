<?php
session_start();
include 'php/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle order placement
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    $cart_query = mysqli_query($conn, "
        SELECT cart.quantity, products.price, products.id as product_id
        FROM cart
        JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = $user_id
    ");

    if (mysqli_num_rows($cart_query) > 0) {
        $total = 0;
        $items = [];
        while ($item = mysqli_fetch_assoc($cart_query)) {
            $total += $item['price'] * $item['quantity'];
            $items[] = $item;
        }

        // Create order
        mysqli_query($conn, "INSERT INTO orders (user_id, total_price) VALUES ($user_id, $total)");
        $order_id = mysqli_insert_id($conn);

        // Save order items
        foreach ($items as $item) {
            $qty = $item['quantity'];
            $price = $item['price'];
            $pid = $item['product_id'];
            mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, $pid, $qty, $price)");
        }

        // Clear cart
        mysqli_query($conn, "DELETE FROM cart WHERE user_id=$user_id");

        header("Location: order_success.php?order_id=$order_id");
        exit();
    }
}

// Get cart items
$cart_query = mysqli_query($conn, "
    SELECT cart.id as cart_id, cart.quantity, products.name, products.price, products.grade, products.category
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = $user_id
");

if (mysqli_num_rows($cart_query) == 0) {
    header("Location: cart.php");
    exit();
}

$total = 0;
$cart_items = [];
while ($item = mysqli_fetch_assoc($cart_query)) {
    $total += $item['price'] * $item['quantity'];
    $cart_items[] = $item;
}

$cart_count = getCartCount($conn, $user_id);

// Get user info
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id");
$user = mysqli_fetch_assoc($user_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout – TechRefurb</title>
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
            <div class="nav-user">
                👋 <?php echo htmlspecialchars($_SESSION['user_name']); ?> &nbsp;|&nbsp;
                <a href="cart.php" class="cart-link">
                    🛒 Cart <?php if ($cart_count > 0): ?>
                        <span class="cart-badge"><?php echo $cart_count; ?></span>
                    <?php endif; ?>
                </a> &nbsp;|&nbsp;
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>

    <section class="checkout-section">
        <h2>Checkout</h2>

        <div class="checkout-grid">

            <!-- Left: Delivery Info -->
            <div class="checkout-left">
                <h3>Delivery Information</h3>
                <form method="POST" action="checkout.php">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" placeholder="+974 XXXX XXXX" required>
                    </div>
                    <div class="form-group">
                        <label>Delivery Address</label>
                        <input type="text" name="address" placeholder="Street, Area, Doha" required>
                    </div>
                    <div class="form-group">
                        <label>Payment Method</label>
                        <select name="payment" class="form-select">
                            <option value="cash">Cash on Delivery</option>
                            <option value="card">Credit / Debit Card</option>
                            <option value="online">Online Transfer</option>
                        </select>
                    </div>
                    <button type="submit" name="place_order" class="btn-submit">Place Order – QAR <?php echo number_format($total, 2); ?></button>
                </form>
            </div>

            <!-- Right: Order Summary -->
            <div class="checkout-right">
                <h3>Order Summary</h3>
                <div class="checkout-items">
                    <?php foreach ($cart_items as $item):
                        $icon = "💻";
                        if ($item['category'] == "Phone") $icon = "📱";
                        if ($item['category'] == "Accessory") $icon = "🎧";
                    ?>
                        <div class="checkout-item">
                            <span class="checkout-item-icon"><?php echo $icon; ?></span>
                            <div class="checkout-item-info">
                                <p><?php echo htmlspecialchars($item['name']); ?></p>
                                <small>Grade <?php echo $item['grade']; ?> · Qty: <?php echo $item['quantity']; ?></small>
                            </div>
                            <span class="checkout-item-price">QAR <?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="checkout-total">
                    <span>Total</span>
                    <span>QAR <?php echo number_format($total, 2); ?></span>
                </div>
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
                <a href="login.php">Login</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright &copy; 2026 TechRefurb Store. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>