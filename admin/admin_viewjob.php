<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: ../login1.php");
    exit();
}

// Handle Admin Delete Job
if (isset($_GET['delete_id'])) {
    $del_id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM comadd_job WHERE id='$del_id'");
    echo "<script>
            alert('Job removed successfully by administrator.');
            window.location='admin_viewjob.php';
          </script>";
    exit();
}

$sql = "SELECT * FROM comadd_job ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$total_jobs = ($result) ? mysqli_num_rows($result) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posted Jobs | TalentFlex Admin</title>
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
        <!-- Topbar Hero Glass -->
        <div class="dashboard-topbar-glass d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 4px;">
                    All Posted Job Listings
                </h2>
                <p style="color: var(--tf-text-muted); font-size: 14px; margin: 0;">
                    Supervise all active positions posted by registered enterprise recruiters across the network.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <!-- Instant Live Filter Search -->
                <div class="admin-table-filter">
                    <i class="fas fa-search text-muted"></i>
                    <input type="text" id="jobSearchInput" onkeyup="filterJobTable()" placeholder="Search jobs, companies, locations...">
                </div>
                <span class="user-badge-nav-admin ms-1">
                    <i class="fas fa-briefcase text-primary"></i> <?php echo $total_jobs; ?> Jobs
                </span>
            </div>
        </div>

        <?php if ($total_jobs > 0) { ?>
            <div class="table-portal-card">
                <div class="table-responsive">
                    <table class="table-portal" id="jobsTable">
                        <thead>
                            <tr>
                                <th>Ref #</th>
                                <th>Company</th>
                                <th>Job Designation</th>
                                <th>Nature</th>
                                <th>Location</th>
                                <th>Salary (₹)</th>
                                <th>Description</th>
                                <th class="text-end">Admin Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><strong>#<?php echo $row['id']; ?></strong></td>
                                    <td>
                                        <strong style="color: var(--tf-navy);">
                                            <i class="fas fa-building text-primary me-1"></i>
                                            <?php echo htmlspecialchars($row['com_name']); ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <span style="font-weight: 700; color: #0f172a;">
                                            <?php echo htmlspecialchars($row['job_title']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="pill-meta pill-type"><?php echo htmlspecialchars($row['job_type']); ?></span>
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                        <?php echo htmlspecialchars($row['location']); ?>
                                    </td>
                                    <td>
                                        <strong class="pill-meta pill-salary">₹<?php echo number_format($row['salary']); ?>/mo</strong>
                                    </td>
                                    <td>
                                        <span class="text-muted" style="font-size: 13.5px;">
                                            <?php echo htmlspecialchars(mb_strimwidth($row['description'], 0, 50, "...")); ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="../job_details.php?id=<?php echo $row['id']; ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill me-1" title="View Public Page">
                                            <i class="fas fa-external-link-alt me-1"></i> View
                                        </a>
                                        <a href="admin_viewjob.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Are you sure you want to delete this job posting permanently?')" title="Delete Job">
                                            <i class="fas fa-trash-alt me-1"></i> Remove
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="portal-card-glass text-center py-5">
                <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                <h4 style="font-weight: 700; color: var(--tf-navy);">No Jobs in the Database</h4>
                <p class="text-muted mb-0">No job listings found in comadd_job table.</p>
            </div>
        <?php } ?>
    </div>

    <!-- Filter JS Script -->
    <script>
    function filterJobTable() {
        var input = document.getElementById("jobSearchInput");
        var filter = input.value.toLowerCase();
        var table = document.getElementById("jobsTable");
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