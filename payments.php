<?php
// --------------------
// Database connection
// --------------------
$servername = "localhost";
$dbname = "u868210921_canucks";
$username = "u868210921_canucks";
$password = "Canucks@1234#";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// --------------------
// Handle payment lookup
// --------------------
$payment_data = null;
$error_message = '';
$search_term_value = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lookup'])) {
    $search_term_value = trim($_POST['search_term']);

    if (!empty($search_term_value)) {
        // Search by customer_name, email, or id
        $sql = "SELECT * FROM payments WHERE customer_name LIKE ? OR customer_email LIKE ? OR id = ?";
        $stmt = $conn->prepare($sql);
        $search_pattern = "%" . $search_term_value . "%";
        $stmt->bind_param("sss", $search_pattern, $search_pattern, $search_term_value);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $payment_data = $result->fetch_assoc();
        } else {
            $error_message = "No payment record found for the provided information.";
        }
        $stmt->close();
    } else {
        $error_message = "Please enter your name, email, or payment ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://canucksimmigration.com/img/favicon.png">
    <meta name="robots" content="index, follow">
    <title>Make a Payment - Canucks Immigration</title>
    <link rel="shortcut icon" href="https://canucksimmigration.com/assets/img/logo/logo.png">
    <link rel="stylesheet" href="https://canucksimmigration.com/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://canucksimmigration.com/assets/css/font-awesome.css">
    <link rel="stylesheet" href="https://canucksimmigration.com/assets/css/animate.css">
    <link rel="stylesheet" href="https://canucksimmigration.com/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="https://canucksimmigration.com/assets/css/meanmenu.css">
    <link rel="stylesheet" href="https://canucksimmigration.com/assets/css/slick.css">
    <link rel="stylesheet" href="https://canucksimmigration.com/assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://canucksimmigration.com/assets/css/nice-select.css">
    <link rel="stylesheet" href="https://canucksimmigration.com/assets/css/main.css">
    <link rel="stylesheet" href="https://canucksimmigration.com/style.css">

    <style>
        :root {
            --body: #fff;
            --black: #000;
            --white: #fff;
            --theme: #E20935;
            --theme2: #E20935;
            --header: #16171A;
            --base: #E20935;
            --text: #5E5F63;
            --text2: #8A8C94;
            --border: #EEEFF4;
            --border2: #D7D7D7;
            --button: #1C2539;
            --button2: #030734;
            --ratting: #F09815;
            --bg: #F5F5F7;
            --bg2: #F6F6F6;
            --bg3: #F5F6FD;
            --bg4: #16171A;
            --bg5: #F8F8F8;
            --bg6: #16171A;
            --bg7: #EDEEEE;
            --gradient-primary: linear-gradient(135deg, #E20935 0%, #b0072a 100%);
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        body {
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
            min-height: 100vh;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .banner-section {
            padding: 60px 0 70px;
            background: var(--gradient-primary);
            position: relative;
            overflow: hidden;
        }

        .banner-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            pointer-events: none;
        }

        .banner-section::after {
            content: '';
            position: absolute;
            bottom: -40%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            pointer-events: none;
        }

        .banner-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
        }

        .banner-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            padding: 8px 24px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            letter-spacing: 0.5px;
        }

        .banner-text h1 {
            font-size: 44px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .banner-text p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 18px;
            max-width: 600px;
            margin: 0 auto;
        }

        .banner-buttons {
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .banner-btn {
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .banner-btn-primary {
            background: #fff;
            color: var(--theme);
        }

        .banner-btn-primary:hover {
            background: var(--theme);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(226, 9, 53, 0.3);
        }

        .banner-btn-secondary {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .banner-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
            color: #fff;
        }

        @media (max-width: 768px) {
            .banner-section {
                padding: 40px 0 50px;
            }

            .banner-text h1 {
                font-size: 30px;
            }
        }

        .payment-section {
            padding: 60px 0 80px;
            background: var(--bg);
        }

        .payment-wrapper {
            max-width: 700px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 20px;
            padding: 50px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
        }

        .payment-wrapper h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--header);
            margin-bottom: 10px;
        }

        .payment-wrapper .subtitle {
            color: var(--text2);
            margin-bottom: 30px;
            font-size: 16px;
        }

        .search-form .input-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-form .input-group input {
            flex: 1;
            min-width: 200px;
            padding: 14px 20px;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
            background: var(--bg);
            color: var(--header);
        }

        .search-form .input-group input:focus {
            outline: none;
            border-color: var(--theme);
            box-shadow: 0 0 0 4px rgba(226, 9, 53, 0.1);
        }

        .search-form .input-group input::placeholder {
            color: var(--text2);
        }

        .search-form .input-group .btn-search {
            padding: 14px 32px;
            background: var(--gradient-primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .search-form .input-group .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .search-hint {
            font-size: 13px;
            color: var(--text2);
            margin-top: 12px;
        }

        .search-hint i {
            margin-right: 4px;
        }

        .error-message {
            background: #fde8ec;
            color: var(--theme);
            padding: 12px 20px;
            border-radius: 10px;
            margin-top: 20px;
            font-weight: 500;
        }

        .payment-details {
            margin-top: 30px;
            border: 2px solid var(--border);
            border-radius: 16px;
            padding: 30px;
            background: var(--bg);
            display: none;
        }

        .payment-details.show {
            display: block;
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .payment-details .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .payment-details .detail-row:last-child {
            border-bottom: none;
        }

        .payment-details .detail-row .label {
            color: var(--text2);
            font-weight: 500;
        }

        .payment-details .detail-row .value {
            color: var(--header);
            font-weight: 600;
        }

        .payment-details .btn-pay {
            width: 100%;
            padding: 16px;
            background: var(--gradient-primary);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            text-decoration: none;
        }

        .payment-details .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: #fff;
        }

        .payment-details .btn-pay:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .payment-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .payment-status.paid {
            background: #d4edda;
            color: #155724;
        }

        .payment-status.pending {
            background: #fff3cd;
            color: #856404;
        }

        .payment-status.failed {
            background: #f8d7da;
            color: #721c24;
        }

        .terms-section {
            padding: 40px 0 60px;
            background: var(--white);
        }

        .terms-wrapper {
            max-width: 700px;
            margin: 0 auto;
        }

        .terms-wrapper h3 {
            font-size: 24px;
            font-weight: 700;
            color: var(--header);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .terms-wrapper h3 i {
            color: var(--theme);
        }

        .terms-wrapper .terms-content {
            background: var(--bg);
            padding: 30px;
            border-radius: 16px;
            border: 1px solid var(--border);
        }

        .terms-wrapper .terms-content h4 {
            font-weight: 600;
            color: var(--header);
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .terms-wrapper .terms-content h4:first-child {
            margin-top: 0;
        }

        .terms-wrapper .terms-content p,
        .terms-wrapper .terms-content li {
            color: var(--text);
            font-size: 15px;
            line-height: 1.8;
        }

        .terms-wrapper .terms-content ul {
            padding-left: 20px;
            margin-bottom: 15px;
        }

        .terms-wrapper .terms-content ul li {
            margin-bottom: 8px;
            list-style-type: disc;
        }

        .terms-wrapper .terms-content .highlight {
            color: var(--theme);
            font-weight: 600;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 16px 38px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: var(--shadow-md);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            text-decoration: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
            text-decoration: none;
        }

        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--gradient-primary);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s;
            z-index: 1000;
        }

        .back-to-top:hover {
            transform: translateY(-3px);
            color: white;
        }

        .back-to-top.show {
            display: flex;
        }

        .cta-section {
            padding: 60px 0;
            text-align: center;
            background: var(--bg);
            border-top: 1px solid var(--border);
        }

        @media (max-width: 768px) {
            .payment-wrapper {
                padding: 30px 20px;
            }

            .search-form .input-group input {
                min-width: 100%;
            }

            .search-form .input-group .btn-search {
                width: 100%;
                justify-content: center;
            }

            .terms-wrapper .terms-content {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <!-- Header Top Start -->
    <div class="header-top-section fix">
        <div class="container">
            <div class="header-top-wrapper">
                <ul class="contact-list">
                    <li>
                        <i class="far fa-envelope"></i>
                        <a href="mailto:info@canucksimmigration.com" class="link">info@canucksimmigration.com</a>
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        6060 Silver Drive, Burnaby BC V5H 2Y3
                    </li>
                </ul>
                <div class="top-right">
                    <div class="social-icon d-flex align-items-center">
                        <a href="https://www.facebook.com/CanucksImmigration"> <i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/canucks.migration.ca"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Area Start -->
    <header class="header-section-1">
        <div id="header-sticky" class="header-1">
            <div class="container-fluid">
                <div class="mega-menu-wrapper">
                    <div class="header-main">
                        <div class="header-left">
                            <div class="logo">
                                <a href="/" class="header-logo">
                                    <img src="https://canucksimmigration.com/assets/img/logo/logo.png" alt="logo-img" style="width: 100px; height: 90px;">
                                </a>
                            </div>
                            <div class="mean__menu-wrapper">
                                <div class="main-menu">
                                    <nav id="mobile-menu">
                                        <ul>
                                            <li class="has-dropdown active menu-thumb">
                                                <a href="https://canucksimmigration.com/">Home</a>
                                            </li>
                                            <li>
                                                <a href="https://canucksimmigration.com/about.html">About</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)">Services <i class="fas fa-angle-down"></i></a>
                                                <ul class="submenu">
                                                    <li><a href="https://canucksimmigration.com/business-investment-visa-for-canada.html">Business Investment Visa for Canada</a></li>
                                                    <li><a href="https://canucksimmigration.com/canada-express-entry.html">Canada Express Entry</a></li>
                                                    <li><a href="https://canucksimmigration.com/judicial-review.html">Judicial Review</a></li>
                                                    <li><a href="https://canucksimmigration.com/provincial-nominee-program.html">PNP</a></li>
                                                    <li><a href="https://canucksimmigration.com/canadian-immigration-services.html">Immigration Consulting Services</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="https://canucksimmigration.com/blogs.php">Blog</a>
                                            </li>
                                            <li>
                                                <a href="https://canucksimmigration.com/contact.html">Contact</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="header-right d-flex justify-content-end align-items-center">
                            <div class="contact-info">
                                <div class="icon">
                                    <img src="https://canucksimmigration.com/assets/img/call.png" alt="img">
                                </div>
                                <div class="content">
                                    <p>Phone:</p>
                                    <h6>
                                        <a href="tel:+18075007906">+1-8075007906</a>
                                    </h6>
                                </div>
                            </div>
                            <div class="header__hamburger d-lg-none my-auto">
                                <div class="sidebar__toggle">
                                    <i class="far fa-bars"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ===== BANNER SECTION ===== -->
    <section class="banner-section">
        <div class="container">
            <div class="banner-content">
                <div class="banner-badge"><i class="fas fa-credit-card"></i> Secure Payment</div>
                <div class="banner-text">
                    <h1>Make a Payment</h1>
                    <p>Enter your name, email, or payment ID to view and complete your payment securely.</p>
                </div>
                <div class="banner-buttons">
                    <a href="https://canucksimmigration.com/" class="banner-btn banner-btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Home
                    </a>
                    <a href="https://canucksimmigration.com/contact.html" class="banner-btn banner-btn-primary">
                        <i class="fas fa-headset"></i> Need Help?
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PAYMENT SECTION ===== -->
    <section class="payment-section">
        <div class="container">
            <div class="payment-wrapper">
                <h2>Find Your Payment</h2>
                <p class="subtitle">Enter your full name, email address, or the payment ID provided to you.</p>

                <form method="POST" class="search-form" id="paymentForm">
                    <div class="input-group">
                        <input type="text"
                            name="search_term"
                            id="search_term"
                            placeholder="Enter your name, email, or payment ID..."
                            value="<?php echo htmlspecialchars($search_term_value); ?>"
                            required>
                        <button type="submit" name="lookup" class="btn-search">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                    <div class="search-hint">
                        <i class="fas fa-info-circle"></i> Example: "John Doe", "john@email.com", or "1" (payment ID)
                    </div>
                </form>

                <?php if ($error_message): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <!-- Payment Details -->
                <div class="payment-details <?php echo $payment_data ? 'show' : ''; ?>">
                    <h4 style="color: var(--header); font-weight: 600; margin-bottom: 20px;">
                        <i class="fas fa-file-invoice" style="color: var(--theme);"></i> Payment Details
                    </h4>

                    <div class="detail-row">
                        <span class="label">Payment ID</span>
                        <span class="value">#<?php echo htmlspecialchars($payment_data['id'] ?? 'N/A'); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Customer Name</span>
                        <span class="value"><?php echo htmlspecialchars($payment_data['customer_name'] ?? 'N/A'); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Email Address</span>
                        <span class="value"><?php echo htmlspecialchars($payment_data['customer_email'] ?? 'N/A'); ?></span>
                    </div>
                    <?php if (isset($payment_data['amount']) && !empty($payment_data['amount'])): ?>
                        <div class="detail-row">
                            <span class="label">Amount</span>
                            <span class="value" style="color: var(--theme); font-size: 20px; font-weight: 700;">
                                $<?php echo number_format($payment_data['amount'], 2); ?> CAD
                            </span>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($payment_data['payment_status']) && !empty($payment_data['payment_status'])): ?>
                        <div class="detail-row">
                            <span class="label">Status</span>
                            <span class="value">
                                <span class="payment-status <?php echo strtolower($payment_data['payment_status']); ?>">
                                    <?php echo ucfirst(htmlspecialchars($payment_data['payment_status'])); ?>
                                </span>
                            </span>
                        </div>
                    <?php endif; ?>
                    <div class="detail-row">
                        <span class="label">Date Created</span>
                        <span class="value"><?php echo date("F j, Y", strtotime($payment_data['created_at'] ?? 'now')); ?></span>
                    </div>

                    <?php if (isset($payment_data['payment_link']) && !empty($payment_data['payment_link'])): ?>
                        <a href="<?php echo htmlspecialchars($payment_data['payment_link']); ?>" target="_blank" class="btn-pay">
                            <i class="fas fa-lock"></i> Pay Now with Stripe
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    <?php else: ?>
                        <button class="btn-pay" disabled>
                            <i class="fas fa-exclamation-triangle"></i> Payment Link Not Available
                        </button>
                    <?php endif; ?>

                    <p style="font-size: 13px; color: var(--text2); margin-top: 15px; text-align: center;">
                        <i class="fas fa-shield-alt"></i> Your payment is secured with industry-standard encryption.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== TERMS & CONDITIONS SECTION ===== -->
    <section class="terms-section">
        <div class="container">
            <div class="terms-wrapper">
                <h3><i class="fas fa-file-contract"></i> Terms & Conditions</h3>
                <div class="terms-content">
                    <h4>1. Payment Obligations</h4>
                    <p>All payments made to Canucks Immigration are for services rendered in accordance with the agreed-upon service agreement. Payments are non-refundable once services have commenced, unless otherwise stated in writing.</p>

                    <h4>2. Payment Methods</h4>
                    <p>We accept payments through our secure Stripe payment gateway. Accepted payment methods include all major credit cards (Visa, MasterCard, American Express) and debit cards. All transactions are processed in <span class="highlight">Canadian Dollars (CAD)</span>.</p>

                    <h4>3. Security</h4>
                    <p>We take the security of your personal and financial information seriously. All payment transactions are encrypted and processed through Stripe's PCI-compliant payment gateway. We do not store any credit card information on our servers.</p>

                    <h4>4. Payment Confirmation</h4>
                    <p>Upon successful completion of your payment, you will receive a confirmation email at the address provided. Please retain this confirmation for your records. If you do not receive a confirmation within 24 hours, please contact our support team.</p>

                    <h4>5. Refund Policy</h4>
                    <p>Refunds are issued at the sole discretion of Canucks Immigration and are subject to the terms of your specific service agreement. Any refund requests must be submitted in writing to <a href="mailto:info@canucksimmigration.com" style="color: var(--theme);">info@canucksimmigration.com</a> and will be reviewed on a case-by-case basis.</p>

                    <h4>6. Late Payments</h4>
                    <p>Payments not received by the due date may be subject to late fees and/or suspension of services. We will make reasonable efforts to contact you regarding overdue payments before any action is taken.</p>

                    <h4>7. Dispute Resolution</h4>
                    <p>Any disputes regarding payments should be brought to our attention immediately. We are committed to resolving any issues fairly and promptly. Please contact us at <a href="mailto:info@canucksimmigration.com" style="color: var(--theme);">info@canucksimmigration.com</a> with any concerns.</p>

                    <h4>8. Consent</h4>
                    <p>By making a payment through our platform, you acknowledge that you have read, understood, and agree to be bound by these terms and conditions. You also consent to the collection and use of your personal information for the purpose of processing your payment.</p>

                    <p style="margin-top: 20px; font-size: 14px; color: var(--text2);">
                        <i class="fas fa-calendar-alt"></i> Last Updated: January 2026
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA SECTION ===== -->
    <section class="cta-section">
        <div class="container">
            <div style="max-width: 700px; margin: 0 auto;">
                <h2 style="font-size: 36px; color: var(--header); font-weight: 700; margin-bottom: 16px;">
                    Need <span style="color: var(--theme);">Assistance?</span>
                </h2>
                <p style="color: var(--text2); font-size: 18px; margin-bottom: 30px;">
                    Our team is here to help with any questions about your payment or our services.
                </p>
                <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
                    <a href="https://canucksimmigration.com/contact.html" class="btn-primary">
                        <i class="fas fa-envelope"></i> Contact Us
                    </a>
                    <a href="tel:+18075007906" class="btn-primary" style="background: var(--header);">
                        <i class="fas fa-phone"></i> Call Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-section footer-bg">
        <div class="container">
            <div class="footer-widgets-wrapper">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 col-md-6 col-lg-3 wow fadeInUp" data-wow-delay=".2s">
                        <div class="single-footer-widget">
                            <div class="widget-head">
                                <a href="https://canucksimmigration.com/">
                                    <img src="https://canucksimmigration.com/assets/img/logo/footer-logo.png" alt="logo-img">
                                </a>
                            </div>
                            <div class="footer-content">
                                <p>Simplifying Canadian immigration with trusted guidance.</p>
                                <div class="social-icon d-flex align-items-center">
                                    <a href="https://www.facebook.com/CanucksImmigration"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://www.instagram.com/canucks.migration.ca"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 ps-lg-5 col-sm-6 col-md-3 col-lg-3 wow fadeInUp" data-wow-delay=".4s">
                        <div class="single-footer-widget">
                            <div class="widget-head">
                                <h5>Explore</h5>
                            </div>
                            <ul class="list-items">
                                <li><a href="https://canucksimmigration.com/">Home</a></li>
                                <li><a href="https://canucksimmigration.com/about.html">About</a></li>
                                <li><a href="https://canucksimmigration.com/contact.html">Contact</a></li>
                                <li><a href="https://canucksimmigration.com/blogs.php">Blogs</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 ps-lg-4 col-sm-6 col-md-3 col-lg-3 wow fadeInUp" data-wow-delay=".6s">
                        <div class="single-footer-widget">
                            <div class="widget-head">
                                <h5>Services</h5>
                            </div>
                            <ul class="list-items">
                                <li><a href="https://canucksimmigration.com/business-investment-visa-for-canada.html">Business Investment Visa</a></li>
                                <li><a href="https://canucksimmigration.com/canada-express-entry.html">Canada Express Entry</a></li>
                                <li><a href="https://canucksimmigration.com/judicial-review.html">Judicial Review</a></li>
                                <li><a href="https://canucksimmigration.com/provincial-nominee-program.html">PNP</a></li>
                                <li><a href="https://canucksimmigration.com/canadian-immigration-services.html">Immigration Consulting</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-md-6 col-lg-3 wow fadeInUp" data-wow-delay=".8s">
                        <div class="single-footer-widget">
                            <div class="widget-head">
                                <h5>Address:</h5>
                            </div>
                            <div class="footer-address-text">
                                <p><i class="fa fa-location"></i>&nbsp; 6060 Silver Drive, Burnaby BC V5H 2Y3</p>
                                <p><i class="fa fa-phone"></i>&nbsp; +1-8075007906</p>
                                <a href="mailto:info@canucksimmigration.com" class="link" style="color:var(--text2)">
                                    <i class="fa fa-envelope"></i> &nbsp; info@canucksimmigration.com
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-wrapper d-flex align-items-center justify-content-between">
                    <p class="wow fadeInLeft color-2" data-wow-delay=".3s">
                        Copyright © 2026 <a href="https://canucksimmigration.com/">Canucks Immigration</a>. All Rights Reserved.
                    </p>
                    <ul class="footer-menu wow fadeInRight" data-wow-delay=".5s">
                        <li><a href="https://canucksimmigration.com/terms-and-conditions.html">Terms & Conditions</a></li>
                        <li><a href="https://canucksimmigration.com/privacy-policy.html">Privacy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- JS -->
    <script src="https://canucksimmigration.com/assets/js/jquery-3.7.1.min.js"></script>
    <script src="https://canucksimmigration.com/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://canucksimmigration.com/assets/js/gsap/gsap.js"></script>
    <script src="https://canucksimmigration.com/assets/js/gsap/gsap-scroll-trigger.js"></script>
    <script src="https://canucksimmigration.com/assets/js/gsap/gsap-split-text.js"></script>
    <script src="https://canucksimmigration.com/assets/js/jquery.nice-select.min.js"></script>
    <script src="https://canucksimmigration.com/assets/js/jquery.waypoints.js"></script>
    <script src="https://canucksimmigration.com/assets/js/jquery.counterup.min.js"></script>
    <script src="https://canucksimmigration.com/assets/js/slick.min.js"></script>
    <script src="https://canucksimmigration.com/assets/js/swiper-bundle.min.js"></script>
    <script src="https://canucksimmigration.com/assets/js/slick-animation.min.js"></script>
    <script src="https://canucksimmigration.com/assets/js/jquery.meanmenu.min.js"></script>
    <script src="https://canucksimmigration.com/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="https://canucksimmigration.com/assets/js/wow.min.js"></script>
    <script src="https://canucksimmigration.com/assets/js/circle-progress.js"></script>
    <script src="https://canucksimmigration.com/assets/js/main.js"></script>

    <script>
        // Back to top button
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        backToTop.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Animate payment details when they appear
        document.addEventListener('DOMContentLoaded', function() {
            const details = document.querySelector('.payment-details');
            if (details && details.classList.contains('show')) {
                details.style.animation = 'fadeInUp 0.5s ease';
            }
        });
    </script>
</body>

</html>
<?php $conn->close(); ?>