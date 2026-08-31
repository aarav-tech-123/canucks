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
// Get Form Data
// ===============================

$first_name = trim(strip_tags($_POST['first_name'] ?? ''));

$last_name = trim(strip_tags($_POST['last_name'] ?? ''));

$age = filter_var(
    $_POST['age'] ?? '',
    FILTER_VALIDATE_INT
);

$english_proficiency = trim(
    strip_tags($_POST['english_proficiency'] ?? '')
);

$education = trim(
    strip_tags($_POST['education'] ?? '')
);

$occupation = trim(
    strip_tags($_POST['occupation'] ?? '')
);

$work_experience = filter_var(
    $_POST['work_experience'] ?? '',
    FILTER_VALIDATE_INT
);

$email = filter_var(
    trim($_POST['email'] ?? ''),
    FILTER_SANITIZE_EMAIL
);

$country = trim(
    strip_tags($_POST['country'] ?? '')
);

$income_band = trim(
    strip_tags($_POST['income_band'] ?? '')
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
    $age === false ||
    empty($english_proficiency) ||
    empty($education) ||
    empty($occupation) ||
    $work_experience === false ||
    empty($email) ||
    empty($country) ||
    empty($income_band) ||
    empty($country_code) ||
    empty($phone)
) {
    die("All required fields are required.");
}


// ===============================
// Email Validation
// ===============================

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address.");
}


// ===============================
// Age Validation
// ===============================

if ($age < 1 || $age > 120) {
    die("Invalid age.");
}


// ===============================
// Work Experience Validation
// ===============================

if ($work_experience < 0 || $work_experience > 100) {
    die("Invalid work experience.");
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

// Allow numbers, spaces, brackets, hyphens and dots
if (!preg_match('/^[0-9\s\-\(\)\.]{5,20}$/', $phone)) {
    die("Invalid phone number.");
}


// ===============================
// Complete Phone Number
// ===============================

$full_phone = $country_code . " " . $phone;


// ===============================
// Save to Database
// ===============================

$stmt = $conn->prepare("
    INSERT INTO contact_enquiries
    (
        first_name,
        last_name,
        age,
        english_proficiency,
        education,
        occupation,
        work_experience,
        email,
        country,
        income_band,
        phone
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    $conn->close();
    die("Database error.");
}


// IMPORTANT:
// phone contains the complete number:
// +91 9876543210
//
// country remains:
// IN / CA / US etc.

$stmt->bind_param(
    "ssisssissss",
    $first_name,
    $last_name,
    $age,
    $english_proficiency,
    $education,
    $occupation,
    $work_experience,
    $email,
    $country,
    $income_band,
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

$subject = "New Immigration Enquiry";

$email_content = "";

$email_content .= "You have received a new immigration enquiry.\n\n";

$email_content .= "----------------------------------------\n";
$email_content .= "PERSONAL INFORMATION\n";
$email_content .= "----------------------------------------\n\n";

$email_content .= "First Name: " . $first_name . "\n";
$email_content .= "Last Name: " . $last_name . "\n";
$email_content .= "Age: " . $age . "\n\n";

$email_content .= "----------------------------------------\n";
$email_content .= "PROFESSIONAL INFORMATION\n";
$email_content .= "----------------------------------------\n\n";

$email_content .= "English Proficiency: " . $english_proficiency . "\n";
$email_content .= "Education: " . $education . "\n";
$email_content .= "Occupation: " . $occupation . "\n";
$email_content .= "Work Experience: " . $work_experience . " years\n\n";

$email_content .= "----------------------------------------\n";
$email_content .= "CONTACT INFORMATION\n";
$email_content .= "----------------------------------------\n\n";

$email_content .= "Email: " . $email . "\n";
$email_content .= "Country of Residence: " . $country . "\n";
$email_content .= "Country Code: " . $country_code . "\n";
$email_content .= "Phone: " . $full_phone . "\n";
$email_content .= "Income Band: " . $income_band . "\n";


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
// Close Database
// ===============================

$conn->close();


// ===============================
// Redirect
// ===============================

header("Location: ./thank-you.html");
exit();
