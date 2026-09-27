<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- FontAwesome & Google Fonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/portal-custom.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.body.classList.add('admin-body');
    });
</script>

<!-- Mobile Header Strip -->
<div class="d-lg-none d-flex align-items-center justify-content-between p-3 text-white w-100" style="position: sticky; top: 0; z-index: 1050; background: #0f172a; border-bottom: 2px solid var(--tf-accent);">
    <div class="d-flex align-items-center gap-2">
        <img src="../assets/img/logo/logo1.png" alt="TalentFlex" style="height:28px; width:auto; filter: brightness(0) invert(1);">
            </div>
    <button type="button" class="sidebar-mobile-toggle" onclick="toggleAdminSidebar()">
        <i class="fas fa-bars"></i>
    </button>
</div>

<!-- Sidebar Overlay for Mobile -->
<div id="adminSidebarOverlay" class="d-lg-none" onclick="toggleAdminSidebar()" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(15,23,42,0.6); backdrop-filter:blur(4px); z-index:999;"></div>

<!-- Admin Sidebar Navigation -->
<aside class="portal-sidebar" id="adminSidebar" style="background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%); border-right: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="portal-sidebar-header" style="border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding: 20px 18px;">
        <a href="dashboard.php" class="portal-sidebar-brand d-flex align-items-center gap-2 text-decoration-none">
            <img src="../assets/img/logo/logo1.png" alt="TalentFlex Logo" style="height:38px; width:auto; filter: brightness(0) invert(1);">
            <span class="badge bg-danger rounded-pill ms-1" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px;">Admin</span>
        </a>
        <button type="button" class="d-lg-none btn btn-sm text-white" onclick="toggleAdminSidebar()">
            <i class="fas fa-times fs-5"></i>
        </button>
    </div>

    <!-- Admin Account Card -->
    <div class="p-3 mx-3 mt-3 rounded-4" style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.12); backdrop-filter: blur(8px);">
        <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 10.5px; letter-spacing: 0.8px; color: #94a3b8 !important;">Portal Administrator</small>
        <strong class="text-white text-truncate d-block mt-1" style="font-size: 14px;">
            <i class="fas fa-shield-alt text-danger me-1"></i> <?php echo htmlspecialchars($_SESSION['admin_name'] ?? $_SESSION['admin_name'] ?? 'Administrator'); ?>
        </strong>
    </div>

    <!-- Navigation Menu -->
    <ul class="portal-sidebar-nav mt-2">
        <li class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
            <a href="dashboard.php">
                <i class="fas fa-chart-line"></i> Dashboard Overview
            </a>
        </li>
        <li class="<?php echo ($current_page == 'admin_viewjob.php') ? 'active' : ''; ?>">
            <a href="admin_viewjob.php">
                <i class="fas fa-briefcase"></i> Posted Jobs
            </a>
        </li>
        <li class="<?php echo ($current_page == 'admin_viewcompany.php') ? 'active' : ''; ?>">
            <a href="admin_viewcompany.php">
                <i class="fas fa-building"></i> Registered Companies
            </a>
        </li>
        <li class="<?php echo ($current_page == 'admin_application.php') ? 'active' : ''; ?>">
            <a href="admin_application.php">
                <i class="fas fa-file-invoice"></i> Candidate Applications
            </a>
        </li>
        <li class="<?php echo ($current_page == 'reg.php') ? 'active' : ''; ?>">
            <a href="reg.php">
                <i class="fas fa-users"></i> Registered Users
            </a>
        </li>
        <li class="mt-3 pt-3" style="border-top: 1px solid rgba(255, 255, 255, 0.1);">
            <a href="../index.php" target="_blank" style="color: #60a5fa;">
                <i class="fas fa-external-link-alt"></i> View User Site <i class="fas fa-arrow-up-right-from-square ms-auto" style="font-size:11px;"></i>
            </a>
        </li>
        <li class="mt-1">
            <a href="adminlogout.php" style="color: #f87171;">
                <i class="fas fa-sign-out-alt"></i> Sign Out
            </a>
        </li>
    </ul>

    <div class="portal-sidebar-footer text-center" style="border-top: 1px solid rgba(255, 255, 255, 0.1); color: #64748b; font-size: 12px; padding: 14px;">
        TalentFlex Suite v2.0
    </div>
</aside>

<script>
function toggleAdminSidebar() {
    var sidebar = document.getElementById('adminSidebar');
    var overlay = document.getElementById('adminSidebarOverlay');
    if (sidebar) {
        sidebar.classList.toggle('show');
        if (overlay) {
            overlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
        }
    }
}
</script>