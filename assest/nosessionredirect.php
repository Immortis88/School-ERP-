<?php
  session_start();
  if(!isset($_SESSION['uid'])){
    $_SESSION['error'] = "Please log in to continue.";
    header("Location: ../login.php");
    // Check if the 'error' session variable is set
if (isset($_SESSION['error'])) {
    // Display the error message in a prominent way (e.g., a Bootstrap alert)
    echo '<div class="alert alert-danger" role="alert">';
    echo $_SESSION['error'];
    echo '</div>';

    // Unset the session variable so it doesn't show up again on refresh
    unset($_SESSION['error']);
}
        exit();
  }
?>