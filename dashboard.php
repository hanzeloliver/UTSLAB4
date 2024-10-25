<?php
session_start();
require 'db.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch existing to-do lists for the logged-in user
$stmt = $pdo->prepare("SELECT * FROM todo_lists WHERE user_id = ?");
$stmt->execute([$user_id]);
$todo_lists = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Dashboard</h1>

    <!-- Form to add a new to-do list -->
    <form id="addListForm">
        <input type="text" name="list_title" id="list_title" placeholder="New To-Do List" required>
        <button type="submit">Create List</button>
    </form>

    <!-- Display existing to-do lists -->
    <ul id="todoLists">
        <?php foreach ($todo_lists as $list) { ?>
            <li>
                <?= htmlspecialchars($list['title']) ?>
                <a href="view_list.php?list_id=<?= $list['id'] ?>">View</a>
                <a href="delete_list.php?list_id=<?= $list['id'] ?>">Delete</a>
            </li>
        <?php } ?>
    </ul>

    <script>
    document.getElementById('addListForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const title = document.getElementById('list_title').value;

        fetch('add_list.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'title': title,
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message); // Show success or error message
            }
            if (response.ok) {
                // Add the new list to the UI
                const todoLists = document.getElementById('todoLists');
                const newListItem = document.createElement('li');
                newListItem.textContent = title; // Use the title of the new list
                const viewLink = document.createElement('a');
                viewLink.href = `view_list.php?list_id=${data.list_id}`; // Assuming add_list.php returns the new list ID
                viewLink.textContent = 'View';
                newListItem.appendChild(viewLink);
                const deleteLink = document.createElement('a');
                deleteLink.href = `delete_list.php?list_id=${data.list_id}`; // Link to delete the list
                deleteLink.textContent = 'Delete';
                newListItem.appendChild(deleteLink);
                todoLists.appendChild(newListItem);
                // Clear the input field
                document.getElementById('list_title').value = '';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
    </script>
</body>
</html>