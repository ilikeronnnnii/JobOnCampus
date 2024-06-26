<?php
session_start();
session_destroy();
header("Location: http://localhost/JobOnCampus/index.php");
exit();
?>