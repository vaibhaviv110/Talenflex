<?php
session_start();
include("db.php");

// Company login check
if (!isset($_SESSION['company_name'])) {
    header("Location: com_login.php");
    exit();
}

$company = $_SESSION['company_name'];
$company_safe = mysqli_real_escape_string($conn, $company);

// Reply submit thay to ahiya handle thase
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reply_message'])) {
    $msg_id = intval($_POST['message_id']);
    $reply_text = mysqli_real_escape_string($conn, $_POST['reply_message']);
    
    // Message ma jodi dida vagar seedhi reply column ma update karo
    $update_sql = "UPDATE contact_messages SET reply = '$reply_text' WHERE id = $msg_id";
    
    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Reply Successfully!'); window.location.href='com_messages.php';</script>";
        exit();
    } else {
        $error_msg = mysqli_error($conn);
    }
}

$sql = "SELECT * FROM contact_messages 
        WHERE company_name = '$company_safe'
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
$total_messages = ($result) ? mysqli_num_rows($result) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Inquiries | TalentFlex Employer</title>
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
                    Candidate Inquiries & Messages
                </h2>
                <p style="color: var(--tf-text-muted); font-size: 14px; margin: 0;">
                    Inquiries submitted by students regarding your job requirements or recruitment drive.
                </p>
            </div>
            <div>
                <span class="badge bg-primary fs-6 px-3 py-2">
                    <?php echo $total_messages; ?> Message<?php echo ($total_messages != 1) ? 's' : ''; ?>
                </span>
            </div>
        </div>

        <?php if ($total_messages > 0) { ?>
            <div class="table-portal-card">
                <div class="table-responsive">
                    <table class="table-portal">
                        <thead>
                            <tr>
                                <th>Candidate Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Sent Date</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            mysqli_data_seek($result, 0);
                            while ($row = mysqli_fetch_assoc($result)) { 
                            ?>
                                <tr>
                                    <td>
                                        <strong style="color: var(--tf-navy);">
                                            <?php echo htmlspecialchars($row['name']); ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="text-primary text-decoration-none">
                                            <?php echo htmlspecialchars($row['email']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <?php echo htmlspecialchars($row['subject']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-size: 14px; color: var(--tf-text-body); white-space: pre-line;">
                                            <?php echo htmlspecialchars($row['message']); ?>
                                        </span>
                                        
                                        <!-- CORRECT PLACE: Reply aayo hase to ahiya table row ni andar j batavse -->
                                        <?php if (!empty($row['reply'])) { ?>
                                            <div style="background: #e6f4ea; border-left: 3px solid #34a853; padding: 8px; margin-top: 8px; border-radius: 4px; font-size: 13px;">
                                                <strong style="color: #137333;"><i class="fas fa-reply me-1"></i> Your Reply:</strong>
                                                <p style="margin: 2px 0 0; color: #202124;"><?php echo htmlspecialchars($row['reply']); ?></p>
                                            </div>
                                        <?php } else { ?>
                                            <div style="margin-top: 6px;">
                                                <span class="badge bg-warning text-dark" style="font-size: 11px;">Not Replied Yet</span>
                                            </div>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo htmlspecialchars($row['created_at']); ?></small>
                                    </td>
                                    <td class="text-end">
                                        <!-- Reply Button -->
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#replyModal<?php echo $row['id']; ?>">
                                            <i class="fas fa-reply me-1"></i> Reply
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modals placed completely outside the table -->
            <?php 
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_assoc($result)) { 
            ?>
                <div class="modal fade" id="replyModal<?php echo $row['id']; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content" style="background-color: #ffffff; color: #000000;">
                            <form action="" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title" style="color: #000000;">Reply to <?php echo htmlspecialchars($row['name']); ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <input type="hidden" name="message_id" value="<?php echo $row['id']; ?>">
                                    <div class="mb-3">
                                        <label class="form-label" style="color: #000000;">Your Reply Message:</label>
                                        <textarea name="reply_message" class="form-control" rows="4" required placeholder="Type your reply here..." style="background-color: #ffffff; color: #000000; border: 1px solid #ced4da;"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Send Reply</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>

        <?php } else { ?>
            <div class="portal-card text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h4 style="font-weight: 700; color: var(--tf-navy);">No Messages Yet</h4>
                <p class="text-muted mb-0">Student inquiries addressed to your company will appear here.</p>
            </div>
        <?php } ?>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>