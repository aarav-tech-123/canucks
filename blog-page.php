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
    </style>
</head>

<body>
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSPXHW6R" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>

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
                        <a href="#https://www.facebook.com/CanucksMigration"> <i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/canucks.migration?igsh=MXdtOGx1ZWJhdHFmOA=="><i
                                class="fab fa-instagram"></i></a>
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
                                    <img src="assets/img/logo/logo.png" alt="logo-img"
                                        style="width: 100px; height: 90px;">
                                </a>
                            </div>
                            <div class="mean__menu-wrapper">
                                <div class="main-menu">
                                    <nav id="mobile-menu">
                                        <ul>
                                            <li class="has-dropdown active menu-thumb">
                                                <a href="/">
                                                    Home
                                                </a>
                                            </li>
                                            <li>
                                                <a href="about.html">About</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)">Services <i class="fas fa-angle-down"></i>
                                                </a>
                                                <ul class="submenu">
                                                    <li><a href="business-investment-visa-for-canada.html">Business
                                                            Investment Visa for Canada</a>
                                                    </li>
                                                    <li><a href="canada-express-entry.html">Canada Express Entry</a>
                                                    </li>
                                                    <li><a href="judicial-review.html">Judicial Review</a></li>
                                                    <li><a href="provincial-nominee-program.html">PNP</a></li>
                                                    <li><a href="canadian-immigration-services.html">Immigration
                                                            Consulting
                                                            Services</a></li>
                                                </ul>
                                            </li>

                                            <li>
                                                <a href="blogs.php">
                                                    Blog
                                                </a>
                                            </li>
                                            <li>
                                                <a href="contact.html">Contact</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="header-right d-flex justify-content-end align-items-center">
                            <div class="contact-info">
                                <div class="icon">
                                    <img src="assets/img/call.png" alt="img">
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

    <!--<< Footer Section Start >>-->
    <footer class="footer-section footer-bg">
        <div class="container">
            <div class="footer-widgets-wrapper">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 col-md-6 col-lg-3 wow fadeInUp" data-wow-delay=".2s">
                        <div class="single-footer-widget">
                            <div class="widget-head">
                                <a href="/">
                                    <img src="assets/img/logo/footer-logo.png" alt="logo-img">
                                </a>
                            </div>
                            <div class="footer-content">
                                <p>
                                    Simplifying Canadian immigration with trusted guidance.
                                </p>
                                <div class="social-icon d-flex align-items-center">
                                    <a href="https://www.facebook.com/CanucksMigration"><i
                                            class="fab fa-facebook-f"></i></a>
                                    <a href="https://www.instagram.com/canucks.migration?igsh=MXdtOGx1ZWJhdHFmOA=="><i
                                            class="fab fa-instagram"></i></a>
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
                                <li>
                                    <a href="/">
                                        Home
                                    </a>
                                </li>
                                <li>
                                    <a href="about.html">
                                        About
                                    </a>
                                </li>
                                <li>
                                    <a href="contact.html">
                                        Contact
                                    </a>
                                </li>
                                <li>
                                    <a href="blogs.php">
                                        Blogs
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 ps-lg-4 col-sm-6 col-md-3 col-lg-3 wow fadeInUp" data-wow-delay=".6s">
                        <div class="single-footer-widget">
                            <div class="widget-head">
                                <h5>Services</h5>
                            </div>
                            <ul class="list-items">
                                <li>
                                    <a href="business-investment-visa-for-canada.html">
                                        Business Investment Visa for Canada
                                    </a>
                                </li>
                                <li>
                                    <a href="canada-express-entry.html">
                                        Canada Express Entry
                                    </a>
                                </li>
                                <li>
                                    <a href="judicial-review.html">
                                        Judicial Review
                                    </a>
                                </li>
                                <li>
                                    <a href="provincial-nominee-program.html">
                                        PNP
                                    </a>
                                </li>
                                <li>
                                    <a href="canadian-immigration-services.html">
                                        Immigration Consulting Services
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-md-6 col-lg-3 wow fadeInUp" data-wow-delay=".8s">
                        <div class="single-footer-widget">
                            <div class="widget-head">
                                <h5>Address:</h5>
                            </div>
                            <div class="footer-address-text">
                                <p>
                                    <i class="fa fa-location"></i>&nbsp; 6060 Silver Drive, Burnaby BC V5H 2Y3
                                </p>
                                <p>
                                    <i class="fa fa-phone"></i>&nbsp; +1-8075007906 <br>
                                </p>
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
                        Copyright © 2026 <a href="/">Canucks Immigration</a>. All Rights Reserved. | Developed by
                        <a href="https://aaravtech.net">Aarav Tech Services LLP</a>
                    </p>
                    <ul class="footer-menu wow fadeInRight" data-wow-delay=".5s">

                        <li>
                            <a href="terms-and-conditions.html">
                                Support
                            </a>
                        </li>
                        <li>
                            <a href="privacy-policy.html">
                                Privacy
                            </a>
                        </li>

                    </ul>
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