<?php

require 'admin_auth.php';
require '../db.php';

$name = $_POST['name'];
$price = $_POST['average_price'];

$stmt = $conn->prepare("
INSERT INTO ingredients
(name, average_price)
VALUES (?,?)
");

$stmt->bind_param(
    "sd",
    $name,
    $price
);

$stmt->execute();

header("Location: ingredients.php");
exit;