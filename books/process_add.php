<?php
session_start();

$title = trim($_POST['title'] ?? '');
$author = trim($_POST['author'] ?? '');
$year = $_POST['year'] ?? '';
$isbn = trim($_POST['isbn'] ?? '');
$stock = $_POST['stock'] ?? '';
$category = trim($_POST['category'] ?? '');

$errors = [];

if ($title === '') {
    $errors[] = "Title is required.";
}
if ($author === '') {
    $errors[] = "Author is required.";
}
if (!is_numeric($year) || $year < 1900 || $year > 2026) {
    $errors[] = "Year must be between 1900 and 2026.";
}
if (!is_numeric($stock) || $stock < 0) {
    $errors[] = "Stock cannot be negative.";
}

// Exercise 1: Validasi ISBN dengan preg_match()
if ($isbn !== '' && !preg_match('/^[0-9\-]+$/', $isbn)) {
    $errors[] = "ISBN must contain only numbers and hyphens.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: add.php');
    exit;
}

if (!isset($_SESSION['buku'])) {
    $_SESSION['buku'] = [];
}

$_SESSION['buku'][] = [
    'title' => $title,
    'author' => $author,
    'year' => (int) $year,
    'isbn' => $isbn,
    'stock' => (int) $stock,
    'category' => $category
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Book added successfully.'];
header('Location: list.php');
exit;