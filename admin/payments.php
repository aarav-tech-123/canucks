<?php
require_once 'auth.php';

$host = "localhost";
$dbname = "u868210921_canucks";
$username = "u868210921_canucks";
$password = "Canucks@1234#";


$payments = [];
$message = '';
$messageType = '';

if (isset($_SESSION['payment_message'])) {
    $message = $_SESSION['payment_message'];
    $messageType = $_SESSION['payment_message_type'] ?? 'success';
    unset($_SESSION['payment_message']);
    unset($_SESSION['payment_message_type']);
}

$mysqli = new mysqli($host, $username, $password, $dbname);

if (!$mysqli->connect_error) {
    $mysqli->set_charset("utf8");
    $result = $mysqli->query("SELECT * FROM payments ORDER BY created_at DESC");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $payments[] = $row;
        }
        $result->free();
    }
    $mysqli->close();
} else {
    $message = 'Error loading payments. Please try again.';
    $messageType = 'error';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body class="ap-body">

    <?php include_once 'header.php'; ?>

    <div class="ap-content">
        <div class="ap-container">
            <h1 class="ap-page-title">Payments</h1>
            <p class="ap-page-subtitle">Manage customer payments</p>

            <?php if ($message): ?>
                <div class="ap-alert ap-alert-<?php echo $messageType; ?>">
                    <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <div class="ap-payment-form">
                <h3 style="margin-bottom:20px; color:#1a1a2e;">Add New Payment</h3>
                <form action="save_payment.php" method="POST" id="apPaymentForm">
                    <input type="hidden" name="csrf_token" value="<?php echo bin2hex(random_bytes(32)); ?>">

                    <div class="ap-form-row">
                        <div class="ap-form-group">
                            <label for="apCustomerName">Customer Name <span class="ap-required">*</span></label>
                            <input type="text" id="apCustomerName" name="customer_name" class="ap-form-control"
                                placeholder="John Doe" required>
                            <span id="apNameError" class="ap-error-message"></span>
                        </div>

                        <div class="ap-form-group">
                            <label for="apCustomerEmail">Email Address <span class="ap-required">*</span></label>
                            <input type="email" id="apCustomerEmail" name="customer_email" class="ap-form-control"
                                placeholder="john@example.com" required>
                            <span id="apEmailError" class="ap-error-message"></span>
                        </div>

                        <div class="ap-form-group">
                            <label for="apPaymentLink">Payment Link <span class="ap-required">*</span></label>
                            <input type="url" id="apPaymentLink" name="payment_link" class="ap-form-control"
                                placeholder="https://payment.example.com/..." required>
                            <span id="apLinkError" class="ap-error-message"></span>
                        </div>
                    </div>

                    <div class="ap-form-actions">
                        <button type="submit" class="ap-btn ap-btn-success">Save Payment</button>
                        <button type="reset" id="apResetBtn" class="ap-btn ap-btn-secondary">Reset</button>
                    </div>
                </form>
            </div>

            <div class="ap-table-wrapper">
                <div class="ap-table-responsive">
                    <table class="ap-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Payment Link</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($payments)): ?>
                                <tr class="ap-empty-row">
                                    <td colspan="5">No payments recorded yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($payments as $index => $payment): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($payment['customer_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($payment['customer_email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <a href="<?php echo htmlspecialchars($payment['payment_link'], ENT_QUOTES, 'UTF-8'); ?>"
                                                target="_blank" class="ap-link">
                                                <?php echo htmlspecialchars($payment['payment_link'], ENT_QUOTES, 'UTF-8'); ?>
                                            </a>
                                        </td>
                                        <td><?php echo date('M d, Y', strtotime($payment['created_at'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'footer.php'; ?>