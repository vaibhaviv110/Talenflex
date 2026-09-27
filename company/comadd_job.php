<?php
session_start();
include("db.php");

if (!isset($_SESSION['company_name'])) {
    header("Location: com_login.php");
    exit();
}

$company = $_SESSION['company_name'];
$msg = "";
$msg_type = "";

if (isset($_POST['submit'])) {
    $com_name = mysqli_real_escape_string($conn, $company);
    $job_title = mysqli_real_escape_string($conn, trim($_POST['job_title']));
    $job_type = mysqli_real_escape_string($conn, trim($_POST['job_type']));
    $location = mysqli_real_escape_string($conn, trim($_POST['location']));
    $salary = intval($_POST['salary']);
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));

    $sql = "INSERT INTO comadd_job
            (com_name, job_title, job_type, location, salary, description, views)
            VALUES
            ('$com_name', '$job_title', '$job_type', '$location', '$salary', '$description', 0)";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('New Job Position Posted Successfully!');
                window.location='commy_job.php';
              </script>";
        exit();
    } else {
        $msg = "Database Error: " . mysqli_error($conn);
        $msg_type = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post New Job | TalentFlex Employer</title>
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
                    Post a New Vacancy
                </h2>
                <p style="color: var(--tf-text-muted); font-size: 14px; margin: 0;">
                    Publish a new job or internship opportunity to the campus talent network.
                </p>
            </div>
            <div>
                <a href="commy_job.php" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-list me-1"></i> View All My Jobs
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
                    <!-- Job Title -->
                    <div class="col-md-6 col-12">
                        <label class="form-label-custom">Job Title / Designation <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            name="job_title"
                            class="form-control-custom"
                            placeholder="e.g. PHP Developer, UI/UX Designer, Data Analyst"
                            required
                        >
                    </div>

                    <!-- Job Type -->
                    <div class="col-md-6 col-12">
                        <label class="form-label-custom">Job Nature / Employment Type <span class="text-danger">*</span></label>
                        <select name="job_type" class="form-control-custom" required>
                            <option value="">-- Select Nature --</option>
                            <option value="Full Time">Full Time</option>
                            <option value="Part Time">Part Time</option>
                            <option value="Internship">Internship</option>
                            <option value="Remote">Remote</option>
                        </select>
                    </div>

                    <!-- Location -->
                    <div class="col-md-6 col-12">
                        <label class="form-label-custom">Job Location (City) <span class="text-danger">*</span></label>
                        <select name="location" class="form-control-custom" required>
                            <option value="">-- Select City Location --</option>
                            <?php
                            $cities = mysqli_query($conn, "SELECT c_name FROM city ORDER BY c_name ASC");
                            if ($cities) {
                                while ($c = mysqli_fetch_assoc($cities)) {
                                    echo "<option value='" . htmlspecialchars($c['c_name']) . "'>" . htmlspecialchars($c['c_name']) . "</option>";
                                }
                            }
                            ?>
                            <option value="Remote / Work from Home">Remote / Work from Home</option>
                        </select>
                    </div>

                    <!-- Salary -->
                    <div class="col-md-6 col-12">
                        <label class="form-label-custom">Monthly Salary / Stipend (₹) <span class="text-danger">*</span></label>
                        <input
                            type="number"
                            name="salary"
                            class="form-control-custom"
                            placeholder="e.g. 25000"
                            min="0"
                            required
                        >
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label-custom">Job Description, Skills & Requirements <span class="text-danger">*</span></label>
                        <textarea
                            name="description"
                            class="form-control-custom"
                            placeholder="Outline roles, daily responsibilities, required technical skills, and qualification requirements..."
                            rows="6"
                            required
                        ></textarea>
                    </div>

                    <div class="col-12 pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="commy_job.php" class="btn btn-light border px-4">Cancel</a>
                        <button type="submit" name="submit" class="btn-tf-primary" style="padding: 12px 34px;">
                            <i class="fas fa-paper-plane me-1"></i> Publish Job Listing
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