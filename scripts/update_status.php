<?php
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $applicationID = $_POST['applicationID'];
    $status = $_POST['status'];

    $sql = "UPDATE application SET Status = ? WHERE ApplicationID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $applicationID);

    if ($stmt->execute()) {
        header("Location: http://localhost/jobOnCampus/supervisor.php"); // Adjust this to the correct dashboard page
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: http://localhost/jobOnCampus/supervisor.php"); // Adjust this to the correct dashboard page
    exit();
}
?>