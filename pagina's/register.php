<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

$username = $_POST['username'];
$email = $_POST['email'];

$password = password_hash(
    $_POST['password'],
    PASSWORD_DEFAULT
);

$sql = "INSERT INTO users(username,email,password) VALUES(?,?,?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param(
    "sss",
    $username,
    $email,
    $password
);

if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

header("Location: login.html");
exit;