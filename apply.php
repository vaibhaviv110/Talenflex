<?php
session_start();
include("db.php");

// Login check
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: login1.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($job_id <= 0) {
    header("Location: s.php");
    exit();
}

// Fetch Job Details
$jobQuery = mysqli_query($conn, "SELECT * FROM comadd_job WHERE id='$job_id'");
if (!$jobQuery || mysqli_num_rows($jobQuery) == 0) {
    header("Location: s.php");
    exit();
}
$job = mysqli_fetch_assoc($jobQuery);
$company_name = $job['com_name'];

// Check if already applied
$check = mysqli_query($conn, "SELECT * FROM application WHERE job_id='$job_id' AND user_id='$user_id'");
$alreadyApplied = ($check && mysqli_num_rows($check) > 0);

// Fetch candidate profile info for auto-filling
$prof_q = mysqli_query($conn, "SELECT * FROM user_profile WHERE user_id='$user_id'");
$prof = ($prof_q && mysqli_num_rows($prof_q) > 0) ? mysqli_fetch_assoc($prof_q) : [];

// Handle Application Submission
$error_msg = "";
$success_msg = "";

if (isset($_POST['apply'])) {
    if ($alreadyApplied) {
        $error_msg = "You have already submitted an application for this position.";
    } else {
        $education = mysqli_real_escape_string($conn, trim($_POST['education'] ?? ''));
        $experience = mysqli_real_escape_string($conn, trim($_POST['experience'] ?? ''));
        $skills = mysqli_real_escape_string($conn, trim($_POST['skills'] ?? ''));
        $message = mysqli_real_escape_string($conn, trim($_POST['message'] ?? ''));

        $resume_uploaded = false;
        $newResumeName = "";

        if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
            $resumeName = $_FILES['resume']['name'];
            $resumeTmp = $_FILES['resume']['tmp_name'];
            $extension = strtolower(pathinfo($resumeName, PATHINFO_EXTENSION));
            $allowed = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];

            if (!in_array($extension, $allowed)) {
                $error_msg = "Only PDF, DOC, DOCX, JPG, and PNG files are accepted.";
            } else {
                $upload_dir = "resume/";
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $newResumeName = time() . "_" . preg_replace("/[^a-zA-Z0-9._-]/", "", basename($resumeName));
                if (move_uploaded_file($resumeTmp, $upload_dir . $newResumeName)) {
                    $resume_uploaded = true;
                } else {
                    $error_msg = "File upload failed. Please try again.";
                }
            }
        } elseif (!empty($prof['resume'])) {
            // Use profile resume if exists
            $newResumeName = $prof['resume'];
            $resume_uploaded = true;
        } else {
            $error_msg = "Please upload your resume to apply.";
        }

        if (empty($error_msg) && $resume_uploaded) {
            $user_name = $_SESSION['name'] ?? '';
            $insert_sql = "INSERT INTO application
                (job_id, company_name, user_id, user_name, email, mobile, education, experience, skills, resume, apply_date, status, message)
                VALUES
                ('$job_id', '$company_name', '$user_id', '$user_name', '', '', '$education', '$experience', '$skills', '$newResumeName', CURDATE(), 'Pending', '$message')";

            if (mysqli_query($conn, $insert_sql)) {
                echo "<script>
                    alert('Your application has been submitted successfully!');
                    window.location.href = 'application.php';
                </script>";
                exit();
            } else {
                $error_msg = "Database Error: " . mysqli_error($conn);
            }
        }
    }
}

include("header.php");
?>

