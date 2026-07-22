<?php

// --------------------
// Database connection
// --------------------
// ✅ Connect to local XAMPP MySQL database
$servername = "localhost";
$username = "u868210921_LWn5H";
$password = ")rkw_t0FWV";
$dbname = "u868210921_sO6aT";  // your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// --------------------
// Validate blog ID
// --------------------
if (!isset($_GET['slug'])) {
    die("Invalid blog slug");
}

$slug = $_GET['slug'];
$sql = "SELECT * FROM wp_posts WHERE post_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $slug);;

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Blog not found!");
}

$blog = $result->fetch_assoc();
$stmt->close();

$sql_meta = "
    SELECT meta_key, meta_value
    FROM wp_postmeta
    WHERE post_id = ?
";

$stmt_meta = $conn->prepare($sql_meta);
$stmt_meta->bind_param("i", $blog['ID']);
$stmt_meta->execute();
$result_meta = $stmt_meta->get_result();

$post_meta = [];
while ($row = $result_meta->fetch_assoc()) {
    $post_meta[$row['meta_key']] = $row['meta_value'];
}

$stmt_meta->close();

// Fetch published blog posts
$sql = "SELECT ID, post_title, post_content, post_date, post_author,post_name
        FROM wp_posts
        WHERE post_type='post' AND post_status='publish' AND post_name != '$slug'
        ORDER BY post_date DESC";
$result = $conn->query($sql);

