<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- FontAwesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/portal-custom.css">

<!-- Mobile Header Strip -->
<div class="d-lg-none d-flex align-items-center justify-content-between p-3 bg-dark text-white w-100" style="position: sticky; top: 0; z-index: 1050;">
    <div class="d-flex align-items-center gap-2">
        <span style="font-size: 18px; font-weight: 800; color: #fff;">Talent<span style="color: #ed2680;">Flex</span></span>
        <small class="badge bg-primary">Recruiter</small>
    </div>
    <button type="button" class="sidebar-mobile-toggle" onclick="toggleCompanySidebar()">
        <i class="fas fa-bars"></i>
    </button>
</div>

<!-- Company Sidebar Navigation -->
<aside class="portal-sidebar" id="companySidebar">
    <div class="portal-sidebar-header">
        <div class="portal-sidebar-brand">
            <span>🏢</span> Talent<span style="color: var(--tf-accent);">Flex</span>
        </div>
        <button type="button" class="d-lg-none btn btn-sm text-white" onclick="toggleCompanySidebar()">
            <i class="fas fa-times fs-5"></i>
        </button>
    </div>

    <?php if (isset($_SESSION['company_name'])) { ?>
        <div class="p-3 mx-3 mt-3 rounded" style="background: #1e293b; border: 1px solid #334155;">
            <small class="text-muted d-block text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Logged in Employer</small>
            <strong class="text-white text-truncate d-block" style="font-size: 14px;">
                <i class="fas fa-building text-primary me-1"></i> <?php echo htmlspecialchars($_SESSION['company_name']); ?>
            </strong>
        </div>
    <?php } ?>

    <ul class="portal-sidebar-nav">
        <li class="<?php echo ($current_page == 'com_dashboard.php') ? 'active' : ''; ?>">
            <a href="com_dashboard.php">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
        </li>
        <li class="<?php echo ($current_page == 'comadd_job.php') ? 'active' : ''; ?>">
            <a href="comadd_job.php">
                <i class="fas fa-plus-circle"></i> Post New Job
            </a>
        </li>
        <li class="<?php echo ($current_page == 'commy_job.php' || $current_page == 'view.php' || $current_page == 'edit.php') ? 'active' : ''; ?>">
            <a href="commy_job.php">
                <i class="fas fa-briefcase"></i> Manage Jobs
            </a>
        </li>
        <li class="<?php echo ($current_page == 'comapplication.php') ? 'active' : ''; ?>">
            <a href="comapplication.php">
                <i class="fas fa-users-cog"></i> Applications
            </a>
        </li>
        <li class="<?php echo ($current_page == 'com_messages.php') ? 'active' : ''; ?>">
            <a href="com_messages.php">
                <i class="fas fa-envelope-open-text"></i> Inquiries & Messages
            </a>
        </li>
        <li class="mt-3 pt-3 border-top border-secondary">
            <a href="../index.php" target="_blank">
                <i class="fas fa-globe"></i> View Public Portal
            </a>
        </li>
        <li>
            <a href="com_logout.php" style="color: #f87171;">
                <i class="fas fa-sign-out-alt"></i> Sign Out
            </a>
        </li>
    </ul>

    <div class="portal-sidebar-footer">
        TalentFlex Recruiter Hub v2.0
    </div>
</aside>

<script>
function toggleCompanySidebar() {
    var sidebar = document.getElementById('companySidebar');
    if (sidebar) {
        sidebar.classList.toggle('show');
    }
}
</script>