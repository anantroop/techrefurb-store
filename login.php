<?php
session_start();
include 'php/config.php';

$login_error = '';
$register_error = '';
$register_success = '';

// Handle Login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        header("Location: index.php");
        exit();
    } else {
        $login_error = 'Invalid email or password.';
    }
}

// Handle Register
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $register_error = 'Email already registered.';
    } else {
        mysqli_query($conn, "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$password')");
        $register_success = 'Account created! You can now sign in.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – TechRefurb</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <header>
        <div class="navbar">
            <div class="logo"><a href="index.php">TechRefurb</a></div>
            <nav>
                <a href="index.php">Home</a>
                <a href="#">Products</a>
                <a href="#">About</a>
            </nav>
            <a href="login.php" class="nav-login">Login</a>
        </div>
    </header>

    <section class="auth-section">

        <!-- Login Form -->
        <div class="auth-card" id="login-box">
            <h2>Sign in</h2>
            <p class="auth-sub">Welcome back to TechRefurb</p>

            <?php if ($login_error): ?>
                <p class="auth-error"><?php echo $login_error; ?></p>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="you@example.com" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Your password" required>
                </div>
                <button type="submit" name="login" class="btn-submit">Sign in</button>
            </form>
            <p class="auth-switch">Don't have an account? <a href="#" onclick="toggle(); return false;">Register</a></p>
        </div>

        <!-- Register Form -->
        <div class="auth-card" id="register-box" style="display:none;">
            <h2>Create account</h2>
            <p class="auth-sub">Join TechRefurb today</p>

            <?php if ($register_error): ?>
                <p class="auth-error"><?php echo $register_error; ?></p>
            <?php endif; ?>

            <?php if ($register_success): ?>
                <p class="auth-success"><?php echo $register_success; ?></p>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" placeholder="Your full name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="you@example.com" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Create a password" required>
                </div>
                <button type="submit" name="register" class="btn-submit">Create account</button>
            </form>
            <p class="auth-switch">Already have an account? <a href="#" onclick="toggle(); return false;">Sign in</a></p>
        </div>

    </section>

    <script>
        function toggle() {
            var login = document.getElementById('login-box');
            var register = document.getElementById('register-box');
            if (login.style.display === 'none') {
                login.style.display = 'block';
                register.style.display = 'none';
            } else {
                login.style.display = 'none';
                register.style.display = 'block';
            }
        }

        // If register had an error or success, show register box automatically
        <?php if ($register_error || $register_success): ?>
        toggle();
        <?php endif; ?>
    </script>

</body>
</html>