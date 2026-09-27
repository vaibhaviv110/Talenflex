<?php
session_start();

unset($_SESSION['admin_user']); 

session_unset();
session_destroy();

header("Location: ../login1.php");
exit();
?>