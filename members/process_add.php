<?php
session_start();
require __DIR__ . '/../includes/connection.php';

$member_no = trim($_POST['member_no'] ?? '');
$name = trim($_POST['name'] ?? '');
$address = trim($_POST['address'] ?? '');
$phone_no = trim($_POST['phone_no'] ?? '');

$errors = [];

if ($member_no === '') { $errors[] = "Member No is required."; }
if ($name === '') { $errors[] = "Name is required."; }
if ($address === '') { $errors[] = "Address is required."; }
if ($phone_no !== '' && !preg_match('/^[0-9]{8,15}$/', $phone_no)) {
    $errors[] = "Phone number must be digits between 8 and 15 characters.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: add.php');
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO members (member_id, name, address, phone) VALUES (:member_id, :name, :address, :phone) RETURNING id");
    $stmt->execute([
        'member_id' => $member_no,
        'name'      => $name,
        'address'   => $address,
        'phone'     => $phone_no
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Member added successfully.'];
    header('Location: list.php');
    exit;
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Member No/ID is already taken. Please use another one.'];
    header('Location: add.php');
    exit;
}