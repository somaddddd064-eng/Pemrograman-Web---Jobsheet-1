<?php
session_start();

$member_no = trim($_POST['member_no'] ?? '');
$name = trim($_POST['name'] ?? '');
$address = trim($_POST['address'] ?? '');
$phone_no = trim($_POST['phone_no'] ?? '');

$errors = [];

if ($member_no === '') {
    $errors[] = "Member No is required.";
}
if ($name === '') {
    $errors[] = "Name is required.";
}
if ($address === '') {
    $errors[] = "Address is required.";
}

// Exercise 2: Validasi Nomor Telepon (hanya angka dan minimal 8 digit)
if ($phone_no !== '' && !preg_match('/^[0-9]{8,15}$/', $phone_no)) {
    $errors[] = "Phone number must be digits between 8 and 15 characters.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: add.php');
    exit;
}

if (!isset($_SESSION['members'])) {
    $_SESSION['members'] = [];
}

$_SESSION['members'][] = [
    'member_no' => $member_no,
    'name' => $name,
    'address' => $address,
    'phone_no' => $phone_no
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Member added successfully.'];
header('Location: list.php');
exit;