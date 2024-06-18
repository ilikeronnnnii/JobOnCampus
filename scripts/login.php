<?php
    if (isset($_POST["login"])){
        $email = $_POST["Email"];
        $password = $_POST["Password"];

        require_once "database.php";

        $sql = "SELECT * FROM user where email = '$email'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if($user){
            if(password_verify($password, $user["Password"])){
                echo "Lepas";
                header("Location: ../careers.php");
            }
        }else{
            echo "<div> email does not exist </div>";
        }

    }

    session_start();
?>