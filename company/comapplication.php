<?php
session_start();
include("db.php");
// ==========================================
// COMPANY LOGIN CHECK
// ==========================================
if (!isset($_SESSION['company_name'])) {
    header("Location: com_login.php");
    exit();
}
$company = $_SESSION['company_name'];
// ==========================================
// UPDATE STATUS WITH INTERVIEW DETAILS
// ==========================================
if (isset($_POST['accept_with_details'])) {

    $id   = intval($_POST['app_id']);
    $date = mysqli_real_escape_string($conn, $_POST['interview_date']);
    $time = mysqli_real_escape_string($conn, $_POST['interview_time']);
    $msg  = mysqli_real_escape_string($conn, $_POST['company_msg']);

    $company_safe = mysqli_real_escape_string($conn, $company);

    $full_status = "Accepted | Date: $date | Time: $time | Note: $msg";

    $update = mysqli_query(
        $conn,
        "UPDATE application
         SET status='$full_status'
         WHERE id='$id'
         AND company_name='$company_safe'"
    );

    if ($update) {
        echo "<script>
                alert('Application Accepted & Interview details sent successfully!');
                window.location='comapplication.php';
              </script>";
        exit();
    } else {
        die("Database Error: " . mysqli_error($conn));
    }
}
// ==========================================
// REJECT APPLICATION
// ==========================================
if (isset($_GET['status']) && isset($_GET['id'])) {

    $id = intval($_GET['id']);
    $status = $_GET['status'];

    if ($status != "Rejected") {
        die("Invalid Status");
    }
    $company_safe = mysqli_real_escape_string($conn, $company);

    $update = mysqli_query(
        $conn,
        "UPDATE application
         SET status='$status'
         WHERE id='$id'
         AND company_name='$company_safe'"
    );

    if ($update) {
        echo "<script>
                alert('Application Rejected successfully!');
                window.location='comapplication.php';
              </script>";
        exit();
    } else {
        die("Database Error: " . mysqli_error($conn));
    }
}
// =========================================
// GET COMPANY APPLICATIONS
// ==========================================
$company_safe = mysqli_real_escape_string($conn, $company);

$sql = "SELECT
            application.*,
            registration.Name,
            registration.Email,
            comadd_job.job_title
        FROM application
        INNER JOIN registration
        ON application.user_id = registration.Id
        INNER JOIN comadd_job
        ON application.job_id = comadd_job.id
        WHERE application.company_name='$company_safe'
        ORDER BY application.id DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
// ==========================================
// SIDEBAR
// ==========================================
include 'sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Candidate Applications | TalentFlex</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* =========================================
   PAGE
========================================== */
body {
    margin: 0;
    background: #f4f5f7;
    font-family: Arial, Helvetica, sans-serif;
    color: #172033;
}
/* ==========================================
   MAIN CONTENT
========================================== */

.application-wrapper {
    margin-left: 260px;
    padding: 25px 28px 40px 28px;
    min-height: 100vh;
}
/* ==========================================
   TOP TITLE
========================================== */

.page-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
}

.page-title h2 {
    margin: 0;
    font-size: 25px;
    font-weight: 700;
    color: #172033;
}

.page-title p {
    margin: 5px 0 0;
    color: #7b8494;
    font-size: 14px;
}
/* ==========================================
   APPLICATION BOX
========================================== */

.application-box {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(0,0,0,.07);
    overflow: hidden;
}
/* ==========================================
   TABLE
========================================== */

.application-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin: 0;
}

.application-table thead th {
    background: #090f1b;
    color: #ffffff;
    border: none;
    padding: 18px 16px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .3px;
    vertical-align: middle;
}

.application-table thead th:first-child {
    border-top-left-radius: 15px;
}

.application-table thead th:last-child {
    border-top-right-radius: 15px;
}

.application-table tbody tr {
    background: #ffffff;
    transition: .2s;
}

.application-table tbody tr:hover {
    background: #fafbfc;
}

.application-table tbody td {
    padding: 17px 16px;
    border-bottom: 1px solid #e7e9ee;
    vertical-align: middle;
    font-size: 13px;
}

.application-table tbody tr:last-child td {
    border-bottom: none;
}
/* ==========================================
   CANDIDATE INFO
========================================== */
.candidate-name {
    font-size: 15px;
    font-weight: 700;
    color: #172033;
    margin-bottom: 6px;
}

.candidate-email {
    font-size: 12px;
    color: #6c7483;
    margin-bottom: 5px;
    word-break: break-word;
}

