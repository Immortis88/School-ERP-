<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "erp_db";
    
    $conn = mysqli_connect($server, $user, $password, $db);

    if (!$conn) {
        header('location: ../errors/error.html');
        exit();
    }


?>