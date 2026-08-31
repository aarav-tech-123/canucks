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

$conn->set_charset("utf8mb4");


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

$country_code = trim(
    strip_tags($_POST['country_code'] ?? '')
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
    empty($country_code) ||
    empty($phone)
) {
    die("All fields are required.");
}


// ===============================
// Email Validation
// ===============================

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address.");
}


// ===============================
// Country Code Validation
// ===============================

if (!preg_match('/^\+[0-9]{1,4}$/', $country_code)) {
    die("Invalid country code.");
}


// ===============================
// Phone Validation
// ===============================

if (!preg_match('/^[0-9\s\-\(\)\.]{5,20}$/', $phone)) {
    die("Invalid phone number.");
}


// ===============================
// Create Complete Phone Number
// ===============================

$full_phone = $country_code . " " . $phone;


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
    $conn->close();
    die("Database error.");
}


// Save complete phone number
$stmt->bind_param(
    "sssss",
    $first_name,
    $last_name,
    $email,
    $country,
    $full_phone
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

$email_content = "";

$email_content .= "You have received a new enquiry from the website popup form.\n\n";

$email_content .= "----------------------------------------\n";
$email_content .= "POPUP FORM ENQUIRY\n";
$email_content .= "----------------------------------------\n\n";

$email_content .= "First Name: " . $first_name . "\n";
$email_content .= "Last Name: " . $last_name . "\n";
$email_content .= "Email: " . $email . "\n";
$email_content .= "Country of Residence: " . $country . "\n";
$email_content .= "Country Code: " . $country_code . "\n";
$email_content .= "Phone: " . $full_phone . "\n";


// ===============================
// Email Headers
// ===============================

$headers = "From: Canucks Immigration <info@canucksimmigration.com>\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";


// ===============================
// Send Email
// ===============================

mail(
    $recipient,
    $subject,
    $email_content,
    $headers
);


// ===============================
// Close Connection
// ===============================

$conn->close();


// ===============================
// Redirect
// ===============================

header("Location: ./thank-you.html");
exit();
