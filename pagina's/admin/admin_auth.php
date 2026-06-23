<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.html");
    exit;
}

include '../db.php';

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT role
    FROM users
    WHERE id = ?
");

$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($user['role'] !== 'admin'){
    header("Location: ../index.php");
    exit;
}