<?php

session_start();
include("db.php");
include 'sidebar.php';
/* ==========================================
   COMPANY LOGIN CHECK
========================================== */

if (!isset($_SESSION['company_name'])) {

    header("Location: com_login.php");
    exit();

}


/* ==========================================
   ADD NEW JOB
========================================== */

if (isset($_POST['submit'])) {

    $com_name = mysqli_real_escape_string(
        $conn,
        $_SESSION['company_name']
    );

    $job_title = mysqli_real_escape_string(
        $conn,
        $_POST['job_title']
    );

    $job_type = mysqli_real_escape_string(
        $conn,
        $_POST['job_type']
    );

    $location = mysqli_real_escape_string(
        $conn,
        $_POST['location']
    );

    $salary = mysqli_real_escape_string(
        $conn,
        $_POST['salary']
    );

    $description = mysqli_real_escape_string(
        $conn,
        $_POST['description']
    );


    /* ==========================================
       NEW JOB = 0 VIEWS
    ========================================== */

    $sql = "INSERT INTO comadd_job
            (
                com_name,
                job_title,
                job_type,
                location,
                salary,
                description,
                views
            )
            VALUES
            (
                '$com_name',
                '$job_title',
                '$job_type',
                '$location',
                '$salary',
                '$description',
                0
            )";


    if (mysqli_query($conn, $sql)) {

        echo "<script>
                alert('Job Added Successfully');
                window.location='com_dashboard.php';
              </script>";

        exit();

    } else {

        echo "Database Error: " . mysqli_error($conn);

    }

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Job</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>

        body {
            background: #f4f7fc;
        }

        .box {
            width: 700px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,.2);
        }

        h2 {
            text-align: center;
            color: #0d6efd;
            margin-bottom: 25px;
        }

        textarea {
            resize: none;
        }

        .views {
            margin-top: 15px;
            padding: 10px 15px;
            background: #f1f3f5;
            border-radius: 8px;
            color: #555;
            font-size: 16px;
            font-weight: bold;
        }
        .sidebar {
    width: 220px !important;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #1e293b;
    z-index: 1000;
}

/* જમણી બાજુના કન્ટેન્ટને સાઇડબારની બરાબર બાજુમાં ખસેડો જેથી મેનુ ન કપાય */
.main-content, .container, .content-box {
    margin-left: 225px !important; /* સાઇડબાર કરતાં થોડી વધુ જગ્યા જેથી ઓવરલેપ ન થાય */
    padding: 20px;
}

    </style>

</head>

<body>

<div class="box">

    <h2>Add New Job</h2>

    <form method="post">

        <!-- JOB TITLE -->

        <div class="mb-3">

            <label>
                <b>Job Title</b>
            </label>

            <input
                type="text"
                name="job_title"
                class="form-control"
                placeholder="Enter Job Title"
                required>

        </div>


        <!-- JOB TYPE -->

        <div class="mb-3">

            <label>
                <b>Job Type</b>
            </label>

            <select
                name="job_type"
                class="form-control"
                required>

                <option value="">
                    Select Job Type
                </option>

                <option value="Full Time">
                    Full Time
                </option>

                <option value="Part Time">
                    Part Time
                </option>

                <option value="Internship">
                    Internship
                </option>

                <option value="Remote">
                    Remote
                </option>

            </select>

        </div>


        <!-- LOCATION -->

        <div class="mb-3">

            <label>
                <b>Location</b>
            </label>

            <input
                type="text"
                name="location"
                class="form-control"
                placeholder="Enter Location"
                required>

        </div>


        <!-- SALARY -->

        <div class="mb-3">

            <label>
                <b>Salary</b>
            </label>

            <input
                type="number"
                name="salary"
                class="form-control"
                placeholder="Enter Salary"
                required>

        </div>


        <!-- DESCRIPTION -->

        <div class="mb-3">

            <label>
                <b>Job Description</b>
            </label>

            <textarea
                name="description"
                rows="5"
                class="form-control"
                placeholder="Enter Job Description"
                required></textarea>

        </div>


        <!-- VIEWS -->

        <div class="views">

            👁 Views: 0

        </div>


        <!-- BUTTONS -->

        <div class="text-center mt-4">

            <button
                type="submit"
                name="submit"
                class="btn btn-primary">

                Post Job

            </button>

            <a
                href="com_dashboard.php"
                class="btn btn-secondary">

                Back

            </a>

        </div>

    </form>

</div>

</body>

</html>