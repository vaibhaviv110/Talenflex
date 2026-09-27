<?php
session_start();
include("db.php");

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Admin Login
    $admin_check = mysqli_query(
        $conn,
        "SELECT * FROM registration 
         WHERE Email='$email' 
         AND Password='$password' 
         AND u_type='admin'"
    );

    if (mysqli_num_rows($admin_check) > 0) {

        $row = mysqli_fetch_assoc($admin_check);

        $_SESSION['admin'] = "admin";
        $_SESSION['admin_name'] = $row['Name'];

        header("Location: admin/dashboard.php");
        exit();
    }


    // Company Login
    $company = mysqli_query(
        $conn,
        "SELECT * FROM companyreg 
         WHERE email='$email' 
         AND password='$password'"
    );

    if (mysqli_num_rows($company) > 0) {

        $row = mysqli_fetch_assoc($company);

        $_SESSION['company_id'] = $row['id'];
        $_SESSION['company_name'] = $row['name'];

        header("Location: company/com_dashboard.php");
        exit();
    }


    // User Login
    $user = mysqli_query(
        $conn,
        "SELECT * FROM registration 
         WHERE Email='$email' 
         AND Password='$password'"
    );

    if (mysqli_num_rows($user) > 0) {

        $row = mysqli_fetch_assoc($user);

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['Name'];


        // Apply Page પરથી આવ્યો હોય
        if (isset($_SESSION['redirect_url'])) {

            $redirect = $_SESSION['redirect_url'];

            unset($_SESSION['redirect_url']);

            header("Location: " . $redirect);
            exit();
        }


        // Profile Check
        $user_id = $row['id'];

        $check = mysqli_query(
            $conn,
            "SELECT * FROM user_profile 
             WHERE user_id='$user_id'"
        );

        if (mysqli_num_rows($check) > 0) {

            header("Location: profile.php");

        } else {

            header("Location: index.php");
        }

        exit();
    }


    echo "<script>
            alert('Invalid Email or Password');
          </script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Login | TalentFlex</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
          rel="stylesheet">


    <style>

        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fc;
            color: #142957;
            padding: 20px;
        }

        /* Main Login Card */
        .login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            padding: 40px 32px 30px;
            border-radius: 18px;
            border: 1px solid #eeeeee;
            box-shadow:
                0 10px 35px rgba(20, 41, 87, 0.12);
        }

        /* Login Heading */
        .login-title {
            text-align: center;
            font-size: 32px;
            font-weight: 700;
            color: #142957;
            margin-bottom: 30px;
        }

        .login-title span {
            color: #ed2680;
        }

        /* Small Icon Above Heading */
        .login-icon {
            width: 58px;
            height: 58px;
            margin: 0 auto 15px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ed2680;
            border: 2px solid #ed2680;
            font-size: 25px;
        }

        /* Input Group */
        .input-group {
            height: 50px;
            margin-bottom: 20px;
            border: 1px solid #dfe2e8;
            border-radius: 9px;
            overflow: hidden;
            transition: 0.3s;
            background: #fff;
        }

        .input-group:focus-within {
            border-color: #ed2680;
            box-shadow:
                0 0 0 3px rgba(237, 38, 128, 0.08);
        }

        .input-group-text {
            width: 52px;
            justify-content: center;
            background: #fff;
            border: none;
            border-right: 1px solid #e5e5e5;
            color: #142957;
            font-size: 18px;
        }

        .form-control {
            border: none;
            box-shadow: none !important;
            color: #142957;
            font-size: 14px;
            padding-left: 14px;
        }

        .form-control::placeholder {
            color: #9a9da5;
        }
        .form-control:focus {
            background: #fff;
            color: #142957;
        }

        /* Login Button */
        .login-btn {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 9px;
            background: #142957;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            transition: 0.3s;
            margin-top: 3px;
        }


        .login-btn:hover {
            background: #ed2680;
            transform: translateY(-2px);
            box-shadow:
                0 7px 18px rgba(237, 38, 128, 0.25);
        }


        /* Register Text */

        .register-text {
            text-align: center;
            margin-top: 22px;
            margin-bottom: 0;
            color: #555;
            font-size: 14px;
        }
        .register-text a {
            color: #ed2680;
            font-weight: 600;
            text-decoration: none;
        }
        .register-text a:hover {

            text-decoration: underline;
        }

        /* Responsive */

        @media (max-width: 576px) {

            body {

                padding: 15px;
            }

            .login-card {

                padding: 32px 20px 25px;
            }

            .login-title {

                font-size: 28px;
            }
        }
    </style>
</head>


<body>
    <div class="login-card">

        <!-- Icon -->
        <div class="login-icon">
            <i class="bi bi-person-lock"></i>
        </div>
        <!-- Heading -->
        <h1 class="login-title">
            Welcome <span>Back</span><br>
            TalentFlex
        </h1>
        <form method="post" action="">
            <!-- Email -->
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-envelope"></i>
                </span>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    placeholder="Email Address"
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
                    style="cursor:pointer; border-right:none; border-left:1px solid #e5e5e5;"
                    onclick="togglePassword()">
                    <i class="bi bi-eye-slash" id="eyeIcon"></i>
                </span>
            </div>

            <!-- Login Button -->
           <!-- Login Button -->
<div class="d-grid">
    <button
        type="submit"
        name="login"
        class="login-btn">
        Login
    </button>
</div>


<!-- Forgot Password -->
<div style="text-align: right; margin-top: 10px;">

    <a href="forget.php"
       style="
            color: #ed2680;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
       ">

        Forgot Password?

    </a>

</div>


<!-- Register -->
<p class="register-text">
    Don't have an account?
    <a href="r.php">
        Register here
    </a>
</p>
        </form>
    </div>

    <script>
        function togglePassword() {
            let password =
                document.getElementById("password");
            let eyeIcon =
                document.getElementById("eyeIcon");

            if (password.type === "password") {
                password.type = "text";
                eyeIcon.classList.remove(
                    "bi-eye-slash"
                );
                eyeIcon.classList.add(
                    "bi-eye"
                );

            } else {
                password.type = "password";
                eyeIcon.classList.remove(
                    "bi-eye"
                );
                eyeIcon.classList.add(
                    "bi-eye-slash"
                );
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>