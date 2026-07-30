<?php

/**
 * CREATE ADMIN USER - RUN ONCE THEN DELETE THIS FILE
 * This script creates an admin user with a hashed password
 * 
 * ⚠️ IMPORTANT: Delete this file immediately after running it!
 * 
 * How to use:
 * 1. Edit the database credentials below
 * 2. Edit the admin username and password
 * 3. Access this file in your browser: http://yourdomain.com/admin/create_admin.php
 * 4. Note the success message and credentials
 * 5. DELETE THIS FILE IMMEDIATELY!
 */

// ============================================
// DATABASE CONFIGURATION - EDIT THESE VALUES
// ============================================
$host = "localhost";
$dbname = "u868210921_canucks";
$username = "u868210921_canucks";
$password = "Canucks@1234#";
// ============================================

// ============================================
// ADMIN CREDENTIALS - EDIT THESE VALUES
// ============================================
$adminUsername = 'admin';              // Change this to your desired username
$adminPassword = 'SecurePassword123!'; // Change this to your desired password
// ============================================

// Connect to database using MySQLi
$mysqli = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("❌ Database connection failed: " . $mysqli->connect_error . "\n");
}

// Set charset to UTF-8
$mysqli->set_charset("utf8");

// Hash the password using bcrypt
$hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

echo "=== Admin User Creator ===\n\n";

// Check if admin already exists
$checkStmt = $mysqli->prepare("SELECT COUNT(*) FROM admin_users WHERE username = ?");
if ($checkStmt) {
    $checkStmt->bind_param("s", $adminUsername);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        echo "⚠️ Admin user '{$adminUsername}' already exists!\n\n";
        echo "Options:\n";
        echo "1. Use a different username\n";
        echo "2. Update the password using UPDATE query\n";
        echo "3. Delete the existing user first\n\n";

        // Offer to update password
        echo "Do you want to update the password instead? (y/n): ";
        $updateChoice = trim(fgets(STDIN));

        if (strtolower($updateChoice) === 'y') {
            $updateStmt = $mysqli->prepare("UPDATE admin_users SET password_hash = ? WHERE username = ?");
            if ($updateStmt) {
                $updateStmt->bind_param("ss", $hashedPassword, $adminUsername);
                if ($updateStmt->execute()) {
                    echo "✅ Password updated successfully!\n";
                    echo "Username: {$adminUsername}\n";
                    echo "New Password: {$adminPassword}\n";
                } else {
                    echo "❌ Failed to update password: " . $updateStmt->error . "\n";
                }
                $updateStmt->close();
            }
        }
    } else {
        // Insert new admin user
        $stmt = $mysqli->prepare("
            INSERT INTO admin_users (username, password_hash, created_at) 
            VALUES (?, ?, NOW())
        ");

        if ($stmt) {
            $stmt->bind_param("ss", $adminUsername, $hashedPassword);

            if ($stmt->execute()) {
                echo "✅ Admin user created successfully!\n\n";
                echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
                echo "📋 CREDENTIALS:\n";
                echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
                echo "Username: {$adminUsername}\n";
                echo "Password: {$adminPassword}\n";
                echo "Password Hash: {$hashedPassword}\n";
                echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
                echo "🔐 Login URL: http://" . $_SERVER['HTTP_HOST'] . "/admin/login.php\n\n";
                echo "⚠️  IMPORTANT:\n";
                echo "1. Store the password securely (e.g., password manager)\n";
                echo "2. DELETE THIS FILE (create_admin.php) IMMEDIATELY!\n";
                echo "3. Change the password regularly for security\n";
            } else {
                echo "❌ Failed to create admin user: " . $stmt->error . "\n";
            }
            $stmt->close();
        } else {
            echo "❌ Failed to prepare insert statement: " . $mysqli->error . "\n";
        }
    }
} else {
    echo "❌ Failed to prepare check statement: " . $mysqli->error . "\n";
}

// Close database connection
$mysqli->close();

echo "\n💡 For security, delete this file now!\n";
echo "   On Linux/Mac: rm create_admin.php\n";
echo "   On Windows: del create_admin.php\n";
