<?php
session_start();
include 'php/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['add'])) {
    $product_id = intval($_GET['add']);
    $check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id=$user_id AND product_id=$product_id");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "UPDATE cart SET quantity = quantity + 1 WHERE user_id=$user_id AND product_id=$product_id");
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)");
    }
    header("Location: cart.php");
    exit();
}

if (isset($_GET['remove'])) {
    $cart_id = intval($_GET['remove']);
    mysqli_query($conn, "DELETE FROM cart WHERE id=$cart_id AND user_id=$user_id");
    header("Location: cart.php");
    exit();
}

$cart_query = mysqli_query($conn, "
    SELECT cart.id as cart_id, cart.quantity, products.name, products.price, products.grade
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = $user_id
");

$total = 0;
$cart_count = getCartCount($conn, $user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart – TechRefurb</title>
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

    <section class="cart-section">
        <h2>Your Cart</h2>

        <?php if (mysqli_num_rows($cart_query) == 0): ?>
            <p class="cart-empty">Your cart is empty. <a href="products.php">Continue shopping →</a></p>
        <?php else: ?>
            <div class="cart-list">
                <?php while ($item = mysqli_fetch_assoc($cart_query)):
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <div class="cart-item">
                        <div class="cart-item-info">
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p>Grade <?php echo $item['grade']; ?> · Qty: <?php echo $item['quantity']; ?></p>
                        </div>
                        <div class="cart-item-price">QAR <?php echo number_format($subtotal, 2); ?></div>
                        <a href="cart.php?remove=<?php echo $item['cart_id']; ?>" class="cart-remove">Remove</a>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="cart-total">
                <span>Total</span>
                <span>QAR <?php echo number_format($total, 2); ?></span>
            </div>

            <a href="checkout.php" class="btn-primary cart-checkout">Checkout</a>
        <?php endif; ?>
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
            <p>Copyright &copy; 2026 TechRefurb Store. All rights reserved. &nbsp;·&nbsp; <a href="admin_login.php" class="admin-footer-link">Admin</a></p>
        </div>
    </footer>

</body>
</html>