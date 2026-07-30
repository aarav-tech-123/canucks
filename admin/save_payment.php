<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$dbname = "u868210921_canucks";
$username = "u868210921_canucks";
$password = "Canucks@1234#";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: payments.php');
    exit();
}

if (!isset($_POST['csrf_token']) || strlen($_POST['csrf_token']) !== 64) {
    $_SESSION['payment_message'] = 'Invalid request. Please try again.';
    $_SESSION['payment_message_type'] = 'error';
    header('Location: payments.php');
    exit();
}

$customerName = isset($_POST['customer_name']) ? trim($_POST['customer_name']) : '';
$customerEmail = isset($_POST['customer_email']) ? trim($_POST['customer_email']) : '';
$paymentLink = isset($_POST['payment_link']) ? trim($_POST['payment_link']) : '';

$errors = [];

if (empty($customerName)) {
    $errors[] = 'Customer name is required.';
} elseif (strlen($customerName) > 100) {
    $errors[] = 'Customer name is too long (max 100 characters).';
}

if (empty($customerEmail)) {
    $errors[] = 'Email address is required.';
} elseif (!filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
} elseif (strlen($customerEmail) > 100) {
    $errors[] = 'Email address is too long (max 100 characters).';
}

if (empty($paymentLink)) {
    $errors[] = 'Payment link is required.';
} elseif (!filter_var($paymentLink, FILTER_VALIDATE_URL)) {
    $errors[] = 'Please enter a valid URL for the payment link.';
} elseif (strlen($paymentLink) > 255) {
    $errors[] = 'Payment link is too long (max 255 characters).';
}

if (!empty($errors)) {
    $_SESSION['payment_message'] = implode(' ', $errors);
    $_SESSION['payment_message_type'] = 'error';
    header('Location: payments.php');
    exit();
}

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_error) {
    error_log('Database connection failed: ' . $mysqli->connect_error);
    $_SESSION['payment_message'] = 'Error saving payment. Please try again.';
    $_SESSION['payment_message_type'] = 'error';
    header('Location: payments.php');
    exit();
}

$mysqli->set_charset("utf8");

$stmt = $mysqli->prepare("
    INSERT INTO payments (customer_name, customer_email, payment_link, created_at) 
    VALUES (?, ?, ?, NOW())
");

if ($stmt) {
    $stmt->bind_param("sss", $customerName, $customerEmail, $paymentLink);

    if ($stmt->execute()) {
        $_SESSION['payment_message'] = 'Payment record saved successfully!';
        $_SESSION['payment_message_type'] = 'success';
    } else {
        error_log('Payment save failed: ' . $stmt->error);
        $_SESSION['payment_message'] = 'Error saving payment. Please try again.';
        $_SESSION['payment_message_type'] = 'error';
    }
    $stmt->close();
} else {
    error_log('Prepare statement failed: ' . $mysqli->error);
    $_SESSION['payment_message'] = 'Error saving payment. Please try again.';
    $_SESSION['payment_message_type'] = 'error';
}

$mysqli->close();

header('Location: payments.php');
exit();
