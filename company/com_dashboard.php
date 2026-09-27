<?php
session_start();
include('db.php');

if (!isset($_SESSION['company_name'])) {
    header("Location: com_login.php");
    exit();
}

$company = $_SESSION['company_name'];
$company_safe = mysqli_real_escape_string($conn, $company);

// 1. Total Jobs
$job_q = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM comadd_job WHERE com_name='$company_safe'");
$total_jobs = ($job_q) ? mysqli_fetch_assoc($job_q)['cnt'] : 0;

// 2. Total Applications
$app_q = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM application a JOIN comadd_job j ON a.job_id=j.id WHERE j.com_name='$company_safe'");
$total_application = ($app_q) ? mysqli_fetch_assoc($app_q)['cnt'] : 0;

// 3. Total Messages / Inquiries
$msg_q = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM contact_messages WHERE company_name='$company_safe'");
$total_messages = ($msg_q) ? mysqli_fetch_assoc($msg_q)['cnt'] : 0;

// 4. Job Views
$view_q = mysqli_query($conn, "SELECT SUM(views) AS total FROM comadd_job WHERE com_name='$company_safe'");
$total_views = ($view_q) ? (mysqli_fetch_assoc($view_q)['total'] ?? 0) : 0;
if (empty($total_views)) { $total_views = 0; }

// Fetch recent 5 applications
$recent_apps_sql = "SELECT a.*, j.job_title 
                    FROM application a
                    JOIN comadd_job j ON a.job_id=j.id
                    WHERE j.com_name='$company_safe'
                    ORDER BY a.id DESC LIMIT 5";
$recent_apps = mysqli_query($conn, $recent_apps_sql);

