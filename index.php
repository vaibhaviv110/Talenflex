<?php
include("db.php");
include("header.php");

// Fetch stats for live counter
$total_jobs_res = mysqli_query($conn, "SELECT COUNT(*) as count FROM comadd_job");
$total_jobs = mysqli_fetch_assoc($total_jobs_res)['count'] ?? 0;

$total_comps_res = mysqli_query($conn, "SELECT COUNT(*) as count FROM companyreg");
$total_comps = mysqli_fetch_assoc($total_comps_res)['count'] ?? 0;

$total_users_res = mysqli_query($conn, "SELECT COUNT(*) as count FROM registration WHERE u_type='user'");
$total_users = mysqli_fetch_assoc($total_users_res)['count'] ?? 0;

$total_placed_res = mysqli_query($conn, "SELECT COUNT(*) as count FROM application WHERE status LIKE '%Accepted%'");
$total_placed = mysqli_fetch_assoc($total_placed_res)['count'] ?? 0;
?>

<!-- Hero Section Start -->
<div class="hero-section-wrap" style="background: linear-gradient(135deg, #f8fafc 0%, #edf2f9 100%); padding: 70px 0 60px; border-bottom: 1px solid #e2e8f0;">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left Text Content -->
            <div class="col-lg-6 col-12 mb-lg-0 mb-40">
                <div class="hero-content-box">
                    <span class="badge mb-15" style="background: #eff6ff; color: var(--tf-primary); font-size: 14px; font-weight: 700; padding: 8px 18px; border-radius: 9999px; border: 1px solid #bfdbfe; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fas fa-graduation-cap"></i> Campus Placement & Job Portal
                    </span>
                    <h1 style="font-size: 46px; line-height: 1.2; font-weight: 800; color: var(--tf-navy); margin-bottom: 20px;">
                        Launch Your Career With <span style="color: var(--tf-primary);">Top Companies</span>
                    </h1>
                    <p style="font-size: 17px; color: var(--tf-text-muted); margin-bottom: 30px; line-height: 1.6;">
                        Connecting ambitious students and graduates with verified recruiters. Discover internships, entry-level positions, and high-impact full-time roles tailored for you.
                    </p>

                    <!-- Quick Search Box -->
                  
                    <div class="popular-tags mt-20" style="font-size: 13.5px; color: var(--tf-text-muted);">
                        <strong style="color: var(--tf-navy);">Trending Roles:</strong>
                        <a href="job.php?skill=Web" class="badge bg-white text-secondary border ms-1 p-2">Web Developer</a>
                        <a href="job.php?skill=UI/UX" class="badge bg-white text-secondary border ms-1 p-2">UI/UX Designer</a>
                        <a href="job.php?skill=Cyber" class="badge bg-white text-secondary border ms-1 p-2">Cyber Security</a>
                        <a href="job.php?skill=Data" class="badge bg-white text-secondary border ms-1 p-2">Data Science</a>
                    </div>
                </div>
            </div>

            <!-- Right Hero Image -->
            <div class="col-lg-6 col-12 text-center">
                <div class="hero-img-wrapper" style="position: relative; display: inline-block;">
                    <img src="h2.png" alt="TalentFlex Job Opportunities" class="img-fluid" style="max-height: 440px; filter: drop-shadow(0 15px 30px rgba(20,41,87,0.15));">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero Section End -->

