<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: login1.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success = "";
$error = "";

if (isset($_POST['upload'])) {
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
        $file_name = $_FILES['cv']['name'];
        $file_tmp = $_FILES['cv']['tmp_name'];
        $allowed = ['pdf', 'doc', 'docx'];
        $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowed)) {
            $error = "Only PDF, DOC, and DOCX files are allowed.";
        } else {
            $upload_folder = "uploads/";
            if (!is_dir($upload_folder)) {
                mkdir($upload_folder, 0777, true);
            }

            $new_name = "CV_" . $user_id . "_" . time() . "." . $extension;
            $destination = $upload_folder . $new_name;

            if (move_uploaded_file($file_tmp, $destination)) {
                $new_name_safe = mysqli_real_escape_string($conn, $new_name);

                // Update user_profile if exists or insert
                $check_prof = mysqli_query($conn, "SELECT * FROM user_profile WHERE user_id='$user_id'");
                if ($check_prof && mysqli_num_rows($check_prof) > 0) {
                    mysqli_query($conn, "UPDATE user_profile SET resume='$new_name_safe' WHERE user_id='$user_id'");
                } else {
                    mysqli_query($conn, "INSERT INTO user_profile (user_id, resume, qualification, passing_year, c_id, skills, experience) VALUES ('$user_id', '$new_name_safe', '', '', '0', '', '')");
                }

                // Also update registration if column exists
                @mysqli_query($conn, "UPDATE registration SET resume='$new_name_safe' WHERE id='$user_id'");

                $success = "Your resume has been uploaded successfully!";
            } else {
                $error = "File upload failed. Please verify folder permissions and try again.";
            }
        }
    } else {
        $error = "Please select a valid CV document.";
    }
}

// Fetch current resume
$prof_q = mysqli_query($conn, "SELECT resume FROM user_profile WHERE user_id='$user_id'");
$cur_resume = ($prof_q && mysqli_num_rows($prof_q) > 0) ? mysqli_fetch_assoc($prof_q)['resume'] : '';

include("header.php");
?>

<!-- Banner Section -->
<div style="background: linear-gradient(135deg, #f8fafc 0%, #edf2f9 100%); padding: 50px 0 45px; border-bottom: 1px solid #e2e8f0; text-align: center;">
    <div class="container">
        <span class="badge mb-2" style="background: var(--tf-primary-light); color: var(--tf-primary); font-size: 13px; font-weight: 700; padding: 6px 14px; border-radius: 9999px;">
            Document Center
        </span>
        <h1 style="font-size: 34px; font-weight: 800; color: var(--tf-navy); margin-bottom: 8px;">
            Upload Your Resume / CV
        </h1>
        <p style="color: var(--tf-text-muted); font-size: 15.5px; margin: 0 auto; max-width: 600px;">
            Keep your resume updated so hiring managers can review your technical qualifications and schedule interviews.
        </p>
    </div>
</div>

<div class="container my-5">
    <div class="portal-card mx-auto" style="max-width: 580px;">
        <div class="text-center mb-4 pb-2 border-bottom">
            <div style="width: 68px; height: 68px; border-radius: 50%; background: var(--tf-primary-light); color: var(--tf-primary); display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 16px;">
                <i class="fas fa-cloud-upload-alt"></i>
            </div>
            <h3 style="font-size: 22px; font-weight: 700; color: var(--tf-navy); margin-bottom: 6px;">
                Select Resume Document
            </h3>
            <p class="text-muted" style="font-size: 14.5px; margin: 0;">
                Supported file formats: PDF, DOC, DOCX (Max size: 5MB)
            </p>
        </div>

        <?php if (!empty($success)) { ?>
            <div class="alert alert-success d-flex align-items-center mb-4">
                <i class="fas fa-check-circle me-2 fs-5"></i>
                <div><?php echo $success; ?></div>
            </div>
        <?php } ?>

        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger d-flex align-items-center mb-4">
                <i class="fas fa-exclamation-circle me-2 fs-5"></i>
                <div><?php echo $error; ?></div>
            </div>
        <?php } ?>

        <?php if (!empty($cur_resume)) { ?>
            <div class="p-3 mb-4 rounded bg-light border d-flex align-items-center justify-content-between">
                <div>
                    <strong class="d-block" style="font-size: 14px; color: var(--tf-navy);">
                        <i class="fas fa-file-pdf text-danger me-1"></i> Current Active Resume
                    </strong>
                    <small class="text-muted"><?php echo htmlspecialchars($cur_resume); ?></small>
                </div>
                <a href="uploads/<?php echo htmlspecialchars($cur_resume); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-download me-1"></i> View / Download
                </a>
            </div>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="form-label-custom">Choose Document File <span class="text-danger">*</span></label>
                <input
                    type="file"
                    name="cv"
                    class="form-control-custom"
                    accept=".pdf,.doc,.docx"
                    required
                >
            </div>

            <div class="d-flex align-items-center justify-content-between pt-2">
                <a href="profile.php" class="btn-tf-outline">
                    <i class="fas fa-user-circle me-1"></i> My Profile
                </a>
                <button type="submit" name="upload" class="btn-tf-primary" style="padding: 12px 30px;">
                    <i class="fas fa-upload me-1"></i> Upload Document
                </button>
            </div>
        </form>
    </div>
</div>

<?php include("footer.php"); ?>