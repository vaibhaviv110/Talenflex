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
$msg = "";
$msg_type = "";

if (isset($_POST['update'])) {
    $job_title = mysqli_real_escape_string($conn, trim($_POST['job_title']));
    $job_type = mysqli_real_escape_string($conn, trim($_POST['job_type']));
    $location = mysqli_real_escape_string($conn, trim($_POST['location']));
    $salary = intval($_POST['salary']);
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));

    $update = "UPDATE comadd_job SET
                job_title='$job_title',
                job_type='$job_type',
                location='$location',
                salary='$salary',
                description='$description'
                WHERE id='$id' AND com_name='$company_safe'";

    if (mysqli_query($conn, $update)) {
        echo "<script>
                alert('Job Details Updated Successfully!');
                window.location='commy_job.php';
              </script>";
        exit();
    } else {
        $msg = "Update Error: " . mysqli_error($conn);
        $msg_type = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job #<?php echo $id; ?> | TalentFlex Employer</title>
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
                    Edit Job Listing
                </h2>
                <p style="color: var(--tf-text-muted); font-size: 14px; margin: 0;">
                    Update requirements, offered package, or job parameters for reference #TF-JOB-<?php echo str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?>.
                </p>
            </div>
            <div>
                <a href="commy_job.php" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to All Jobs
                </a>
            </div>
        </div>

        <div class="portal-card mx-auto" style="max-width: 820px;">
            <?php if (!empty($msg)) { ?>
                <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $msg; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php } ?>

            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6 col-12">
                        <label class="form-label-custom">Job Title <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            name="job_title"
                            class="form-control-custom"
                            value="<?php echo htmlspecialchars($row['job_title']); ?>"
                            required
                        >
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label-custom">Job Nature <span class="text-danger">*</span></label>
                        <select name="job_type" class="form-control-custom" required>
                            <?php
                            $types = ["Full Time", "Part Time", "Internship", "Remote"];
                            foreach ($types as $t) {
                                $sel = ($row['job_type'] == $t) ? 'selected' : '';
                                echo "<option value='$t' $sel>$t</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label-custom">Location / City <span class="text-danger">*</span></label>
                        <select name="location" class="form-control-custom" required>
                            <?php
                            $cities = mysqli_query($conn, "SELECT c_name FROM city ORDER BY c_name ASC");
                            if ($cities) {
                                while ($c = mysqli_fetch_assoc($cities)) {
                                    $sel = (strcasecmp($row['location'], $c['c_name']) == 0) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($c['c_name']) . "' $sel>" . htmlspecialchars($c['c_name']) . "</option>";
                                }
                            }
                            ?>
                            <option value="Remote / Work from Home" <?php echo ($row['location'] == 'Remote / Work from Home') ? 'selected' : ''; ?>>Remote / Work from Home</option>
                        </select>
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label-custom">Monthly Salary (₹) <span class="text-danger">*</span></label>
                        <input
                            type="number"
                            name="salary"
                            class="form-control-custom"
                            value="<?php echo htmlspecialchars($row['salary']); ?>"
                            required
                        >
                    </div>

                    <div class="col-12">
                        <label class="form-label-custom">Job Description & Requirements <span class="text-danger">*</span></label>
                        <textarea
                            name="description"
                            class="form-control-custom"
                            rows="6"
                            required
                        ><?php echo htmlspecialchars($row['description']); ?></textarea>
                    </div>

                    <div class="col-12 pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="commy_job.php" class="btn btn-light border px-4">Cancel</a>
                        <button type="submit" name="update" class="btn-tf-primary" style="padding: 12px 34px;">
                            <i class="fas fa-save me-1"></i> Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>