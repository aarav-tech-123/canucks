<?php

/**
 * Admin Login Page
 */

// Start session for error messages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_id']) && isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}

// Check for error message from authenticate.php
$error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body class="ap-body">
    <div class="ap-login-container">
        <div class="ap-card">
            <div class="ap-card-header">
                <h1>Admin Login</h1>
                <p>Enter your credentials to access the dashboard</p>
            </div>

            <?php if ($error): ?>
                <div class="ap-alert ap-alert-error">
                    <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <form action="authenticate.php" method="POST" id="apLoginForm">
                <!-- CSRF Protection -->
                <input type="hidden" name="csrf_token" value="<?php echo bin2hex(random_bytes(32)); ?>">

                <div class="ap-form-group">
                    <label for="apUsername">Username <span class="ap-required">*</span></label>
                    <input type="text" id="apUsername" name="username" class="ap-form-control"
                        placeholder="Enter your username" required autofocus>
                </div>

                <div class="ap-form-group">
                    <label for="apPassword">Password <span class="ap-required">*</span></label>
                    <input type="password" id="apPassword" name="password" class="ap-form-control"
                        placeholder="Enter your password" required>
                </div>

                <button type="submit" class="ap-btn ap-btn-primary">Sign In</button>
            </form>
        </div>
    </div>

    <script src="../assets/js/admin.js"></script>
</body>

</html>