.candidate-phone {
    font-size: 12px;
    color: #697386;
}

.email-icon {
    color: #1261d8;
    margin-right: 5px;
}

.phone-icon {
    color: #168b58;
    margin-right: 5px;
}
/* ==========================================
   POSITION
========================================== */

.position-badge {
    display: inline-block;
    padding: 6px 11px;
    background: #f0f1f4;
    border-radius: 7px;
    color: #3c4350;
    font-size: 11px;
    font-weight: 600;
}
/* ==========================================
   EDUCATION
========================================== */

.education-main {
    font-weight: 700;
    color: #2b3340;
    font-size: 14px;
}

.education-sub {
    margin-top: 4px;
    color: #6e7684;
    font-size: 12px;
}
/* ==========================================
   SKILLS
========================================== */

.skills-text {
    color: #626b79;
    font-size: 12px;
    max-width: 100px;
    word-break: break-word;
}
/* ==========================================
   RESUME
========================================== */

.resume-btn {
    min-width: 62px;
    height: 66px;
    border: 1px solid #1769e0;
    background: #f8fbff;
    color: #1769e0;
    border-radius: 5px;
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 11px;
    font-weight: 600;
}

.resume-btn:hover {
    background: #1769e0;
    color: white;
}

.resume-icon {
    font-size: 18px;
    margin-bottom: 3px;
}
/* ==========================================
   STATUS
========================================== */

.status-box {
    min-width: 180px;
    padding: 10px 12px;
    background: #effaf4;
    border: 1px solid #a9dfc0;
    border-radius: 8px;
}

.status-label {
    display: inline-block;
    border: 1px solid #81cfa8;
    border-radius: 18px;
    padding: 6px 12px;
    color: #18784d;
    font-size: 11px;
    font-weight: 700;
    background: #f4fff8;
    margin-bottom: 7px;
}

.status-dot {
    width: 7px;
    height: 7px;
    background: #1b9a61;
    border-radius: 50%;
    display: inline-block;
    margin-right: 5px;
}

.status-details {
    color: #4f685a;
    font-size: 11px;
    line-height: 1.6;
}

.pending-status {
    background: #fff8e7;
    border: 1px solid #f1d38a;
    color: #9a6b00;
    padding: 8px 12px;
    border-radius: 18px;
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
}

.rejected-status {
    background: #fff0f0;
    border: 1px solid #efb0b0;
    color: #bd2929;
    padding: 8px 12px;
    border-radius: 18px;
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
}
/* ==========================================
   ACTIONS
========================================== */
.action-area {
    display: flex;
    align-items: center;
    gap: 5px;
}

.shortlist-btn {
    min-width: 77px;
    height: 52px;
    border: none;
    border-radius: 4px;
    background: #087c4c;
    color: white;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
}

.shortlist-btn:hover {
    background: #05633d;
}

.shortlist-icon {
    display: block;
    font-size: 14px;
    margin-bottom: 2px;
}

.reject-btn {
    width: 30px;
    height: 52px;
    border: 1px solid #d73a3a;
    border-radius: 4px;
    background: white;
    color: #d73a3a;
    font-size: 18px;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
}
.reject-btn:hover {
    background: #d73a3a;
    color: white;
}
/* ==========================================
   MODAL
========================================== */

.modal-content {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 15px 45px rgba(0,0,0,.25);
}

.modal-header {
    background: #080f1b;
    color: white;
    border: none;
    padding: 18px 22px;
}

.modal-title {
    font-size: 17px;
    font-weight: 600;
}

.modal-header .btn-close {
    filter: invert(1);
}

.modal-body {
    padding: 25px;
}
.form-label {
    color: #273247;
    font-size: 13px;
    margin-bottom: 7px;
}
.form-control {
    border: 1px solid #d9dee7;
    border-radius: 8px;
    min-height: 46px;
    font-size: 13px;
}
.form-control:focus {
    border-color: #1769e0;
    box-shadow: 0 0 0 3px rgba(23,105,224,.1);
}
.modal-footer {
    border-top: 1px solid #eeeeee;
    padding: 15px 22px;
}
/* ==========================================
   BACK BUTTON
========================================== */

.back-dashboard {
    margin-top: 20px;
    display: inline-block;
    background: #172033;
    color: white;
    text-decoration: none;
    padding: 10px 18px;
    border-radius: 7px;
    font-size: 13px;
}
.back-dashboard:hover {
    background: #080f1b;
    color: white;
}
/* ==========================================
   RESPONSIVE
========================================== */