<!-- Live Portal Stats Counter Start -->
<div class="stats-counter-strip" style="background: #ffffff; padding: 35px 0; border-bottom: 1px solid #e2e8f0;">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3 col-6">
                <div class="stat-counter-item">
                    <h3 style="font-size: 36px; font-weight: 800; color: var(--tf-primary); margin-bottom: 5px;">
                        <?php echo number_format($total_jobs); ?>+
                    </h3>
                    <p style="color: var(--tf-text-muted); font-weight: 600; margin: 0; font-size: 14px; text-transform: uppercase;">
                        Active Jobs Posted
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-counter-item">
                    <h3 style="font-size: 36px; font-weight: 800; color: var(--tf-accent); margin-bottom: 5px;">
                        <?php echo number_format($total_comps); ?>+
                    </h3>
                    <p style="color: var(--tf-text-muted); font-weight: 600; margin: 0; font-size: 14px; text-transform: uppercase;">
                        Partner Companies
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-counter-item">
                    <h3 style="font-size: 36px; font-weight: 800; color: #10b981; margin-bottom: 5px;">
                        <?php echo number_format($total_users); ?>+
                    </h3>
                    <p style="color: var(--tf-text-muted); font-weight: 600; margin: 0; font-size: 14px; text-transform: uppercase;">
                        Registered Students
                    </p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-counter-item">
                    <h3 style="font-size: 36px; font-weight: 800; color: var(--tf-navy); margin-bottom: 5px;">
                        <?php echo number_format($total_placed); ?>+
                    </h3>
                    <p style="color: var(--tf-text-muted); font-weight: 600; margin: 0; font-size: 14px; text-transform: uppercase;">
                        Offers & Shortlists
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Live Portal Stats Counter End -->

