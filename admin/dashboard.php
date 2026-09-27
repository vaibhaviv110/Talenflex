<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: ../login1.php");
    exit();
}

// 1. Total Jobs Count
$job_query = mysqli_query($conn, "SELECT COUNT(*) as total_jobs FROM comadd_job");
$total_jobs = ($job_query) ? mysqli_fetch_assoc($job_query)['total_jobs'] : 0;

// 2. Total Users Count
$user_query = mysqli_query($conn, "SELECT COUNT(*) as total_users FROM registration WHERE u_type='user'");
$total_users = ($user_query) ? mysqli_fetch_assoc($user_query)['total_users'] : 0;

// 3. Total Applications Count
$app_query = mysqli_query($conn, "SELECT COUNT(*) as total_apps FROM application");
$total_apps = ($app_query) ? mysqli_fetch_assoc($app_query)['total_apps'] : 0;

// 4. Total Companies Count
$comp_query = mysqli_query($conn, "SELECT COUNT(*) as total_comps FROM companyreg");
$total_comps = ($comp_query) ? mysqli_fetch_assoc($comp_query)['total_comps'] : 0;

// Fetch recent 5 applications
$recent_apps = mysqli_query($conn, "SELECT a.*, r.Name as applicant_name FROM application a LEFT JOIN registration r ON a.user_id = r.id ORDER BY a.id DESC LIMIT 5");

