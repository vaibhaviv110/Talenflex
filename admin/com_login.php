<?php
session_start();
include("db.php");

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM companyreg WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);

        $_SESSION['company_id'] = $row['id'];
        $_SESSION['company_name'] = $row['name'];

        header("Location: com_dashboard.php");
        exit();
    }
    else
    {
        echo "<script>alert('Invalid Email or Password');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Company Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    background:url('lig.jpg') no-repeat center center/cover;
    height:100vh;
}

.overlay{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.6);
}

.login-box{
    width:400px;
    background:rgba(255,255,255,.1);
    backdrop-filter:blur(10px);
    padding:35px;
    border-radius:15px;
    color:#fff;
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
}

.btn{
    width:100%;
}
</style>

</head>
<body>

<div class="overlay"></div>

<div class="login-box">

<h2 class="text-center mb-4">Company Login</h2>

<form method="POST" action="">

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button type="submit" name="login" class="btn btn-primary">
Login
</button>

</form>

</div>

</body>
</html>