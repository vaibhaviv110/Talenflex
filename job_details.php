<?php
include("db.php");
include("header.php");

$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($job_id > 0) {
    $job_res = mysqli_query($conn, "SELECT * FROM comadd_job WHERE id='$job_id'");
    $job = ($job_res) ? mysqli_fetch_assoc($job_res) : null;
} else {
    $job = null;
}

// Fallback to latest job if id is missing or invalid
if (!$job) {
    $fallback_res = mysqli_query($conn, "SELECT * FROM comadd_job ORDER BY id DESC LIMIT 1");
    $job = ($fallback_res) ? mysqli_fetch_assoc($fallback_res) : null;
    $job_id = $job['id'] ?? 0;
}

// Query company details if available
$com_name = $job['com_name'] ?? '';
$comp_info = null;
if (!empty($com_name)) {
    $com_safe = mysqli_real_escape_string($conn, $com_name);
    $comp_res = mysqli_query($conn, "SELECT * FROM companyreg WHERE name='$com_safe' LIMIT 1");
    if ($comp_res && mysqli_num_rows($comp_res) > 0) {
        $comp_info = mysqli_fetch_assoc($comp_res);
    }
}
?>

<?php if ($job) { ?>
    <!-- Job Header Banner -->
    <div style="background: linear-gradient(135deg, #f8fafc 0%, #edf2f9 100%); padding: 50px 0 45px; border-bottom: 1px solid #e2e8f0;">
        <div class="container">
            <div class="d-flex flex-md-row flex-column align-items-md-center justify-content-between gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge" style="background: var(--tf-primary-light); color: var(--tf-primary); font-size: 13px; font-weight: 700; padding: 6px 14px; border-radius: 9999px;">
                            <i class="fas fa-building me-1"></i> <?php echo htmlspecialchars($job['com_name']); ?>
                        </span>
                        <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 13px;">
                            <i class="fas fa-briefcase me-1 text-muted"></i> <?php echo htmlspecialchars($job['job_type']); ?>
                        </span>
                    </div>
                    <h1 style="font-size: 36px; font-weight: 800; color: var(--tf-navy); margin: 0 0 10px;">
                        <?php echo htmlspecialchars($job['job_title']); ?>
                    </h1>
                    <div class="d-flex flex-wrap align-items-center gap-3 text-muted" style="font-size: 15px;">
                        <span><i class="fas fa-map-marker-alt text-danger me-1"></i> <?php echo htmlspecialchars($job['location']); ?></span>
                        <?php if (!empty($job['salary'])) { ?>
                            <span><i class="fas fa-rupee-sign text-success me-1"></i> ₹<?php echo number_format($job['salary']); ?> / month</span>
                        <?php } ?>
                        <span><i class="far fa-clock text-primary me-1"></i> Recently Posted</span>
                    </div>
                </div>

                <div>
                    <a href="apply.php?id=<?php echo $job['id']; ?>" class="btn-tf-primary" style="padding: 14px 34px; font-size: 16px;">
                        <i class="fas fa-paper-plane me-1"></i> Apply For This Job
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="container my-5">
        <div class="row g-4">
            <!-- Left 8 Columns: Detailed Description -->
            <div class="col-lg-8 col-12">
                <!-- Description Card -->
                <div class="portal-card mb-4">
                    <h3 style="font-size: 22px; font-weight: 700; color: var(--tf-navy); margin-bottom: 18px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">
                        <i class="fas fa-align-left text-primary me-2"></i> Role Overview & Description
                    </h3>
                    <div style="color: var(--tf-text-body); font-size: 15.5px; line-height: 1.8;">
                        <?php echo nl2br(htmlspecialchars($job['description'])); ?>
                    </div>
                </div>

                <!-- Responsibilities Card -->
                <div class="portal-card mb-4">
                    <h3 style="font-size: 22px; font-weight: 700; color: var(--tf-navy); margin-bottom: 18px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">
                        <i class="fas fa-check-circle text-success me-2"></i> Key Responsibilities
                    </h3>
                    <ul style="list-style: none; padding: 0; margin: 0; color: var(--tf-text-body); font-size: 15px; line-height: 1.8;">
                        <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Collaborate with cross-functional technical and product teams to deliver high quality solutions.</li>
                        <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Implement scalable code, conduct debugging, and maintain engineering standards.</li>
                        <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Learn and adopt industry best practices, new frameworks, and architectural patterns.</li>
                        <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> Participate in code reviews, daily stand-ups, and sprint planning sessions.</li>
                    </ul>
                </div>

                <!-- Qualifications & Skills Card -->
                <div class="portal-card mb-4">
                    <h3 style="font-size: 22px; font-weight: 700; color: var(--tf-navy); margin-bottom: 18px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">
                        <i class="fas fa-graduation-cap text-primary me-2"></i> Eligibility & Requirements
                    </h3>
                    <ul style="list-style: none; padding: 0; margin: 0; color: var(--tf-text-body); font-size: 15px; line-height: 1.8;">
                        <li class="mb-2"><i class="fas fa-arrow-right text-primary me-2"></i> Bachelor's or Master's degree in Computer Science, IT, BCA, MCA, Engineering, or relevant disciplines.</li>
                        <li class="mb-2"><i class="fas fa-arrow-right text-primary me-2"></i> Solid foundation in required core tools, languages, and frameworks.</li>
                        <li class="mb-2"><i class="fas fa-arrow-right text-primary me-2"></i> Good problem-solving abilities and communication skills.</li>
                        <li class="mb-2"><i class="fas fa-arrow-right text-primary me-2"></i> Freshers with strong project portfolios and experienced professionals are welcome to apply.</li>
                    </ul>
                </div>
            </div>

            <!-- Right 4 Columns: Job Overview & Company Info -->
            <div class="col-lg-4 col-12">
                <!-- Overview Card -->
                <div class="portal-card mb-4">
                    <h4 style="font-size: 18px; font-weight: 700; color: var(--tf-navy); margin-bottom: 18px; padding-bottom: 10px; border-bottom: 1.5px solid #f1f5f9;">
                        Job Summary
                    </h4>

                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 40px; height: 40px; border-radius: 8px; background: #eff6ff; color: var(--tf-primary); display: flex; align-items: center; justify-content: center; margin-right: 14px; font-size: 16px;">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Job Nature</small>
                            <strong style="color: var(--tf-navy);"><?php echo htmlspecialchars($job['job_type']); ?></strong>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 40px; height: 40px; border-radius: 8px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; margin-right: 14px; font-size: 16px;">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Offered Salary</small>
                            <strong style="color: var(--tf-navy);">₹<?php echo number_format($job['salary']); ?> / month</strong>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div style="width: 40px; height: 40px; border-radius: 8px; background: #fef2f2; color: #ef4444; display: flex; align-items: center; justify-content: center; margin-right: 14px; font-size: 16px;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Location</small>
                            <strong style="color: var(--tf-navy);"><?php echo htmlspecialchars($job['location']); ?></strong>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <div style="width: 40px; height: 40px; border-radius: 8px; background: #f5f3ff; color: #8b5cf6; display: flex; align-items: center; justify-content: center; margin-right: 14px; font-size: 16px;">
                            <i class="fas fa-hashtag"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Job Reference ID</small>
                            <strong style="color: var(--tf-navy);">TF-JOB-<?php echo str_pad($job['id'], 4, '0', STR_PAD_LEFT); ?></strong>
                        </div>
                    </div>

                    <a href="apply.php?id=<?php echo $job['id']; ?>" class="btn-tf-primary w-100 mb-2">
                        Apply Now
                    </a>
                    <a href="s.php" class="btn-tf-outline w-100">
                        Back to Search
                    </a>
                </div>

                <!-- Company Info Card -->
                <div class="portal-card">
                    <h4 style="font-size: 18px; font-weight: 700; color: var(--tf-navy); margin-bottom: 16px; padding-bottom: 10px; border-bottom: 1.5px solid #f1f5f9;">
                        Company Overview
                    </h4>
                    <h5 style="font-weight: 700; color: var(--tf-navy); margin-bottom: 6px;">
                        <?php echo htmlspecialchars($job['com_name']); ?>
                    </h5>
                    <?php if ($comp_info) { ?>
                        <p style="font-size: 14px; color: var(--tf-text-muted); margin-bottom: 12px;">
                            <i class="fas fa-industry text-primary me-1"></i> Industry: <?php echo htmlspecialchars($comp_info['industry'] ?: 'Information Technology'); ?>
                        </p>
                        <p style="font-size: 14px; color: var(--tf-text-muted); margin-bottom: 12px;">
                            <i class="fas fa-map-pin text-primary me-1"></i> Head Office: <?php echo htmlspecialchars($comp_info['address'] ?: $job['location']); ?>
                        </p>
                        <p style="font-size: 14px; color: var(--tf-text-muted); margin-bottom: 18px;">
                            <i class="fas fa-envelope text-primary me-1"></i> Contact: <?php echo htmlspecialchars($comp_info['email']); ?>
                        </p>
                    <?php } else { ?>
                        <p style="font-size: 14px; color: var(--tf-text-muted); margin-bottom: 18px;">
                            Verified hiring partner registered on the TalentFlex Campus Network.
                        </p>
                    <?php } ?>
                    <a href="contact.php" class="btn btn-sm btn-light border w-100 text-muted">
                        <i class="fas fa-question-circle me-1"></i> Inquire About Role
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php } else { ?>
    <div class="container my-5">
        <div class="empty-state-card">
            <div class="empty-state-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="empty-state-title">Job Not Found</h3>
            <p class="empty-state-text">The requested job posting may have expired or been removed by the employer.</p>
            <a href="s.php" class="btn-tf-primary">Browse Active Jobs</a>
        </div>
    </div>
<?php } ?>

<?php include("footer.php"); ?>