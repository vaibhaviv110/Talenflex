<?php
// Include database connection
include("db.php"); 


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$logged_user_name = $_SESSION['name'] ?? $_SESSION['user_name'] ?? $_SESSION['candidate_name'] ?? $_SESSION['user'] ?? '';
$logged_user_email = $_SESSION['email'] ?? $_SESSION['user_email'] ?? $_SESSION['mail'] ?? $_SESSION['candidate_email'] ?? '';

if (empty($logged_user_email) && !empty($logged_user_name)) {
    $safe_name = mysqli_real_escape_string($conn, $logged_user_name);
    $fetch_email_q = mysqli_query($conn, "SELECT email FROM registration WHERE name = '$safe_name' LIMIT 1");
    if ($fetch_email_q && mysqli_num_rows($fetch_email_q) > 0) {
        $row = mysqli_fetch_assoc($fetch_email_q);
        $logged_user_email = $row['email'] ?? '';
    }
}



$alert_msg = "";
$alert_type = "";

$companies_q = mysqli_query($conn, "SELECT * FROM companyreg");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_message'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $target_recruiter = mysqli_real_escape_string($conn, $_POST['company_name']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO contact_messages (name, email, company_name, subject, message, created_at) 
            VALUES ('$fullname', '$email', '$target_recruiter', '$subject', '$message', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Your message has been sent successfully!'); window.location.href='contact.php';</script>";
        exit();
    } else {
        $alert_msg = "Error: " . mysqli_error($conn);
        $alert_type = "danger";
    }
}
include("header.php"); 
?>

<!-- Banner Section -->
<div style="background: linear-gradient(135deg, #f8fafc 0%, #edf2f9 100%); padding: 50px 0 45px; border-bottom: 1px solid #e2e8f0; text-align: center;">
    <div class="container">
        <span class="badge mb-2" style="background: var(--tf-primary-light); color: var(--tf-primary); font-size: 13px; font-weight: 700; padding: 6px 14px; border-radius: 9999px;">
            Get in Touch
        </span>
        <h1 style="font-size: 36px; font-weight: 800; color: var(--tf-navy); margin-bottom: 8px;">
            Contact TalentFlex & Placement Cell
        </h1>
        <p style="color: var(--tf-text-muted); font-size: 16px; max-width: 600px; margin: 0 auto;">
            Have questions about on-campus recruitment, company registration, or application assistance? Reach out to our dedicated support team.
        </p>
    </div>
</div>

