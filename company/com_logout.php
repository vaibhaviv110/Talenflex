<?php
session_start();

unset($_SESSION['company_id']);
unset($_SESSION['company_name']);

session_unset();
session_destroy();

header("Location: ../login1.php");
exit();
?>