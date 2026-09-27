<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login1.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user registration info
$user_q = mysqli_query($conn, "SELECT * FROM registration WHERE id='$user_id'");
$user_info = ($user_q) ? mysqli_fetch_assoc($user_q) : [];

// Fetch user profile info
$profile_q = mysqli_query($conn, "SELECT * FROM user_profile WHERE user_id='$user_id'");
$data = ($profile_q && mysqli_num_rows($profile_q) > 0) ? mysqli_fetch_assoc($profile_q) : null;

$msg = "";
$msg_type = "";

if (isset($_POST['submit'])) {
    $qualification = mysqli_real_escape_string($conn, trim($_POST['qualification']));
    $passing_year = mysqli_real_escape_string($conn, trim($_POST['passing_year']));
    $c_id = mysqli_real_escape_string($conn, trim($_POST['c_id']));
    $skills = mysqli_real_escape_string($conn, trim($_POST['skills']));
    $experience = mysqli_real_escape_string($conn, trim($_POST['experience']));

    // Handle resume upload if new file provided
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $allowed = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $upload_folder = "uploads/";
            if (!is_dir($upload_folder)) {
                mkdir($upload_folder, 0777, true);
            }
            $resume = time() . "_" . preg_replace("/[^a-zA-Z0-9._-]/", "", basename($_FILES['resume']['name']));
            move_uploaded_file($_FILES['resume']['tmp_name'], $upload_folder . $resume);
        } else {
            $resume = $data['resume'] ?? '';
            $msg = "Invalid file type. Only PDF, DOC, DOCX, and images are allowed.";
            $msg_type = "danger";
        }
    } else {
        $resume = $data['resume'] ?? '';
    }

    if (empty($msg)) {
        if ($data) {
            $sql = "UPDATE user_profile SET
                    qualification='$qualification',
                    passing_year='$passing_year',
                    c_id='$c_id',
                    skills='$skills',
                    experience='$experience',
                    resume='$resume'
                    WHERE user_id='$user_id'";
        } else {
            $sql = "INSERT INTO user_profile
                    (user_id, qualification, passing_year, c_id, skills, experience, resume)
                    VALUES
                    ('$user_id', '$qualification', '$passing_year', '$c_id', '$skills', '$experience', '$resume')";
        }

        if (mysqli_query($conn, $sql)) {
            $msg = "Profile updated successfully!";
            $msg_type = "success";
            // Refresh data
            $profile_q = mysqli_query($conn, "SELECT * FROM user_profile WHERE user_id='$user_id'");
            $data = mysqli_fetch_assoc($profile_q);
        } else {
            $msg = "Database Error: " . mysqli_error($conn);
            $msg_type = "danger";
        }
    }
}

include("header.php");
?>

