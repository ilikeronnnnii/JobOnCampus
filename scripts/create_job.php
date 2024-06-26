<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    // Redirect to login page or show an error
    header('Location: ../index.php');
    exit();
}

// Include database connection
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $position = $_POST['position'];
    $facultyID = $_POST['faculty'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $deadline = $_POST['deadline'];
    $description = $_POST['description'];
    $lecturer = $_POST['lecturer'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO jobs (facultyID, position, location, salary, deadline, description, lecturer) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdsss", $facultyID, $position, $location, $salary, $deadline, $description, $lecturer);

    // Execute statement
    if ($stmt->execute()) {
        header("Location: ../supervisor.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>