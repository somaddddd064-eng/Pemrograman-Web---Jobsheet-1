<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMPUS-Mini<?php echo isset($page_title) ? ' | ' . $page_title : ''; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/app.js" defer></script>
</head>
<body>
<header>
    <h1>SIMPUS-Mini</h1>
    <button type="button" id="nav-toggle-btn" class="nav-toggle-label" aria-label="Menu">&#9776;</button>
    <nav>
        <ul>
            <li><a href="/index.php">Home</a></li>
            <li><a href="/books/list.php">Book List</a></li>
            <li><a href="/books/add.php">Add Book</a></li>
            <li><a href="/members/list.php">Member List</a></li>
            <li><a href="/members/add.php">Add Member</a></li>
        </ul>
    </nav>
</header>
<main>