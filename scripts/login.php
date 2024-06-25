<?php
session_start();

if (isset($_POST["login"])) {
    $email = $_POST["Email"];
    $password = $_POST["Password"];

    require_once "database.php";

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($password, $user["Password"])) {
            // Set the userID and username in the session
            $_SESSION["userID"] = $user["UserID"];
            $_SESSION["username"] = $user["Name"];
            header("Location: ../careers.php");
            exit(); // Ensure no further code is executed
        } else {
            echo "<div>Incorrect password.</div>";
        }
    } else {
        echo "<div>Email does not exist.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>