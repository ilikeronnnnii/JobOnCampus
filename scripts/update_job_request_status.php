<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ../index.php"); // Redirect to login page if not logged in
    exit();
}

require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requestID = $_POST['requestID'];
    $status = $_POST['status'];

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE job_request SET status = ? WHERE requestID = ?");
    $stmt->bind_param("si", $status, $requestID);

    if ($stmt->execute()) {
        header("Location: ../supervisor.php"); // Redirect back to the supervisor dashboard
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>