<?php

/**
 * Authentication Handler - MySQLi Version
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================
// DATABASE CONFIGURATION - EDIT THESE VALUES
// ============================================
$host = "localhost";
$dbname = "u868210921_canucks";
$username = "u868210921_canucks";
$password = "Canucks@1234#";

// ============================================

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_error) {
    error_log('Database connection failed: ' . $mysqli->connect_error);
    $_SESSION['login_error'] = 'System error. Please try again later.';
    header('Location: login.php');
    exit();
}

$mysqli->set_charset("utf8");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit();
}

if (!isset($_POST['csrf_token']) || strlen($_POST['csrf_token']) !== 64) {
    $_SESSION['login_error'] = 'Invalid request. Please try again.';
    header('Location: login.php');
    exit();
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($username) || empty($password)) {
    $_SESSION['login_error'] = 'Username and password are required.';
    header('Location: login.php');
    exit();
}

$stmt = $mysqli->prepare("SELECT admin_id, username, password_hash FROM admin_users WHERE username = ?");
if ($stmt) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int)$admin['admin_id'];
        $_SESSION['username'] = $admin['username'];
        unset($_SESSION['login_error']);
        header('Location: dashboard.php');
        exit();
    } else {
        sleep(1);
        $_SESSION['login_error'] = 'Invalid username or password.';
        header('Location: login.php');
        exit();
    }
    $stmt->close();
} else {
    error_log('Login query failed: ' . $mysqli->error);
    $_SESSION['login_error'] = 'System error. Please try again later.';
    header('Location: login.php');
    exit();
}

$mysqli->close();
