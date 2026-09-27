<?php
session_start();
include("db.php");

if (!isset($_SESSION['company_name'])) {
    header("Location: com_login.php");
    exit();
}

$company = $_SESSION['company_name'];
$company_safe = mysqli_real_escape_string($conn, $company);

$sql = "SELECT * FROM comadd_job WHERE com_name='$company_safe' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$total_posted = ($result) ? mysqli_num_rows($result) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Posted Jobs | TalentFlex Employer</title>
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
                    Manage Posted Jobs
                </h2>
                <p style="color: var(--tf-text-muted); font-size: 14px; margin: 0;">
                    You have <?php echo $total_posted; ?> active vacancy listing<?php echo ($total_posted != 1) ? 's' : ''; ?> on TalentFlex.
                </p>
            </div>
            <div>
                <a href="comadd_job.php" class="btn-tf-primary" style="padding: 10px 22px; font-size: 14px;">
                    <i class="fas fa-plus-circle me-1"></i> Post New Job
                </a>
            </div>
        </div>

        <?php if ($total_posted > 0) { ?>
            <div class="table-portal-card">
                <div class="table-responsive">
                    <table class="table-portal">
                        <thead>
                            <tr>
                                <th>Ref #</th>
                                <th>Job Designation</th>
                                <th>Employment Nature</th>
                                <th>Work Location</th>
                                <th>Offered Salary</th>
                                <th>Brief Description</th>
                                <th class="text-end">Manage Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><strong>#<?php echo $row['id']; ?></strong></td>
                                    <td>
                                        <strong style="color: var(--tf-navy); font-size: 15px;">
                                            <?php echo htmlspecialchars($row['job_title']); ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <span class="pill-meta pill-type"><?php echo htmlspecialchars($row['job_type']); ?></span>
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                        <?php echo htmlspecialchars($row['location']); ?>
                                    </td>
                                    <td>
                                        <strong class="text-success">₹<?php echo number_format($row['salary']); ?></strong>/mo
                                    </td>
                                    <td>
                                        <span class="text-muted" style="font-size: 13.5px;">
                                            <?php echo htmlspecialchars(mb_strimwidth($row['description'], 0, 45, "...")); ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white me-1">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning text-dark me-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this job posting?')">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="portal-card text-center py-5">
                <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                <h4 style="font-weight: 700; color: var(--tf-navy);">No Jobs Posted Yet</h4>
                <p class="text-muted mb-4">Start by creating your first campus job or internship listing.</p>
                <a href="comadd_job.php" class="btn-tf-primary">
                    <i class="fas fa-plus-circle me-1"></i> Post Your First Vacancy
                </a>
            </div>
        <?php } ?>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>