<!-- Job Categories Section Start -->
<section class="py-5" style="padding: 70px 0;">
    <div class="container">
        <div class="row justify-content-center text-center mb-50">
            <div class="col-lg-8">
                <span style="color: var(--tf-primary); font-weight: 700; text-transform: uppercase; font-size: 13.5px; letter-spacing: 1px;">
                    Explore Fields
                </span>
                <h2 style="font-size: 34px; font-weight: 800; color: var(--tf-navy); margin-top: 8px;">
                    Browse By Job Category
                </h2>
                <p style="color: var(--tf-text-muted); font-size: 16px;">
                    Find career opportunities in technical, creative, and engineering domains.
                </p>
            </div>
        </div>

        <div class="row g-4">
            <?php
            $categories = [
                ['title' => 'Web Developer', 'param' => 'Web', 'icon' => 'flaticon-cms', 'query' => "job_title LIKE '%Web%' OR job_title LIKE '%PHP%'"],
                ['title' => 'UI/UX Designer', 'param' => 'UI/UX', 'icon' => 'flaticon-tour', 'query' => "job_title LIKE '%UI/UX%'"],
                ['title' => 'Data Science', 'param' => 'Data', 'icon' => 'flaticon-app', 'query' => "job_title LIKE '%Data%'"],
                ['title' => 'Cyber Security', 'param' => 'Cyber', 'icon' => 'flaticon-report', 'query' => "job_title LIKE '%Cyber%'"],
                ['title' => 'Software Engineer', 'param' => 'Software Engineer', 'icon' => 'flaticon-real-estate', 'query' => "job_title LIKE '%Software Engineer%'"],
                ['title' => 'AI / LLM Engineer', 'param' => 'AI/LLM Engineer', 'icon' => 'flaticon-high-tech', 'query' => "job_title LIKE '%AI%' OR job_title LIKE '%LLM%'"],
                ['title' => 'Digital Marketing', 'param' => 'Digital Marketing', 'icon' => 'flaticon-content', 'query' => "job_title LIKE '%Marketing%'"],
                ['title' => 'Core Engineering', 'param' => 'Engineering', 'icon' => 'flaticon-helmet', 'query' => "job_title LIKE '%Engineering%' OR job_title LIKE '%Mechanical%'"]
            ];

            foreach ($categories as $cat) {
                $q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM comadd_job WHERE " . $cat['query']);
                $cnt = ($q) ? (mysqli_fetch_assoc($q)['total'] ?? 0) : 0;
            ?>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <a href="job.php?skill=<?php echo urlencode($cat['param']); ?>" class="text-decoration-none">
                        <div class="portal-card text-center h-100 p-4" style="transition: all 0.3s ease;">
                            <div class="category-icon mb-3" style="font-size: 34px; color: var(--tf-primary);">
                                <span class="<?php echo $cat['icon']; ?>"></span>
                            </div>
                            <h5 style="font-weight: 700; color: var(--tf-navy); margin-bottom: 8px;">
                                <?php echo htmlspecialchars($cat['title']); ?>
                            </h5>
                            <span class="badge" style="background: var(--tf-primary-light); color: var(--tf-primary); font-weight: 600; padding: 6px 14px; border-radius: 9999px;">
                                <?php echo $cnt; ?> Open Jobs
                            </span>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- Job Categories Section End -->

<!-- Latest Jobs Section Start -->
<section style="background: #ffffff; padding: 75px 0; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">
    <div class="container">
        <div class="row align-items-end mb-40">
            <div class="col-md-8 col-12">
                <span style="color: var(--tf-primary); font-weight: 700; text-transform: uppercase; font-size: 13.5px; letter-spacing: 1px;">
                    Recent Listings
                </span>
                <h2 style="font-size: 34px; font-weight: 800; color: var(--tf-navy); margin-top: 8px;">
                    Latest Job Openings
                </h2>
                <p style="color: var(--tf-text-muted); font-size: 16px; margin: 0;">
                    Apply to newly listed vacancies from top verified hiring partners.
                </p>
            </div>
            <div class="col-md-4 col-12 text-md-end mt-md-0 mt-3">
                <a href="s.php" class="btn-tf-outline">
                    View All Jobs <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <div class="job-cards-grid">
            <?php
            $latest_jobs_q = mysqli_query($conn, "SELECT * FROM comadd_job ORDER BY id DESC LIMIT 6");
            if ($latest_jobs_q && mysqli_num_rows($latest_jobs_q) > 0) {
                while ($job = mysqli_fetch_assoc($latest_jobs_q)) {
            ?>
                    <div class="job-card-modern">
                        <div>
                            <div class="company-badge">
                                <i class="fas fa-building text-primary"></i>
                                <?php echo htmlspecialchars($job['com_name'] ?? 'Company'); ?>
                            </div>
                            <h3 class="job-title">
                                <a href="job_details.php?id=<?php echo $job['id']; ?>">
                                    <?php echo htmlspecialchars($job['job_title']); ?>
                                </a>
                            </h3>
                            <div class="job-meta-pills">
                                <span class="pill-meta pill-type">
                                    <i class="fas fa-briefcase"></i> <?php echo htmlspecialchars($job['job_type']); ?>
                                </span>
                                <span class="pill-meta pill-loc">
                                    <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($job['location']); ?>
                                </span>
                                <?php if (!empty($job['salary'])) { ?>
                                    <span class="pill-meta pill-salary">
                                        <i class="fas fa-rupee-sign"></i> <?php echo number_format($job['salary']); ?> / mo
                                    </span>
                                <?php } ?>
                            </div>
                            <p style="font-size: 14px; color: var(--tf-text-muted); line-height: 1.5; margin-bottom: 20px;">
                                <?php echo htmlspecialchars(mb_strimwidth($job['description'], 0, 110, "...")); ?>
                            </p>
                        </div>
                        <div class="job-card-actions">
                            <a href="job_details.php?id=<?php echo $job['id']; ?>" class="btn-tf-outline" style="padding: 7px 16px; font-size: 13.5px;">
                                Details
                            </a>
                            <a href="apply.php?id=<?php echo $job['id']; ?>" class="btn-tf-primary" style="padding: 8px 20px; font-size: 13.5px;">
                                Apply Now
                            </a>
                        </div>
                    </div>
            <?php
                }
            } else {
            ?>
                <div class="col-12">
                    <div class="empty-state-card">
                        <div class="empty-state-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h4 class="empty-state-title">No Job Openings Available</h4>
                        <p class="empty-state-text">Check back soon as new recruiters post openings regularly.</p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- Latest Jobs Section End -->

<!-- How It Works Section Start -->
<section style="padding: 80px 0; background: #f8fafc;">
    <div class="container">
        <div class="row justify-content-center text-center mb-50">
            <div class="col-lg-8">
                <span style="color: var(--tf-primary); font-weight: 700; text-transform: uppercase; font-size: 13.5px; letter-spacing: 1px;">
                    Simple Process
                </span>
                <h2 style="font-size: 34px; font-weight: 800; color: var(--tf-navy); margin-top: 8px;">
                    How TalentFlex Works
                </h2>
                <p style="color: var(--tf-text-muted); font-size: 16px;">
                    Three easy steps to fast-track your employment journey.
                </p>
            </div>
        </div>

        <div class="row g-4 text-center">
            <div class="col-lg-4 col-md-6">
                <div class="portal-card p-4 h-100">
                    <div style="width: 70px; height: 70px; border-radius: 50%; background: #eff6ff; color: var(--tf-primary); display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 20px;">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h4 style="font-size: 20px; font-weight: 700; color: var(--tf-navy); margin-bottom: 12px;">
                        1. Register & Build Profile
                    </h4>
                    <p style="color: var(--tf-text-muted); font-size: 15px; margin: 0;">
                        Sign up as a candidate, showcase your degree, passing year, key technical skills, and upload your resume.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="portal-card p-4 h-100">
                    <div style="width: 70px; height: 70px; border-radius: 50%; background: #fdf2f8; color: var(--tf-accent); display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 20px;">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4 style="font-size: 20px; font-weight: 700; color: var(--tf-navy); margin-bottom: 12px;">
                        2. Search & Apply
                    </h4>
                    <p style="color: var(--tf-text-muted); font-size: 15px; margin: 0;">
                        Filter jobs by skills, location, or work preference. Apply instantly with your profile and attached resume.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="portal-card p-4 h-100">
                    <div style="width: 70px; height: 70px; border-radius: 50%; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 20px;">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4 style="font-size: 20px; font-weight: 700; color: var(--tf-navy); margin-bottom: 12px;">
                        3. Get Shortlisted & Hired
                    </h4>
                    <p style="color: var(--tf-text-muted); font-size: 15px; margin: 0;">
                        Companies review applications, schedule interviews, and issue offer letters directly through the portal.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- How It Works Section End -->

<!-- Why TalentFlex Feature Section Start -->
<section style="background: #ffffff; padding: 80px 0; border-top: 1px solid #e2e8f0;">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left Information Column -->
            <div class="col-lg-6 col-12 mb-lg-0 mb-40">
                <span style="color: var(--tf-primary); font-weight: 700; text-transform: uppercase; font-size: 13.5px; letter-spacing: 1px;">
                    Campus Advantage
                </span>
                <h2 style="font-size: 36px; font-weight: 800; color: var(--tf-navy); margin-top: 8px; margin-bottom: 20px;">
                    Why Students & Recruiters Rely on TalentFlex
                </h2>
                <p style="color: var(--tf-text-muted); font-size: 16px; margin-bottom: 30px;">
                    Designed specifically for college placements and enterprise campus recruitment drives, offering structured workflows from resume collection to final selection.
                </p>

                <div class="row g-4">
                    <div class="col-md-6 col-12">
                        <div class="d-flex align-items-start gap-3">
                            <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff6ff; color: var(--tf-primary); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <h5 style="font-size: 17px; font-weight: 700; color: var(--tf-navy); margin-bottom: 4px;">Verified Recruiters</h5>
                                <p style="font-size: 14px; color: var(--tf-text-muted); margin: 0;">Direct connections with verified HR representatives and companies.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="d-flex align-items-start gap-3">
                            <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff6ff; color: var(--tf-primary); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div>
                                <h5 style="font-size: 17px; font-weight: 700; color: var(--tf-navy); margin-bottom: 4px;">Centralized Resumes</h5>
                                <p style="font-size: 14px; color: var(--tf-text-muted); margin: 0;">Easily manage, upload, and update your CV in PDF/Doc format.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="d-flex align-items-start gap-3">
                            <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff6ff; color: var(--tf-primary); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div>
                                <h5 style="font-size: 17px; font-weight: 700; color: var(--tf-navy); margin-bottom: 4px;">Live Application Status</h5>
                                <p style="font-size: 14px; color: var(--tf-text-muted); margin: 0;">Track Pending, Accepted, or Interview notifications in real time.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="d-flex align-items-start gap-3">
                            <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff6ff; color: var(--tf-primary); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                <i class="fas fa-building"></i>
                            </div>
                            <div>
                                <h5 style="font-size: 17px; font-weight: 700; color: var(--tf-navy); margin-bottom: 4px;">Employer Dashboard</h5>
                                <p style="font-size: 14px; color: var(--tf-text-muted); margin: 0;">Robust candidate sorting, status updates, and hiring analytics.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-40">
                    <a href="s.php" class="btn-tf-primary me-3">
                        <i class="fas fa-briefcase"></i> Explore Jobs
                    </a>
                    <a href="company/com.php" class="btn-tf-outline">
                        <i class="fas fa-building"></i> Post A Vacancy
                    </a>
                </div>
            </div>

            <!-- Right Image Column -->
            <div class="col-lg-6 col-12 text-center">
                <div class="p-3" style="background: #f8fafc; border-radius: var(--tf-radius-lg); border: 1px solid #e2e8f0; display: inline-block;">
                    <img src="devlopers.png" alt="TalentFlex Developers" class="img-fluid" style="border-radius: var(--tf-radius); max-height: 420px; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Why TalentFlex Feature Section End -->

<!-- Testimonials Section Start -->
<section style="padding: 75px 0; background: #f8fafc; border-top: 1px solid #e2e8f0;">
    <div class="container">
        <div class="row justify-content-center text-center mb-50">
            <div class="col-lg-8">
                <span style="color: var(--tf-primary); font-weight: 700; text-transform: uppercase; font-size: 13.5px; letter-spacing: 1px;">
                    Success Stories
                </span>
                <h2 style="font-size: 34px; font-weight: 800; color: var(--tf-navy); margin-top: 8px;">
                    What Our Users Say
                </h2>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="portal-card p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--tf-primary-light); color: var(--tf-primary); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 18px; margin-right: 14px;">
                            B
                        </div>
                        <div>
                            <h5 style="margin: 0; font-size: 16px; font-weight: 700; color: var(--tf-navy);">Bhavy Patel</h5>
                            <span style="font-size: 13px; color: var(--tf-text-muted);">Placed at TCS</span>
                        </div>
                    </div>
                    <p style="color: var(--tf-text-body); font-size: 14.5px; line-height: 1.6; margin: 0;">
                        "TalentFlex made applying during campus drives completely seamless. I received my interview schedule through the portal notifications and secured an offer."
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="portal-card p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: #fdf2f8; color: var(--tf-accent); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 18px; margin-right: 14px;">
                            U
                        </div>
                        <div>
                            <h5 style="margin: 0; font-size: 16px; font-weight: 700; color: var(--tf-navy);">Urmi Usdad</h5>
                            <span style="font-size: 13px; color: var(--tf-text-muted);">BCA Graduate</span>
                        </div>
                    </div>
                    <p style="color: var(--tf-text-body); font-size: 14.5px; line-height: 1.6; margin: 0;">
                        "The ability to filter jobs specifically by skills and cities in Gujarat helped me discover internship openings matched precisely to my profile."
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="portal-card p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 18px; margin-right: 14px;">
                            Q
                        </div>
                        <div>
                            <h5 style="margin: 0; font-size: 16px; font-weight: 700; color: var(--tf-navy);">Qutonz Recruitment Lead</h5>
                            <span style="font-size: 13px; color: var(--tf-text-muted);">Hiring Partner</span>
                        </div>
                    </div>
                    <p style="color: var(--tf-text-body); font-size: 14.5px; line-height: 1.6; margin: 0;">
                        "Posting job vacancies and reviewing applications with candidate resumes directly in the company dashboard saved our recruitment team days of effort."
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Testimonials Section End -->

<!-- Call to Action Banner Start -->
<div style="background: linear-gradient(135deg, var(--tf-navy) 0%, var(--tf-navy-dark) 100%); color: #ffffff; padding: 60px 0; text-align: center;">
    <div class="container">
        <h2 style="color: #ffffff; font-size: 34px; font-weight: 800; margin-bottom: 14px;">
            Ready to Take the Next Step in Your Career?
        </h2>
        <p style="color: #94a3b8; font-size: 16px; max-width: 600px; margin: 0 auto 28px;">
            Join hundreds of students and employers already using TalentFlex for campus recruitment.
        </p>
        <div class="d-flex justify-content-center flex-wrap gap-3">
            <a href="r.php" class="btn-tf-accent">
                <i class="fas fa-user-graduate"></i> Register as Candidate
            </a>
            <a href="company/com.php" class="btn-tf-primary" style="background: #ffffff; color: var(--tf-navy) !important;">
                <i class="fas fa-building"></i> Register as Company
            </a>
        </div>
    </div>
</div>
<!-- Call to Action Banner End -->


<?php include("footer.php"); ?>