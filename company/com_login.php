<?php
session_start();
include("db.php");

$error_msg = "";

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
    $password = mysqli_real_escape_string($conn, trim($_POST['password'] ?? ''));

    $sql = "SELECT * FROM companyreg WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['company_id'] = $row['cid'] ?? $row['id'];
        $_SESSION['company_name'] = $row['name'];
        $_SESSION['email'] = $row['email'];

        header("Location: com_dashboard.php");
        exit();
    } else {
        $error_msg = "Invalid employer email or password. Please verify credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Login | TalentFlex</title>
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
            padding: 24px 16px;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            padding: 38px 32px 30px;
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
            margin-bottom: 20px;
            transition: all 0.2s;
        }

        .back-home:hover {
            color: #2563eb;
            transform: translateX(-3px);
        }

        .login-icon {
            width: 58px;
            height: 58px;
            margin: 0 auto 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            background: #eff6ff;
            border: 2px solid #bfdbfe;
            font-size: 24px;
        }

        .login-title {
            text-align: center;
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .login-subtitle {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            margin-bottom: 24px;
        }

        .input-group {
            height: 48px;
            margin-bottom: 18px;
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
            width: 48px;
            justify-content: center;
            background: #f8fafc;
            border: none;
            border-right: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 17px;
        }

        .form-control {
            border: none;
            box-shadow: none !important;
            color: #0f172a;
            font-size: 14.5px;
            padding-left: 14px;
            font-family: inherit;
        }

        .login-btn {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 10px;
            background: #2563eb;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            transition: 0.25s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .login-btn:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.3);
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
            padding: 7px 10px;
            font-size: 12.5px;
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
    </style>
</head>

<body>
    <div class="login-card">
        <a href="../index.php" class="back-home">
            <i class="bi bi-arrow-left"></i> Return to Homepage
        </a>

        <!-- Portal Role Selector -->
        <div class="role-switch-pills">
            <a href="../login1.php">Candidate</a>
            <a href="com_login.php" class="active">Employer</a>
            <a href="../admin/dashboard.php">Admin</a>
        </div>

        <div class="login-icon">
            <i class="bi bi-building"></i>
        </div>

        <h1 class="login-title">Employer Login</h1>
        <p class="login-subtitle">Access your TalentFlex Recruiter Dashboard</p>

        <?php if (!empty($error_msg)) { ?>
            <div class="alert alert-danger py-2 px-3 mb-3 d-flex align-items-center" style="font-size: 13.5px;">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-6"></i>
                <div><?php echo $error_msg; ?></div>
            </div>
        <?php } ?>

        <form method="POST">
            <!-- Email -->
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-envelope"></i>
                </span>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="Work Email Address"
                    required
                >
            </div>

            <!-- Password -->
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-lock"></i>
                </span>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Password"
                    required
                >
                <span
                    class="input-group-text"
                    style="cursor: pointer; border-right: none; border-left: 1px solid #e2e8f0; background: #ffffff;"
                    onclick="togglePassword()"
                >
                    <i class="bi bi-eye-slash" id="eyeIcon"></i>
                </span>
            </div>

            <button type="submit" name="login" class="login-btn mt-2">
                <i class="bi bi-box-arrow-in-right"></i> Sign In to Employer Hub
            </button>

            <div class="text-center mt-4 pt-3 border-top" style="font-size: 14px; color: #64748b;">
                Need an employer account?
                <a href="com.php" style="color: #2563eb; font-weight: 700; text-decoration: none;">
                    Register your company
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