<?php
include "db.php";
session_start();

$error_msg = "";
$success_msg = "";

if (isset($_POST['btn1'])) {
    $nm1 = mysqli_real_escape_string($conn, trim($_POST['nm1'] ?? ''));
    $mail = mysqli_real_escape_string($conn, trim($_POST['mail'] ?? ''));
    $pwd = mysqli_real_escape_string($conn, trim($_POST['pwd'] ?? ''));
    $number = mysqli_real_escape_string($conn, trim($_POST['num'] ?? ''));
    $gender = mysqli_real_escape_string($conn, trim($_POST['gender'] ?? ''));
    $city = mysqli_real_escape_string($conn, trim($_POST['city'] ?? ''));
    $u_type = 'user';

    // Check if email exists
    $check_email = mysqli_query($conn, "SELECT id FROM registration WHERE Email='$mail'");
    if ($check_email && mysqli_num_rows($check_email) > 0) {
        $error_msg = "This email is already registered. Please sign in or use another email.";
    } else {
        $qry = "INSERT INTO registration
                (Name, Email, Password, PhoneNumber, gender, city, u_type)
                VALUES
                ('$nm1', '$mail', '$pwd', '$number', '$gender', '$city', '$u_type')";

        if (mysqli_query($conn, $qry)) {
            echo "<script>
                    alert('Registration Successful! Please sign in to your new account.');
                    window.location.href='login1.php';
                  </script>";
            exit();
        } else {
            $error_msg = "Registration failed: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Registration | TalentFlex</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

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
            max-width: 640px;
            background: #ffffff;
            padding: 36px 32px 30px;
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
        <a href="index.php" class="back-home">
            <i class="bi bi-arrow-left"></i> Return to Homepage
        </a>

        <!-- Portal Role Selector -->
        <div class="role-switch-pills">
            <a href="r.php" class="active"><i class="bi bi-person-fill"></i> Candidate Registration</a>
            <a href="company/com.php"><i class="bi bi-building"></i> Company Registration</a>
        </div>

        <h1 class="reg-title">Create Candidate Account</h1>
        <p class="reg-subtitle">Join TalentFlex to apply for verified campus & corporate roles</p>

        <?php if (!empty($error_msg)) { ?>
            <div class="alert alert-danger py-2 px-3 mb-3 d-flex align-items-center" style="font-size: 13.5px;">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-6"></i>
                <div><?php echo $error_msg; ?></div>
            </div>
        <?php } ?>

        <form method="POST">
            <div class="row g-3">
                <!-- Name -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="nm1" class="form-control" placeholder="John Doe" required>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="mail" class="form-control" placeholder="name@example.com" required>
                    </div>
                </div>

                <!-- Phone -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="tel" name="num" class="form-control" placeholder="10-digit number" required>
                    </div>
                </div>

                <!-- Password -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password" name="pwd" class="form-control" placeholder="Choose strong password" required>
                        <span class="input-group-text" style="cursor: pointer; border-right: none; border-left: 1px solid #e2e8f0; background: #ffffff;" onclick="togglePassword()">
                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                <!-- Gender -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                        <select name="gender" class="form-select" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <!-- City -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Current City <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                        <select name="city" class="form-select" required>
                            <option value="">Select City</option>
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
                    <button type="submit" name="btn1" class="register-btn">
                        <i class="bi bi-check2-circle me-1"></i> Register Account
                    </button>
                </div>
            </div>

            <div class="text-center mt-3 pt-3 border-top" style="font-size: 14px; color: #64748b;">
                Already have an account?
                <a href="login1.php" style="color: #2563eb; font-weight: 700; text-decoration: none;">
                    Sign in here
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