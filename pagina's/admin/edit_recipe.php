<?php

require 'admin_auth.php';
require '../db.php';

if(!isset($_GET['id'])){
    die("Geen recept geselecteerd.");
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("
    SELECT *
    FROM recipes
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$recipe = $result->fetch_assoc();

if(!$recipe){
    die("Recept niet gevonden.");
}


$ingredients = [];

$result = $conn->query("
    SELECT *
    FROM ingredients
    ORDER BY name
");

while($row = $result->fetch_assoc()){
    $ingredients[] = $row;
}


$stmt = $conn->prepare("
    SELECT
        ri.ingredient_id,
        ri.amount,
        ri.unit
    FROM recipe_ingredients ri
    WHERE ri.recipe_id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$recipeIngredients = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recept Bewerken</title>
</head>
<body>

<h1>Recept Bewerken</h1>

<form
    action="update_recipe.php"
    method="POST"
    enctype="multipart/form-data"
>

    <input
        type="hidden"
        name="id"
        value="<?= $recipe['id'] ?>"
    >

    <label>Titel</label>

    <input
        type="text"
        name="title"
        value="<?= htmlspecialchars($recipe['title']) ?>"
        required
    >

    <label>Beschrijving</label>

    <textarea name="description"><?= htmlspecialchars($recipe['description']) ?></textarea>

    <label>Bereidingswijze</label>

    <textarea name="instructions"><?= htmlspecialchars($recipe['instructions']) ?></textarea>

    <label>Aantal personen</label>

    <input
        type="number"
        name="servings"
        value="<?= $recipe['servings'] ?>"
    >

    <label>Geschatte prijs (€)</label>

    <input
        type="number"
        step="0.01"
        name="estimated_cost"
        value="<?= $recipe['estimated_cost'] ?>"
    >

    <?php if(!empty($recipe['image'])): ?>

        <label>Huidige afbeelding</label>

        <img
            src="../<?= $recipe['image'] ?>"
            width="200"
        >

    <?php endif; ?>

    <label>Nieuwe afbeelding</label>

    <input
        type="file"
        name="image"
    >

    <hr>

    <h2>Ingrediënten</h2>

    <div id="ingredients-container">

        <?php while($ri = $recipeIngredients->fetch_assoc()): ?>

            <div class="ingredient-row">

                <select name="ingredient_id[]">

                    <?php foreach($ingredients as $ingredient): ?>

                        <option
                            value="<?= $ingredient['id'] ?>"
                            <?= ($ingredient['id'] == $ri['ingredient_id']) ? 'selected' : '' ?>
                        >
                            <?= htmlspecialchars($ingredient['name']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

                <input
                    type="number"
                    step="0.01"
                    name="amount[]"
                    value="<?= $ri['amount'] ?>"
                >

                <input
                    type="text"
                    name="unit[]"
                    value="<?= htmlspecialchars($ri['unit']) ?>"
                >

            </div>

        <?php endwhile; ?>

    </div>

    <button
        type="button"
        class="btn"
        onclick="addIngredient()"
    >
        + Ingrediënt toevoegen
    </button>

    <br><br>

    <button
        type="submit"
        class="btn"
    >
        Recept opslaan
    </button>

</form>

<script>

function addIngredient(){

    const container =
        document.getElementById('ingredients-container');

    const row =
        document.createElement('div');

    row.classList.add('ingredient-row');

    row.innerHTML = `

        <select name="ingredient_id[]">

            <?php foreach($ingredients as $ingredient): ?>

                <option value="<?= $ingredient['id'] ?>">
                    <?= htmlspecialchars($ingredient['name']) ?>
                </option>

            <?php endforeach; ?>

        </select>

        <input
            type="number"
            step="0.01"
            name="amount[]"
            placeholder="Hoeveelheid"
        >

        <input
            type="text"
            name="unit[]"
            placeholder="gram, ml, stuk"
        >
    `;

    container.appendChild(row);
}

</script>

</body>
</html>