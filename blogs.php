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