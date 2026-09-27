<?php
session_start();
include("db.php");

if(isset($_POST['apply']))
{
    $job_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $resume = $_FILES['resume']['name'];
    $tmp = $_FILES['resume']['tmp_name'];

    move_uploaded_file($tmp,"resume/".$resume);

    $sql = "INSERT INTO applications(job_id,user_id,resume,status)
            VALUES('$job_id','$user_id','$resume','Pending')";

    if(mysqli_query($conn,$sql))
    {
        echo "<script>
        alert('Application Submitted Successfully');
        window.location='my_applications.php';
        </script>";
    }
    else
    {
        echo mysqli_error($conn);
    }
}
?>
<form method="post" enctype="multipart/form-data">

    <label>Select Resume</label>
    <input type="file" name="resume" class="form-control" required>

    <br>

    <button type="submit" name="apply" class="btn btn-primary">
        Apply Now
    </button>

</form>