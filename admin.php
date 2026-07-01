<?php
session_start();
include 'php/config.php';

// Admin protection - separate from user login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Simple admin protection
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header("Location: index.php");
    exit();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: admin.php");
    exit();
}

// Handle Add Product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $grade = mysqli_real_escape_string($conn, $_POST['grade']);
    $stock = intval($_POST['stock']);

    mysqli_query($conn, "INSERT INTO products (name, category, description, price, grade, stock) VALUES ('$name', '$category', '$description', $price, '$grade', $stock)");
    header("Location: admin.php");
    exit();
}

// Handle Edit Product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_product'])) {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $grade = mysqli_real_escape_string($conn, $_POST['grade']);
    $stock = intval($_POST['stock']);

    mysqli_query($conn, "UPDATE products SET name='$name', category='$category', description='$description', price=$price, grade='$grade', stock=$stock WHERE id=$id");
    header("Location: admin.php");
    exit();
}

// Get all products
$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");

// Get edit product if requested
$edit_product = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $edit_result = mysqli_query($conn, "SELECT * FROM products WHERE id=$edit_id");
    $edit_product = mysqli_fetch_assoc($edit_result);
}

// Get stats
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products"))['count'];
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders"))['count'];
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_price) as total FROM orders"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel – TechRefurb</title>
    <link rel="stylesheet" href="css/style.css?v=4">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <div class="navbar">
            <div class="logo"><a href="index.php">TechRefurb</a></div>
            <nav>
                <a href="index.php">← Back to Store</a>
            </nav>
            <div class="nav-user">
                👤 Admin &nbsp;|&nbsp;
                <a href="admin_logout.php">Logout</a>
            </div>
        </div>
    </header>

    <section class="admin-section">
        <h2>Admin Panel</h2>

        <!-- Stats -->
        <div class="admin-stats">
            <div class="admin-stat-card">
                <h3><?php echo $total_products; ?></h3>
                <p>Total Products</p>
            </div>
            <div class="admin-stat-card">
                <h3><?php echo $total_users; ?></h3>
                <p>Registered Users</p>
            </div>
            <div class="admin-stat-card">
                <h3><?php echo $total_orders; ?></h3>
                <p>Total Orders</p>
            </div>
            <div class="admin-stat-card">
                <h3>QAR <?php echo number_format($total_revenue ?? 0, 0); ?></h3>
                <p>Total Revenue</p>
            </div>
        </div>

        <div class="admin-grid">

            <!-- Add / Edit Product Form -->
            <div class="admin-form-box">
                <h3><?php echo $edit_product ? 'Edit Product' : 'Add New Product'; ?></h3>
                <form method="POST" action="admin.php">
                    <?php if ($edit_product): ?>
                        <input type="hidden" name="id" value="<?php echo $edit_product['id']; ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="name" placeholder="e.g. Dell Latitude 5490" value="<?php echo $edit_product ? htmlspecialchars($edit_product['name']) : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" class="form-select">
                            <option value="Laptop" <?php echo ($edit_product && $edit_product['category'] == 'Laptop') ? 'selected' : ''; ?>>Laptop</option>
                            <option value="Phone" <?php echo ($edit_product && $edit_product['category'] == 'Phone') ? 'selected' : ''; ?>>Phone</option>
                            <option value="Accessory" <?php echo ($edit_product && $edit_product['category'] == 'Accessory') ? 'selected' : ''; ?>>Accessory</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3" placeholder="Product details..."><?php echo $edit_product ? htmlspecialchars($edit_product['description']) : ''; ?></textarea>
                    </div>
                    <div class="admin-form-row">
                        <div class="form-group">
                            <label>Price (QAR)</label>
                            <input type="number" name="price" placeholder="0.00" step="0.01" value="<?php echo $edit_product ? $edit_product['price'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Grade</label>
                            <select name="grade" class="form-select">
                                <option value="A" <?php echo ($edit_product && $edit_product['grade'] == 'A') ? 'selected' : ''; ?>>Grade A</option>
                                <option value="B" <?php echo ($edit_product && $edit_product['grade'] == 'B') ? 'selected' : ''; ?>>Grade B</option>
                                <option value="C" <?php echo ($edit_product && $edit_product['grade'] == 'C') ? 'selected' : ''; ?>>Grade C</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="number" name="stock" placeholder="0" value="<?php echo $edit_product ? $edit_product['stock'] : ''; ?>" required>
                        </div>
                    </div>
                    <button type="submit" name="<?php echo $edit_product ? 'edit_product' : 'add_product'; ?>" class="btn-submit">
                        <?php echo $edit_product ? 'Save Changes' : 'Add Product'; ?>
                    </button>
                    <?php if ($edit_product): ?>
                        <a href="admin.php" class="admin-cancel">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Products Table -->
            <div class="admin-table-box">
                <h3>All Products (<?php echo $total_products; ?>)</h3>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Grade</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($product = mysqli_fetch_assoc($products)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo $product['category']; ?></td>
                                <td><span class="grade grade-<?php echo strtolower($product['grade']); ?>">Grade <?php echo $product['grade']; ?></span></td>
                                <td>QAR <?php echo number_format($product['price'], 0); ?></td>
                                <td><?php echo $product['stock']; ?></td>
                                <td class="admin-actions">
                                    <a href="admin.php?edit=<?php echo $product['id']; ?>" class="admin-edit">Edit</a>
                                    <a href="admin.php?delete=<?php echo $product['id']; ?>" class="admin-delete" onclick="return confirm('Delete this product?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </section>

</body>
</html>