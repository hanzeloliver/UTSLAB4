<?php
session_start();
require 'db.php'; // Include the database connection

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to the dashboard if logged in
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List Application</title>
    <link rel="stylesheet" href="style2.css"> <!-- Link to the CSS file -->
</head>
<body>
    <h1>Welcome to the To-Do List Application</h1>
    <p>Please <a href="login.php">login</a> or <a href="register.php">register</a> to continue.</p>
</body>
</html>