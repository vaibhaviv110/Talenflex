<?php
session_start();
include("db.php");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>



    <meta charset="UTF-8" />
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            /* column layout */
            margin: "120px";
            background: url(./lig.jpg) no-repeat center center/cover;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.65);
            z-index: 0;
        }

        .main-content {
            flex: 1;
            /* take available space */
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 40px 30px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
            color: #fff;
        }

        h1.login-title {
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
            font-size: 2rem;
            color: #f9d342;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 0 8px #f9d342;
            color: #fff;
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: #f9d342;
        }

        .btn-primary {
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            background: linear-gradient(135deg, #f9d342, #ff8800);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0px 8px 20px rgba(249, 211, 66, 0.7);
        }

        footer {
            position: relative;
            z-index: 1;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            text-align: center;
            padding: 12px;
        }
    </style>
</head>

<body>

    <div class="overlay"></div>
    <br><br><br><br><br><br><br>
    <div class="main-content">
        <div class="login-card">
            <h1 class="login-title">Admin Login</h1>
            <form action="" method="POST">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required />
                </div>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required />
                </div>
                <div class="d-grid">
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div><br><br>

</body>

</html>