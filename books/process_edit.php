<?php
session_start();
require __DIR__ . '/../includes/connection.php';

$id = $_POST['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$title = trim($_POST['title'] ?? '');
$author = trim($_POST['author'] ?? '');
$year = $_POST['year'] ?? '';
$isbn = trim($_POST['isbn'] ?? '');
$stock = $_POST['stock'] ?? '';
$category = trim($_POST['category'] ?? '');

$errors = [];

if ($title === '') { $errors[] = "Title is required."; }
if ($author === '') { $errors[] = "Author is required."; }
if (!is_numeric($year) || $year < 1900 || $year > 2026) { $errors[] = "Year must be between 1900 and 2026."; }
if (!is_numeric($stock) || $stock < 0) { $errors[] = "Stock cannot be negative."; }
if ($isbn !== '' && !preg_match('/^[0-9\-]+$/', $isbn)) { $errors[] = "ISBN must contain only numbers and hyphens."; }

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare("UPDATE books SET title = :title, author = :author, year = :year, isbn = :isbn, stock = :stock, category = :category WHERE id = :id");
$stmt->execute([
    'title'    => $title,
    'author'   => $author,
    'year'     => (int) $year,
    'isbn'     => $isbn,
    'stock'    => (int) $stock,
    'category' => $category,
    'id'       => $id
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Book updated successfully.'];
header('Location: list.php');
exit;