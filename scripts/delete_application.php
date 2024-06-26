<?php
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $applicationID = $_POST['applicationID'];

    $sql = "DELETE FROM application WHERE ApplicationID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $applicationID);

    if ($stmt->execute()) {
        header("Location: ../supervisor.php"); // Adjust this to the correct dashboard page
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../supervisor.php"); // Adjust this to the correct dashboard page
    exit();
}
?>