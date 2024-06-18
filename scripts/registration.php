<?php
require_once('database.php'); // Ensure the path to database.php is correct

if (isset($_POST["submit"])) {
    echo "Form is submitted!<br>";
    
    $name = $_POST["Name"];
    $email = $_POST["Email"];
    $password = $_POST["Password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $pname = rand(1000, 10000)."-".$_FILES["Resume"]["name"];
    $tname = $_FILES["Resume"]["tmp_name"];

    $uploads_dir = "uploads";

    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0755, true);
    }

    move_uploaded_file($tname, $uploads_dir.'/'.$pname);


    $sql = "INSERT into user(Name, Email, Password, Resume) VALUES ('$name', '$email', '$hashedPassword', '$pname')";

    if(mysqli_query($conn, $sql)){
        echo "File successfully uploaded";
        setcookie("status", "success");
        header("Location: ../index.php");
    }else{
        setcookie("status", "error");
    }

}
?>
