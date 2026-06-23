<?php

require 'admin_auth.php';
require '../db.php';

$id = $_POST['id'];

$stmt = $conn->prepare("
SELECT image
FROM recipes
WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$recipe = $stmt->get_result()->fetch_assoc();

if($recipe){

    if(
        !empty($recipe['image']) &&
        file_exists("../" . $recipe['image'])
    ){

        unlink("../" . $recipe['image']);
    }

    $stmt = $conn->prepare("
    DELETE FROM recipes
    WHERE id = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: recipes.php");
exit;