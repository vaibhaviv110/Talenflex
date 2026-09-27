<?php
session_start();
include("db.php");

if (!isset($_SESSION['company_name'])) {
    header("Location: com_login.php");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$company = mysqli_real_escape_string($conn, $_SESSION['company_name']);

mysqli_query($conn, "DELETE FROM comadd_job WHERE id='$id' AND com_name='$company'");

header("Location: commy_job.php");
exit();
?>