<?php
include "db.php";
session_start();

$error_msg = "";

// ================= COMPANY LOGIN =================
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
    $password = mysqli_real_escape_string($conn, trim($_POST['password'] ?? ''));

    $qry = "SELECT * FROM companyreg WHERE email='$email' AND password='$password'";
    $res = mysqli_query($conn, $qry);
    $user = ($res) ? mysqli_fetch_assoc($res) : null;

    if ($user) {
        $_SESSION['company_name'] = $user['name'];
        $_SESSION['company_id'] = $user['cid'];
        $_SESSION['email'] = $user['email'];

        header("Location: com_dashboard.php");
        exit();
    } else {
        $error_msg = "Invalid employer email or password.";
    }
}

// ================= COMPANY REGISTRATION =================
if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name'] ?? ''));
    $email = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
    $mobile = mysqli_real_escape_string($conn, trim($_POST['mobile'] ?? ''));
    $address = mysqli_real_escape_string($conn, trim($_POST['address'] ?? ''));
    $c_id = intval($_POST['c_id'] ?? 0);
    $industry = mysqli_real_escape_string($conn, trim($_POST['industry'] ?? ''));
    $password = mysqli_real_escape_string($conn, trim($_POST['password'] ?? ''));

    // Check existing company email
    $check_exist = mysqli_query($conn, "SELECT cid FROM companyreg WHERE email='$email'");
    if ($check_exist && mysqli_num_rows($check_exist) > 0) {
        $error_msg = "A company is already registered with this email address.";
    } else {
        $sql = "INSERT INTO companyreg
                (name, email, mobile, address, c_id, industry, password)
                VALUES
                ('$name', '$email', '$mobile', '$address', '$c_id', '$industry', '$password')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Company Registered Successfully! Please sign in with your credentials.');
                    window.location='com_login.php';
                  </script>";
            exit();
        } else {
            $error_msg = "Registration Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Registration | TalentFlex Employer</title>
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico">

    <!-- Bootstrap 5 & Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            color: #0f172a;
            padding: 30px 16px;
        }

        .reg-card {
            width: 100%;
            max-width: 660px;
            background: #ffffff;
            padding: 38px 34px 30px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }

        .back-home {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #64748b;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            margin-bottom: 18px;
            transition: all 0.2s;
        }

        .back-home:hover {
            color: #2563eb;
            transform: translateX(-3px);
        }

        .role-switch-pills {
            display: flex;
            gap: 8px;
            margin-bottom: 22px;
            background: #f1f5f9;
            padding: 4px;
            border-radius: 10px;
        }

        .role-switch-pills a {
            flex: 1;
            text-align: center;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 7px;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s;
        }

        .role-switch-pills a.active {
            background: #ffffff;
            color: #0f172a;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        }

        .reg-title {
            text-align: center;
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .reg-subtitle {
            text-align: center;
            color: #64748b;
            font-size: 14.5px;
            margin-bottom: 24px;
        }

        .form-label {
            font-weight: 600;
            font-size: 13.5px;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .input-group {
            height: 48px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            transition: 0.25s;
            background: #ffffff;
        }

        .input-group:focus-within {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .input-group-text {
            width: 46px;
            justify-content: center;
            background: #f8fafc;
            border: none;
            border-right: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 16px;
        }

        .form-control, .form-select {
            border: none;
            box-shadow: none !important;
            color: #0f172a;
            font-size: 14px;
            padding-left: 12px;
            font-family: inherit;
        }

        .register-btn {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 10px;
            background: #2563eb;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            transition: 0.25s;
            margin-top: 10px;
        }

        .register-btn:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.3);
        }
    </style>
</head>

<body>
    <div class="reg-card">
        <a href="../index.php" class="back-home">
            <i class="bi bi-arrow-left"></i> Return to Homepage
        </a>

        <!-- Portal Role Selector -->
        <div class="role-switch-pills">
            <a href="../r.php"><i class="bi bi-person"></i> Candidate Registration</a>
            <a href="com.php" class="active"><i class="bi bi-building-fill"></i> Company Registration</a>
        </div>

        <h1 class="reg-title">Register Your Company</h1>
        <p class="reg-subtitle">Connect with top university talent and hire qualified graduates</p>

        <?php if (!empty($error_msg)) { ?>
            <div class="alert alert-danger py-2 px-3 mb-3 d-flex align-items-center" style="font-size: 13.5px;">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-6"></i>
                <div><?php echo $error_msg; ?></div>
            </div>
        <?php } ?>

        <form method="POST">
            <div class="row g-3">
                <!-- Company Name -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Company / Enterprise Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-building"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="e.g. TCS, Wipro, Unicorn Tech" required>
                    </div>
                </div>

                <!-- Official Email -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Official Work Email <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="hr@company.com" required>
                    </div>
                </div>

                <!-- Contact Number -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Contact / HR Phone Number <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="tel" name="mobile" class="form-control" placeholder="10-digit number" required>
                    </div>
                </div>

                <!-- Password -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Portal Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Create strong password" required>
                        <span class="input-group-text" style="cursor: pointer; border-right: none; border-left: 1px solid #e2e8f0; background: #ffffff;" onclick="togglePassword()">
                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                <!-- Industry -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Industry Domain <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                        <select name="industry" class="form-select" required>
                            <option value="">-- Select Industry --</option>
                            <option value="Information Technology">Information Technology</option>
                            <option value="Software Development">Software Development</option>
                            <option value="Cyber Security">Cyber Security</option>
                            <option value="Financial Services & Banking">Financial Services & Banking</option>
                            <option value="Manufacturing & Core Engineering">Manufacturing & Core Engineering</option>
                            <option value="Healthcare & Pharma">Healthcare & Pharma</option>
                            <option value="Education & EdTech">Education & EdTech</option>
                            <option value="Digital Marketing & Media">Digital Marketing & Media</option>
                            <option value="Other">Other Domain</option>
                        </select>
                    </div>
                </div>

                <!-- City -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Headquarters / City <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                        <select name="address" class="form-select" required>
                            <option value="">-- Select City --</option>
                            <?php
                            $cities = mysqli_query($conn, "SELECT c_name FROM city ORDER BY c_name ASC");
                            if ($cities) {
                                while ($c = mysqli_fetch_assoc($cities)) {
                                    echo "<option value='" . htmlspecialchars($c['c_name']) . "'>" . htmlspecialchars($c['c_name']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" name="register" class="register-btn">
                        <i class="bi bi-check2-circle me-1"></i> Register Company Account
                    </button>
                </div>
            </div>

            <div class="text-center mt-3 pt-3 border-top" style="font-size: 14px; color: #64748b;">
                Already registered with TalentFlex?
                <a href="com_login.php" style="color: #2563eb; font-weight: 700; text-decoration: none;">
                    Employer Sign In
                </a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            let password = document.getElementById("password");
            let eyeIcon = document.getElementById("eyeIcon");
            if (password.type === "password") {
                password.type = "text";
                eyeIcon.classList.remove("bi-eye-slash");
                eyeIcon.classList.add("bi-eye");
            } else {
                password.type = "password";
                eyeIcon.classList.remove("bi-eye");
                eyeIcon.classList.add("bi-eye-slash");
            }
        }
    </script>
</body>
</html>