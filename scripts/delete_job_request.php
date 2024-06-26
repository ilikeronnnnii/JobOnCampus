<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ../index.php"); // Redirect to login page if not logged in
    exit();
}

require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requestID = $_POST['requestID'];

    // Prepare and bind
    $stmt = $conn->prepare("DELETE FROM job_request WHERE requestID = ?");
    $stmt->bind_param("i", $requestID);

    if ($stmt->execute()) {
        header("Location: ../supervisor.php"); // Redirect back to the supervisor dashboard
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>