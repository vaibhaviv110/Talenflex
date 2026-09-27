<?php
include "db.php";

session_start();

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $qry = "SELECT * FROM companyreg WHERE Email='$email'";
    $res = mysqli_query($conn, $qry);

    $user = mysqli_fetch_assoc($res);

    if ($user && $user['Password'] == $password) {
        $_SESSION['name'] = $user['Name'];
        $_SESSION['email'] = $user['Email'];
        header("Location: com_dashboard.php");
        exit();
    } else {

        echo "<script>alert('Invalid Email or Password');</script>";
    }
}
?>



<?php

include("db.php");

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $industry = $_POST['industry'];
    $password = $_POST['password'];

    $sql = "INSERT INTO companyreg(name,email,mobile,address,industry,password)
            VALUES('$name','$email','$mobile','$address','$industry','$password')";

    if (mysqli_query($conn, $sql)) {

        echo "<script>
            alert('Company Registered Successfully');
            window.location='com_login.php';
          </script>";
        exit();
    } else {

        echo "Error : " . mysqli_error($conn);
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>Company Registration</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #eef5ff;
        }

        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .left {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .left img {
            width: 90%;
            height: 650px;
            object-fit: cover;
            border-radius: 10px;
        }

        .right {
            width: 50%;
            display: flex;
            justify-content: center;
        }

        .form-box {

            width: 500px;
            background: #fff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, .2);

        }

        .form-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #0d6efd;
        }

        input,
        textarea,
        select {

            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;

        }

        textarea {
            height: 90px;
            resize: none;
        }

        button {

            width: 100%;
            padding: 14px;
            background: #0d6efd;
            color: white;
            border: none;
            font-size: 18px;
            border-radius: 6px;
            cursor: pointer;

        }

        button:hover {

            background: #0047c5;

        }
    </style>

</head>

<body>

    <div class="container">

        <div class="left">

            <img src="bg.jpg.png">

        </div>

        <div class="right">

            <div class="form-box">

                <h2>Company Registration</h2>

                <form method="post">

                    <input type="text"
                        name="name"
                        placeholder="Company Name"
                        required>

                    <input type="email"
                        name="email"
                        placeholder="Company Email"
                        required>


                    <input type="text" name="num" class="form-control" 
                    placeholder="10 digit number" required pattern="\d{10}">


                    <textarea
                        name="address"
                        placeholder="Company Address"
                        required></textarea>

                    <select name="industry" required>

                        <option value="">Select Industry</option>

                        <option>Information Technology</option>

                        <option>Software Development</option>

                        <option>Cyber Security</option>

                        <option>Banking & Finance</option>

                        <option>Healthcare</option>

                        <option>E-Commerce</option>

                        <option>Manufacturing</option>

                        <option>Construction</option>

                        <option>Marketing</option>

                    </select>
                    <input type="password"
                        name="password"
                        placeholder="Password"
                        required>

                    <button type="submit" name="register">
                        Register Company
                    </button>
                    <p style="text-align:center; margin-top:20px;">
                        Already have a company account?
                        <a href="com_login.php" style="color:#0d6efd; font-weight:bold; text-decoration:none;">
                            Login Here
                        </a>
                    </p>
                </form>

            </div>

        </div>

    </div>

</body>

</html>