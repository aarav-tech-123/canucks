<?php

/**
 * Admin Header Template
 * Common navigation for all protected pages
 * All classes prefixed with 'ap-'
 */
?>
<header class="ap-admin-header">
    <div class="ap-container">
        <a href="dashboard.php" class="ap-logo">Admin<span>Panel</span></a>

        <nav class="ap-nav-menu">
            <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'ap-active' : ''; ?>">
                Dashboard
            </a>
            <a href="payments.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'payments.php' ? 'ap-active' : ''; ?>">
                Payments
            </a>
        </nav>

        <div class="ap-nav-user">
            <span class="ap-user-name">👤 <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></span>
            <a href="logout.php" class="ap-logout-btn">Logout</a>
        </div>
    </div>
</header>