// Fetch recent 5 jobs
$recent_jobs_sql = "SELECT * FROM comadd_job WHERE com_name='$company_safe' ORDER BY id DESC LIMIT 5";
$recent_jobs = mysqli_query($conn, $recent_jobs_sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard | TalentFlex</title>
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico">

    <!-- Bootstrap 5 & Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/portal-custom.css">
</head>

<body style="background: #f1f5f9; display: flex; flex-direction: column; min-height: 100vh;">

    <!-- Sidebar Inclusion -->
    <?php include('sidebar.php'); ?>

    <!-- Main Dashboard Content -->
    <div class="portal-dashboard-main">
        <!-- Top Bar -->
        <div class="dashboard-topbar">
            <div>
                <h2 style="font-size: 24px; font-weight: 800; color: var(--tf-navy); margin-bottom: 4px;">
                    Welcome back, <?php echo htmlspecialchars($company); ?>!
                </h2>
                <p style="color: var(--tf-text-muted); font-size: 14.5px; margin: 0;">
                    Manage your active job postings, review applicant profiles, and schedule interviews.
                </p>
            </div>
            <div>
                <a href="comadd_job.php" class="btn-tf-primary" style="padding: 10px 22px; font-size: 14px;">
                    <i class="fas fa-plus-circle me-1"></i> Post New Vacancy
                </a>
            </div>
        </div>

        <!-- Metric Stat Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6 col-12">
                <div class="stat-card-modern">
                    <div class="stat-card-info">
                        <h3><?php echo number_format($total_jobs); ?></h3>
                        <p>Total Jobs Posted</p>
                    </div>
                    <div class="stat-card-icon icon-blue">
                        <i class="fas fa-briefcase"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 col-12">
                <div class="stat-card-modern">
                    <div class="stat-card-info">
                        <h3><?php echo number_format($total_application); ?></h3>
                        <p>Total Applications</p>
                    </div>
                    <div class="stat-card-icon icon-green">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 col-12">
                <div class="stat-card-modern">
                    <div class="stat-card-info">
                        <h3><?php echo number_format($total_messages); ?></h3>
                        <p>Candidate Inquiries</p>
                    </div>
                    <div class="stat-card-icon icon-purple">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 col-12">
                <div class="stat-card-modern">
                    <div class="stat-card-info">
                        <h3><?php echo number_format($total_views); ?></h3>
                        <p>Job Impressions</p>
                    </div>
                    <div class="stat-card-icon icon-pink">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Applications Table -->
        <div class="portal-card mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <h4 style="font-size: 18px; font-weight: 700; color: var(--tf-navy); margin: 0;">
                    <i class="fas fa-user-clock text-primary me-2"></i> Recent Candidate Applications
                </h4>
                <a href="comapplication.php" class="btn btn-sm btn-outline-primary">
                    View All Applications <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>

            <?php if ($recent_apps && mysqli_num_rows($recent_apps) > 0) { ?>
                <div class="table-responsive">
                    <table class="table-portal">
                        <thead>
                            <tr>
                                <th>Candidate Name</th>
                                <th>Position</th>
                                <th>Education</th>
                                <th>Experience</th>
                                <th>Applied Date</th>
                                <th>Review Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($app = mysqli_fetch_assoc($recent_apps)) { ?>
                                <tr>
                                    <td>
                                        <strong style="color: var(--tf-navy);">
                                            <?php echo htmlspecialchars($app['user_name'] ?: 'Applicant #' . $app['user_id']); ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <?php echo htmlspecialchars($app['job_title']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($app['education'] ?: 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($app['experience'] ?: 'Fresher'); ?></td>
                                    <td><?php echo htmlspecialchars($app['apply_date']); ?></td>
                                    <td>
                                        <?php if (stripos($app['status'], 'Accepted') !== false) { ?>
                                            <span class="badge-status badge-status-accepted">Shortlisted</span>
                                        <?php } elseif (stripos($app['status'], 'Rejected') !== false) { ?>
                                            <span class="badge-status badge-status-rejected">Rejected</span>
                                        <?php } else { ?>
                                            <span class="badge-status badge-status-pending">Pending</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-end">
                                        <a href="comapplication.php" class="btn btn-sm btn-light border">
                                            Review
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-inbox fa-2x mb-2 text-muted"></i>
                    <p class="mb-0">No candidate applications received yet.</p>
                </div>
            <?php } ?>
        </div>

        <!-- Recent Jobs Table -->
        <div class="portal-card">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <h4 style="font-size: 18px; font-weight: 700; color: var(--tf-navy); margin: 0;">
                    <i class="fas fa-list-ul text-primary me-2"></i> Active Job Postings
                </h4>
                <a href="commy_job.php" class="btn btn-sm btn-outline-primary">
                    Manage All Jobs <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>

            <?php if ($recent_jobs && mysqli_num_rows($recent_jobs) > 0) { ?>
                <div class="table-responsive">
                    <table class="table-portal">
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Nature</th>
                                <th>Location</th>
                                <th>Offered Salary</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($jb = mysqli_fetch_assoc($recent_jobs)) { ?>
                                <tr>
                                    <td>
                                        <strong style="color: var(--tf-navy);">
                                            <?php echo htmlspecialchars($jb['job_title']); ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <span class="pill-meta pill-type"><?php echo htmlspecialchars($jb['job_type']); ?></span>
                                    </td>
                                    <td><?php echo htmlspecialchars($jb['location']); ?></td>
                                    <td>₹<?php echo number_format($jb['salary']); ?>/mo</td>
                                    <td class="text-end">
                                        <a href="view.php?id=<?php echo $jb['id']; ?>" class="btn btn-sm btn-info text-white">View</a>
                                        <a href="edit.php?id=<?php echo $jb['id']; ?>" class="btn btn-sm btn-warning text-dark">Edit</a>
                                        <a href="delete.php?id=<?php echo $jb['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this job?')">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="text-center py-4 text-muted">
                    <p class="mb-3">You haven't posted any jobs yet.</p>
                    <a href="comadd_job.php" class="btn-tf-primary">
                        <i class="fas fa-plus-circle me-1"></i> Post Your First Job
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>