<div class="container my-5">
    <div class="row g-5">
        <!-- Contact Form & History (Left 7 Cols) -->
        <div class="col-lg-7 col-12">
            <div class="portal-card mb-5">
                <h3 style="font-size: 22px; font-weight: 700; color: var(--tf-navy); margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1.5px solid #f1f5f9;">
                    Send Us a Message
                </h3>

                <?php if (!empty($alert_msg)) { ?>
                    <div class="alert alert-<?php echo $alert_type; ?> alert-dismissible fade show" role="alert">
                        <?php echo $alert_msg; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6 col-12">
                            <label class="form-label-custom">Full Name <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                name="name"
                                class="form-control-custom"
                                value="<?php echo htmlspecialchars($logged_user_name); ?>"
                                placeholder="Enter your full name"
                                required
                            >
                        </div>

                        <div class="col-md-6 col-12">
                            <label class="form-label-custom">Email Address <span class="text-danger">*</span></label>
                            <input
                                type="email"
                                name="email"
                                class="form-control-custom"
                                value="<?php echo htmlspecialchars($logged_user_email); ?>"
                                placeholder="name@example.com"
                                required
                            >
                        </div>

                        <div class="col-md-6 col-12">
                            <label class="form-label-custom">Select Target Recruiter</label>
                            <select name="company_name" class="form-control-custom">
                                <option value="General Placement Cell">-- General Placement Cell --</option>
                                <?php
                                if ($companies_q) {
                                    while ($comp = mysqli_fetch_assoc($companies_q)) {
                                        $comp_name = $comp['name'] ?? $comp['company_name'] ?? '';
                                        if(!empty($comp_name)) {
                                            echo "<option value='" . htmlspecialchars($comp_name) . "'>" . htmlspecialchars($comp_name) . "</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 col-12">
                            <label class="form-label-custom">Subject / Topic <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                name="subject"
                                class="form-control-custom"
                                placeholder="e.g. Campus Drive Query, Technical Help"
                                required
                            >
                        </div>

                        <div class="col-12">
                            <label class="form-label-custom">Message <span class="text-danger">*</span></label>
                            <textarea
                                name="message"
                                class="form-control-custom"
                                placeholder="Write your inquiry or question in detail..."
                                rows="5"
                                required
                            ></textarea>
                        </div>

                        <div class="col-12 pt-2">
                            <button type="submit" name="send_message" class="btn-tf-primary" style="padding: 12px 34px; font-size: 15px;">
                                <i class="fas fa-paper-plane me-1"></i> Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- USER INQUIRY HISTORY & COMPANY REPLIES SECTION -->
            <div class="portal-card">
                <h3 style="font-size: 20px; font-weight: 700; color: var(--tf-navy); margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1.5px solid #f1f5f9;">
                    <i class="fas fa-history me-2"></i> Your Sent Messages & Replies
                </h3>
                <p class="text-muted" style="font-size: 13px; margin-bottom: 15px;">Showing messages based on your logged-in email (<strong><?php echo htmlspecialchars($logged_user_email); ?></strong>):</p>
                
                <?php
                if (!empty($logged_user_email)) {
                    $check_email = mysqli_real_escape_string($conn, $logged_user_email);
                    $history_q = mysqli_query($conn, "SELECT * FROM contact_messages WHERE email = '$check_email' ORDER BY id DESC");
                    
                    if ($history_q && mysqli_num_rows($history_q) > 0) {
                        while ($hist = mysqli_fetch_assoc($history_q)) {
                            ?>
                            <div class="card mb-3 border bg-light shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-secondary"><?php echo htmlspecialchars($hist['company_name'] ?? 'General'); ?></span>
                                        <small class="text-muted"><?php echo htmlspecialchars($hist['created_at']); ?></small>
                                    </div>
                                    <h6 class="text-primary fw-bold mb-1">Subject: <?php echo htmlspecialchars($hist['subject']); ?></h6>
                                    <p class="mb-2 text-dark" style="font-size: 14px;"><strong>Your Message:</strong> <?php echo htmlspecialchars($hist['message']); ?></p>

                                    <!-- Company Reply Box -->
                                    <?php if (!empty($hist['reply'])) { ?>
                                        <div class="alert alert-success mt-2 mb-0 p-2" style="font-size: 13px;">
                                            <strong>Company Reply:</strong> <?php echo htmlspecialchars($hist['reply']); ?>
                                        </div>
                                    <?php } else { ?>
                                        <div class="alert alert-warning mt-2 mb-0 p-2 text-muted" style="font-size: 13px;">
                                            <em>Status: Pending (Waiting for company reply...)</em>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p class="text-muted text-center py-3">You have not sent any messages yet.</p>';
                    }
                } else {
                    echo '<p class="text-danger text-center py-3">Email address not found.</p>';
                }
                ?>
            </div>
        </div>

        <div class="col-lg-5 col-12">
            <div class="portal-card mb-4">
                <h3 style="font-size: 20px; font-weight: 700; color: var(--tf-navy); margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1.5px solid #f1f5f9;">
                    Placement Office
                </h3>

                <div class="d-flex align-items-start mb-4">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff6ff; color: var(--tf-primary); display: flex; align-items: center; justify-content: center; font-size: 18px; margin-right: 16px; flex-shrink: 0;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <strong style="color: var(--tf-navy); display: block; font-size: 15px;">Campus Address</strong>
                        <span class="text-muted" style="font-size: 14px;">
                            DR. HARIBHAI GODHANI CAMPUS MANAGED BY 
                            SHREE SARDAR PATEL EDUCATION TRUST B/H. RAILWAY STATION, 
                            SARDARPARA, JOSHIPURA, JUNAGADH 362001, Gujarat, India
                        </span>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 18px; margin-right: 16px; flex-shrink: 0;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <strong style="color: var(--tf-navy); display: block; font-size: 15px;">Official Email</strong>
                        <span class="text-muted" style="font-size: 14px;">talentflex@gmail.com</span>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: #fdf2f8; color: var(--tf-accent); display: flex; align-items: center; justify-content: center; font-size: 18px; margin-right: 16px; flex-shrink: 0;">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <strong style="color: var(--tf-navy); display: block; font-size: 15px;">Helpline Numbers</strong>
                        <span class="text-muted" style="font-size: 14px;">+91 94278 05272</span>
                    </div>
                </div>

                <div class="d-flex align-items-start">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 18px; margin-right: 16px; flex-shrink: 0;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <strong style="color: var(--tf-navy); display: block; font-size: 15px;">Office Working Hours</strong>
                        <span class="text-muted" style="font-size: 14px;">Monday – Saturday: 9:00 AM – 5:30 PM</span>
                    </div>
                </div>
            </div>

            <!-- Recruiter Quick Help Card -->
            <div class="portal-card" style="background: linear-gradient(135deg, var(--tf-navy) 0%, var(--tf-navy-dark) 100%); color: #ffffff;">
                <h4 style="color: #ffffff; font-size: 18px; font-weight: 700; margin-bottom: 10px;">
                    Are you an Employer?
                </h4>
                <p style="color: #cbd5e1; font-size: 14px; margin-bottom: 18px;">
                    Looking to register your enterprise for on-campus student hiring? Register your company account directly.
                </p>
                <a href="company/com.php" class="btn-tf-accent" style="font-size: 14px; padding: 9px 20px;">
                    Register as Recruiter
                </a>
            </div>
        </div>
    </div>
</div>

<?php 
include("footer.php"); 
?>