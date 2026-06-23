<?php

require 'admin_auth.php';
require '../db.php';

$ingredients = $conn->query("
    SELECT *
    FROM ingredients
    ORDER BY name
");
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Recept toevoegen</title>
</head>
<body>

<h1>Nieuw recept toevoegen</h1>

<form action="save_recipe.php" method="POST" enctype="multipart/form-data">

    <label>Titel</label>
    <input type="text" name="title" required>

    <br><br>

    <label>Beschrijving</label>
    <textarea name="description"></textarea>

    <br><br>

    <label>Bereidingswijze</label>
    <textarea name="instructions"></textarea>

    <br><br>

    <label>Aantal personen</label>
    <input type="number" name="servings">

    <br><br>

    <label>Geschatte prijs</label>
    <input type="number" step="0.01" name="estimated_cost">

    <br><br>

    <label>Afbeelding</label>
    <input type="file" name="image">

    <br><br>

    <h3>Ingrediënten</h3>

    <div id="ingredients-container">

        <div class="ingredient-row">

            <select name="ingredient_id[]">

                <?php while($ingredient = $ingredients->fetch_assoc()): ?>

                    <option value="<?= $ingredient['id'] ?>">
                        <?= htmlspecialchars($ingredient['name']) ?>
                    </option>

                <?php endwhile; ?>

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
                placeholder="gram, ml, stuk..."
            >

        </div>

    </div>

    <button type="button" onclick="addIngredient()">
        + Ingrediënt toevoegen
    </button>

    <button type="submit">
        Recept opslaan
    </button>

</form>

</body>
</html>

<script>

function addIngredient(){

    const container =
        document.getElementById(
            'ingredients-container'
        );

    const row =
        document.querySelector(
            '.ingredient-row'
        );

    const clone =
        row.cloneNode(true);

    clone.querySelectorAll('input')
        .forEach(input => input.value = '');

    container.appendChild(clone);
}

</script>