<!-- Banner Section -->
<div style="background: linear-gradient(135deg, #f8fafc 0%, #edf2f9 100%); padding: 50px 0 45px; border-bottom: 1px solid #e2e8f0;">
    <div class="container">
        <span class="badge mb-2" style="background: var(--tf-primary-light); color: var(--tf-primary); font-size: 13px; font-weight: 700; padding: 6px 14px; border-radius: 9999px;">
            Candidate Account
        </span>
        <h1 style="font-size: 34px; font-weight: 800; color: var(--tf-navy); margin-bottom: 8px;">
            My Profile
        </h1>
        <p style="color: var(--tf-text-muted); font-size: 15.5px; margin: 0;">
            Manage your academic background, core skills, and resume visible to hiring managers.
        </p>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4 justify-content-center">
        <!-- Profile Summary Left Column -->
        <div class="col-lg-4 col-12">
            <div class="portal-card text-center mb-4">
                <div style="width: 84px; height: 84px; border-radius: 50%; background: var(--tf-primary-light); color: var(--tf-primary); font-size: 34px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; border: 3px solid #bfdbfe;">
                    <?php echo strtoupper(substr($user_info['Name'] ?? 'U', 0, 1)); ?>
                </div>
                <h4 style="font-weight: 700; color: var(--tf-navy); margin-bottom: 4px;">
                    <?php echo htmlspecialchars($user_info['Name'] ?? 'Candidate'); ?>
                </h4>
                <p class="text-muted mb-3" style="font-size: 14.5px;">
                    <i class="fas fa-envelope me-1 text-primary"></i> <?php echo htmlspecialchars($user_info['Email'] ?? ''); ?>
                </p>
                <?php if (!empty($user_info['PhoneNumber'])) { ?>
                    <p class="text-muted mb-3" style="font-size: 14.5px;">
                        <i class="fas fa-phone me-1 text-success"></i> <?php echo htmlspecialchars($user_info['PhoneNumber']); ?>
                    </p>
                <?php } ?>

                <hr class="my-3">

                <div class="d-flex justify-content-around text-center py-2">
                    <div>
                        <small class="text-muted d-block">Education</small>
                        <strong style="color: var(--tf-navy);"><?php echo htmlspecialchars($data['qualification'] ?? 'Pending'); ?></strong>
                    </div>
                    <div style="border-left: 1px solid #e2e8f0;"></div>
                    <div>
                        <small class="text-muted d-block">Batch</small>
                        <strong style="color: var(--tf-navy);"><?php echo htmlspecialchars($data['passing_year'] ?? 'N/A'); ?></strong>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="application.php" class="btn-tf-outline w-100 mb-2" style="font-size: 14px;">
                        <i class="fas fa-file-alt me-1"></i> View Applications
                    </a>
                </div>
            </div>

            <!-- Resume Status Box -->
            <div class="portal-card">
                <h5 style="font-weight: 700; color: var(--tf-navy); margin-bottom: 12px;">
                    <i class="fas fa-file-invoice text-primary me-2"></i> Current Resume
                </h5>
                <?php if (!empty($data['resume'])) { ?>
                    <p class="text-muted" style="font-size: 14px; margin-bottom: 14px;">
                        Attached file: <strong><?php echo htmlspecialchars($data['resume']); ?></strong>
                    </p>
                    <a href="uploads/<?php echo htmlspecialchars($data['resume']); ?>" target="_blank" class="btn btn-sm btn-primary w-100">
                        <i class="fas fa-download me-1"></i> Download Resume
                    </a>
                <?php } else { ?>
                    <p class="text-muted" style="font-size: 14px; margin-bottom: 0;">
                        No resume uploaded yet. Upload your CV below to increase your shortlisting chances.
                    </p>
                <?php } ?>
            </div>
        </div>

        <!-- Edit Profile Form Right Column -->
        <div class="col-lg-8 col-12">
            <div class="portal-card">
                <h3 style="font-size: 22px; font-weight: 700; color: var(--tf-navy); margin-bottom: 22px; padding-bottom: 12px; border-bottom: 1.5px solid #f1f5f9;">
                    Edit Academic & Professional Details
                </h3>

                <?php if (!empty($msg)) { ?>
                    <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show" role="alert">
                        <?php echo $msg; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <!-- Qualification -->
                        <div class="col-md-6 col-12">
                            <label class="form-label-custom">Degree / Qualification <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                name="qualification"
                                class="form-control-custom"
                                placeholder="e.g. BCA, MCA, B.Tech CS"
                                value="<?php echo htmlspecialchars($data['qualification'] ?? ''); ?>"
                                required
                            >
                        </div>

                        <!-- Passing Year -->
                        <div class="col-md-6 col-12">
                            <label class="form-label-custom">Passing / Graduation Year <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                name="passing_year"
                                class="form-control-custom"
                                placeholder="e.g. 2026, 2025"
                                value="<?php echo htmlspecialchars($data['passing_year'] ?? ''); ?>"
                                required
                            >
                        </div>

                        <!-- City -->
                        <div class="col-md-6 col-12">
                            <label class="form-label-custom">Preferred Location / City <span class="text-danger">*</span></label>
                            <select name="c_id" class="form-control-custom" required>
                                <option value="">-- Select Preferred City --</option>
                                <?php
                                $city_result = mysqli_query($conn, "SELECT * FROM city ORDER BY c_name ASC");
                                while ($city = mysqli_fetch_assoc($city_result)) {
                                    $selected = (($data['c_id'] ?? '') == $city['c_id']) ? 'selected' : '';
                                    echo "<option value='" . $city['c_id'] . "' $selected>" . htmlspecialchars($city['c_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Experience -->
                        <div class="col-md-6 col-12">
                            <label class="form-label-custom">Total Experience <span class="text-danger">*</span></label>
                            <select name="experience" class="form-control-custom" required>
                                <option value="">-- Select Experience Level --</option>
                                <?php
                                $levels = ["Fresher", "6 Months Internship", "1 Year", "2 Years", "3 Years", "4+ Years"];
                                foreach ($levels as $lvl) {
                                    $selected = (strcasecmp($data['experience'] ?? '', $lvl) == 0) ? 'selected' : '';
                                    echo "<option value='$lvl' $selected>$lvl</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Skills -->
                        <div class="col-12">
                            <label class="form-label-custom">Technical Skills & Expertise <span class="text-danger">*</span></label>
                            <textarea
                                name="skills"
                                class="form-control-custom"
                                placeholder="List your key programming languages, frameworks, or certifications (e.g. PHP, Python, React, SQL, Java, Figma)..."
                                rows="3"
                                required
                            ><?php echo htmlspecialchars($data['skills'] ?? ''); ?></textarea>
                            <small class="text-muted">Separate skills with commas.</small>
                        </div>

                        <!-- Resume Upload -->
                        <div class="col-12">
                            <label class="form-label-custom">Upload / Update Resume</label>
                            <input
                                type="file"
                                name="resume"
                                class="form-control-custom"
                                accept=".pdf,.doc,.docx,.jpg,.png"
                            >
                            <small class="text-muted">Allowed formats: PDF, DOC, DOCX, JPG, PNG (Max 5MB). Leave blank to keep existing file.</small>
                        </div>

                        <div class="col-12 pt-3 border-top d-flex justify-content-end">
                            <button type="submit" name="submit" class="btn-tf-primary" style="padding: 12px 36px; font-size: 16px;">
                                <i class="fas fa-save me-1"></i> Save Profile Details
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
