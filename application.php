<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login1.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Join comadd_job to get job_title if available
$sql = "SELECT a.*, j.job_title 
        FROM application a
        LEFT JOIN comadd_job j ON a.job_id = j.id
        WHERE a.user_id = '$user_id'
        ORDER BY a.id DESC";

$result = mysqli_query($conn, $sql);
$total_applications = ($result) ? mysqli_num_rows($result) : 0;

include("header.php");
?>

<!-- Banner Section -->
<div style="background: linear-gradient(135deg, #f8fafc 0%, #edf2f9 100%); padding: 50px 0 45px; border-bottom: 1px solid #e2e8f0;">
    <div class="container">
        <div class="d-flex flex-md-row flex-column justify-content-between align-items-md-center gap-3">
            <div>
                <span class="badge mb-2" style="background: var(--tf-primary-light); color: var(--tf-primary); font-size: 13px; font-weight: 700; padding: 6px 14px; border-radius: 9999px;">
                    Candidate Portal
                </span>
                <h1 style="font-size: 34px; font-weight: 800; color: var(--tf-navy); margin-bottom: 8px;">
                    My Applications
                </h1>
                <p style="color: var(--tf-text-muted); font-size: 15.5px; margin: 0;">
                    Track real-time application updates, recruiter reviews, and scheduled interviews.
                </p>
            </div>
            <div>
                <a href="s.php" class="btn-tf-primary">
                    <i class="fas fa-search me-1"></i> Browse More Jobs
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <?php if ($total_applications > 0) { ?>
        <div class="table-portal-card">
            <div class="table-responsive">
                <table class="table-portal">
                    <thead>
                        <tr>
                            <th>Company & Job Title</th>
                            <th>Education & Exp</th>
                            <th>Skills Provided</th>
                            <th>Applied Date</th>
                            <th>Status & Interview Info</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td>
                                    <strong style="color: var(--tf-navy); font-size: 15px;">
                                        <?php echo htmlspecialchars($row['job_title'] ?: 'Job Position'); ?>
                                    </strong>
                                    <div class="text-muted" style="font-size: 13.5px;">
                                        <i class="fas fa-building text-primary me-1"></i>
                                        <?php echo htmlspecialchars($row['company_name']); ?>
                                    </div>
                                </td>
                                <td>
                                    <div><strong><?php echo htmlspecialchars($row['education'] ?: 'N/A'); ?></strong></div>
                                    <small class="text-muted"><?php echo htmlspecialchars($row['experience'] ?: 'Fresher'); ?></small>
                                </td>
                                <td>
                                    <span class="text-muted" style="font-size: 13.5px;">
                                        <?php echo htmlspecialchars(mb_strimwidth($row['skills'], 0, 40, "...")); ?>
                                    </span>
                                </td>
                                <td>
                                    <span style="font-size: 14px; color: var(--tf-text-body);">
                                        <i class="far fa-calendar-alt text-muted me-1"></i>
                                        <?php echo htmlspecialchars($row['apply_date']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $status_value = $row['status'];
                                    if (stripos($status_value, 'Accepted') !== false) {
                                    ?>
                                        <div class="p-2 rounded" style="background: #ecfdf5; border: 1px solid #a7f3d0;">
                                            <span class="badge-status badge-status-accepted mb-1">
                                                <i class="fas fa-check-circle"></i> Shortlisted
                                            </span>
                                            <div style="font-size: 12.5px; color: #065f46; line-height: 1.4;">
                                                <?php echo htmlspecialchars($status_value); ?>
                                            </div>
                                        </div>
                                    <?php } elseif (stripos($status_value, 'Rejected') !== false) { ?>
                                        <span class="badge-status badge-status-rejected">
                                            <i class="fas fa-times-circle"></i> Not Selected
                                        </span>
                                    <?php } else { ?>
                                        <span class="badge-status badge-status-pending">
                                            <i class="fas fa-clock"></i> In Review
                                        </span>
                                    <?php } ?>
                                </td>
                                <td class="text-end">
                                    <?php if (!empty($row['job_id'])) { ?>
                                        <a href="job_details.php?id=<?php echo $row['job_id']; ?>" class="btn-tf-outline" style="padding: 6px 14px; font-size: 13px;">
                                            View Job
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } else { ?>
        <div class="empty-state-card">
            <div class="empty-state-icon">
                <i class="fas fa-file-invoice"></i>
            </div>
            <h3 class="empty-state-title">No Applications Submitted Yet</h3>
            <p class="empty-state-text">
                You haven't applied to any job positions yet. Start exploring active campus listings and submit your first application.
            </p>
            <a href="s.php" class="btn-tf-primary">
                <i class="fas fa-search me-1"></i> Explore Available Jobs
            </a>
        </div>
    <?php } ?>
</div>

<?php include("footer.php"); ?>