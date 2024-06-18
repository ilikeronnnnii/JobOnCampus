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
                header("Location: ../careers.php");
                session_start();
                $_SESSION["username"] = $user["Name"];
            }
        }else{
            echo "<div> email does not exist </div>";
        }

    }
  
?>