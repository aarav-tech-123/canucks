<?php

// ===============================
// Database Configuration
// ===============================
$host = "localhost";
$dbname = "u868210921_canucks";
$username = "u868210921_canucks";
$password = "Canucks@1234#";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed.");
}


// ===============================
// Only allow POST requests
// ===============================
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ./index.html");
    exit();
}


// ===============================
// Get and sanitize form data
// ===============================
$first_name = trim(
    strip_tags($_POST['first_name'] ?? '')
);

$last_name = trim(
    strip_tags($_POST['last_name'] ?? '')
);

$email = filter_var(
    trim($_POST['email'] ?? ''),
    FILTER_SANITIZE_EMAIL
);

$country = trim(
    strip_tags($_POST['country'] ?? '')
);

$phone = trim(
    strip_tags($_POST['phone'] ?? '')
);


// ===============================
// Validation
// ===============================
if (
    empty($first_name) ||
    empty($last_name) ||
    empty($email) ||
    empty($country) ||
    empty($phone)
) {
    die("All fields are required.");
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address.");
}


// ===============================
// Save to Database
// ===============================
$stmt = $conn->prepare("
    INSERT INTO popup_enquiries
    (
        first_name,
        last_name,
        email,
        country,
        phone
    )
    VALUES (?, ?, ?, ?, ?)
");

if (!$stmt) {
    die("Database error.");
}

$stmt->bind_param(
    "sssss",
    $first_name,
    $last_name,
    $email,
    $country,
    $phone
);


if (!$stmt->execute()) {
    $stmt->close();
    $conn->close();

    die("Failed to save enquiry.");
}

$stmt->close();


// ===============================
// Send Email
// ===============================
$recipient = "info@canucksimmigration.com";

$subject = "New Popup Form Enquiry";

$email_content = "You have received a new enquiry from the website popup form.\n\n";

$email_content .= "First Name: " . $first_name . "\n";
$email_content .= "Last Name: " . $last_name . "\n";
$email_content .= "Email: " . $email . "\n";
$email_content .= "Country of Residence: " . $country . "\n";
$email_content .= "Phone: " . $phone . "\n";


$headers = "From: Canucks Immigration <info@canucksimmigration.com>\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

mail(
    $recipient,
    $subject,
    $email_content,
    $headers
);


// ===============================
// Redirect
// ===============================
$conn->close();

header("Location: ./thank-you.html");
exit();
