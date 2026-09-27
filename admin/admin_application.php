<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: ../login1.php");
    exit();
}

$sql = "SELECT a.*, r.Name AS applicant_name, r.Email AS applicant_email, r.PhoneNumber AS applicant_phone, j.job_title
        FROM application a
        LEFT JOIN registration r ON a.user_id = r.id
        LEFT JOIN comadd_job j ON a.job_id = j.id
        ORDER BY a.id DESC";

$result = mysqli_query($conn, $sql);
$total_apps = ($result) ? mysqli_num_rows($result) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Candidate Applications | TalentFlex Admin</title>
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
        <!-- Dashboard Topbar Glass -->
        <div class="dashboard-topbar-glass d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 4px;">
                    All Candidate Applications
                </h2>
                <p style="color: var(--tf-text-muted); font-size: 14px; margin: 0;">
                    Central oversight of all student applications submitted to campus recruiters.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <!-- Instant Live Filter Search -->
                <div class="admin-table-filter">
                    <i class="fas fa-search text-muted"></i>
                    <input type="text" id="appSearchInput" onkeyup="filterAppTable()" placeholder="Search candidate, company, education, status...">
                </div>
                <span class="user-badge-nav-admin ms-1">
                    <i class="fas fa-file-alt text-primary"></i> <?php echo $total_apps; ?> Applications
                </span>
            </div>
        </div>

        <?php if ($total_apps > 0) { ?>
            <div class="table-portal-card">
                <div class="table-responsive">
                    <table class="table-portal" id="applicationsTable">
                        <thead>
                            <tr>
                                <th>App #</th>
                                <th>Candidate Name</th>
                                <th>Recruiter & Role</th>
                                <th>Education & Exp</th>
                                <th>Skills</th>
                                <th>Resume</th>
                                <th>Applied Date</th>
                                <th class="text-end">Current Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><strong>#<?php echo $row['id']; ?></strong></td>
                                    <td>
                                        <strong style="color: var(--tf-navy); font-size: 15px;">
                                            <?php echo htmlspecialchars($row['applicant_name'] ?: ($row['user_name'] ?: 'Applicant #' . $row['user_id'])); ?>
                                        </strong>
                                        <?php if (!empty($row['applicant_email'])) { ?>
                                            <div class="text-muted" style="font-size: 12.5px;">
                                                <i class="fas fa-envelope text-primary me-1"></i> <?php echo htmlspecialchars($row['applicant_email']); ?>
                                            </div>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <strong style="color: var(--tf-navy);"><?php echo htmlspecialchars($row['company_name']); ?></strong>
                                        <div class="text-muted" style="font-size: 13px;">
                                            <i class="fas fa-briefcase text-muted me-1"></i><?php echo htmlspecialchars($row['job_title'] ?: 'Job #' . $row['job_id']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div><strong style="color:#0f172a;"><?php echo htmlspecialchars($row['education'] ?: 'N/A'); ?></strong></div>
                                        <small class="text-muted"><?php echo htmlspecialchars($row['experience'] ?: 'Fresher'); ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border fw-normal" style="font-size: 12px;">
                                            <?php echo htmlspecialchars(mb_strimwidth($row['skills'], 0, 30, "...")); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                        $resume_file = $row['resume'];
                                        $resume_path = "";
                                        if (!empty($resume_file)) {
                                            if (file_exists("../resume/" . $resume_file)) {
                                                $resume_path = "../resume/" . $resume_file;
                                            } elseif (file_exists("../uploads/" . $resume_file)) {
                                                $resume_path = "../uploads/" . $resume_file;
                                            }
                                        }
                                        ?>
                                        <?php if (!empty($resume_path)) { ?>
                                            <a href="<?php echo htmlspecialchars($resume_path); ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size: 12px;">
                                                <i class="fas fa-file-pdf text-danger me-1"></i> View CV
                                            </a>
                                        <?php } else { ?>
                                            <span class="text-muted" style="font-size: 12px;">None</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo htmlspecialchars($row['apply_date']); ?></small>
                                    </td>
                                    <td class="text-end">
                                        <?php if (stripos($row['status'], 'Accepted') !== false) { ?>
                                            <span class="badge-status badge-status-accepted">Shortlisted</span>
                                        <?php } elseif (stripos($row['status'], 'Rejected') !== false) { ?>
                                            <span class="badge-status badge-status-rejected">Rejected</span>
                                        <?php } else { ?>
                                            <span class="badge-status badge-status-pending">Pending</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="portal-card-glass text-center py-5">
                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                <h4 style="font-weight: 700; color: var(--tf-navy);">No Applications Found</h4>
                <p class="text-muted mb-0">No application submissions logged in the system.</p>
            </div>
        <?php } ?>
    </div>

    <!-- Filter JS Script -->
    <script>
    function filterAppTable() {
        var input = document.getElementById("appSearchInput");
        var filter = input.value.toLowerCase();
        var table = document.getElementById("applicationsTable");
        var tr = table.getElementsByTagName("tr");

        for (var i = 1; i < tr.length; i++) {
            var text = tr[i].textContent || tr[i].innerText;
            if (text.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
    </script>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>