<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: ../login1.php");
    exit();
}

// Handle Admin Delete Company
if (isset($_GET['delete_cid'])) {
    $del_cid = intval($_GET['delete_cid']);
    mysqli_query($conn, "DELETE FROM companyreg WHERE cid='$del_cid'");
    echo "<script>
            alert('Company record removed successfully.');
            window.location='admin_viewcompany.php';
          </script>";
    exit();
}

$sql = "SELECT cid, name, email, mobile, address, industry FROM companyreg ORDER BY cid DESC";
$result = mysqli_query($conn, $sql);
$total_comps = ($result) ? mysqli_num_rows($result) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Companies | TalentFlex Admin</title>
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
        <!-- Dashboard Glass Topbar -->
        <div class="dashboard-topbar-glass d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 4px;">
                    Registered Corporate Partners
                </h2>
                <p style="color: var(--tf-text-muted); font-size: 14px; margin: 0;">
                    Directory of verified enterprise employers and campus recruitment partners.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <!-- Instant Live Filter Search -->
                <div class="admin-table-filter">
                    <i class="fas fa-search text-muted"></i>
                    <input type="text" id="compSearchInput" onkeyup="filterCompanyTable()" placeholder="Search company name, email, industry...">
                </div>
                <span class="user-badge-nav-admin ms-1">
                    <i class="fas fa-building text-primary"></i> <?php echo $total_comps; ?> Companies
                </span>
            </div>
        </div>

        <?php if ($total_comps > 0) { ?>
            <div class="table-portal-card">
                <div class="table-responsive">
                    <table class="table-portal" id="companyTable">
                        <thead>
                            <tr>
                                <th>CID</th>
                                <th>Company Name</th>
                                <th>Work Email</th>
                                <th>Contact Phone</th>
                                <th>Headquarters</th>
                                <th>Industry Sector</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><strong>#<?php echo $row['cid']; ?></strong></td>
                                    <td>
                                        <strong style="color: var(--tf-navy); font-size: 15px;">
                                            <i class="fas fa-building text-primary me-1"></i>
                                            <?php echo htmlspecialchars($row['name']); ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="text-primary text-decoration-none fw-semibold">
                                            <i class="fas fa-envelope text-muted me-1"></i><?php echo htmlspecialchars($row['email']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            <i class="fas fa-phone text-muted me-1"></i><?php echo htmlspecialchars($row['mobile'] ?: 'Not Provided'); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                        <?php echo htmlspecialchars($row['address'] ?: 'N/A'); ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-primary border border-primary-subtle px-2 py-1 rounded-pill" style="font-size: 11.5px;">
                                            <?php echo htmlspecialchars($row['industry'] ?: 'Information Technology'); ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="admin_viewcompany.php?delete_cid=<?php echo $row['cid']; ?>" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Delete this company account and all related records?')" title="Delete Company">
                                            <i class="fas fa-trash-alt me-1"></i> Remove
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="portal-card-glass text-center py-5">
                <i class="fas fa-building fa-3x text-muted mb-3"></i>
                <h4 style="font-weight: 700; color: var(--tf-navy);">No Companies Registered</h4>
                <p class="text-muted mb-0">No company entries found in the companyreg table.</p>
            </div>
        <?php } ?>
    </div>

    <!-- Filter JS Script -->
    <script>
    function filterCompanyTable() {
        var input = document.getElementById("compSearchInput");
        var filter = input.value.toLowerCase();
        var table = document.getElementById("companyTable");
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