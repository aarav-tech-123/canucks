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
    <link rel="icon" href="img/favicon.png">
    <meta name="robots" content="index, follow">
    <title>Explore Our Blog Section | Learn, Apply & Grow with Insights</title>
    <meta name="description"
        content="Unlock expert articles on marketing, design & technology. Learn what works, apply it & see results. Browse CanucksMigration blogs now and grow smarter today.">
    <link rel="canonical" href="https://canucksimmigration.com/blogs.php" />

    <!-- ✅ Styles & Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
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

        /* Hero */
        .hero {
            padding: 140px 0 80px;
            background: linear-gradient(180deg, #ffffff 0%, #f5f5f7 100%);
            position: relative;
        }

        .hero h1 {
            font-size: 60px;
            font-weight: 800;
            color: var(--header);
            letter-spacing: -1px;
        }

        .hero h1 .gradient-text {
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

        .hero p {
            font-size: 20px;
            color: var(--text);
            max-width: 700px;
            margin: 0 auto 40px;
        }

        /* Blog section */
        .blog-section {
            padding: 80px 0 100px;
            background: var(--bg);
        }

        .section-title h2 {
            font-size: 48px;
            color: var(--header);
            font-weight: 700;
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

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 40px;
            }

            .section-title h2 {
                font-size: 36px;
            }

            .cta-section h2 {
                font-size: 34px;
            }

            .blog-grid {
                grid-template-columns: 1fr;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 12px;
            }
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

    <!-- ✅ Spinner -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- ✅ Header - Updated to CanucksMigration -->
    <div class="container-fluid header position-relative p-0">
        <nav class="navbar navbar-expand-lg fixed-top navbar-light px-lg-5 py-3 py-lg-0">
            <a href="https://canucksmigration.ca" class="navbar-brand p-0">
                <img src="img/company_logo_white.svg" alt="CanucksMigration" id="toggleImg" style="transition: all ease .8s; height:40px;">
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
                                    <a href="digital-marketing-services.html" class="submenu-link">Digital Marketing</a>
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
                                    <a href="web-development-services.html" class="submenu-link">Web Development</a>
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
                                    <a href="bpo-services.html" class="submenu-link">BPO</a>
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

        <!-- Hero Section -->
        <section class="hero">
            <div class="container hero-content text-center">
                <ol class="breadcrumb justify-content-center mb-3">
                    <li class="breadcrumb-item"><a href="https://canucksmigration.ca">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                </ol>
                <h1>Our <span class="gradient-text">Blogs</span></h1>
                <p>A place where new ideas meet practical insights. Discover our blogs to keep you informed and inspired.</p>
            </div>
        </section>
    </div>

    <!-- ✅ Blog Section -->
    <section class="blog-section">
        <div class="container">
            <div class="section-title text-center">
                <h2>Insights & Ideas for Your <span class="gradient-text">Digital Journey</span></h2>
                <p>Unlock expert articles on marketing, design & technology. Learn what works, apply it & see results.</p>
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
                        <a class="blog-card" href="https://canucksmigration.ca/blogs/<?php echo $row['post_name']; ?>">
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
    <section class="cta-section text-center">
        <div class="container">
            <div class="cta-content">
                <h2>Let's Create Something Amazing Together</h2>
                <p>Ready to transform your digital presence? Let's discuss how our expertise can help your business
                    thrive in the digital landscape.</p>
                <div class="hero-buttons">
                    <a href="contact.html" class="btn-primary">Request a Quote <i class="fas fa-paper-plane"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- ✅ Footer - Updated to CanucksMigration -->
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
                        <li><a href="about.html"><i class="fas fa-chevron-right"></i> About Us</a></li>
                        <li><a href="blogs.php"><i class="fas fa-chevron-right"></i> Blogs</a></li>
                        <li><a href="career.php"><i class="fas fa-chevron-right"></i> Career</a></li>
                        <li><a href="contact.html"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Our Services</h3>
                    <ul class="footer-links">
                        <li><a href="custom-website-development-services.html"><i class="fas fa-chevron-right"></i> Web Development</a></li>
                        <li><a href="web-and-mobile-app-development.html"><i class="fas fa-chevron-right"></i> Mobile Apps</a></li>
                        <li><a href="graphic-designing.html"><i class="fas fa-chevron-right"></i> Graphic Designing</a></li>
                        <li><a href="digital-marketing-services.html"><i class="fas fa-chevron-right"></i> Digital Marketing</a></li>
                        <li><a href="ui-ux-design-services.html"><i class="fas fa-chevron-right"></i> UI/UX Design</a></li>
                        <li><a href="bpo-services.html"><i class="fas fa-chevron-right"></i> BPO Services</a></li>
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
                    <a href="privacy-policy.html">Privacy Policy</a>
                    <a href="terms-and-conditions.html">Terms of Service</a>
                    <a href="sitemap.html">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="js/main.js"></script>
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
    <script src="./index.js"></script>
</body>

</html>

<?php $conn->close(); ?>