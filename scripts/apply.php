<?php
include ("database.php");
session_start();

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: http://localhost/jobOnCampus/index.php"); // Redirect to login page if not logged in
    exit();
}

// Get the job ID from the URL
if (isset($_GET['jobID'])) {
    $jobID = intval($_GET['jobID']);
} else {
    header("Location: careers.php"); // Redirect to careers page if no job ID is provided
    exit();
}

// Get the user ID from the session
$userID = $_SESSION['userID'];

// Check if the user has already applied for the job
$sqlCheck = "SELECT * FROM application WHERE userID = ? AND jobID = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("ii", $userID, $jobID);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    // User has already applied for this job
    $message = "You have already applied for this job.";
} else {
    // Insert a new application record
    $dateApplied = date("Y-m-d H:i:s"); // Get the current date and time
    $sqlInsert = "INSERT INTO application (userID, jobID, status, dateApplied) VALUES (?, ?, 'pending', ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("iis", $userID, $jobID, $dateApplied);

    if ($stmtInsert->execute()) {
        header("Location: http://localhost/jobOnCampus/applications.php");
    }
}

$stmtCheck->close();
$stmtInsert->close();
$conn->close();
?>