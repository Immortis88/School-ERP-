<?php
// Your plain text password
$password = "123";

// Generate a secure hash using bcrypt (default)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Display the hashed password
echo $hashed_password;
?>