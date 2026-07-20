<?php
// Database Configuration
$host = "localhost";
$dbname = "u868210921_canucks";
$username = "u868210921_canucks";
$password = "Canucks@1234#";

try {
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Database Connection Failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Database Connection Failed.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get Form Data
    $name = trim(strip_tags($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = trim(strip_tags($_POST['phone']));
    $message = trim($_POST['message']);

    // Validation
    if (empty($name) || empty($email) || empty($message)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Save to Database
    $stmt = $conn->prepare("INSERT INTO contact_enquiries (name, email, phone, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $phone, $message);

    if (!$stmt->execute()) {
        die("Failed to save data.");
    }

    $stmt->close();

    // Send Email
    $recipient = "info@canucksimmigration.com"; // Change this

    $subject = "New Contact Form Submission";

    $email_content = "You have received a new enquiry.\n\n";
    $email_content .= "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone No.: $phone\n";
    $email_content .= "Message:\n$message\n";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8";

    mail($recipient, $subject, $email_content, $headers);

    // Redirect to Thank You Page
    header("Location: ./thank-you.html");
    exit();

} else {
    header("Location: ./index.html");
    exit();
}
?>