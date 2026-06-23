<?php

require 'admin_auth.php';
require '../db.php';

$id = $_POST['id'];

$title = $_POST['title'];
$description = $_POST['description'];
$instructions = $_POST['instructions'];
$servings = $_POST['servings'];
$estimated_cost = $_POST['estimated_cost'];

$stmt = $conn->prepare("
SELECT image
FROM recipes
WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$currentRecipe = $stmt->get_result()->fetch_assoc();

$image = $currentRecipe['image'];

if(
    isset($_FILES['image']) &&
    $_FILES['image']['error'] === 0
)
{

    $filename =
        time() . "_" .
        basename($_FILES['image']['name']);

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "../uploads/" . $filename
    );

    $image = "uploads/" . $filename;
}

$stmt = $conn->prepare("
UPDATE recipes
SET
title = ?,
description = ?,
instructions = ?,
servings = ?,
estimated_cost = ?,
image = ?
WHERE id = ?
");

$stmt->bind_param(
    "sssidsi",
    $title,
    $description,
    $instructions,
    $servings,
    $estimated_cost,
    $image,
    $id
);

$stmt->execute();

header("Location: recipes.php");
exit;