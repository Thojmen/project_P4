<?php

require 'admin_auth.php';
require '../db.php';

/* gegevens ophalen */

$title = $_POST['title'];
$description = $_POST['description'];
$instructions = $_POST['instructions'];
$servings = $_POST['servings'];
$estimated_cost = $_POST['estimated_cost'];

$image = "";

/* afbeelding uploaden */

if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){

    $filename = time() . "_" . $_FILES['image']['name'];

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "../uploads/" . $filename
    );

    $image = "uploads/" . $filename;
}

/* recept opslaan */

$stmt = $conn->prepare("
INSERT INTO recipes
(title, description, instructions, servings, estimated_cost, image)
VALUES (?,?,?,?,?,?)
");

$stmt->bind_param(
    "sssids",
    $title,
    $description,
    $instructions,
    $servings,
    $estimated_cost,
    $image
);

$stmt->execute();


$recipeId = $conn->insert_id;

if(isset($_POST['ingredient_id'])){

    foreach($_POST['ingredient_id'] as $index => $ingredientId){

        $amount = $_POST['amount'][$index];
        $unit = $_POST['unit'][$index];

        if(!empty($ingredientId) && !empty($amount)){

            $stmt = $conn->prepare("
            INSERT INTO recipe_ingredients
            (recipe_id, ingredient_id, amount, unit)
            VALUES (?,?,?,?)
            ");

            $stmt->bind_param(
                "iids",
                $recipeId,
                $ingredientId,
                $amount,
                $unit
            );

            $stmt->execute();
        }
    }
}


header("Location: recipes.php");
exit;