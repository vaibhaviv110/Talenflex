<?php
include("db.php");
include("header.php");

$skill = isset($_GET['skill']) ? trim($_GET['skill']) : '';
$location = isset($_GET['location']) ? trim($_GET['location']) : '';

// Build Search Query
$sql = "SELECT * FROM comadd_job WHERE 1";
$conditions = [];

if ($skill !== '') {
    $skill_safe = mysqli_real_escape_string($conn, $skill);
    $words = explode(" ", $skill_safe);
    $skill_conditions = [];

    foreach ($words as $word) {
        $word = trim($word);
        if ($word !== '') {
            $skill_conditions[] = "(job_title LIKE '%$word%' OR job_type LIKE '%$word%' OR description LIKE '%$word%')";
        }
    }

    if (!empty($skill_conditions)) {
        $sql .= " AND (" . implode(" AND ", $skill_conditions) . ")";
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

<!-- Page Banner -->
<div style="background: linear-gradient(135deg, #f8fafc 0%, #edf2f9 100%); padding: 50px 0 45px; border-bottom: 1px solid #e2e8f0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 38px; font-weight: 800; color: var(--tf-navy); margin-bottom: 10px;">
            Find Your Dream Job
        </h1>
        <p style="color: var(--tf-text-muted); font-size: 16px; max-width: 600px; margin: 0 auto;">
            Search hundreds of verified campus and corporate openings from top hiring partners.
        </p>
    </div>
</div>

<div class="container my-5">
    <!-- Responsive Modern Search Box -->
    <div class="portal-search-wrapper">
        <form action="s.php" method="GET" class="portal-search-form">
            <!-- Skill Input with Dropdown -->
            <div class="portal-search-field">
                <i class="fas fa-search search-icon"></i>
                <input
                    type="text"
                    id="skillInput"
                    name="skill"
                    placeholder="Enter skills or job title (e.g. PHP, UI/UX, Data Science)"
                    value="<?php echo htmlspecialchars($skill); ?>"
                    autocomplete="off"
                    onfocus="showSkillList()"
                    onkeyup="filterSkills()"
                >
                <div id="skillList" class="search-suggest-dropdown">
                    <div onclick="selectSkill('Web Developer')"><i class="fas fa-code me-2 text-primary"></i> Web Developer</div>
                    <div onclick="selectSkill('PHP Developer')"><i class="fab fa-php me-2 text-primary"></i> PHP Developer</div>
                    <div onclick="selectSkill('UI/UX Designer')"><i class="fas fa-paint-brush me-2 text-primary"></i> UI/UX Designer</div>
                    <div onclick="selectSkill('Data Science')"><i class="fas fa-chart-bar me-2 text-primary"></i> Data Science</div>
                    <div onclick="selectSkill('Cyber Security')"><i class="fas fa-shield-alt me-2 text-primary"></i> Cyber Security</div>
                    <div onclick="selectSkill('Software Engineer')"><i class="fas fa-laptop-code me-2 text-primary"></i> Software Engineer</div>
                    <div onclick="selectSkill('AI/LLM Engineer')"><i class="fas fa-robot me-2 text-primary"></i> AI/LLM Engineer</div>
                    <div onclick="selectSkill('Digital Marketing')"><i class="fas fa-bullhorn me-2 text-primary"></i> Digital Marketing</div>
                    <div onclick="selectSkill('Mechanical Engineering')"><i class="fas fa-cogs me-2 text-primary"></i> Mechanical Engineering</div>
                </div>
            </div>

            <!-- Location Input with Dropdown -->
            <div class="portal-search-field">
                <i class="fas fa-map-marker-alt search-icon"></i>
                <input
                    type="text"
                    id="locationInput"
                    name="location"
                    placeholder="City or location (e.g. Surat, Ahmedabad, Pune)"
                    value="<?php echo htmlspecialchars($location); ?>"
                    autocomplete="off"
                    onfocus="showLocationList()"
                    onkeyup="filterLocations()"
                >
                <div id="locationList" class="search-suggest-dropdown">
                    <?php
                    $city_q = mysqli_query($conn, "SELECT c_name FROM city ORDER BY c_name ASC");
                    if ($city_q) {
                        while ($c = mysqli_fetch_assoc($city_q)) {
                            echo '<div onclick="selectLocation(\'' . htmlspecialchars($c['c_name'], ENT_QUOTES) . '\')"><i class="fas fa-map-pin me-2 text-muted"></i> ' . htmlspecialchars($c['c_name']) . '</div>';
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- Search Button -->
            <button type="submit" class="portal-search-btn">
                <i class="fas fa-search"></i> Search Jobs
            </button>
        </form>
    </div>

    <!-- Active Filter Strip & Results Header -->
    <div class="d-flex flex-md-row flex-column justify-content-between align-items-md-center align-items-start mb-30 pb-3 border-bottom">
        <div>
            <h3 style="font-size: 22px; font-weight: 700; color: var(--tf-navy); margin: 0;">
                <?php if ($skill !== '' || $location !== '') { ?>
                    Search Results <span class="text-muted fw-normal fs-6">(<?php echo $total_found; ?> jobs found)</span>
                <?php } else { ?>
                    All Available Jobs <span class="text-muted fw-normal fs-6">(<?php echo $total_found; ?> total openings)</span>
                <?php } ?>
            </h3>
            <?php if ($skill !== '' || $location !== '') { ?>
                <div class="mt-2 d-flex flex-wrap gap-2 align-items-center">
                    <span class="text-muted fs-6">Filters:</span>
                    <?php if ($skill !== '') { ?>
                        <span class="badge bg-light text-dark border px-3 py-2">
                            Keyword: <strong><?php echo htmlspecialchars($skill); ?></strong>
                        </span>
                    <?php } ?>
                    <?php if ($location !== '') { ?>
                        <span class="badge bg-light text-dark border px-3 py-2">
                            Location: <strong><?php echo htmlspecialchars($location); ?></strong>
                        </span>
                    <?php } ?>
                    <a href="s.php" class="btn btn-sm btn-link text-danger text-decoration-none">
                        <i class="fas fa-times"></i> Clear Filters
                    </a>
                </div>
            <?php } ?>
        </div>

        <div class="mt-md-0 mt-3">
            <span class="text-muted fs-6">Sorted by: <strong>Latest First</strong></span>
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
                            <i class="fas fa-info-circle"></i> View Details
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
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="empty-state-title">No Matching Jobs Found</h3>
                    <p class="empty-state-text">
                        We couldn't find any job postings matching your current search criteria. Try using different keywords or clearing your filters.
                    </p>
                    <a href="s.php" class="btn-tf-primary">
                        <i class="fas fa-redo"></i> Reset All Filters
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Autocomplete & Filter Script -->
<script>
function showSkillList() {
    document.getElementById('skillList').style.display = 'block';
}

function selectSkill(val) {
    document.getElementById('skillInput').value = val;
    document.getElementById('skillList').style.display = 'none';
}

function filterSkills() {
    var input = document.getElementById('skillInput').value.toLowerCase();
    var list = document.getElementById('skillList');
    var items = list.getElementsByTagName('div');
    var count = 0;
    for (var i = 0; i < items.length; i++) {
        var text = items[i].innerText.toLowerCase();
        if (text.indexOf(input) > -1) {
            items[i].style.display = '';
            count++;
        } else {
            items[i].style.display = 'none';
        }
    }
    list.style.display = count > 0 ? 'block' : 'none';
}

function showLocationList() {
    document.getElementById('locationList').style.display = 'block';
}

function selectLocation(val) {
    document.getElementById('locationInput').value = val;
    document.getElementById('locationList').style.display = 'none';
}

function filterLocations() {
    var input = document.getElementById('locationInput').value.toLowerCase();
    var list = document.getElementById('locationList');
    var items = list.getElementsByTagName('div');
    var count = 0;
    for (var i = 0; i < items.length; i++) {
        var text = items[i].innerText.toLowerCase();
        if (text.indexOf(input) > -1) {
            items[i].style.display = '';
            count++;
        } else {
            items[i].style.display = 'none';
        }
    }
    list.style.display = count > 0 ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
    var skillInput = document.getElementById('skillInput');
    var skillList = document.getElementById('skillList');
    var locInput = document.getElementById('locationInput');
    var locList = document.getElementById('locationList');

    if (skillInput && skillList && !skillInput.contains(e.target) && !skillList.contains(e.target)) {
        skillList.style.display = 'none';
    }
    if (locInput && locList && !locInput.contains(e.target) && !locList.contains(e.target)) {
        locList.style.display = 'none';
    }
});
</script>

<?php include("footer.php"); ?>