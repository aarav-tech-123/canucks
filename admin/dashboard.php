<?php
require_once 'auth.php';

$host = "localhost";
$dbname = "u868210921_canucks";
$username = "u868210921_canucks";
$password = "Canucks@1234#";


$totalPayments = 0;
$mysqli = new mysqli($host, $username, $password, $dbname);

if (!$mysqli->connect_error) {
    $mysqli->set_charset("utf8");
    $result = $mysqli->query("SELECT COUNT(*) FROM payments");
    if ($result) {
        $row = $result->fetch_row();
        $totalPayments = $row[0];
        $result->free();
    }
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body class="ap-body">

    <?php include_once 'header.php'; ?>

    <div class="ap-content">
        <div class="ap-container">
            <h1 class="ap-page-title">Dashboard</h1>
            <p class="ap-page-subtitle">Welcome back, <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>!</p>

            <div class="ap-stats-grid">
                <div class="ap-stat-card">
                    <div class="ap-stat-label">Total Payments</div>
                    <div class="ap-stat-value"><?php echo number_format($totalPayments); ?></div>
                </div>
                <div class="ap-stat-card">
                    <div class="ap-stat-label">Status</div>
                    <div class="ap-stat-value" style="font-size:20px; color:#22c55e;">● Active</div>
                </div>
                <div class="ap-stat-card">
                    <div class="ap-stat-label">Today</div>
                    <div class="ap-stat-value"><?php echo date('M j, Y'); ?></div>
                </div>
            </div>

            <div class="ap-quick-actions">
                <h3>Quick Actions</h3>
                <div class="ap-actions-group">
                    <a href="payments.php" class="ap-btn ap-btn-primary">Manage Payments</a>
                    <a href="logout.php" class="ap-btn ap-btn-secondary">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'footer.php'; ?>

</body>

</html>