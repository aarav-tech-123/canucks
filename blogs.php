<?php
// ✅ Enable debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Connect to local XAMPP MySQL database
$servername = "localhost";
$username = "u868210921_LWn5H";
$password = ")rkw_t0FWV";
$dbname = "u868210921_sO6aT"; // ⚠️ Change this to your actual DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Fetch published blog posts
$sql = "SELECT ID, post_title, post_content, post_date, post_author,post_name
        FROM wp_posts
        WHERE post_type='post' AND post_status='publish'
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
    <link rel="icon" href="https://canucksimmigration.com/img/favicon.png">
    <meta name="robots" content="index, follow">
    <title>Explore Our Blog Section | Learn, Apply & Grow with Insights</title>
    <meta name="description"
        content="Unlock expert articles on marketing, design & technology. Learn what works, apply it & see results. Browse CanucksMigration blogs now and grow smarter today.">
    <link rel="canonical" href="https://canucksimmigration.com/blogs.php" />

    <!-- CSS -->
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
            --bs-bg-dark: var(--header);
            --bs-light: var(--bg);
            --accent: var(--theme);
            --accent-light: #ff3b5e;
            --gradient-primary: linear-gradient(135deg, #E20935 0%, #b0072a 100%);
            --gradient-secondary: linear-gradient(135deg, #16171A 0%, #2a2c33 100%);
            --gradient-card: linear-gradient(145deg, rgba(255, 255, 255, 0.95) 0%, #f8f8fa 100%);
            --gradient-text: linear-gradient(90deg, #E20935, #ff4b6e, #E20935);
            --gradient-pricing: linear-gradient(135deg, rgba(226, 9, 53, 0.08) 0%, rgba(22, 23, 26, 0.04) 100%);
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
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ===== BANNER SECTION ===== */
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
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .banner-text h1 {
            font-size: 48px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .banner-text h1 span {
            color: #ffd700;
        }

        .banner-text p {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.9);
            max-width: 750px;
            margin: 0 auto 30px;
            line-height: 1.6;
        }

        .banner-buttons {
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .banner-btn {
            padding: 14px 36px;
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
            background: #ffd700;
            color: var(--header);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
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
                font-size: 32px;
            }

            .banner-text p {
                font-size: 17px;
            }

            .banner-buttons {
                flex-direction: column;
                align-items: center;
            }

            .banner-btn {
                padding: 12px 28px;
                font-size: 15px;
                width: 100%;
                max-width: 280px;
                justify-content: center;
            }
        }

        /* Blog section */
        .blog-section {
            padding: 80px 0 100px;
            background: var(--bg);
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title .subheading {
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            color: var(--theme);
            font-size: 14px;
            margin-bottom: 10px;
        }

        .section-title h2 {
            font-size: 44px;
            color: var(--header);
            font-weight: 700;
            margin-bottom: 16px;
        }

        .section-title h2 .gradient-text {
            background: var(--gradient-text);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% auto;
            animation: textShine 3s linear infinite;
        }

        .section-title p {
            color: var(--text2);
            font-size: 18px;
            max-width: 750px;
            margin: 0 auto;
            line-height: 1.7;
        }

        @keyframes textShine {
            to {
                background-position: 200% center;
            }
        }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 30px;
        }

        .blog-card {
            background: var(--white);
            border-radius: 24px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
            text-decoration: none;
            color: inherit;
            display: block;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .blog-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
            border-color: var(--theme);
        }

        .blog-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            background: var(--bg2);
        }

        .blog-content {
            padding: 28px 24px 30px;
        }

        .blog-meta {
            display: flex;
            gap: 18px;
            font-size: 14px;
            color: var(--text2);
            margin-bottom: 12px;
        }

        .blog-meta i {
            color: var(--theme);
            margin-right: 6px;
        }

        .blog-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--header);
            margin-bottom: 14px;
            line-height: 1.3;
        }

        .blog-excerpt {
            color: var(--text);
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .read-more {
            background: var(--theme);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            display: inline-block;
            text-decoration: none;
            cursor: pointer;
        }

        .read-more:hover {
            background: #b0072a;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(226, 9, 53, 0.25);
            color: white;
        }

        /* CTA */
        .cta-section {
            padding: 90px 0;
            background: var(--white);
            border-top: 1px solid var(--border);
        }

        .cta-section h2 {
            font-size: 44px;
            font-weight: 700;
            color: var(--header);
        }

        .cta-section p {
            font-size: 18px;
            color: var(--text2);
            max-width: 700px;
            margin: 0 auto 30px;
        }

        .btn-primary {
            background: var(--theme);
            color: white;
            border: none;
            padding: 14px 38px;
            border-radius: 40px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 14px rgba(226, 9, 53, 0.2);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background: #b0072a;
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(226, 9, 53, 0.3);
            color: white;
        }
    </style>
    <!-- ✅ Google Tag Manager -->
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
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-MSPXHW6R');
    </script>
</head>

<body>
    <!-- ✅ Google Tag Manager (noscript) -->
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
                        <a href="https://www.facebook.com/CanucksMigration"> <i class="fab fa-facebook-f"></i></a>
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
                                <a href="https://canucksimmigration.com/" class="header-logo">
                                    <img src="https://canucksimmigration.com/assets/img/logo/logo.png" alt="logo-img"
                                        style="width: 100px; height: 90px;">
                                </a>
                            </div>
                            <div class="mean__menu-wrapper">
                                <div class="main-menu">
                                    <nav id="mobile-menu">
                                        <ul>
                                            <li class="has-dropdown active menu-thumb">
                                                <a href="https://canucksimmigration.com/">
                                                    Home
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://canucksimmigration.com/about.html">About</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)">Services <i class="fas fa-angle-down"></i>
                                                </a>
                                                <ul class="submenu">
                                                    <li><a href="https://canucksimmigration.com/business-investment-visa-for-canada.html">Business
                                                            Investment Visa for Canada</a>
                                                    </li>
                                                    <li><a href="https://canucksimmigration.com/canada-express-entry.html">Canada Express Entry</a>
                                                    </li>
                                                    <li><a href="https://canucksimmigration.com/judicial-review.html">Judicial Review</a></li>
                                                    <li><a href="https://canucksimmigration.com/provincial-nominee-program.html">PNP</a></li>
                                                    <li><a href="https://canucksimmigration.com/canadian-immigration-services.html">Immigration
                                                            Consulting Services</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="https://canucksimmigration.com/blogs.php">
                                                    Blog
                                                </a>
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
                <!-- <div class="banner-badge">
                    <i class="fas fa-blog"></i> Our Blogs
                </div> -->
                <div class="banner-text">
                    <h1>Our Blogs</h1>
                    <p>A place where immigration insights meet practical guidance. Explore our blogs to stay informed, prepared, and confident throughout your immigration journey.</p>
                </div>
                <div class="banner-buttons">
                    <a href="#latest-blogs" class="banner-btn banner-btn-primary">
                        <i class="fas fa-arrow-down"></i> Explore Blogs
                    </a>
                    <a href="https://canucksimmigration.com/contact.html" class="banner-btn banner-btn-secondary">
                        <i class="fas fa-paper-plane"></i> Get Started
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ✅ Blog Section -->
    <section class="blog-section" id="latest-blogs">
        <div class="container">
            <div class="section-title">
                <span class="subheading">Latest Insights & Guidance</span>
                <h2>Insights & Guidance for Your <span class="gradient-text">Immigration Journey</span></h2>
                <p>Explore expert articles on immigration pathways, application processes, policies, and helpful tips. Gain practical knowledge, understand your options, and make informed decisions at every step of your journey.</p>
            </div>

            <div class="blog-grid">
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
                        <a class="blog-card" href="https://canucksimmigration.com/blogs/<?php echo $row['post_name']; ?>">
                            <?php if ($img_url): ?>
                                <img src="<?php echo $img_url; ?>" class="blog-image"
                                    alt="<?php echo htmlspecialchars($row['post_title']); ?>">
                            <?php else: ?>
                                <div class="blog-image" style="background: var(--bg2); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-newspaper" style="font-size: 48px; color: var(--theme);"></i>
                                </div>
                            <?php endif; ?>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span><i class="fas fa-calendar-alt"></i> <?php echo date("F j, Y", strtotime($row['post_date'])); ?></span>
                                    <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($author); ?></span>
                                </div>
                                <h3 class="blog-title"><?php echo htmlspecialchars($row['post_title']); ?></h3>
                                <p class="blog-excerpt"><?php echo substr(strip_tags($row['post_content']), 0, 120); ?>...</p>
                                <span class="read-more">Read More</span>
                            </div>
                        </a>

                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p style="color: var(--text2); font-size: 18px;">No blogs found. Check back soon for new articles!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content text-center">
                <h2>Ready to Begin Your Canadian Immigration Journey?</h2>
                <p>Get expert guidance and personalized support to explore the right immigration pathway for your goals.</p>
                <div class="hero-buttons">
                    <a href="https://canucksimmigration.com/contact.html" class="btn-primary">Lets Get Started<i class="fas fa-paper-plane"></i></a>
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
                                <a href="https://canucksimmigration.com/">
                                    <img src="https://canucksimmigration.com/assets/img/logo/footer-logo.png" alt="logo-img">
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
                                    <a href="https://canucksimmigration.com/">
                                        Home
                                    </a>
                                </li>
                                <li>
                                    <a href="https://canucksimmigration.com/about.html">
                                        About
                                    </a>
                                </li>
                                <li>
                                    <a href="https://canucksimmigration.com/contact.html">
                                        Contact
                                    </a>
                                </li>
                                <li>
                                    <a href="https://canucksimmigration.com/blogs.php">
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
                                    <a href="https://canucksimmigration.com/business-investment-visa-for-canada.html">
                                        Business Investment Visa for Canada
                                    </a>
                                </li>
                                <li>
                                    <a href="https://canucksimmigration.com/canada-express-entry.html">
                                        Canada Express Entry
                                    </a>
                                </li>
                                <li>
                                    <a href="https://canucksimmigration.com/judicial-review.html">
                                        Judicial Review
                                    </a>
                                </li>
                                <li>
                                    <a href="https://canucksimmigration.com/provincial-nominee-program.html">
                                        PNP
                                    </a>
                                </li>
                                <li>
                                    <a href="https://canucksimmigration.com/canadian-immigration-services.html">
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
                        Copyright © 2026 <a href="https://canucksimmigration.com/">Canucks Immigration</a>. All Rights Reserved. | Developed by
                        <a href="https://canucksimmigration.com">Canucks Immigration</a>
                    </p>
                    <ul class="footer-menu wow fadeInRight" data-wow-delay=".5s">

                        <li>
                            <a href="https://canucksimmigration.com/terms-and-conditions.html">
                                Support
                            </a>
                        </li>
                        <li>
                            <a href="https://canucksimmigration.com/privacy-policy.html">
                                Privacy
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!--<< All JS Plugins >>-->
    <script src="https://canucksimmigration.com/assets/js/jquery-3.7.1.min.js"></script>
    <script src="https://canucksimmigration.com/assets/js/viewport.jquery.js"></script>
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
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
    <script src="https://canucksimmigration.com/index.js"></script>
</body>

</html>

<?php $conn->close(); ?>