// Fetch recent 5 companies
$recent_comps = mysqli_query($conn, "SELECT * FROM companyreg ORDER BY cid DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | TalentFlex Central Suite</title>
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico">

    <!-- Bootstrap 5 & Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/portal-custom.css">
</head>

<body class="admin-body" style="display: flex; flex-direction: column; min-height: 100vh;">

    <!-- Sidebar Inclusion inside Body -->
    <?php include('sidebar.php'); ?>

    <div class="portal-dashboard-main">
        <!-- Dashboard Glassmorphic Topbar -->
        <div class="dashboard-topbar-glass d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h2 style="font-size: 24px; font-weight: 800; margin-bottom: 4px;">
                    Portal Administration Suite
                </h2>
                <p style="color: var(--tf-text-muted); font-size: 14px; margin: 0;">
                    Supervise platform metrics, monitor recruiters, student placements, and job vacancies.
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="admin_viewjob.php" class="btn-tf-outline btn-sm">
                    <i class="fas fa-briefcase"></i> Manage Jobs
                </a>
                <a href="admin_application.php" class="btn-tf-accent btn-sm">
                    <i class="fas fa-file-invoice"></i> Applications
                </a>
            </div>
        </div>

        <!-- 4 Metric Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6 col-12">
                <div class="stat-card-modern">
                    <div class="stat-card-info">
                        <h3><?php echo number_format($total_jobs); ?></h3>
                        <p>Total Job Postings</p>
                    </div>
                    <div class="stat-card-icon icon-blue">
                        <i class="fas fa-briefcase"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 col-12">
                <div class="stat-card-modern">
                    <div class="stat-card-info">
                        <h3><?php echo number_format($total_users); ?></h3>
                        <p>Registered Students</p>
                    </div>
                    <div class="stat-card-icon icon-green">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 col-12">
                <div class="stat-card-modern">
                    <div class="stat-card-info">
                        <h3><?php echo number_format($total_apps); ?></h3>
                        <p>Total Applications</p>
                    </div>
                    <div class="stat-card-icon icon-purple">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 col-12">
                <div class="stat-card-modern">
                    <div class="stat-card-info">
                        <h3><?php echo number_format($total_comps); ?></h3>
                        <p>Registered Companies</p>
                    </div>
                    <div class="stat-card-icon icon-pink">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Action Shortcuts -->
        <div class="portal-card-glass mb-4 p-4">
            <h5 style="font-weight: 700; color: var(--tf-navy); margin-bottom: 16px;" class="d-flex align-items-center gap-2">
                <i class="fas fa-bolt text-warning fs-5"></i> Quick Administrative Shortcuts
            </h5>
            <div class="d-flex flex-wrap gap-2">
                <a href="admin_viewjob.php" class="btn-tf-primary btn-sm">
                    <i class="fas fa-briefcase"></i> View Jobs (<?php echo $total_jobs; ?>)
                </a>
                <a href="admin_viewcompany.php" class="btn-tf-outline btn-sm">
                    <i class="fas fa-building"></i> View Companies (<?php echo $total_comps; ?>)
                </a>
                <a href="admin_application.php" class="btn-tf-accent btn-sm">
                    <i class="fas fa-file-alt"></i> View Applications (<?php echo $total_apps; ?>)
                </a>
                <a href="reg.php" class="btn-tf-secondary btn-sm">
                    <i class="fas fa-users"></i> View Candidates (<?php echo $total_users; ?>)
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Recent Applications Left -->
            <div class="col-lg-7 col-12">
                <div class="portal-card-glass h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h5 style="font-weight: 700; color: var(--tf-navy); margin: 0;">
                            <i class="fas fa-clock text-primary me-2"></i> Recent Applications
                        </h5>
                        <a href="admin_application.php" class="text-primary text-decoration-none fw-semibold style-link">
                            View All <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>

                    <?php if ($recent_apps && mysqli_num_rows($recent_apps) > 0) { ?>
                        <div class="table-responsive">
                            <table class="table-portal">
                                <thead>
                                    <tr>
                                        <th>Applicant</th>
                                        <th>Company</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($a = mysqli_fetch_assoc($recent_apps)) { ?>
                                        <tr>
                                            <td>
                                                <strong style="color: var(--tf-navy);">
                                                    <?php echo htmlspecialchars($a['applicant_name'] ?: ($a['user_name'] ?: 'Applicant #' . $a['user_id'])); ?>
                                                </strong>
                                            </td>
                                            <td><?php echo htmlspecialchars($a['company_name']); ?></td>
                                            <td>
                                                <?php if (stripos($a['status'], 'Accepted') !== false) { ?>
                                                    <span class="badge-status badge-status-accepted">Shortlisted</span>
                                                <?php } elseif (stripos($a['status'], 'Rejected') !== false) { ?>
                                                    <span class="badge-status badge-status-rejected">Rejected</span>
                                                <?php } else { ?>
                                                    <span class="badge-status badge-status-pending">Pending</span>
                                                <?php } ?>
                                            </td>
                                            <td><small class="text-muted"><?php echo htmlspecialchars($a['apply_date']); ?></small></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <p class="text-muted text-center py-4">No applications submitted yet.</p>
                    <?php } ?>
                </div>
            </div>

            <!-- Recent Companies Right -->
            <div class="col-lg-5 col-12">
                <div class="portal-card-glass h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h5 style="font-weight: 700; color: var(--tf-navy); margin: 0;">
                            <i class="fas fa-building text-primary me-2"></i> Registered Companies
                        </h5>
                        <a href="admin_viewcompany.php" class="text-primary text-decoration-none fw-semibold style-link">
                            View All <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>

                    <?php if ($recent_comps && mysqli_num_rows($recent_comps) > 0) { ?>
                        <div class="table-responsive">
                            <table class="table-portal">
                                <thead>
                                    <tr>
                                        <th>Company</th>
                                        <th>Location</th>
                                        <th>Industry</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($c = mysqli_fetch_assoc($recent_comps)) { ?>
                                        <tr>
                                            <td>
                                                <strong style="color: var(--tf-navy);">
                                                    <?php echo htmlspecialchars($c['name']); ?>
                                                </strong>
                                                <div class="text-muted" style="font-size: 12px;"><?php echo htmlspecialchars($c['email']); ?></div>
                                            </td>
                                            <td><small class="text-muted"><?php echo htmlspecialchars($c['address'] ?: 'N/A'); ?></small></td>
                                            <td>
                                                <span class="badge bg-light text-dark border" style="font-size: 11px;">
                                                    <?php echo htmlspecialchars($c['industry'] ?: 'IT'); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <p class="text-muted text-center py-4">No companies registered yet.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>