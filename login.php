<?php
session_start();
require 'db.php'; // Ensure this points to the correct database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($email) || empty($password)) {
        echo "Email and password cannot be empty.";
        exit();
    }

    // Prepare statement to fetch user from the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Check if user found and password matches
    if ($user && password_verify($password, $user['password'])) {
        // Store user ID in session
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title> <!-- Corrected title -->
    <link rel="stylesheet" href="style.css"> <!-- Ensure CSS file is linked -->
</head>
<body>
    <div class="container">
        <h1>Login</h1> <!-- Corrected heading -->
        <form method="POST" action="login.php"> <!-- Changed action to login.php -->
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p class="signup-link">Don't have an account? <a href="register.php">Register</a></p> <!-- Corrected link -->
        </form>
    </div>
</body>
</html>
