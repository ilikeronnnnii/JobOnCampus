<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    // Redirect to login page or show an error
    header('Location: index.php');
    exit();
}

// Include database connection
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $jobPosition = $_POST['job_title'];
    $faculty = $_POST['education'];
    $about_yourself = $_POST['about_yourself']; // Not used in the table structure, but keep for future use
    $certification = $_POST['certifications'];
    $user_id = $_SESSION['userID'];
    $dateRequested = date('Y-m-d'); // Current date

    // Map faculty name to facultyID
    $faculty_map = [
        'computing' => 1,
        'management' => 2,
        'science' => 3,
        'mechanical' => 4,
    ];
    $facultyID = $faculty_map[$faculty];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO job_request (userID, dateRequested, certification, jobPosition, facultyID, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("isssi", $user_id, $dateRequested, $certification, $jobPosition, $facultyID);

    // Execute statement
    if ($stmt->execute()) {
        header("Location: ../request.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>