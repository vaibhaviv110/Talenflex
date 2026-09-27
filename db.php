<?php
$conn = mysqli_connect("localhost","root","","jobportal1");

if(!$conn)
    {
    die("Connection Failed: " . mysqli_connect_error());
}
?>