@media(max-width: 1100px) {

    .application-wrapper {
        margin-left: 230px;
        padding: 20px;
    }

    .application-table {
        min-width: 1100px;
    }

    .application-box {
        overflow-x: auto;
    }
}


/* Remove underline from company sidebar links */
.portal-sidebar-nav a,
.portal-sidebar-nav a:hover,
.portal-sidebar-nav a:focus,
.portal-sidebar-nav a:active {
    text-decoration: none !important;
}

</style></style>
</head>
<body>
<div class="application-wrapper">

    <!-- =====================================
         PAGE TITLE
    ====================================== -->

    <div class="page-title">

        <div>
            <h2>Candidate Applications</h2>

            <p>
                Review and manage applications received for your jobs
            </p>
        </div>
    </div>
    <!-- =====================================
         APPLICATION TABLE
    ====================================== -->

    <div class="application-box">
        <table class="application-table">
            <thead>
                <tr>
                    <th style="width:18%;">
                        Candidate Info
                    </th>

                    <th style="width:13%;">
                        Position
                    </th>

                    <th style="width:12%;">
                        Education<br>&amp; Exp
                    </th>

                    <th style="width:9%;">
                        Skills
                    </th>

                    <th style="width:9%;">
                        Resume
                    </th>

                    <th style="width:20%;">
                        Status
                    </th>

                    <th style="width:13%;">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $status = $row['status'];

        /*
        ---------------------------------------
        GET ACCEPTED INTERVIEW DETAILS
        ---------------------------------------
        */
        $interviewDate = "";
        $interviewTime = "";
        $interviewNote = "";
        if (strpos($status, "Accepted") !== false) {

            if (preg_match('/Date:\s*([^|]+)/', $status, $match)) {
                $interviewDate = trim($match[1]);
            }

            if (preg_match('/Time:\s*([^|]+)/', $status, $match)) {
                $interviewTime = trim($match[1]);
            }

            if (preg_match('/Note:\s*(.*)$/', $status, $match)) {
                $interviewNote = trim($match[1]);
            }
        }
?>
                <tr>
                    <!-- =================================
                         CANDIDATE INFO
                    ================================== -->
                    <td>

                        <div class="candidate-name">
                            <?php
                            echo htmlspecialchars($row['Name']);
                            ?>
                        </div>

                        <div class="candidate-email">
                            <span class="email-icon">✉</span>

                            <?php
                            echo htmlspecialchars($row['Email']);
                            ?>
                        </div>
                        <div class="candidate-phone">
                            <span class="phone-icon">☎</span>
                            <?php
                            if (!empty($row['mobile'])) {

                                echo htmlspecialchars($row['mobile']);

                            } elseif (!empty($row['phone'])) {

                                echo htmlspecialchars($row['phone']);
                            } else {
                                echo "No Phone";
                            }
                            ?>
                        </div>
                    </td>
                    <!-- =================================
                         POSITION
                    ================================== -->
                    <td>
                        <span class="position-badge">
                            <?php
                            echo htmlspecialchars($row['job_title']);
                            ?>
                        </span>
                    </td>
                    <!-- =================================
                         EDUCATION & EXPERIENCE
                    ================================== -->

                    <td>
                        <div class="education-main">
                            <?php
                            if (!empty($row['education'])) {

                                echo htmlspecialchars($row['education']);
                            } else {
                                echo "N/A";
                            }
                            ?>
                        </div>
                        <div class="education-sub">
                            <?php
                            if (!empty($row['experience'])) {

                                echo htmlspecialchars($row['experience']);

                            } else {

                                echo "0 Years";
                            }
                            ?>
                        </div>
                    </td>
                    <!-- =================================
                         SKILLS
                    ================================== -->
                    <td>
                        <div class="skills-text">
                            <?php
                            if (!empty($row['skills'])) {

                                echo htmlspecialchars($row['skills']);
                            } else {
                                echo "N/A";
                            }
                            ?>
                        </div>
                    </td>
                    <!-- =================================
                         RESUME
                    ================================== -->
                    <td>
                        <?php
                        if (!empty($row['resume'])) {
                        ?>
                            <a
                                href="../resume/<?php echo htmlspecialchars($row['resume']); ?>"
                                target="_blank"
                                class="resume-btn"
                            >
                                <span class="resume-icon">📄</span>
                                <span>View CV</span>
                            </a>
                        <?php
                        } else {

                            echo '<span class="text-muted">No CV</span>';

                        }
                        ?>
                    </td>
                    <!-- =================================
                         STATUS
                    ================================== -->
                    <td>
