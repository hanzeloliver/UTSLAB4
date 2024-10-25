<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$list_id = $_GET['list_id'];

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE list_id = ?");
$stmt->execute([$list_id]);
$tasks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>View To-Do List</h1>
    <ul>
        <?php foreach ($tasks as $task) { ?>
            <li>
                <?= $task['task_name'] ?>
                <?= $task['is_completed'] ? 'Completed' : 'Incomplete' ?>
            </li>
        <?php } ?>
    </ul>
</body>
</html>