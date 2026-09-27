<?php
session_start();
include("db.php");

if (!isset($_SESSION['reset_email'])) {
    header("Location: forget.php");
    exit();
}

$email = $_SESSION['reset_email'];
$message = "";
$message_type = "";

if (isset($_POST['reset'])) {
    $password = mysqli_real_escape_string($conn, trim($_POST['password'] ?? ''));
    $confirm_password = mysqli_real_escape_string($conn, trim($_POST['confirm_password'] ?? ''));

    if ($password !== $confirm_password) {
        $message = "Passwords do not match. Please verify and retype.";
        $message_type = "danger";
    } elseif (strlen($password) < 4) {
        $message = "Password must be at least 4 characters long.";
        $message_type = "danger";
    } else {
        $update = mysqli_query($conn, "UPDATE registration SET Password='$password' WHERE Email='$email'");

        if ($update) {
            unset($_SESSION['reset_email']);
            echo "<script>
                    alert('Password has been updated successfully! Please login with your new password.');
                    window.location.href = 'login1.php';
                  </script>";
            exit();
        } else {
            $message = "Database Error: " . mysqli_error($conn);
            $message_type = "danger";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password | TalentFlex</title>
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
            padding: 24px 16px;
        }

        .auth-card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            padding: 38px 32px 30px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }

        .auth-icon {
            width: 58px;
            height: 58px;
            margin: 0 auto 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #10b981;
            background: #ecfdf5;
            border: 2px solid #a7f3d0;
            font-size: 24px;
        }

        .auth-title {
            text-align: center;
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .auth-subtitle {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            margin-bottom: 24px;
            line-height: 1.5;
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

        .auth-btn {
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

        .auth-btn:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.3);
        }
    </style>
</head>

<body>
    <div class="auth-card">
        <div class="auth-icon">
            <i class="bi bi-key-fill"></i>
        </div>

        <h1 class="auth-title">Set New Password</h1>
        <p class="auth-subtitle">
            Create a new password for <strong><?php echo htmlspecialchars($email); ?></strong>
        </p>

        <?php if (!empty($message)) { ?>
            <div class="alert alert-<?php echo $message_type; ?> py-2 px-3 mb-3 d-flex align-items-center" style="font-size: 13.5px;">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-6"></i>
                <div><?php echo $message; ?></div>
            </div>
        <?php } ?>

        <form method="POST">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="New Password"
                    required
                >
            </div>

            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    class="form-control"
                    placeholder="Confirm New Password"
                    required
                >
            </div>

            <button type="submit" name="reset" class="auth-btn">
                <i class="bi bi-check2-circle"></i> Update Password
            </button>
        </form>

        <div class="text-center mt-4 pt-3 border-top" style="font-size: 14px; color: #64748b;">
            <a href="login1.php" style="color: #2563eb; font-weight: 700; text-decoration: none;">
                Cancel and return to Login
            </a>
        </div>
    </div>
</body>
</html>