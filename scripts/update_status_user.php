<?php
session_start();
require_once "database.php";

if (isset($_POST['jobID']) && isset($_POST['status']) && isset($_SESSION['userID'])) {
    $jobID = $_POST['jobID'];
    $status = $_POST['status'];
    $userID = $_SESSION['userID'];

    $sql = "UPDATE application SET status = ? WHERE jobID = ? AND userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $status, $jobID, $userID);

    if ($stmt->execute()) {
        header("Location: ../applications.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>