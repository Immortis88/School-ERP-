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

	if ($password === $db_pass) {  // Use password_verify if hashed
		$_SESSION['uid'] = $id;
		$_SESSION['role'] = $role;

		// Redirect based on role
		switch ($role) {
			case 'admin':
				header("Location: admin_panel/dashboard.php");
				break;
			case 'teacher':
				header("Location: teacher_panel/dashboard.php");
				break;
			case 'student':
				header("Location: student_panel/dashboard.php");
				break;
			default:
				echo "Unknown role.";
		}
		exit();
	} else {
		echo "Invalid password.";
	}
	} else {
	echo "User not found.";
	}
}
?>