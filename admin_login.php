<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Admin credentials - you can change these
    if ($username == 'admin' && $password == 'techrefurb2026') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – TechRefurb</title>
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
        </div>
    </header>

    <section class="auth-section">
        <div class="auth-card">
            <div style="text-align:center; margin-bottom: 24px;">
                <span style="font-size: 40px;">🔐</span>
            </div>
            <h2>Admin Access</h2>
            <p class="auth-sub">TechRefurb administration panel</p>

            <?php if ($error): ?>
                <p class="auth-error"><?php echo $error; ?></p>
            <?php endif; ?>

            <form method="POST" action="admin_login.php">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Admin username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Admin password" required>
                </div>
                <button type="submit" class="btn-submit">Access Admin Panel</button>
            </form>
        </div>
    </section>

</body>
</html>