<div class="container my-5">
    <div class="portal-card mx-auto" style="max-width: 740px;">
        <!-- Header Banner -->
        <div class="text-center mb-4 pb-3 border-bottom">
            <span class="badge mb-2" style="background: var(--tf-primary-light); color: var(--tf-primary); font-size: 13px; font-weight: 700; padding: 6px 14px; border-radius: 9999px;">
                Job Application
            </span>
            <h2 style="font-size: 28px; font-weight: 800; color: var(--tf-navy); margin-bottom: 8px;">
                Apply for <?php echo htmlspecialchars($job['job_title']); ?>
            </h2>
            <p style="color: var(--tf-text-muted); font-size: 15px; margin: 0;">
                <i class="fas fa-building text-primary me-1"></i> <?php echo htmlspecialchars($job['com_name']); ?>
                &nbsp;|&nbsp;
                <i class="fas fa-map-marker-alt text-danger me-1"></i> <?php echo htmlspecialchars($job['location']); ?>
                <?php if (!empty($job['salary'])) { ?>
                    &nbsp;|&nbsp;
                    <i class="fas fa-rupee-sign text-success me-1"></i> ₹<?php echo number_format($job['salary']); ?>/mo
                <?php } ?>
            </p>
        </div>

        <?php if (!empty($error_msg)) { ?>
            <div class="alert alert-danger d-flex align-items-center mb-4">
                <i class="fas fa-exclamation-circle me-2 fs-5"></i>
                <div><?php echo $error_msg; ?></div>
            </div>
        <?php } ?>

        <?php if ($alreadyApplied) { ?>
            <div class="alert alert-warning text-center py-4 mb-4">
                <i class="fas fa-check-double fa-2x mb-2 text-warning"></i>
                <h5>Application Already Submitted</h5>
                <p class="mb-3 text-muted">You have already applied for this opening. You can check the current review status in your candidate dashboard.</p>
                <a href="application.php" class="btn-tf-primary">
                    <i class="fas fa-file-alt me-1"></i> View My Applications
                </a>
            </div>
        <?php } else { ?>
            <form method="POST" enctype="multipart/form-data">
                <!-- Education -->
                <div class="mb-3">
                    <label class="form-label-custom">Highest Qualification <span class="text-danger">*</span></label>
                    <select name="education" class="form-control-custom" required>
                        <option value="">-- Select Highest Qualification --</option>
                        <?php
                        $quals = ["BCA", "MCA", "B.Tech / B.E.", "M.Tech", "B.Sc (IT / CS)", "M.Sc (IT)", "Diploma Engineering", "BBA / MBA", "Other Graduate"];
                        $cur_qual = $prof['qualification'] ?? '';
                        foreach ($quals as $q) {
                            $sel = (stripos($cur_qual, $q) !== false) ? 'selected' : '';
                            echo "<option value='$q' $sel>$q</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Experience -->
                <div class="mb-3">
                    <label class="form-label-custom">Relevant Experience <span class="text-danger">*</span></label>
                    <select name="experience" class="form-control-custom" required>
                        <option value="">-- Select Experience Level --</option>
                        <?php
                        $exps = ["Fresher / Entry Level", "6 Months Internship", "1 Year", "2 Years", "3 Years", "4+ Years"];
                        $cur_exp = $prof['experience'] ?? '';
                        foreach ($exps as $e) {
                            $sel = (stripos($cur_exp, $e) !== false) ? 'selected' : '';
                            echo "<option value='$e' $sel>$e</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Key Skills -->
                <div class="mb-3">
                    <label class="form-label-custom">Key Skills & Tools <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="skills"
                        class="form-control-custom"
                        placeholder="e.g. PHP, MySQL, JavaScript, React, Python, Git"
                        value="<?php echo htmlspecialchars($prof['skills'] ?? ''); ?>"
                        required
                    >
                    <small class="text-muted">Separate skills with commas.</small>
                </div>

                <!-- Resume Upload -->
                <div class="mb-3">
                    <label class="form-label-custom">Resume / CV Attachment <span class="text-danger">*</span></label>
                    <?php if (!empty($prof['resume'])) { ?>
                        <div class="p-2 mb-2 bg-light border rounded d-flex align-items-center justify-content-between">
                            <span class="text-muted fs-6">
                                <i class="fas fa-file-pdf text-danger me-1"></i> Current Profile Resume: <strong><?php echo htmlspecialchars($prof['resume']); ?></strong>
                            </span>
                            <small class="text-success fw-bold">Ready to attach</small>
                        </div>
                    <?php } ?>
                    <input
                        type="file"
                        name="resume"
                        class="form-control-custom"
                        accept=".pdf,.doc,.docx,.jpg,.png"
                        <?php echo empty($prof['resume']) ? 'required' : ''; ?>
                    >
                    <small class="text-muted">Accepted formats: PDF, DOC, DOCX, JPG, PNG (Max 5MB)</small>
                </div>

                <!-- Cover Note / Message -->
                <div class="mb-4">
                    <label class="form-label-custom">Brief Message to Employer (Optional)</label>
                    <textarea
                        name="message"
                        class="form-control-custom"
                        placeholder="Introduce yourself, mention key academic achievements or availability date..."
                        rows="3"
                    ></textarea>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                    <a href="job_details.php?id=<?php echo $job_id; ?>" class="btn-tf-outline">
                        <i class="fas fa-arrow-left me-1"></i> Back to Job
                    </a>
                    <button type="submit" name="apply" class="btn-tf-primary" style="padding: 12px 36px; font-size: 16px;">
                        <i class="fas fa-check-circle me-1"></i> Submit Application
                    </button>
                </div>
            </form>
        <?php } ?>
    </div>
</div>

<?php include("footer.php"); ?>