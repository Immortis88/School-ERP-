<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   include 'assest/config.php';
$username = $_POST['username'];
$password = $_POST['password'];

// Prepared statement for security
$query = "SELECT s_no, password, role FROM users WHERE username=?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

	if (mysqli_stmt_num_rows($stmt) === 1) {
	mysqli_stmt_bind_result($stmt, $id, $db_pass, $role);
	mysqli_stmt_fetch($stmt);

		if (password_verify($password, $db_pass)) { // Use password_verify if hashed
            $_SESSION['uid'] = $id;
            $_SESSION['role'] = $role;
            // Redirect back to login.php with success and role parameters
            header("Location: login.php?success=true&role=" . urlencode($role));
            exit();
        } else {
            // Handle invalid password
            header("Location: login.php?error=invalid_password");
            exit();
        }
    } else {
        // Handle user not found
        header("Location: login.php?error=user_not_found");
        exit();
    }
}
?>