if ($result === false) {
    die("❌ SQL Error: " . $conn->error);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/favicon.png">
    <meta name="robots" content="index, follow">
    <meta name="title" content="<?php echo htmlspecialchars($post_meta['rank_math_title'] ?? $blog['post_title']); ?>">
    <meta name="description" content="<?php echo htmlspecialchars($post_meta['rank_math_description'] ?? 'Default meta description here.'); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($post_meta['rank_math_focus_keyword'] ?? ''); ?>">
    <link rel="canonical" href="https://canucksmigration.ca/blogs/<?php echo $slug; ?>" />
    <title><?php echo htmlspecialchars($post_meta['rank_math_title'] ?? $blog['post_title']); ?></title>

    <!-- CSS -->
    <link href="https://canucksmigration.ca/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://canucksmigration.ca/css/style.css">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/brands.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-MSPXHW6R');
    </script>
    <!-- End Google Tag Manager -->
    <style>
        /* ===== UPDATED COLOR SCHEME ===== */
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
            --color-gradient-1: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 19.36%, rgba(15, 116, 230, 0.55) 71.26%, #166FD3 100%);
            --color-gradient-2: linear-gradient(180deg, rgba(0, 0, 0, 0.31) 0%, rgba(0, 0, 0, 0.78) 100%);
            ---box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;

            /* extended for design */
            --bs-bg-light: #FFFFFF;
            --bs-dark: var(--header);
            --bs-text-primary: var(--header);
            --bs-text-secondary: var(--text);
            --bs-text-muted: var(--text2);
            --accent: var(--theme);
            --accent-light: #ff3b5e;
            --accent-lighter: #fde8ec;
            --gradient-bg: linear-gradient(180deg, #ffffff 0%, #f5f5f7 100%);
            --gradient-primary: linear-gradient(135deg, #E20935 0%, #b0072a 100%);
            --gradient-light: linear-gradient(135deg, #F7FAFC 0%, #EDF2F7 100%);
            --gradient-card: linear-gradient(145deg, #FFFFFF 0%, #F7FAFC 100%);
            --gradient-text: linear-gradient(90deg, #E20935, #ff4b6e, #E20935);
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --border-light: 1px solid #E2E8F0;
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

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px 0 20px;
        }

        /* Header / Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.02);
        }

        .navbar .nav-link,
        .navbar .navbar-nav .nav-link {
            color: var(--header) !important;
            font-weight: 500;
        }

        .navbar .nav-link:hover {
            color: var(--theme) !important;
        }

        .glass-btn {
            background: var(--theme);
            color: white !important;
            border-radius: 40px;
            padding: 0.6rem 1.6rem;
            font-weight: 600;
            font-size: 0.85rem;
            border: none;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .glass-btn:hover {
            background: #b0072a;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(226, 9, 53, 0.25);
            color: white !important;
        }

        .breadcrumb-item a {
            color: var(--theme);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--text);
        }

        /* Blog Hero Section */
        .blog-hero {
            padding: 150px 0 80px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(180deg, #ffffff 0%, #f5f5f7 100%);
            text-align: center;
            border-bottom: var(--border-light);
        }

        .blog-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            margin-bottom: 40px;
        }

        .blog-hero h1 {
            font-size: 35px;
            margin-bottom: 24px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -1px;
            color: var(--header);
        }

        .blog-hero h1 .gradient-text {
            background: var(--gradient-text);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% auto;
            animation: textShine 3s linear infinite;
        }

        @keyframes textShine {
            to {
                background-position: 200% center;
            }
        }

        .blog-meta {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            color: var(--text2);
            font-size: 16px;
            margin-bottom: 40px;
        }

        .blog-meta i {
            color: var(--theme);
            margin-right: 8px;
        }

        /* Blog Content Section */
        .blog-content-section {
            position: relative;
            background: var(--bg);
        }

        .blog-content-wrapper {
            max-width: 900px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 20px;
            padding: 50px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
        }

        .blog-featured-image {
            width: 100%;
            border-radius: 15px;
            margin-bottom: 40px;
            box-shadow: var(--shadow-md);
        }

        .blog-content {
            font-size: 18px;
            line-height: 1.8;
            color: var(--text);
        }

        .blog-content h1,
        .blog-content h2,
        .blog-content h3,
        .blog-content h4 {
            color: var(--header);
            margin: 30px 0 20px;
            font-weight: 600;
        }

        .blog-content h1 {
            font-size: 32px;
            padding-bottom: 10px;
        }

        .blog-content h2 {
            font-size: 28px;
        }

        .blog-content h3 {
            font-size: 24px;
        }

        .blog-content p {
            margin-bottom: 20px;
            font-weight: 400;
            color: var(--text);
        }

        .blog-content a {
            color: var(--theme);
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
        }

        .blog-content a:hover {
            color: #b0072a;
            text-decoration: underline;
        }

        .blog-content ul,
        .blog-content ol {
            margin: 20px 0;
            padding-left: 30px;
            color: var(--text);
        }

        .blog-content li {
            margin-bottom: 10px;
        }

        .blog-content blockquote {
            border-left: 4px solid var(--theme);
            padding: 20px 20px 20px 30px;
            margin: 30px 0;
            font-style: italic;
            color: var(--text);
            background: var(--accent-lighter);
            border-radius: 0 10px 10px 0;
            box-shadow: var(--shadow-sm);
        }

        .blog-content code {
            background: var(--accent-lighter);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            color: var(--theme);
        }

        .blog-content pre {
            background: var(--header);
            color: white;
            padding: 20px;
            border-radius: 10px;
            overflow-x: auto;
            margin: 20px 0;
            box-shadow: var(--shadow-md);
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
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
            text-decoration: none;
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--gradient-primary);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
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

        .blog-section {
            padding-top: 100px;
            padding-bottom: 50px;
        }

        .blog-card {
            background-color: var(--white);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: transform 0.3s ease-in-out;
            height: 100%;
            border: 1px solid var(--border);
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--theme);
        }

        .blog-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .blog-content {
            padding: 20px;
        }

        .blog-content h4 {
            font-weight: bold;
            color: var(--header);
        }

        .blog-meta {
            font-size: 0.9rem;
            color: var(--text2);
        }

        .read-more-btn {
            color: var(--theme);
            text-decoration: none;
            font-weight: bold;
        }

        .read-more-btn:hover {
            color: #b0072a;
        }

        /* CTA Section */
        .cta-section {
            padding: 100px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
            background: var(--white);
            border-top: 1px solid var(--border);
        }

        .cta-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .cta-section h2 {
            font-size: 48px;
            margin-bottom: 24px;
            color: var(--header);
            font-weight: 700;
            line-height: 1.2;
        }

        .cta-section p {
            font-size: 20px;
            max-width: 700px;
            margin: 0 auto 40px;
            color: var(--text2);
        }

        .cta-content .highlight {
            color: var(--theme);
        }

        .cta-content .highlight-alt {
            color: #ff4b6e;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header .subheading {
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            color: var(--theme);
            margin-bottom: 10px;
        }

        .section-header .title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--header);
        }

        .blog-slider-wrapper {
            position: relative;
            overflow: hidden;
        }

        .blog-slider {
            display: flex;
            gap: 30px;
            transition: transform 0.6s ease-in-out;
            overflow-x: auto;
            scroll-behavior: smooth;
            scrollbar-width: none;
            padding: 1rem 0;
        }

        .blog-slider::-webkit-scrollbar {
            display: none;
        }

        .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: var(--white);
            color: var(--header);
            border: 1px solid var(--border);
            font-size: 2rem;
            padding: 6px 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 5;
            border-radius: 50%;
            box-shadow: var(--shadow-md);
        }

        .slider-btn:hover {
            background: var(--theme);
            color: white;
            border-color: var(--theme);
            box-shadow: 0 0 15px rgba(226, 9, 53, 0.3);
        }

        .slider-btn.left {
            left: 10px;
        }

        .slider-btn.right {
            right: 10px;
        }

        .blog-cta-container {
            background: var(--bg);
        }

        /* Footer */
        footer {
            background: var(--header);
            color: rgba(255, 255, 255, 0.8);
            padding: 60px 0 30px;
        }

        .footer-logo-text {
            font-size: 1.6rem;
            font-weight: 700;
            color: white;
        }

        .footer-column h3,
        .footer-column h4 {
            color: white;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .footer-links,
        .contact-info {
            list-style: none;
            padding: 0;
        }

        .footer-links li,
        .contact-info li {
            margin-bottom: 12px;
        }

        .footer-links a,
        .contact-info a,
        .contact-info span {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: 0.3s;
        }

        .footer-links a:hover {
            color: var(--theme);
            padding-left: 6px;
        }

        .social-links a {
            display: inline-block;
            width: 38px;
            height: 38px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
            text-align: center;
            line-height: 38px;
            color: white;
            margin-right: 12px;
            transition: 0.3s;
        }

        .social-links a:hover {
            background: var(--theme);
            color: white;
        }

        .newsletter-form {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .newsletter-form input {
            flex: 1;
            padding: 10px 16px;
            border-radius: 40px;
            border: none;
            background: rgba(255, 255, 255, 0.08);
            color: white;
        }

        .newsletter-form input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .newsletter-form button {
            background: var(--theme);
            border: none;
            padding: 10px 20px;
            border-radius: 40px;
            color: white;
            font-weight: 600;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            padding-top: 24px;
            margin-top: 40px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }

        .footer-bottom-links a {
            color: rgba(255, 255, 255, 0.6);
            margin-left: 24px;
            text-decoration: none;
        }

        .footer-bottom-links a:hover {
            color: var(--theme);
        }

        /* Responsive Design */
        @media (max-width: 1100px) {
            .blog-hero h1 {
                font-size: 42px;
            }

            .cta-section h2 {
                font-size: 32px;
            }
        }

        @media (max-width: 768px) {
            .blog-hero {
                padding: 150px 0 60px;
            }

            .blog-hero h1 {
                font-size: 36px;
            }

            .blog-meta {
                flex-direction: column;
                gap: 10px;
            }

            .blog-content-wrapper {
                padding: 30px 20px;
            }

            .cta-section h2 {
                font-size: 28px;
            }

            .back-to-top {
                bottom: 20px;
                right: 20px;
                width: 45px;
                height: 45px;
            }

            .blog-card {
                flex: 0 0 280px;
            }
        }

        @media (max-width: 576px) {
            .blog-hero h1 {
                font-size: 32px;
            }

            .cta-section h2 {
                font-size: 24px;
            }

            .blog-content {
                font-size: 16px;
            }

            .blog-content h1 {
                font-size: 28px;
            }

            .blog-content h2 {
                font-size: 24px;
            }

            .blog-content h3 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSPXHW6R" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>

    <!-- Header - Updated to CanucksMigration -->
    <div class="container-fluid header position-relative p-0">
        <nav class="navbar navbar-expand-lg fixed-top navbar-light px-lg-5 py-3 py-lg-0">
            <a href="https://canucksmigration.ca" class="navbar-brand p-0">
                <img src="https://canucksmigration.ca/img/company_logo_white.svg" alt="CanucksMigration" id="toggleImg" style="transition: all ease .8s; height:40px;">
            </a>
            <button class="navbar-toggler navbar-toggler-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="https://canucksmigration.ca" class="nav-item nav-link">Home</a>
                    <a href="https://canucksmigration.ca/about.html" class="nav-item nav-link">About</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Services</a>
                        <div class="dropdown-menu m-0">
                            <div class="submenu-wrapper">
                                <div class="dropdown-item submenu-parent">
                                    <a href="https://canucksmigration.ca/digital-marketing-services.html" class="submenu-link">Digital Marketing</a>
                                    <button class="submenu-toggle" type="button">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="submenu">
                                    <a class="dropdown-item" href="https://canucksmigration.ca/seo-company-in-india.html">SEO</a>
                                    <a class="dropdown-item" href="https://canucksmigration.ca/social-media-optimization-services.html">SMO/SMM</a>
                                    <a class="dropdown-item" href="https://canucksmigration.ca/best-ppc-marketing-agency.html">PPC</a>
                                    <a class="dropdown-item" href="https://canucksmigration.ca/content-marketing-services.html">Content Marketing</a>
                                </div>
                            </div>
                            <div class="submenu-wrapper">
                                <div class="dropdown-item submenu-parent">
                                    <a href="https://canucksmigration.ca/web-development-services.html" class="submenu-link">Web Development</a>
                                    <button class="submenu-toggle" type="button">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="submenu">
                                    <a class="dropdown-item" href="https://canucksmigration.ca/custom-website-development-services.html">Custom Website Development</a>
                                    <a class="dropdown-item" href="https://canucksmigration.ca/ui-ux-design-services.html">UI/UX Design</a>
                                    <a class="dropdown-item" href="https://canucksmigration.ca/web-and-mobile-app-development.html">Web/Mobile App Development</a>
                                </div>
                            </div>
                            <div class="submenu-wrapper">
                                <a href="https://canucksmigration.ca/logo-design-services.html" class="dropdown-item">Logo Design</a>
                            </div>
                            <div class="submenu-wrapper">
                                <div class="dropdown-item submenu-parent">
                                    <a href="https://canucksmigration.ca/bpo-services.html" class="submenu-link">BPO</a>
                                    <button class="submenu-toggle" type="button">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="submenu">
                                    <a class="dropdown-item" href="https://canucksmigration.ca/back-office-support-services.html">Back Office Support</a>
                                    <a class="dropdown-item" href="https://canucksmigration.ca/call-center-services.html">Call Centre Services</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="https://canucksmigration.ca/blogs.php" class="nav-item nav-link active">Blogs</a>
                    <a href="https://canucksmigration.ca/career.php" class="nav-item nav-link">Career</a>
                    <a href="https://canucksmigration.ca/contact.html" class="nav-item nav-link">Contact</a>
                </div>
                <a href="tel:+917318083502" class="glass-btn nav-link-btn" style="margin-right: 2rem; font-size: .8rem; padding:.6rem 1.8rem;">Let's Talk</a>
            </div>
        </nav>

        <!-- Blog Hero Section -->
        <?php
        $author_id = $blog['post_author'];
        $author_result = $conn->query("SELECT display_name FROM wp_users WHERE ID = $author_id");
        $author = ($author_result && $author_result->num_rows > 0)
            ? $author_result->fetch_assoc()['display_name']
            : "Unknown";

        $image_result = $conn->query("
            SELECT meta_value FROM wp_postmeta
            WHERE post_id = {$blog['ID']} AND meta_key = '_thumbnail_id' LIMIT 1
        ");
        $thumbnail_id = ($image_result && $image_result->num_rows > 0)
            ? $image_result->fetch_assoc()['meta_value']
            : 0;

        $img_url = '';
        if ($thumbnail_id) {
            $guid_result = $conn->query("SELECT guid FROM wp_posts WHERE ID = $thumbnail_id");
            $img_url = ($guid_result && $guid_result->num_rows > 0)
                ? $guid_result->fetch_assoc()['guid']
                : '';
        }
        ?>

        <section class="blog-hero">
            <div class="container">
                <h1><?php echo htmlspecialchars($blog['post_title']); ?></h1>
                <div class="blog-meta">
                    <span><i class="fas fa-calendar-alt"></i> <?php echo date("F j, Y", strtotime($blog['post_date'])); ?></span>
                    <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($author); ?></span>
                </div>
            </div>
        </section>
    </div>

    <!-- Blog Content Section -->
    <section class="blog-content-section">
        <div class="container">
            <?php if ($img_url): ?>
                <img src="<?php echo $img_url; ?>" class="blog-image" style="border-radius: 20px;"
                    alt="<?php echo htmlspecialchars($blog['post_title']); ?>">
            <?php else: ?>
                <div class="blog-content-wrapper">
                    <div class="blog-image" style="background: var(--gradient-primary); display: flex; align-items: center; justify-content: center; height: 300px; border-radius: 20px;">
                        <i class="fas fa-newspaper" style="font-size: 48px; color: white;"></i>
                    </div>
                <?php endif; ?>

                <div class="blog-content-wrapper">
                    <div class="blog-content">
                        <?php echo $blog['post_content']; ?>
                    </div>
                </div>
                </div>
    </section>

    <div class="blog-cta-container">
        <section class="blog-section">
            <div class="container" style="max-width: 1200px;">
                <div class="section-header">
                    <p class="subheading">Our Blogs</p>
                    <h2 class="title">Latest Insights & Stories</h2>
                </div>

                <div class="blog-slider-wrapper">
                    <button class="slider-btn left">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                    <div class="blog-slider">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <?php
                                $author_id = $row['post_author'];
                                $author_result = $conn->query("SELECT display_name FROM wp_users WHERE ID = $author_id");
                                $author = ($author_result && $author_result->num_rows > 0)
                                    ? $author_result->fetch_assoc()['display_name']
                                    : "Unknown";

                                $image_result = $conn->query("
                                        SELECT meta_value FROM wp_postmeta
                                        WHERE post_id = {$row['ID']} AND meta_key = '_thumbnail_id' LIMIT 1
                                    ");
                                $thumbnail_id = ($image_result && $image_result->num_rows > 0)
                                    ? $image_result->fetch_assoc()['meta_value']
                                    : 0;

                                $img_url = '';
                                if ($thumbnail_id) {
                                    $guid_result = $conn->query("SELECT guid FROM wp_posts WHERE ID = $thumbnail_id");
                                    $img_url = ($guid_result && $guid_result->num_rows > 0)
                                        ? $guid_result->fetch_assoc()['guid']
                                        : '';
                                }
                                ?>
                                <div class="blog-card">
                                    <h3 class="blog-title" style="padding: 20px 20px 0; font-size:1.2rem; font-weight:700; color:var(--header);"><?php echo htmlspecialchars($row['post_title']) ?></h3>
                                    <?php if ($img_url): ?>
                                        <div class="blog-image" style="margin-bottom: 0;">
                                            <img src="<?php echo htmlspecialchars($img_url) ?>" alt="Blog Image" />
                                        </div>
                                    <?php else: ?>
                                        <div class="blog-image" style="margin-bottom: 0; background: var(--bg2); display:flex; align-items:center; justify-content:center; height:200px;">
                                            <i class="fas fa-newspaper" style="font-size:48px; color:var(--theme);"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="blog-content">
                                        <p style="color:var(--text);"><?php echo substr(strip_tags($row['post_content']), 0, 120); ?>...</p>
                                        <a href="https://canucksmigration.ca/blogs/<?php echo $row['post_name']; ?>" class="read-more-btn">Read More <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="col-12 text-center">
                                <p style="color: var(--text2); font-size: 18px;">No blogs found. Check back soon for new articles!</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <button class="slider-btn right">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </section>
    </div>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Let's Create Something Amazing Together</h2>
                <p>Ready to transform your digital presence? Let's discuss how our expertise can help your business
                    thrive in the digital landscape.</p>
                <div class="hero-buttons">
                    <a href="https://canucksmigration.ca/contact.html" class="btn-primary">Request a Quote <i class="fas fa-paper-plane"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer - Updated to CanucksMigration -->
    <footer>
        <div class="container-fluid footer-container" style="padding: 0 2rem;">
            <div class="footer-content" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); gap:40px;">
                <div class="footer-column">
                    <div class="footer-logo">
                        <div class="footer-logo-text">CanucksMigration</div>
                    </div>
                    <p>We provide cutting-edge technology solutions to help businesses thrive in the digital age. Our team of experts delivers innovative software and consulting services.</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/CanucksMigration/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/canucksmigration/" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/canucks-migration/" target="_blank"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="https://canucksmigration.ca"><i class="fas fa-chevron-right"></i> Home</a></li>
                        <li><a href="https://canucksmigration.ca/about.html"><i class="fas fa-chevron-right"></i> About Us</a></li>
                        <li><a href="https://canucksmigration.ca/blogs.php"><i class="fas fa-chevron-right"></i> Blogs</a></li>
                        <li><a href="https://canucksmigration.ca/career.php"><i class="fas fa-chevron-right"></i> Career</a></li>
                        <li><a href="https://canucksmigration.ca/contact.html"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Our Services</h3>
                    <ul class="footer-links">
                        <li><a href="https://canucksmigration.ca/custom-website-development-services.html"><i class="fas fa-chevron-right"></i> Web Development</a></li>
                        <li><a href="https://canucksmigration.ca/web-and-mobile-app-development.html"><i class="fas fa-chevron-right"></i> Mobile Apps</a></li>
                        <li><a href="https://canucksmigration.ca/graphic-designing.html"><i class="fas fa-chevron-right"></i> Graphic Designing</a></li>
                        <li><a href="https://canucksmigration.ca/digital-marketing-services.html"><i class="fas fa-chevron-right"></i> Digital Marketing</a></li>
                        <li><a href="https://canucksmigration.ca/ui-ux-design-services.html"><i class="fas fa-chevron-right"></i> UI/UX Design</a></li>
                        <li><a href="https://canucksmigration.ca/bpo-services.html"><i class="fas fa-chevron-right"></i> BPO Services</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <ul class="contact-info">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Kanpur Nagar, Uttar Pradesh, India</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>+91 7318083502</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>contact@canucksmigration.ca</span>
                        </li>
                    </ul>

                    <h4 style="margin-top: 20px; margin-bottom: 10px;">Newsletter</h4>
                    <p style="font-size: 0.9rem;">Subscribe to our newsletter for the latest updates.</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Your email address" required>
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
            </div>

            <div class="footer-bottom">
                <p style="margin-bottom:0;">&copy; 2026 CanucksMigration. All Rights Reserved.</p>
                <div class="footer-bottom-links">
                    <a href="https://canucksmigration.ca/privacy-policy.html">Privacy Policy</a>
                    <a href="https://canucksmigration.ca/terms-and-conditions.html">Terms of Service</a>
                    <a href="https://canucksmigration.ca/sitemap.html">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <a href="#" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="https://canucksmigration.ca/js/main.js"></script>
    <script src="https://canucksmigration.ca/index.js"></script>
    <script>
        // Show/hide back to top button
        window.addEventListener('scroll', function() {
            const backToTop = document.querySelector('.back-to-top');
            if (window.scrollY > 50) {
                backToTop.style.display = 'flex';
            } else {
                backToTop.style.display = 'none';
            }
        });

        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for back to top
        document.querySelector('.back-to-top').addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Slider functionality
        const slider = document.querySelector(".blog-slider");
        const leftBtn = document.querySelector(".slider-btn.left");
        const rightBtn = document.querySelector(".slider-btn.right");

        if (slider && leftBtn && rightBtn) {
            const cardWidth = 380;

            rightBtn.addEventListener("click", () => {
                slider.scrollBy({
                    left: cardWidth,
                    behavior: "smooth"
                });
            });

            leftBtn.addEventListener("click", () => {
                slider.scrollBy({
                    left: -cardWidth,
                    behavior: "smooth"
                });
            });
        }
    </script>
</body>

</html>
<?php
$conn->close();
?>