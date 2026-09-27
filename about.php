<?php
include("db.php");
include("header.php");
?>

<!-- Banner Section -->
<div style="background: linear-gradient(135deg, #f8fafc 0%, #edf2f9 100%); padding: 60px 0 50px; border-bottom: 1px solid #e2e8f0; text-align: center;">
    <div class="container">
        <span class="badge mb-2" style="background: var(--tf-primary-light); color: var(--tf-primary); font-size: 13px; font-weight: 700; padding: 6px 14px; border-radius: 9999px;">
            About Our Platform
        </span>
        <h1 style="font-size: 40px; font-weight: 800; color: var(--tf-navy); margin-bottom: 12px;">
            Empowering Careers Through TalentFlex
        </h1>
        <p style="color: var(--tf-text-muted); font-size: 17px; max-width: 650px; margin: 0 auto;">
            A centralized digital placement and career ecosystem bridging ambitious students with high-growth enterprise recruiters.
        </p>
    </div>
</div>

<!-- Mission & Vision Section -->
<section style="padding: 80px 0; background: #ffffff;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 col-12">
                <span style="color: var(--tf-primary); font-weight: 700; text-transform: uppercase; font-size: 13.5px; letter-spacing: 1px;">
                    Our Core Mission
                </span>
                <h2 style="font-size: 34px; font-weight: 800; color: var(--tf-navy); margin-top: 8px; margin-bottom: 20px;">
                    Modernizing Campus Recruitment for Higher Education
                </h2>
                <p style="color: var(--tf-text-body); font-size: 16px; line-height: 1.8; margin-bottom: 20px;">
                    TalentFlex was developed to solve the logistical and communication challenges faced by college placement cells, candidates, and visiting recruiters. By replacing fragmented spreadsheets and manual resume sorting with a centralized, data-driven platform, we ensure that every qualified student gets equal access to verified job opportunities.
                </p>
                <p style="color: var(--tf-text-muted); font-size: 15px; line-height: 1.7; margin-bottom: 30px;">
                    Whether you are an engineering fresher seeking your first tech internship, or a corporate talent team looking for certified graduates, TalentFlex streamlines the entire hiring pipeline.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="s.php" class="btn-tf-primary">
                        <i class="fas fa-search me-1"></i> Browse Open Roles
                    </a>
                    <a href="contact.php" class="btn-tf-outline">
                        <i class="fas fa-envelope me-1"></i> Contact Placement Cell
                    </a>
                </div>
            </div>

            <div class="col-lg-6 col-12 text-center">
                <div class="p-3" style="background: #f8fafc; border-radius: var(--tf-radius-lg); border: 1px solid #e2e8f0; display: inline-block;">
                    <img src="devlopers.png" alt="TalentFlex Campus Team" class="img-fluid" style="border-radius: var(--tf-radius); max-height: 400px; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Three Pillars Section -->
<section style="padding: 75px 0; background: #f8fafc; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">
    <div class="container">
        <div class="row justify-content-center text-center mb-50">
            <div class="col-lg-8">
                <span style="color: var(--tf-primary); font-weight: 700; text-transform: uppercase; font-size: 13.5px; letter-spacing: 1px;">
                    Ecosystem Value
                </span>
                <h2 style="font-size: 34px; font-weight: 800; color: var(--tf-navy); margin-top: 8px;">
                    Tailored for Every Stakeholder
                </h2>
            </div>
        </div>

        <div class="row g-4">
            <!-- Candidate Pillar -->
            <div class="col-lg-4 col-md-6">
                <div class="portal-card h-100 p-4">
                    <div style="width: 58px; height: 58px; border-radius: 12px; background: #eff6ff; color: var(--tf-primary); display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 20px;">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4 style="font-size: 20px; font-weight: 700; color: var(--tf-navy); margin-bottom: 12px;">
                        For Students & Alumni
                    </h4>
                    <p style="color: var(--tf-text-muted); font-size: 14.5px; line-height: 1.7; margin: 0;">
                        Build a certified digital resume, discover verified openings categorized by technical skills, apply in one click, and track your selection status in real-time.
                    </p>
                </div>
            </div>

            <!-- Recruiter Pillar -->
            <div class="col-lg-4 col-md-6">
                <div class="portal-card h-100 p-4">
                    <div style="width: 58px; height: 58px; border-radius: 12px; background: #fdf2f8; color: var(--tf-accent); display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 20px;">
                        <i class="fas fa-building"></i>
                    </div>
                    <h4 style="font-size: 20px; font-weight: 700; color: var(--tf-navy); margin-bottom: 12px;">
                        For Corporate Recruiters
                    </h4>
                    <p style="color: var(--tf-text-muted); font-size: 14.5px; line-height: 1.7; margin: 0;">
                        Post internships and full-time jobs easily, screen candidate resumes, schedule interview slots, and communicate directly with applicants.
                    </p>
                </div>
            </div>

            <!-- Placement Cell Pillar -->
            <div class="col-lg-4 col-md-6">
                <div class="portal-card h-100 p-4">
                    <div style="width: 58px; height: 58px; border-radius: 12px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 20px;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4 style="font-size: 20px; font-weight: 700; color: var(--tf-navy); margin-bottom: 12px;">
                        For Placement Cell Admins
                    </h4>
                    <p style="color: var(--tf-text-muted); font-size: 14.5px; line-height: 1.7; margin: 0;">
                        Monitor on-campus hiring drives, supervise company listings, oversee student eligibility, and generate verified placement records.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Placement Drive Metrics -->
<section style="padding: 70px 0; background: #ffffff;">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-3 col-6">
                <h2 style="font-size: 40px; font-weight: 800; color: var(--tf-primary); margin-bottom: 6px;">94%</h2>
                <p style="color: var(--tf-text-muted); font-weight: 600; text-transform: uppercase; font-size: 13.5px; margin: 0;">Eligible Students Placed</p>
            </div>
            <div class="col-md-3 col-6">
                <h2 style="font-size: 40px; font-weight: 800; color: var(--tf-accent); margin-bottom: 6px;">50+</h2>
                <p style="color: var(--tf-text-muted); font-weight: 600; text-transform: uppercase; font-size: 13.5px; margin: 0;">Corporate Partners</p>
            </div>
            <div class="col-md-3 col-6">
                <h2 style="font-size: 40px; font-weight: 800; color: #10b981; margin-bottom: 6px;">12+ LPA</h2>
                <p style="color: var(--tf-text-muted); font-weight: 600; text-transform: uppercase; font-size: 13.5px; margin: 0;">Highest Package</p>
            </div>
            <div class="col-md-3 col-6">
                <h2 style="font-size: 40px; font-weight: 800; color: var(--tf-navy); margin-bottom: 6px;">100%</h2>
                <p style="color: var(--tf-text-muted); font-weight: 600; text-transform: uppercase; font-size: 13.5px; margin: 0;">Verified Job Postings</p>
            </div>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>