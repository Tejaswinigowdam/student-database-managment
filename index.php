<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, post-check=0, pre-check=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Login Options</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bitter:ital@0;1&display=swap" rel="stylesheet">
</head>
<body>
<div class="login-container">
    <div class="login-info">
        <h1>
             Welcome to Academic Netlink!
        </h2>
        <p>
        Your go-to platform for accessing academic details and resources : )
        </p>
    </div>
    <div class="login-options">
        <h2>USER LOGIN</h2>
        <div class="login-option">
            <a href="admin/admin_login.php">Admin Login</a>
        </div>
        <div class="login-option">
            <a href="faculty/faculty_login.php">Faculty Login</a>
        </div>
        <div class="login-option">
            <a href="student/student_login.php">Student Login</a>
        </div>
        <div class="login-option">
            <a href="parent/parent_login.php">Parent Login</a>
        </div>
    </div>
</div>
</body>
</html>
<?php
// Include database connection file
require_once('db_connection.php');

// Fetch user roles from the database
$sql = "SELECT DISTINCT role FROM User";
$result = $conn->query($sql);
$roles = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $roles[] = $row['role'];
    }
}
?>