<?php
session_start();
include("db.php");

$message = "";
$message_type = "";

if (isset($_POST['forgot'])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));

    // Check if user exists
    $check = mysqli_query($conn, "SELECT * FROM registration WHERE Email='$email'");
    if ($check && mysqli_num_rows($check) > 0) {
        $_SESSION['reset_email'] = $email;
        header("Location: reset.php");
        exit();
    } else {
        $message = "Email address not found in registered candidate records.";
        $message_type = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | TalentFlex</title>
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

        .back-link {
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

        .back-link:hover {
            color: #2563eb;
            transform: translateX(-3px);
        }

        .auth-icon {
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
        <a href="login1.php" class="back-link">
            <i class="bi bi-arrow-left"></i> Back to Login
        </a>

        <div class="auth-icon">
            <i class="bi bi-shield-lock"></i>
        </div>

        <h1 class="auth-title">Recover Password</h1>
        <p class="auth-subtitle">Enter your registered email to reset your candidate account credentials</p>

        <?php if (!empty($message)) { ?>
            <div class="alert alert-<?php echo $message_type; ?> py-2 px-3 mb-3 d-flex align-items-center" style="font-size: 13.5px;">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-6"></i>
                <div><?php echo $message; ?></div>
            </div>
        <?php } ?>

        <form method="POST">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="Registered Email Address"
                    required
                >
            </div>

            <button type="submit" name="forgot" class="auth-btn">
                <i class="bi bi-arrow-right-circle"></i> Continue to Password Reset
            </button>
        </form>

        <div class="text-center mt-4 pt-3 border-top" style="font-size: 14px; color: #64748b;">
            Remember your password?
            <a href="login1.php" style="color: #2563eb; font-weight: 700; text-decoration: none;">
                Sign In
            </a>
        </div>
    </div>
</body>
</html>