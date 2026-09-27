<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    include "db.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $qualification = $_POST['education'];
        $passing_year = $_POST['passing_year'];
        $experience = $_POST['experience'];
        $skills = $_POST['skills'];
        

        $user_id = $_SESSION['user_id'] ?? 1;

        // Resume
        $resume_name = $_FILES['resume']['name'];
        $resume_tmp = $_FILES['resume']['tmp_name'];

        $upload_folder = "uploads/";

        if (!is_dir($upload_folder)) {
            mkdir($upload_folder, 0777, true);
        }

        $resume_path = $upload_folder . time() . "_" . $resume_name;

        move_uploaded_file($resume_tmp, $resume_path);


        // Save in database
        $sql = "INSERT INTO user_profile
    (user_id, qualification, passing_year, skills, experience, resume, name, email, mobile)
    VALUES
    ('$user_id',
     '$qualification',
     '$passing_year',
     '$skills',
     '$experience',
     '$resume_path',
     '$name',
     '$email',
     '$mobile',
    )";


        if (mysqli_query($conn, $sql)) {

            echo "<script>
            alert('Application Applied Successfully! 🎉');
            window.location.href = 'job.php';
        </script>";

        } else {

            echo "<script>
            alert('Application Failed!');
            window.history.back();
        </script>";
        }
    }
    ?>
</body>

</html>