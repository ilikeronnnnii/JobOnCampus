<?php
$hostName = "localhost";
$dbUser = "joboncampus_aan";
$dbPassword = "";
$dbName = "joboncampus_joboncampus";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Something went wrong!");
}
?>