<?php
if ($status == "Pending") {
?>
                        <span class="pending-status">
                            ● PENDING
                        </span>
<?php
}
elseif (strpos($status, "Accepted") !== false) {
?>
                        <div class="status-box">
                            <div class="status-label">
                                <span class="status-dot"></span>
                                SHORTLISTED
                            </div>
                            <div class="status-details">
                                <div>
                                    Accepted
                                    <?php
                                    if (!empty($interviewDate)) {
                                        echo " | Date: " .
                                             htmlspecialchars($interviewDate);
                                    }
                                    ?>
                                </div>
                                <?php
                                if (!empty($interviewTime)) {
                                ?>
                                <div>
                                    Time:
                                    <?php
                                    echo htmlspecialchars($interviewTime);
                                    ?>
                                </div>
                                <?php
                                }
                                if (!empty($interviewNote)) {
                                ?>
                                <div>
                                    Note:
                                    <?php
                                    echo htmlspecialchars($interviewNote);
                                    ?>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
<?php
}
elseif ($status == "Rejected") {
?>
                        <span class="rejected-status">
                            ✖ REJECTED
                        </span>
<?php
}
else {
?>
                        <span class="pending-status">
                            <?php
                            echo htmlspecialchars($status);
                            ?>
                        </span>
<?php
}
?>
                    </td>
                    <!-- =================================
                         ACTIONS
                    ================================== -->
                    <td>
<?php
if ($status == "Pending" || strpos($status, "Accepted") !== false) {
?>
                        <div class="action-area">
                            <!-- SHORTLIST BUTTON -->
                            <button
                                type="button"
                                class="shortlist-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#acceptModal<?php echo $row['id']; ?>"
                            >

                                <span class="shortlist-icon">▣</span>
                                Shortlist
                            </button>
                            <!-- REJECT BUTTON -->
                            <a
                                href="comapplication.php?status=Rejected&id=<?php echo $row['id']; ?>"
                                class="reject-btn"
                                onclick="return confirm('Reject this application?');"
                                title="Reject Application">                            
                                ×
                            </a>
                        </div>
                        <!-- =================================
                             INTERVIEW MODAL
                        ================================== -->
                        <div
                            class="modal fade"
                            id="acceptModal<?php echo $row['id']; ?>"
                            tabindex="-1"
                            aria-hidden="true">                        
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <!-- MODAL HEADER -->
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Schedule Interview
                                        </h5>
                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"
                                        ></button>
                                    </div>
                                    <!-- FORM -->
                                    <form method="POST">
                                        <div class="modal-body">
                                            <input
                                                type="hidden"
                                                name="app_id"
                                                value="<?php echo $row['id']; ?>"
                                            >
                                            <!-- CANDIDATE -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    Candidate
                                                </label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    value="<?php echo htmlspecialchars($row['Name']); ?>"
                                                    readonly>                                           
                                            </div>
                                            <!-- DATE -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    Interview Date
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input
                                                    type="date"
                                                    name="interview_date"
                                                    class="form-control"
                                                    required>                                                
                                            </div>
                                            <!-- TIME -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    Interview Time
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input
                                                    type="time"
                                                    name="interview_time"
                                                    class="form-control"
                                                    required>                                             
                                            </div>
                                            <!-- NOTE -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    Venue / Online Meeting Link / Note
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <textarea
                                                    name="company_msg"
                                                    class="form-control"
                                                    rows="4"
                                                    placeholder="e.g. Campus Block C Room 204 or Google Meet link..."
                                                    required
                                                ></textarea>
                                            </div>
                                        </div>
                                        <!-- MODAL FOOTER -->
                                        <div class="modal-footer">
                                            <button
                                                type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal"
                                            >
                                                Close
                                            </button>
                                            <button
                                                type="submit"
                                                name="accept_with_details"
                                                class="btn btn-success">                                       
                                                Send &amp; Accept
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
<?php
}
else {
?>
                        <span class="text-muted fw-semibold">
                            Processed
                        </span>
<?php
}
?>
                    </td>
                </tr>
<?php
    }
}
else {
?>
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            No Applications Found
                        </div>
                    </td>
                </tr>
<?php
}
?>
            </tbody>
        </table>
    </div>
    <!-- BACK DASHBOARD -->
    <a
        href="com_dashboard.php"
        class="back-dashboard"
    >
        ← Back Dashboard
    </a>
</div>
<!-- ==========================================
     BOOTSTRAP JS
========================================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>