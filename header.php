<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TalentFlex - Modern Job Portal Platform</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Assets -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/price_rangs.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/portal-custom.css">
    <style>
/* Header logo size fix */
.header-area .headder-top .col-xl-2 img {
    width: 210px !important;
    height: 75px !important;
    object-fit: contain;
    display: block;
}

/* Header height and alignment */
.header-area .headder-top .row {
    min-height: 95px;
}

.header-area .headder-top .col-xl-2 {
    display: flex;
    align-items: center;
}

/* Navigation alignment */
.header-area .main-menu {
    margin-top: 0 !important;
}

.header-area #navigation {
    margin: 0;
    padding: 0;
}

/* Login / buttons alignment */
.header-btn-wrap {
    white-space: nowrap;
}
</style>
</head>

<body>
    <!-- Header Start -->
    <header class="header-area">
        <div class="headder-top header-sticky">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Logo Column -->
                    <div class="col-xl-2 col-lg-2 col-md-4 col-6">
                        <div class="" style="display: flex;justify-content: space-between;">
                            <a href="index.php"><img src="assets/img/logo/logo1.png"
                                    alt=""></a>
                        </div>
                    </div>


                    <!-- Main Navigation Menu -->
                    <div class="col-xl-7 col-lg-7 d-none d-lg-block">
                        <div class="main-menu text-center">
                            <nav>
                                <ul id="navigation">
                                    <li class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                                        <a href="index.php">Home</a>
                                    </li>
                                    <li class="<?php echo ($current_page == 's.php' || $current_page == 'job.php' || $current_page == 'job_details.php') ? 'active' : ''; ?>">
                                        <a href="s.php">Search Jobs</a>
                                    </li>
                                    <li class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">
                                        <a href="about.php">About Us</a>
                                    </li>

                                    <?php if (isset($_SESSION['name']) && !isset($_SESSION['admin'])) { ?>
                                        <li class="<?php echo ($current_page == 'profile.php' || $current_page == 'application.php' || $current_page == 'upload.php') ? 'active' : ''; ?>">
                                            <a href="profile.php">Candidate Area <i class="ti-angle-down" style="font-size:11px;"></i></a>
                                            <ul class="submenu">
                                                <li><a href="profile.php"><i class="fas fa-user-circle"></i> My Profile</a></li>
                                                <li><a href="application.php"><i class="fas fa-file-alt"></i> My Applications</a></li>
                                                <li><a href="upload.php"><i class="fas fa-cloud-upload-alt"></i> Upload Resume</a></li>
                                            </ul>
                                        </li>
                                    <?php } ?>

                                    <li class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">
                                        <a href="contact.php">Contact Us</a>
                                    </li>

                                    <?php if (!isset($_SESSION['name']) && !isset($_SESSION['company_name']) && !isset($_SESSION['admin'])) { ?>
                                        <li>
                                            <a href="#">Register <i class="ti-angle-down" style="font-size:11px;"></i></a>
                                            <ul class="submenu">
                                                <li><a href="r.php"><i class="fas fa-user-graduate"></i> Candidate Register</a></li>
                                                <li><a href="company/com.php"><i class="fas fa-building"></i> Company Register</a></li>
                                            </ul>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Header Action Buttons & User Badge -->
                    <div class="col-xl-3 col-lg-3 col-md-8 col-6">
                        <div class="header-btn-wrap d-none d-lg-flex align-items-center justify-content-end">
                            <?php if (isset($_SESSION['admin'])) { ?>
                                <span class="user-badge-nav">
                                    <i class="fas fa-shield-alt"></i> <?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?>
                                </span>
                                <a href="admin/dashboard.php" class="btn-nav-primary">Dashboard</a>
                                <a href="logout.php" class="btn-nav-outline">Logout</a>

                            <?php } elseif (isset($_SESSION['company_name'])) { ?>
                                <span class="user-badge-nav">
                                    <i class="fas fa-building"></i> <?php echo htmlspecialchars($_SESSION['company_name']); ?>
                                </span>
                                <a href="company/com_dashboard.php" class="btn-nav-primary">Portal</a>
                                <a href="logout.php" class="btn-nav-outline">Logout</a>

                            <?php } elseif (isset($_SESSION['name'])) { ?>
                                <span class="user-badge-nav">
                                    <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['name']); ?>
                                </span>
                                <a href="logout.php" class="btn-nav-outline">Logout</a>

                            <?php } else { ?>

                                <a href="login1.php" class="btn-nav-primary">Login</a>
                            <?php } ?>
                        </div>

                        <!-- Mobile Menu Button Container -->
                        <div class="col-12 p-0">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Main Content Area Starts -->
    <main class="main-wrapper">