<?php
  session_start();
  if(!isset($_SESSION['userid'])){
    $_SESSION['error'] = "Please log in to continue.";
    header("Location: ../login.php");
        exit();
  }
?>