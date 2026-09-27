<?php
session_start();
include("db.php");

if (!isset($_SESSION['company_name'])) {
    header("Location: com_login.php");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$company = $_SESSION['company_name'];
$company_safe = mysqli_real_escape_string($conn, $company);

$sql = "SELECT * FROM comadd_job WHERE id='$id' AND com_name='$company_safe'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    header("Location: commy_job.php");
    exit();
}

$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job #<?php echo $id; ?> | TalentFlex Employer</title>
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico">

    <!-- Bootstrap 5 & Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/portal-custom.css">
</head>

<body style="background: #f1f5f9; display: flex; flex-direction: column; min-height: 100vh;">

    <!-- Sidebar Inclusion inside Body -->
    <?php include('sidebar.php'); ?>

    <div class="portal-dashboard-main">
        <div class="dashboard-topbar">
            <div>
                <h2 style="font-size: 22px; font-weight: 800; color: var(--tf-navy); margin-bottom: 4px;">
                    Job Posting Details
                </h2>
                <p style="color: var(--tf-text-muted); font-size: 14px; margin: 0;">
                    Reference #TF-JOB-<?php echo str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?>
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit me-1"></i> Edit This Job
                </a>
                <a href="commy_job.php" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to Jobs
                </a>
            </div>
        </div>

        <div class="portal-card mx-auto" style="max-width: 800px;">
            <div class="d-flex justify-content-between align-items-start mb-4 pb-3 border-bottom">
                <div>
                    <span class="badge mb-2" style="background: var(--tf-primary-light); color: var(--tf-primary); font-size: 13px; font-weight: 700; padding: 6px 14px; border-radius: 9999px;">
                        <?php echo htmlspecialchars($row['com_name']); ?>
                    </span>
                    <h3 style="font-size: 26px; font-weight: 800; color: var(--tf-navy); margin-bottom: 6px;">
                        <?php echo htmlspecialchars($row['job_title']); ?>
                    </h3>
                    <div class="d-flex gap-3 text-muted" style="font-size: 14px;">
                        <span><i class="fas fa-map-marker-alt text-danger me-1"></i> <?php echo htmlspecialchars($row['location']); ?></span>
                        <span><i class="fas fa-briefcase text-primary me-1"></i> <?php echo htmlspecialchars($row['job_type']); ?></span>
                        <span><i class="fas fa-rupee-sign text-success me-1"></i> ₹<?php echo number_format($row['salary']); ?> / month</span>
                    </div>
                </div>
            </div>

            <h5 style="font-weight: 700; color: var(--tf-navy); margin-bottom: 12px;">Job Description & Requirements:</h5>
            <div class="p-3 mb-4 rounded bg-light border" style="font-size: 15px; line-height: 1.8; color: var(--tf-text-body);">
                <?php echo nl2br(htmlspecialchars($row['description'])); ?>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <a href="commy_job.php" class="btn btn-light border">
                    <i class="fas fa-list me-1"></i> Return to List
                </a>
                <div class="d-flex gap-2">
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-tf-primary" style="padding: 9px 22px; font-size: 14px;">
                        <i class="fas fa-edit me-1"></i> Edit Details
                    </a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Delete this job listing?')">
                        <i class="fas fa-trash-alt me-1"></i> Delete
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>