<?php
include("db.php");
include("header.php");

$skill = trim($_GET['skill'] ?? '');
$location = trim($_GET['location'] ?? '');

$sql = "SELECT * FROM comadd_job WHERE 1";

if ($skill !== '') {
    $skill_safe = mysqli_real_escape_string($conn, $skill);

    if (strtolower($skill) == 'web') {
        $sql .= " AND (job_title LIKE '%Web%' OR job_title LIKE '%PHP%')";
    } elseif (strtolower($skill) == 'engineering') {
        $sql .= " AND (job_title LIKE '%Engineering%' OR job_title LIKE '%Mechanical%')";
    } else {
        $sql .= " AND (
            job_title LIKE '%$skill_safe%'
            OR job_type LIKE '%$skill_safe%'
            OR description LIKE '%$skill_safe%'
        )";
    }
}

if ($location !== '') {
    $loc_safe = mysqli_real_escape_string($conn, $location);
    $sql .= " AND (location LIKE '%$loc_safe%')";
}

$sql .= " ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$total_found = ($result) ? mysqli_num_rows($result) : 0;
?>

<!-- Banner Section -->
<div style="background: linear-gradient(135deg, #f8fafc 0%, #edf2f9 100%); padding: 50px 0 45px; border-bottom: 1px solid #e2e8f0; text-align: center;">
    <div class="container">
        <span class="badge mb-2" style="background: var(--tf-primary-light); color: var(--tf-primary); font-size: 13px; font-weight: 700; padding: 6px 14px; border-radius: 9999px;">
            Category Browse
        </span>
        <h1 style="font-size: 36px; font-weight: 800; color: var(--tf-navy); margin-bottom: 10px;">
            <?php echo !empty($skill) ? htmlspecialchars($skill) . " Jobs" : "Available Positions"; ?>
        </h1>
        <p style="color: var(--tf-text-muted); font-size: 16px; margin: 0 auto; max-width: 600px;">
            Showing <?php echo $total_found; ?> verified opening<?php echo ($total_found != 1) ? 's' : ''; ?> currently accepting applications.
        </p>
    </div>
</div>

<div class="container my-5">
    <!-- Filter Strip -->
    <div class="d-flex flex-md-row flex-column justify-content-between align-items-md-center align-items-start mb-30 pb-3 border-bottom">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="text-muted fs-6">Filtered by:</span>
            <?php if (!empty($skill)) { ?>
                <span class="badge bg-light text-dark border px-3 py-2">
                    Skill: <strong><?php echo htmlspecialchars($skill); ?></strong>
                </span>
            <?php } ?>
            <?php if (!empty($location)) { ?>
                <span class="badge bg-light text-dark border px-3 py-2">
                    Location: <strong><?php echo htmlspecialchars($location); ?></strong>
                </span>
            <?php } ?>
            <a href="s.php" class="btn btn-sm btn-link text-primary text-decoration-none">
                <i class="fas fa-sliders-h"></i> Advanced Search
            </a>
        </div>
        <div class="mt-md-0 mt-3">
            <a href="s.php" class="btn-tf-outline" style="padding: 7px 18px; font-size: 13.5px;">
                <i class="fas fa-list"></i> View All Categories
            </a>
        </div>
    </div>

    <!-- Job Cards Grid -->
    <div class="job-cards-grid">
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <div class="job-card-modern">
                    <div>
                        <div class="company-badge">
                            <i class="fas fa-building text-primary"></i>
                            <?php echo htmlspecialchars($row['com_name'] ?? 'Company'); ?>
                        </div>
                        <h3 class="job-title">
                            <a href="job_details.php?id=<?php echo $row['id']; ?>">
                                <?php echo htmlspecialchars($row['job_title']); ?>
                            </a>
                        </h3>
                        <div class="job-meta-pills">
                            <span class="pill-meta pill-type">
                                <i class="fas fa-briefcase"></i> <?php echo htmlspecialchars($row['job_type']); ?>
                            </span>
                            <span class="pill-meta pill-loc">
                                <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location']); ?>
                            </span>
                            <?php if (!empty($row['salary'])) { ?>
                                <span class="pill-meta pill-salary">
                                    <i class="fas fa-rupee-sign"></i> <?php echo number_format($row['salary']); ?> / mo
                                </span>
                            <?php } ?>
                        </div>
                        <p style="font-size: 14px; color: var(--tf-text-muted); line-height: 1.5; margin-bottom: 20px;">
                            <?php echo htmlspecialchars(mb_strimwidth($row['description'], 0, 120, "...")); ?>
                        </p>
                    </div>

                    <div class="job-card-actions">
                        <a href="job_details.php?id=<?php echo $row['id']; ?>" class="btn-tf-outline" style="padding: 7px 16px; font-size: 13.5px;">
                            <i class="fas fa-info-circle"></i> Details
                        </a>
                        <a href="apply.php?id=<?php echo $row['id']; ?>" class="btn-tf-primary" style="padding: 8px 20px; font-size: 13.5px;">
                            Apply Now
                        </a>
                    </div>
                </div>
        <?php
            }
        } else {
        ?>
            <div class="col-12 w-100">
                <div class="empty-state-card">
                    <div class="empty-state-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3 class="empty-state-title">No Openings in this Category</h3>
                    <p class="empty-state-text">
                        There are currently no active vacancies matching "<?php echo htmlspecialchars($skill); ?>". Check our full job listings for related opportunities.
                    </p>
                    <a href="s.php" class="btn-tf-primary">
                        <i class="fas fa-search"></i> Browse All Openings
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include("footer.php"); ?>
