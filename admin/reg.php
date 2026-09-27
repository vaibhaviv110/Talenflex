<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: ../login1.php");
    exit();
}

// Handle Delete User
if (isset($_GET['delete_id'])) {
    $del_id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM registration WHERE id='$del_id'");
    echo "<script>
            alert('User account removed successfully.');
            window.location='reg.php';
          </script>";
    exit();
}

$sql = "SELECT * FROM registration ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$total_users = ($result) ? mysqli_num_rows($result) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Candidates & Admins | TalentFlex</title>
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
        <!-- Dashboard Topbar Glass -->
        <div class="dashboard-topbar-glass d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 4px;">
                    Registered User Accounts
                </h2>
                <p style="color: var(--tf-text-muted); font-size: 14px; margin: 0;">
                    Directory of registered students, candidates, and administrative accounts.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <!-- Instant Live Filter Search -->
                <div class="admin-table-filter">
                    <i class="fas fa-search text-muted"></i>
                    <input type="text" id="userSearchInput" onkeyup="filterUserTable()" placeholder="Search user name, email, city, role...">
                </div>
                <span class="user-badge-nav-admin ms-1">
                    <i class="fas fa-users text-primary"></i> <?php echo $total_users; ?> Users
                </span>
            </div>
        </div>

        <?php if ($total_users > 0) { ?>
            <div class="table-portal-card">
                <div class="table-responsive">
                    <table class="table-portal" id="usersTable">
                        <thead>
                            <tr>
                                <th>UID</th>
                                <th>Candidate Name</th>
                                <th>Email Address</th>
                                <th>Contact Phone</th>
                                <th>Gender</th>
                                <th>City Location</th>
                                <th>Role Type</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><strong>#<?php echo $row['id']; ?></strong></td>
                                    <td>
                                        <strong style="color: var(--tf-navy); font-size: 15px;">
                                            <i class="fas fa-user-circle text-primary me-1"></i>
                                            <?php echo htmlspecialchars($row['Name']); ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <a href="mailto:<?php echo htmlspecialchars($row['Email']); ?>" class="text-primary text-decoration-none fw-semibold">
                                            <i class="fas fa-envelope text-muted me-1"></i><?php echo htmlspecialchars($row['Email']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            <i class="fas fa-phone text-muted me-1"></i><?php echo htmlspecialchars($row['PhoneNumber'] ?: 'Not Provided'); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-capitalize badge bg-light text-dark border"><?php echo htmlspecialchars($row['gender'] ?: '-'); ?></span>
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                        <?php echo htmlspecialchars($row['city'] ?: '-'); ?>
                                    </td>
                                    <td>
                                        <?php if ($row['u_type'] == 'admin') { ?>
                                            <span class="badge bg-danger rounded-pill px-3 py-1">Admin</span>
                                        <?php } else { ?>
                                            <span class="badge bg-primary rounded-pill px-3 py-1">Candidate</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-end">
                                        <?php if ($row['u_type'] != 'admin') { ?>
                                            <a href="reg.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Permanently remove this candidate account?')" title="Delete User">
                                                <i class="fas fa-trash-alt me-1"></i> Delete
                                            </a>
                                        <?php } else { ?>
                                            <span class="badge bg-light text-muted border rounded-pill px-3 py-1">Protected</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="portal-card-glass text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h4 style="font-weight: 700; color: var(--tf-navy);">No Users Registered</h4>
                <p class="text-muted mb-0">No records found in registration table.</p>
            </div>
        <?php } ?>
    </div>

    <!-- Filter JS Script -->
    <script>
    function filterUserTable() {
        var input = document.getElementById("userSearchInput");
        var filter = input.value.toLowerCase();
        var table = document.getElementById("usersTable");
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