<?php
//session_start();
include("db.php");
include 'sidebar.php'; ?>
<?php
include("header.php");?>
 
<?php
if(!isset($_SESSION['company_name']))
{
    header("Location: com_login.php");
    exit();
}

$company = $_SESSION['company_name'];

$sql = "SELECT * FROM comadd_job WHERE com_name='$company'";
$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Jobs</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2 class="mb-4">My Posted Jobs</h2>

<table class="table table-bordered table-striped">

<tr>
    <th>ID</th>
    <th>Job Title</th>
    <th>Job Type</th>
    <th>Location</th>
    <th>Salary</th>
    <th>Description</th>
</tr>

<?php
while($row = mysqli_fetch_assoc($result))
{
?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['job_title']; ?></td>
    <td><?php echo $row['job_type']; ?></td>
    <td><?php echo $row['location']; ?></td>
    <td><?php echo $row['salary']; ?></td>
    <td><?php echo $row['description']; ?></td>
</tr>

<?php
}
?>

</table>

<a href="com_dashboard.php" class="btn btn-primary">Back</a>

</div>

</body>
<?php include("footer.php")?>
</html>